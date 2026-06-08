<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrderCustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:order-create');
    }

    public function index()
    {
        $products = Product::available()->with(['series', 'color', 'storage', 'brand'])->get();
        $brands = Brand::all();
        $customers = Customer::pluck('name', 'id')->prepend('Walk in Customer', 0);
        $currentDate = Carbon::now()->format('Y-m-d');
        $order = Order::orderBy('id', 'desc')->first();
        $nextOrderId = $order ? $order->id + 1 : 1;

        return view('orderCustomer.index', compact('products', 'brands', 'customers', 'currentDate', 'nextOrderId'));
    }
    public function search(Request $request)
    {
        $query = $request->input('q');

        $products = Product::available()
            ->with(['series', 'color', 'storage', 'brand'])
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhereHas('brand', fn($b) => $b->where('name', 'LIKE', "%{$query}%"))
                    ->orWhere('price', 'LIKE', "%{$query}%");
            })
            ->get();

        return response()->json($products);
    }
}
