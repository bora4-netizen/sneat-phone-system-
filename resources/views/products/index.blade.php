@extends('layouts.app')
@push('styles')
@endpush

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="pull-right">
                @can('product-create')
                    <a class="btn btn-outline-primary" href="{{ route('products.create', withLang()) }}">
                        <i class='bx bx-plus-circle'></i> {{ __('product.btn_create_title') }}
                    </a>
                @endcan
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productSearchModal">
                    <i class='bx bx-search'></i>
                </button>
            </div>
        </div>
    </div>

    <div class="col-xl-12 mb-3 d-flex justify-content-end align-items-center">
        <div class="btn-toolbar demo-inline-spacing" role="toolbar">
            <div class="btn-group" role="group">
                @if($view == 'gride')
                    <a href="{{ $url }}" class="btn btn-outline-secondary">
                        <i class='bx bx-list-ul'></i>
                    </a>
                @else
                    <a href="{{ $url }}" class="btn btn-outline-secondary">
                        <i class='bx bxs-grid-alt'></i>
                    </a>
                @endif
            </div>
        </div>
    </div>

    @if($view == 'gride')
        <h6>{{ __('product.list_title') }} : {{$totalProductAvailable}} ({{ __('product.btn_lists') }}:{{$totalProductSold}})</h6>

        <!-- Grid Product -->
        <div class="row row-cols-1 row-cols-md-4 g-4 mb-5">
            @foreach ($products as $key => $product)
            <div class="col">
                <div class="card h-100 rounded-3 shadow-sm">

                    <div class="position-relative">
                        <img class="card-img-top" style="height:180px;object-fit:cover;"
                            src="{{ $product->image_name }}" alt="Product image"
                            onError="this.onerror=null;this.src='{{ asset('/assets/img/blank-product.svg') }}';">
                        <div class="position-absolute top-0 start-0 p-2 d-flex gap-1">
                            {!! $product->condition_label_badges_name ?? '' !!}
                            {!! $product->status_badges_name ?? '' !!}
                        </div>
                    </div>

                    <div class="card-body d-flex flex-column px-3 pt-3 pb-2">

                        <h5 class="fw-bold mb-3">{{ $product->product_name ?? '' }}</h5>
                        <h6 class="fw-bold mb-2">{{ setToStringDolla($product->selling_price ?? 0) }}</h6>

                        <table class="table table-sm table-borderless mb-0 small">
                            <tr>
                                <td class="text-muted fw-semibold ps-0" style="width:44%">{{ __('product.imei') }}</td>
                                <td class="fw-semibold text-end pe-0">{{ $product->product_imei ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-semibold ps-0">{{ __('product.series') }}</td>
                                <td class="fw-semibold text-end pe-0">{{ $product->series->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-semibold ps-0">{{ __('product.color') }}</td>
                                <td class="fw-semibold text-end pe-0">{{ $product->color->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-semibold ps-0">{{ __('product.model') }}</td>
                                <td class="fw-semibold text-end pe-0">{{ $product->modelType->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-semibold ps-0">{{ __('product.storage') }}</td>
                                <td class="fw-semibold text-end pe-0">{{ $product->storage->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-semibold ps-0">{{ __('product.machine') }}</td>
                                <td class="fw-semibold text-end pe-0">{{ $product->network->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-semibold ps-0">{{ __('product.percentage') }}</td>
                                <td class="fw-semibold text-end pe-0">{{ $product->percentage ?? '' }}%</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-semibold ps-0">{{ __('product.battery_percentage') }}</td>
                                <td class="fw-semibold text-end pe-0">{{ $product->battery_percentage ?? '' }}%</td>
                            </tr>
                        </table>

                        <div class="d-flex justify-content-end gap-2 pt-2 mt-auto border-top">
                            @can('product-list')
                            <a href="{{ route('products.show', withLang(['product' => $product->id])) }}" class="btn btn-icon btn-outline-secondary">
                                <span class="tf-icons bx bx-detail"></span>
                            </a>
                            @endcan
                            @can('product-edit')
                            <a href="{{ route('products.edit', withLang(['product' => $product->id])) }}" class="btn btn-icon btn-outline-secondary">
                                <span class="tf-icons bx bx-edit-alt"></span>
                            </a>
                            @endcan
                            @can('order-create')
                                @if(!$product->isSoldOut())
                                    <a href="{{ route('sales.create', withLang(['id' => $product->id])) }}" class="btn btn-icon btn-outline-secondary">
                                        <span class="tf-icons bx bxs-cart-alt"></span>
                                    </a>
                                @endif
                            @endcan
                            <form method="POST" action="{{ route('products.destroy', withLang(['product' => $product->id])) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-icon btn-outline-danger"
                                    onclick="return confirm('{{ __('common.lbl_confirm_delete') }}')">
                                    <span class="tf-icons bx bx-trash"></span>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pagination">
            {!! $products->withQueryString()->appends(request()->except('page'))->links('pagination::bootstrap-5') !!}
        </div>

    @else
        <!-- List Product Table -->
        <div class="card">
            <div class="card-header">
                <h5>{{ __('product.list_title') }}</h5>
                <h6>{{ __('product.list_title') }} : {{ __('product.btn_lists') }} {{$totalProductAvailable}} ({{ __('report.stock.sold') }}:{{$totalProductSold}})</h6>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{ __('product.name') }}</th>
                            <th>{{ __('product.imei') }}</th>
                            <th>{{ __('product.series') }}</th>
                            <th>{{ __('product.color') }}</th>
                            <th>{{ __('product.model') }}</th>
                            <th>{{ __('product.storage') }}</th>
                            <th>{{ __('product.condition.title') }}</th>
                            <th>{{ __('product.machine') }}</th>
                            <th>{{ __('product.status') }}</th>
                            @canany(['product-list', 'product-edit', 'product-delete', 'order-create'])
                            <th>{{ __('common.lbl_actions') }}</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $key => $product)
                            <tr>
                                <td>
                                    <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                            data-bs-placement="top" class="avatar avatar-xs pull-up"
                                            title="{{ $product->name }}">
                                            <img src="{{ $product->image_name }}" alt="Product"
                                                class="rounded-circle"
                                                onError="this.onerror=null;this.src='{{ asset('/assets/img/blank-product.svg') }}';" />
                                        </li>
                                    </ul>
                                </td>
                                <td><strong>{{ $product->product_name ?? '' }}</strong></td>
                                <td>{{ $product->product_imei ?? '' }}</td>
                                <td>{{ $product->series->name ?? '' }}</td>
                                <td>{{ $product->color->name ?? '' }}</td>
                                <td>{{ $product->modelType->name ?? '' }}</td>
                                <td>{{ $product->storage->name ?? '' }}</td>
                                <td>{!! $product->condition_label_badges_name ?? '' !!}</td>
                                <td>{{ $product->network->name ?? '' }}</td>
                                <td>{!! $product->status_badges_name ?? '' !!}</td>
                                <td>
                                    @can('product-list')
                                    <a href="{{ route('products.show', withLang(['product' => $product->id])) }}" class="btn btn-icon btn-outline-secondary">
                                        <span class="tf-icons bx bx-detail"></span>
                                    </a>
                                    @endcan
                                    @can('product-edit')
                                    <a href="{{ route('products.edit', withLang(['product' => $product->id])) }}" class="btn btn-icon btn-outline-secondary">
                                        <span class="tf-icons bx bx-edit-alt"></span>
                                    </a>
                                    @endcan
                                    @can('order-create')
                                        @if(!$product->isSoldOut())
                                            <a href="{{ route('sales.create', withLang(['id' => $product->id])) }}" class="btn btn-icon btn-outline-secondary">
                                                <span class="tf-icons bx bxs-cart-alt"></span>
                                            </a>
                                        @endif
                                    @endcan
                                    <form method="POST" action="{{ route('products.destroy', withLang(['product' => $product->id])) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-outline-danger"
                                            onclick="return confirm('{{ __('common.lbl_confirm_delete') }}')">
                                            <span class="tf-icons bx bx-trash"></span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="no-data">
                                <th colspan="10" class="p-5 text-center">{{ __('common.lbl_no_data') }}</th>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="pagination">
                    {!! $products->withQueryString()->appends(request()->except('page'))->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
        <!--/ List Product Table -->
    @endif

    <!-- Search Modal -->
    <div class="modal fade" id="productSearchModal" tabindex="-1" aria-hidden="true">
        <form method="GET" action="{{ url()->current() }}">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('product.serahc_title') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="view" value="{{ $view ?? '' }}"/>
                        <input type="hidden" class="form-control" name="search" value="true"/>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="product-name" class="form-label">{{ __('product.label_search_name_or_imei') }}</label>
                                <input type="text" id="product-name" name="search_product"
                                    value="@if(isset($parameterNames['search_product']) && $parameterNames['search_product'] != '') {{ $parameterNames['search_product'] }} @endif"
                                    class="form-control" placeholder="{{ __('product.placholder_search_name_or_imei') }}" />
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col mb-0">
                                <label for="Condition" class="form-label">{{ __('product.condition.title') }}</label>
                                <select id="condition" class="select2 form-select" name="condition">
                                    <option value="">{{ __('common.lbl_select') }}</option>
                                    @foreach ($conditions as $key => $value)
                                        <option value="{{ $key }}" @if(isset($parameterNames['condition']) && $parameterNames['condition'] == $key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col mb-0">
                                <label for="brand" class="form-label">{{ __('product.brand') }}</label>
                                <select id="brand" class="select2 form-select" name="brand_id">
                                    <option value="">{{ __('common.lbl_select') }}</option>
                                    @foreach ($brands as $key => $value)
                                        <option value="{{ $key }}" @if(isset($parameterNames['brand_id']) && $parameterNames['brand_id'] == $key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col mb-0">
                                <label for="series" class="form-label">{{ __('product.series') }}</label>
                                <select id="series" class="select2 form-select" name="series_id">
                                    <option value="">{{ __('common.lbl_select') }}</option>
                                    @foreach ($series as $key => $value)
                                        <option value="{{ $key }}" @if(isset($parameterNames['series_id']) && $parameterNames['series_id'] == $key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col mb-0">
                                <label for="type_of_machine" class="form-label">{{ __('product.type_of_machine') }}</label>
                                <select id="type_of_machine" class="select2 form-select" name="type_of_machine">
                                    <option value="">{{ __('common.lbl_select') }}</option>
                                    @foreach ($type_of_machines as $key => $value)
                                        <option value="{{ $key }}" @if(isset($parameterNames['type_of_machine']) && $parameterNames['type_of_machine'] == $key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="color" class="form-label">{{ __('product.color') }}</label>
                                <select id="color" class="select2 form-select" name="color_id">
                                    <option value="">{{ __('common.lbl_select') }}</option>
                                    @foreach ($colors as $key => $value)
                                        <option value="{{ $key }}" @if(isset($parameterNames['color_id']) && $parameterNames['color_id'] == $key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col mb-0">
                                <label for="storage" class="form-label">{{ __('product.storage') }}</label>
                                <select id="storage" class="select2 form-select" name="storage_id">
                                    <option value="">{{ __('common.lbl_select') }}</option>
                                    @foreach ($storage as $key => $value)
                                        <option value="{{ $key }}" @if(isset($parameterNames['storage_id']) && $parameterNames['storage_id'] == $key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col mb-0">
                                <label for="status" class="form-label">{{ __('product.status') }}</label>
                                <select id="status" class="select2 form-select" name="status">
                                    <option value="">{{ __('common.lbl_select') }}</option>
                                    @foreach ($status as $key => $value)
                                        <option value="{{ $key }}" @if(isset($parameterNames['status']) && $parameterNames['status'] == $key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('products.index', withLang(['view' => $view])) }}" class="btn btn-outline-secondary">
                            {{ __('button.clear') }}
                        </a>
                        <button type="submit" class="btn btn-primary">{{ __('button.search') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
<!-- / Content -->
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('#brand').change(function() {
            var brandID = $(this).val();
            $('#series').prop("disabled", false);
            if (brandID !== '') {
                $.ajax({
                    type: 'GET',
                    url: '/en/series/brand/' + brandID,
                    dataType: 'json',
                    success: function(data) {
                        var series = $('#series');
                        series.empty();
                        series.append('<option>{{ __('common.lbl_select') }}</option>');
                        if (data.length > 0) {
                            $.each(data, function(key, value) {
                                series.append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    }
                });
            } else {
                $('#series').empty().append('<option value="">{{ __('common.lbl_select') }}</option>');
                $('#series').prop("disabled", true);
            }
        });
    });

    function submitForm() {
        $('.submit-delete').click();
    }
</script>
@endpush