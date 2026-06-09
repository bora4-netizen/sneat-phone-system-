<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Series;
use App\Models\Color;
use App\Models\ModelType;
use App\Models\Storage;
use App\Models\Customer;
use App\Models\Cart;
use App\Models\OrderDetail;
use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:order-list|order-create|order-edit|order-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:order-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:order-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:order-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $query = Order::query();
        $customers = Customer::all();
        $parameterNames = [];

        if ($request->search || $request->anyFilled(['customer', 'from_date', 'to_date'])) {
            $filters = $request->only(['customer', 'from_date', 'to_date']);

            if (!empty($filters['customer'])) {
                $query->where('customer_id', $filters['customer']);
                $parameterNames['customer'] = $filters['customer'];
            }

            if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
                $query->whereBetween('order_date', [$filters['from_date'], $filters['to_date']]);
                $parameterNames['from_date'] = $filters['from_date'];
                $parameterNames['to_date'] = $filters['to_date'];
            } elseif (!empty($filters['from_date'])) {
                $query->where('order_date', '>=', $filters['from_date']);
                $parameterNames['from_date'] = $filters['from_date'];
            } elseif (!empty($filters['to_date'])) {
                $query->where('order_date', '<=', $filters['to_date']);
                $parameterNames['to_date'] = $filters['to_date'];
            }
        }

        $orders = $query->orderBy('order_date', 'desc')->paginate(20);
        session(['printInvoiceId' => null]);

        return view('orders.index', compact('orders', 'customers', 'parameterNames'));
    }

    public function create(Request $request)
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        $products = Product::available()->with(['series', 'color', 'storage'])->get();
        $customers = Customer::pluck('name', 'id')->prepend('Walk in Customer', 0);
        $productOrder = null;
        $totalPrice = 0;

        if ($request->id) {
            $productOrder = Product::available()->with(['series', 'color', 'storage'])->find($request->id);
            $totalPrice = $productOrder ? $productOrder->selling_price : 0;
        }

        return view('orders.create', compact('products', 'customers', 'productOrder', 'currentDate', 'totalPrice'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_date' => 'required|date',
            'customer'   => 'required',
            'product'    => 'required|array|min:1',
        ]);

        $order = Order::create([
            'customer_id'    => $request->customer,
            'employee_id'    => Auth::user()->id,
            'status'         => Order::STATUS_ACTIVE,
            'total_amount'   => $request->total_amount,
            'payment_status' => Order::PAYMENT_STATUS_PAID,
            'payment_type'   => Order::PAYMENT_TYPE_CASH,
            'note'           => $request->note ?? '',
            'order_date'     => $request->order_date,
        ]);

        foreach ($request->product as $key => $productId) {
            $product = Product::find($productId);
            if ($product) {
                OrderDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $productId,
                    'unit_price' => $request->unit_price[$key] ?? $product->selling_price,
                ]);
                $product->update(['status' => Product::STATUS_ID_SOLD]);
            }
        }

        return redirect()->route('sales.invoice', withLang(['order' => $order->id]));
    }

    public function show(string $lang, Order $order)
    {
        $order = $order->with('orderDetails', 'customer', 'employee')->findOrFail($order->id);
        $order_detals = OrderDetail::where('order_id', $order->id)->with('product')->get();
        return view('orders.show', compact('order', 'order_detals'));
    }

    public function checkProductOrder(Request $request)
{
    if (empty($request->productIds)) {
        return response()->json(['message' => 'No products selected.'], 422);
    }
    foreach ($request->productIds as $productId) {
        $product = Product::available()->find($productId);
        if (!$product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }
    }
    return response()->json(['message' => 'Submiting Order'], 201);
}

    /**
     * Delete the specified order.
     */
    public function destroy(string $lang, Order $order)
    {
        OrderDetail::where('order_id', $order->id)->delete();
        $order->delete();
        return redirect()->route('sales.index', withLang())->with('success', 'Sale deleted successfully');
    }

    public function invoice(string $lang, Order $order)
    {
        $order = $order->with('orderDetails', 'customer', 'employee')->findOrFail($order->id);
        $order_detals = OrderDetail::where('order_id', $order->id)->with('product')->get();
        return view('orders.invoice', compact('order', 'order_detals'));
    }

    /**
     * Generate PDF invoice for the specified order.
     */
    public function invoicePdf(Request $request, string $lang, Order $order)
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        $order = $order->with('orderDetails', 'customer', 'employee')->findOrFail($order->id);
        $order_detals = OrderDetail::where('order_id', $order->id)->with('product')->get();
        $file_pdf = 'invoice-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . '.pdf';
        $type = $request->type ?? 'download';
        return view('orders.invoice-pdf', compact('order', 'order_detals', 'currentDate', 'file_pdf', 'type'));
    }
}