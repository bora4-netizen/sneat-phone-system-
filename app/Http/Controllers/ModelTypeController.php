<?php

namespace App\Http\Controllers;

use App\Models\ModelType;
use SoftDeletes;
use Illuminate\Http\Request;

class ModelTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $lang)
    {
        //

        $model_types = ModelType::withCount([
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

        return view('model_type.index', ['model_types' => $model_types]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('model_type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:25|unique:model_types,name',
        ]);
        $model_type = new ModelType();
        $model_type->name = $request->name;
        $model_type->save();
        return redirect()->route('model_type.index', withLang());

        ModelType::create([
            'name' => $request->name,

        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ModelType $model_types)
    {
        return view('model_type.show', ['modelType' => $model_types]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $model_type, string $lang, string $id)
    {
        $model_type = ModelType::findorfail($id);
        return view('model_type.edit', ['model_type' => $model_type]);
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
            'name' => 'required|unique:model_types'
        ]), $messages);
        // dd($messages);
        $model_type = ModelType::findorfail($request->id);
        $model_type->name = $request->name;
        $model_type->save();
        // dd($model_type);
        return redirect()->route('model_type.index', withLang());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function softdelete($id)
    {
        $model = ModelType::findOrFail($id);
        $model->delete();


        return redirect()->back()->with('success', 'Model type deleted successfully!');
    }

    public function destroy(string $lang, ModelType $model_type)
    {
        $model_type->delete();
        return redirect()->route('model_type.index', withLang())->with('success', 'Deleted successfully');
    }
}
