<?php

namespace App\Http\Controllers;

use App\Models\Network;
use Illuminate\Http\Request;

class NetworkController extends Controller
{
    public function index(Request $request)
    {
        $networks = Network::withCount([
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

        return view('network.index', ['networks' => $networks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
           
         return view('modelType.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'name' => 'required|string|max:25|unique:networks,name',
        ]);
        $network = new Network();
        $network->name = $request->name;
        $network->save();
        return redirect()->route('network.index', withLang());
    }

    /**
     * Display the specified resource.
     */
    public function show(Network $networks) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $network, string $lang, string $id)
    {
        $network = Network::findOrFail($id);
        return view('network.edit', ['network' => $network]);
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
            'name' => 'required|unique:networks'
        ]), $messages);
        // dd($messages);
        $network = Network::findorfail($request->id);
        $network->name = $request->name;
        $network->save();
        // dd($network);
        return redirect()->route('network.index', withLang());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $lang, Network $network)
    {
        $network->delete();
        return redirect()->route('network.index', withLang())->with('success', 'Deleted successfully');
    }
}
