@extends('layouts.app')

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">

    {{-- ── SUMMARY CARDS ─────────────────────────────────────────────── --}}
    <div class="row">
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="badge bg-label-primary p-2">
                                <i class="fa-solid fa-mobile-button"></i>
                            </span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">{{ __('report.product.total_product') }}</span>
                    <h3 class="card-title text-nowrap mb-1">{{ $totalProduct ?? '' }}</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="badge bg-label-danger p-2">
                                <i class="fa-solid fa-mobile-button"></i>
                            </span>
                        </div>
                    </div>
                    <!-- <span class="fw-semibold d-block mb-1">{{ __('report.product.total_product_new') }}</span> -->
                     <span class="fw-semibold d-block mb-1 text-nowrap">{{ __('report.product.total_product_new') }}</span>
                    <h3 class="card-title text-nowrap mb-1">{{ $totalProductConditionNew }}</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="badge bg-label-info p-2">
                                <i class="fa-solid fa-mobile-button"></i>
                            </span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">{{ __('report.product.total_purchase') }}</span>
                    <h3 class="card-title text-nowrap mb-1">{{ setToStringDolla($totalPurchasePrice) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="badge bg-label-success p-2">
                                <i class="fa-solid fa-mobile-button"></i>
                            </span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">{{ __('report.product.total_selling') }}</span>
                    <h3 class="card-title text-nowrap mb-1">{{ setToStringDolla($totalSellingPrice) }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- ── TABLE + ACTION BAR ────────────────────────────────────────── --}}
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3" style="overflow: visible;">
                <x-report-menu-bar />

                <x-reports.action-buttons
                    :pdfRoute="'reports.product.pdf'"
                    :pdfData="array_merge(withLang(['type' => 'download']), $parameterNames)"
                    :printRoute="'reports.product.pdf'"
                    :printData="array_merge(withLang(['type' => 'print']), $parameterNames)"
                    :routeSelectSearch="'reports.product'"
                />
            </ul>

            <!-- Product Report Table -->
            <div class="card">
                <h5 class="card-header">{{ __('report.stock.products') }}</h5>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>{{ __('report.stock.series') }}</th>
                                    <th>{{ __('report.stock.brand') }}</th>
                                    <th>{{ __('report.stock.locked') }}</th>
                                    <th>{{ __('product.storage') }}</th>
                                    <th>{{ __('product.imei') }}</th>
                                    <th>{{ __('product.color') }}</th>
                                    <th class="text-center">{{ __('product.condition.title') }}</th>
                                    <th class="text-center">{{ __('product.purchase_price') }}</th>
                                    <th class="text-center">{{ __('product.selling_price') }}</th>
                                    <th class="text-center">{{ __('product.note') }}</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @forelse ($products as $product)
                                    <tr>
                                        <td><strong>{{ $product->id }}</strong></td>
                                        <td><strong>{{ $product->series_name }}</strong></td>
                                        <td>{{ $product->brand->name }}</td>
                                        <td>{{ $product->network->name ?? '' }}</td>
                                        <td>{{ $product->storage->name }}</td>
                                        <td>{{ $product->product_imei }}</td>
                                        <td>{{ $product->color->name }}</td>
                                        <td>{!! $product->condition_label_badges_name ?? '' !!}</td>
                                        <td class="text-center">{{ setToStringDolla($product->purchase_price) }}</td>
                                        <td class="text-center">{{ setToStringDolla($product->selling_price) }}</td>
                                        <td>{!! $product->note !!}</td>
                                    </tr>
                                @empty
                                    <tr class="no-data">
                                        <td colspan="11" class="p-5 text-center">{{ __('common.lbl_no_data') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="pagination">
                            {!! $products->withQueryString()->appends(request()->except('page'))->links('pagination::bootstrap-5') !!}
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Product Report Table -->
        </div>
    </div>
</div>

{{-- ── SEARCH MODAL ──────────────────────────────────────────────────── --}}
<div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
    <form method="GET" action="{{ url()->current() }}">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('common.lbl_search') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="search" value="true" />

                    <div class="row g-2 mb-3">
                        <div class="col mb-0">
                            <label for="search_name" class="form-label">{{ __('product.name') }}</label>
                            <input
                                type="text"
                                id="search_name"
                                class="form-control"
                                name="search_name"
                                value="{{ $parameterNames['search_name'] ?? '' }}"
                            />
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col mb-0">
                            <label for="from-date" class="form-label">{{ __('common.lbl_from_date') }}</label>
                            <input
                                type="date"
                                id="from-date"
                                class="form-control"
                                name="from_date"
                                value="{{ $parameterNames['from_date'] ?? '' }}"
                            />
                        </div>
                        <div class="col mb-0">
                            <label for="to-date" class="form-label">{{ __('common.lbl_to_date') }}</label>
                            <input
                                type="date"
                                id="to-date"
                                class="form-control"
                                name="to_date"
                                value="{{ $parameterNames['to_date'] ?? '' }}"
                            />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('reports.product', withLang()) }}" class="btn btn-outline-secondary">
                        {{ __('button.clear') }}
                    </a>
                    <button type="submit" class="btn btn-primary">{{ __('button.search') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection