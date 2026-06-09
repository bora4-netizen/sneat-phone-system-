@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <div class="container-fluid flex-grow-1 container-p-y">

        <div class="card">

            <h3 class="card-header fw-bold">
                {{ __('product.show_title') }}
            </h3>

            <div class="card-body">

                <!-- Product Image -->
                <div class="mb-4">
                    <img
                        src="{{ $product->image_name }}"
                        alt="product-image"
                        width="100"
                        height="100"
                        onerror="this.onerror=null;this.src='{{ asset('/assets/img/blank-product.svg') }}';"
                    >
                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <strong>{{ __('product.name') }} :</strong>
                        {{ $product->product_name ?? '' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>{{ __('product.imei') }} :</strong>
                        {{ $product->product_imei ?? '' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>{{ __('product.code') }} :</strong>
                        {{ $product->product_code ?? '' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>{{ __('product.brand') }} :</strong>
                        {{ $product->brand->name ?? '' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>{{ __('product.series') }} :</strong>
                        {{ $product->series->name ?? '' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>{{ __('product.model') }} :</strong>
                        {{ $product->modelType->name ?? '' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>{{ __('product.color') }} :</strong>
                        {{ $product->color->name ?? '' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>{{ __('product.storage') }} :</strong>
                        {{ $product->storage->name ?? '' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>{{ __('product.machine') }} :</strong>
                        {{ $product->network->name ?? '' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>{{ __('product.condition.title') }} :</strong>
                        {{ strip_tags($product->condition_label_badges_name ?? '') }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>{{ __('product.type_of_machine') }} :</strong>
                        {{ $product->type_of_machine ?? '' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>{{ __('product.battery_percentage') }} :</strong>
                        {{ $product->battery_percentage ? $product->battery_percentage.'%' : '' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>{{ __('product.percentage') }} :</strong>
                        {{ $product->percentage ? $product->percentage.'%' : '' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>{{ __('product.purchase_price') }} :</strong>
                        {{ $product->purchase_price ? '$'.number_format($product->purchase_price, 2) : '' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>{{ __('product.selling_price') }} :</strong>
                        {{ $product->selling_price ? '$'.number_format($product->selling_price, 2) : '' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>{{ __('product.purchase_date') }} :</strong>
                        {{ $product->purchase_date ? \Carbon\Carbon::parse($product->purchase_date)->format('Y-m-d') : '' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>{{ __('product.status') }} :</strong>
                        {{ strip_tags($product->status_badges_name ?? '') }}
                    </div>

                    @if($product->note)
                    <div class="col-md-12 mb-3">
                        <strong>{{ __('product.note') }} :</strong>
                        {{ $product->note }}
                    </div>
                    @endif

                </div>

                <div class="mt-4">
                    <a href="{{ route('products.index', withLang()) }}" class="btn btn-outline-secondary me-2">
                        {{ __('product.btn_lists') }}
                    </a>

                    @can('product-edit')
                    <a href="{{ route('products.edit', withLang(['product' => $product->id])) }}" class="btn btn-primary">
                        {{ __('button.edit') }}
                    </a>
                    @endcan
                </div>

            </div>

        </div>

    </div>
</div>

@endsection