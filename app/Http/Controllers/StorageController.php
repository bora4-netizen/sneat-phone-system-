<?php

namespace App\Http\Controllers;

use App\Models\Storage;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $storages = storage::withCount([
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
        return view('storages.index', ['storages' => $storages]);
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
            'name' => 'required|string|max:25|unique:storages,name',
        ]);
        $storage = new storage();
        $storage->name = $request->name;
        $storage->save();
        return redirect()->route('storage.index', withLang());
    }

    /**
     * Display the specified resource.
     */
    public function show(Storage $storage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Storage $storage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Storage $storage)
    {
        //
        $validatedData = $request->validate([
            'name' => 'required|string|max:25|unique:storages,name',
        ]);
        $storage = new storage();
        $storage->name = $request->name;
        $storage->save();
        return redirect()->route('storage.index', withLang());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Storage $storage)
    {
        //
    }
}
