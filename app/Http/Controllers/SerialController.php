<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Models\Brand;
use Illuminate\Http\Request;

class SerialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

        $serials = Series::withCount([
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
        $brands = Brand::pluck('name', 'id');

        return view('series.index',['brands' => $brands, 'serials' => $serials]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // return view('Series.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'name' => 'required|string|max:25',
            'brand' => 'required',
        ]);
        $serial = new Series();
        $serial->name = $request->name;
        $serial->brand_id = $request->brand;
        $serial->save();
        return redirect()->route('serial.index', withLang());
    }

    /**
     * Display the specified resource.
     */
    public function show(Series $serials)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $serial, string $lang, string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $lang)
    {

        $messages = [
            'required' => 'This field can not be blanked',
            'unique' => 'This model type is exists'
        ];
        $validatedData = $request->validate(([
            'name' => 'required|unique:series'
        ]), $messages);
        // dd($messages);
        $serial = Series::findorfail($request->id);
        $serial->name = $request->name;
        $serial->save();
        // dd($serial);
        return redirect()->route('serial.index', withLang());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Series $serial)
    {
        //
    }
}
