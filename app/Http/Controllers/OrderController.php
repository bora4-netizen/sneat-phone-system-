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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:order-list|order-create|order-edit|order-delete', ['only' => ['index','store']]);
        $this->middleware('permission:order-create', ['only' => ['create','store']]);
        $this->middleware('permission:order-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:order-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::query();
        $customers = Customer::all();
        $parameterNames = [];

        if ($request->search) {
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

    /**
     * Show the form for creating a new order.
     */
    public function create(Request $request)
    {
        $customers = Customer::all();
        $products = Product::available()->get();

        return view('orders.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request, string $lang)
    {
        // Add your order saving logic here when ready

        return redirect()->route('sales.index', withLang())->with('success', 'Sale created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $lang, Order $order)
    {
        $order = $order->with('orderDetails', 'customer', 'employee')->findOrfail($order->id);
        $order_detals = OrderDetail::where('order_id', $order->id)->with('product')->get();
        return view('orders.show', compact('order', 'order_detals'));
    }

    /**
     * Check product availability before order.
     */
    public function checkProductOrder(Request $request)
    {
        foreach ($request->productIds as $key => $productId) {
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
        $orderDetial = OrderDetail::where('order_id', $order->id)->get();

        return redirect()->route('sales.index', withLang())->with('success', 'Sale deleted successfully');
    }

    /**
     * Display the invoice for the specified order.
     */
    public function invoice(string $lang, Order $order)
    {
        $order = $order->with('orderDetails', 'customer', 'employee')->findOrfail($order->id);
        $order_detals = OrderDetail::where('order_id', $order->id)->with('product')->get();
        return view('orders.invoice', compact('order', 'order_detals'));
    }

    /**
     * Generate PDF invoice for the specified order.
     */
    public function invoicePdf(Request $request, string $lang, Order $order)
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        $order = $order->with('orderDetails', 'customer', 'employee')->findOrfail($order->id);
        $order_detals = OrderDetail::where('order_id', $order->id)->with('product')->get();
        $file_pdf = 'invoice-'.str_pad($order->id, 5, '0', STR_PAD_LEFT).'.pdf';
        $type = $request->type ?? 'download';
        return view('orders.invoice-pdf', compact('order', 'order_detals', 'currentDate', 'file_pdf', 'type'));
    }
}