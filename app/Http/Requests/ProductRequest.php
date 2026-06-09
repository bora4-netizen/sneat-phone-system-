<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    // public function rules(): array
    // {
    //   return [
    //     'product_name' => 'required|string|max:255',
    //     'product_imei' => 'required|numeric',
    //     'brand' => 'required|integer|exists:brands,id',
    //     'series' => 'required|integer|exists:series,id',
    //     'color' => 'required|integer|exists:colors,id',
    //     'model_type' => 'required|integer|exists:model_types,id',
    //     'condition' => 'required|string|max:255',
    //     'storage' => 'required|integer|exists:storages,id',
    //     'type_of_machine' => 'required|string|max:255',
    //     'network' => 'required_if:type_of_machine,2',
    //     'purchase_price' => 'required|numeric',
    //     'selling_price' => 'numeric',
    //     'purchase_date' => 'required|date',
    //     'status' => 'required|string', // Change 'active' and 'inactive' to the valid status values.
    // ];
    // }

    public function rules(): array
{
    return [
        'product_name'    => 'required|string|max:255',
        'product_imei'    => 'nullable|string|max:255',
        'brand'           => 'nullable|integer|exists:brands,id',
        'series'          => 'nullable|integer|exists:series,id',
        'color'           => 'nullable|integer|exists:colors,id',
        'model_type'      => 'nullable|integer|exists:model_types,id',
        'condition'       => 'nullable|string|max:255',
        'storage'         => 'nullable|integer|exists:storages,id',
        'type_of_machine' => 'nullable|string|max:255',
        'network'         => 'nullable|integer|exists:networks,id',
        'battery_percentage' => 'nullable|integer|min:0|max:100',
        'percentage'      => 'nullable|integer|min:0|max:100',
        'purchase_price'  => 'nullable|numeric|min:0',
        'selling_price'   => 'nullable|numeric|min:0',
        'purchase_date'   => 'nullable|date',
        'status'          => 'required|string',
        'note'            => 'nullable|string',
        'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];
}
}
