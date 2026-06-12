<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Series;
use App\Models\Color;
use App\Models\ModelType;
use App\Models\Network;
use App\Models\Storage;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','store']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      $query = Product::query()->with('network');

      $brands = Brand::pluck('name', 'id');
      $series = Series::pluck('name', 'id');
      $colors = Color::pluck('name', 'id');
      $modelTypes = ModelType::pluck('name', 'id');
      $storage = Storage::pluck('name', 'id');

      $type_of_machines = Product::TYPE_OF_MACHINE;
      $conditions = Product::CONDITION;
      $status = Product::getStatuses();

      $parameterNames = [];

      if ($request->search) {
        $filters = $request->only(['condition', 'brand_id', 'series_id', 'type_of_machine', 'color_id', 'storage_id', 'status']);

        foreach ($filters as $key => $value) {
            if (!empty($value)) {
                $query->where($key, $value);
                $parameterNames[$key] = $value;
            }
        }

        if ($request->has('search_product') && !empty($request->search_product)) {
            $search_product = $request->search_product;
            $query->where(function ($query) use ($search_product) {
                $query->where('product_name', 'like', '%' . $search_product . '%')
                    ->orWhere('product_imei', 'like', '%' . $search_product . '%');
            });
            $parameterNames['search_product'] = $search_product;
        }
      }

      $view = 'list';
      $viewUrl = 'gride';

      if ($request->view && $request->view == 'gride') {
        $view = $request->view;
        $viewUrl = 'list';
      }

      $url = $request->fullUrlWithQuery(['view' => $viewUrl]);
      // $products = $query->orderBy('status', 'asc')->orderBy('purchase_date', 'desc')->paginate(20);
      // $totalProductAvailable = $query->where('status', 1)->count();
      // $totalProductSold = Product::where('status', 2)->count();
      $totalProductAvailable = Product::where('status', 1)->count();
$totalProductSold = Product::where('status', 2)->count();
$products = Product::paginate(20);

      return view('products.index', compact('products', 'view', 'brands', 'series', 'colors', 'modelTypes', 'storage', 'conditions', 'type_of_machines', 'status', 'parameterNames', 'url', 'totalProductAvailable', 'totalProductSold'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::pluck('name', 'id');
        $series = Series::pluck('name', 'id');
        $colors = Color::pluck('name', 'id');
        $modelTypes = ModelType::pluck('name', 'id');
        $storage = Storage::pluck('name', 'id');
        $networks = Network::pluck('name', 'id');

        return view('products.create', compact(
            'brands',
            'series',
            'colors',
            'modelTypes',
            'storage',
            'networks'
        ));

      
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
      $product = new Product();
      $product->product_code = $request->product_code ?? '';
      $product->product_name = $request->product_name;
      $product->product_imei = $request->product_imei;
      $product->brand_id = $request->brand;
      $product->series_id = $request->series;
      $product->color_id = $request->color;
      $product->model_type_id = $request->model_type;
      $product->condition = $request->condition;
      $product->storage_id = $request->storage;
      $product->type_of_machine = $request->type_of_machine;
      $product->network_id = $request->network;
      $product->battery_percentage = $request->battery_percentage;
      $product->percentage = $request->percentage;
      $product->purchase_price = $request->purchase_price;
      $product->selling_price = $request->selling_price;
      $product->employee_id = Auth::user()->id;
      $product->purchase_date = $request->purchase_date;
      $product->image = '';
      $product->status = $request->status;
      $product->note = $request->note ?? '';

      $product->save();
      if ($image = $request->file('image')) {
        $destinationPath = 'images/product/';
        $formattedNumber = str_pad($product->id, 5, '0', STR_PAD_LEFT);
        $filename = $image->getClientOriginalName();
        $productImage = $formattedNumber. "_" .md5($filename . time()) . "." . $image->getClientOriginalExtension();
        $image->move($destinationPath, $productImage);
        $product->image = $productImage;
        $product->save();
      }
       // Optionally, you can return a response to indicate success or redirect to a different page.
      // return redirect()->route('products.show', withLang(['product' => $product->id]));
      return redirect()->route('products.index', withLang())
    ->with('success', 'Product saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $lang, Product $product)
    {
      $product = $product->with('brand', 'series', 'color', 'modelType', 'storage')->findOrfail($product->id);
      return view('products.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $lang, Product $product)
    {
        $brands = Brand::pluck('name', 'id');
        $series = Series::pluck('name', 'id');
        $colors = Color::pluck('name', 'id');
        $modelTypes = ModelType::pluck('name', 'id');
        $storage = Storage::pluck('name', 'id');
        $networks = Network::pluck('name', 'id');

        return view('products.edit', compact(
            'product',
            'brands',
            'series',
            'colors',
            'modelTypes',
            'storage',
            'networks'
        ));

      
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $lang, Product $product)
    {
        $product->product_code = $request->product_code ?? '';
        $product->product_name = $request->product_name;
        $product->product_imei = $request->product_imei;
        $product->brand_id = $request->brand;
        $product->series_id = $request->series;
        $product->color_id = $request->color;
        $product->model_type_id = $request->model_type;
        $product->condition = $request->condition;
        $product->storage_id = $request->storage;
        $product->type_of_machine = $request->type_of_machine;
        $product->network_id = $request->network;
        $product->battery_percentage = $request->battery_percentage;
        $product->percentage = $request->percentage;
        $product->purchase_price = $request->purchase_price;
        $product->selling_price = $request->selling_price;
        $product->purchase_date = $request->purchase_date;
        $product->status = $request->status;
        $product->note = $request->note ?? '';

        // update image if exists
        if ($image = $request->file('image')) {
            $destinationPath = 'images/product/';
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move($destinationPath, $filename);

            $product->image = $filename;
        }

        $product->save();

        return redirect()->route('products.index', withLang())
            ->with('success', 'Product updated successfully');

      
    }

    public function getSeriesBybrand(string $lang, string $id)
  {
    // Fetch data based on $selectedValue
    $series = Series::where('brand_id', $id)->get();

    return response()->json($series);
  }

  public function getProductById(string $lang, string $id)
  {
    // Fetch data based on $selectedValue
    $product = Product::with('series','color','storage')->where('status', Product::STATUS_ID_AVAILABLE)->find($id);

    if ($product) {
      // If the product is found, respond with a 200 OK status
      return response()->json($product);
    } else {
        // If the product is not found, respond with a 404 Not Found status
        return response()->json(['message' => 'Product not found'], 404);
    }
  }

  public function destroy(string $lang, Product $product)
  {
    $product->delete();
    return redirect()->route('products.index', withLang());
  }

}
