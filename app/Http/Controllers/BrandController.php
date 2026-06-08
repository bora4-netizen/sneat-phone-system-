<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $lang)
    {
        //
        $brands = Brand::withCount([
          'products',
          'products as products_status_instock_count' => function ($query) {
              $query->where('status', 1);
          },
          'products as products_status_sold_count' => function ($query) {
              $query->where('status', 2);
          },
          'products as products_status_loan_count' => function ($query) {
              $query->where('status', 3);
          },
        ])->get();
        return view('brands.index', ['brands' => $brands]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'name' => 'required|string|max:25|unique:brands,name',
        ]);
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->save();
        return redirect()->route('brand.index', withLang());
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        //
        $messages = [
            'required' => 'This field can not be blanked',
            'unique' => 'This model type is exists'
        ];
        $validatedData = $request->validate(([
            'name' => 'required|unique:brands'
        ]), $messages);
        // dd($messages);
        $brand = Brand::findorfail($request->id);
        $brand->name = $request->name;
        $brand->save();
        // dd($brand);
        return redirect()->route('brand.index', withLang());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $lang, Brand $brand)
{
    $brand->delete(); 
    return redirect()->route('brand.index', withLang())->with('success', 'Deleted successfully');
}

}
