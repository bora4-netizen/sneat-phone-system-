@extends('layouts.app')

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="badge bg-label-primary p-2"><i class="fa-solid fa-mobile-button"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">{{ __('report.total')}}</span>
                    <h3 class="card-title text-nowrap mb-1">{{  $totalProduct ?? '' }}</h3>
                    <small>{{ __('report.stock.products')}}</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12 mb-4">
          <div class="card">
              <div class="card-body">
                  <div class="card-title d-flex align-items-start justify-content-between">
                      <div class="avatar flex-shrink-0">
                        <span class="badge bg-label-success p-2"><i class="fa-solid fa-mobile-button"></i></span>
                      </div>
                  </div>
                  <span class="fw-semibold d-block mb-1">{{ __('report.stock.instock') }}</span>
                  <h3 class="card-title text-nowrap mb-1">{{ $totalProductAviable }}</h3>
                  <small>{{ __('report.stock.products')}}</small>
              </div>
          </div>
      </div>
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="badge bg-label-info p-2"><i class="fa-solid fa-mobile-button"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">{{ __('report.stock.sold')}}</span>
                    <h3 class="card-title text-nowrap mb-1">{{  $totalProductSold }}</h3>
                    <small>{{ __('report.stock.products')}}</small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="badge bg-label-danger p-2"><i class="fa-solid fa-mobile-button"></i></span>
                        </div>
                    </div>
                    <!-- <span class="fw-semibold d-block mb-1">ប្រាក់ដែលលក់បាន</span>
                    <h3 class="card-title text-nowrap mb-1">{{ setToStringDolla($totalSoldProductPrice) }}</h3>
                    <small>ដុល្លា</small> -->
                    <span class="fw-semibold d-block mb-1">{{ __('report.stock.total_revenue') }}</span>
                    <h3 class="card-title text-nowrap mb-1">{{ setToStringDolla($totalSoldProductPrice) }}</h3>
                    <small>{{ __('report.stock.dollar') }}</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
          <ul class="nav nav-pills flex-column flex-md-row mb-3">
            <x-report-menu-bar />

            <!-- Action Buttons -->
            <x-reports.action-buttons
              :pdfRoute="'reports.stock.pdf'"
              :pdfData="array_merge(withLang(['type' => 'download']), $parameterNames)"
              :printRoute="'reports.stock.pdf'"
              :printData="array_merge(withLang(['type' => 'print']), $parameterNames)"
              :routeSelectSearch="'false'"
            />
          </ul>
            <!-- Stock Report Table -->
            <div class="card">
                <h5 class="card-header">{{ __('report.stock.products') }} {{ $statusName }}</h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                      <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th rowspan="">{{ __('report.stock.series') }}</th>
                              <th rowspan="">{{ __('report.stock.brand') }}</th>
                              <th colspan="5" class="text-center">{{ __('report.stock.used') }}</th>
                              <th colspan="5" class="text-center">{{ __('report.stock.new') }}</th>
                              <th colspan="" class="text-center">{{ __('report.total') }}</th>
                              <th rowspan="" class="text-center">{{ __('report.stock.total_price') }}</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th class="text-center">{{ __('report.stock.sold') }}</th>
                                <th class="text-center">{{ __('report.stock.original') }} </th>
                                <th class="text-center">{{ __('report.stock.unlock') }}</th>
                                <th class="text-center">{{ __('report.stock.broken') }}</th>
                                <th class="text-center">{{ __('report.total') }}</th>
                                <th class="text-center">{{ __('report.stock.sold') }}</th>
                                <th class="text-center">{{ __('report.stock.original') }} </th>
                                <th class="text-center">{{ __('report.stock.unlock') }}</th>
                                <th class="text-center">{{ __('report.total') }}</th>
                                <th></th>
                                <th></th>
                            </tr>
                          </thead>
                          <tbody class="table-border-bottom-0">
                              @forelse ($seriesCounts as $series)
                                  <tr>
                                      <td><strong>{{ $series->series_name }}</strong></td>
                                      <td>{{ $series->brand_name }}</td>
                                      <td class="text-center text-info">{{ $series->condition_count_sold_used }}</td>
                                      <td class="text-center text-success">{{ $series->condition_count_instock_used - $series->condition_count_instock_unlock_used }} </td>
                                      <td class="text-center text-success">{{ $series->condition_count_instock_unlock_used }} </td>
                                      <td class="text-center text-danger">{{ $series->condition_count_broken_used }}</td>
                                      <td class="text-center text-warning">{{ $series->condition_count_1 }}</td>
                                      <td class="text-center text-info">{{ $series->condition_count_sold_new }}</td>
                                      <td class="text-center text-success">{{ $series->condition_count_instock_new - $series->condition_count_instock_unlock_new }} </td>
                                      <td class="text-center text-success">{{ $series->condition_count_instock_unlock_new }} </td>
                                      <td class="text-center text-danger">{{ $series->condition_count_broken_new }}</td>
                                      <td class="text-center text-warning">{{ $series->condition_count_2 }}</td>
                                      <td class="text-center text-primary">{{ $series->product_count }}</td>
                                      <td class="text-center bg-label-info">{{ setToStringDolla($series->total_selling_price) }}</td>
                                  </tr>
                              @empty
                                  <tr class="no-data">
                                    <th colspan="9" class="p-5 text-center">{{ __('common.lbl_no_data') }}</th>
                                  </tr>
                              @endforelse
                          </tbody>
                      </table>
                      <div class="pagination">
                        {!! $seriesCounts->withQueryString()->appends(request()->except('page'))->links('pagination::bootstrap-5') !!}
                      </div>
                  </div>
                </div>
            </div>
            <!--/ Stock Report Table -->
        </div>
    </div>
</div>
 <!--/ List Sale Table -->
 <div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
    <form method="GET" action="{{ url()->current() }}">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchLabel">{{ __('common.lbl_search') }}</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="search" value="true"/>
                    <div class="row g-2 mb-3">
                      <div class="col mb-0">
                          <label for="search_name" class="form-label">{{__('report.stock.series')}}</label>
                          <input type="text" class="form-control" name="search_name" value="@if(isset($parameterNames['search_name']) && $parameterNames['search_name'] != '') {{ $parameterNames['search_name'] }}@endif"/>
                      </div>
                  </div>
                    <div class="row g-2 mb-3">
                        <div class="col mb-0">
                            <label for="status" class="form-label">{{__('product.status')}}</label>
                            <select id="status" class="select2 form-select" name="status">
                                <option value="">{{__('common.lbl_select')}}</option>
                                @foreach ($status as $key => $value)
                                    <option value="{{ $key }}" @if(isset($parameterNames['status']) && $parameterNames['status'] == $key) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col mb-0">
                            <label for="from-date" class="form-label">{{__('common.lbl_from_date')}}</label>
                            <input class="form-control" type="date" value="@if(isset($parameterNames['from_date']) && $parameterNames['from_date'] != ''){{ $parameterNames['from_date'] }}@endif" id="from-date" name="from_date"/>
                        </div>
                        <div class="col mb-0">
                            <label for="to-date" class="form-label">{{__('common.lbl_to_date')}}</label>
                            <input class="form-control" type="date" value="@if(isset($parameterNames['to_date']) && $parameterNames['to_date'] != ''){{ $parameterNames['to_date'] }}@endif" id="to-date" name="to_date"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('reports.stock', withLang()) }}" class="btn btn-outline-secondary">
                        {{ __('button.clear') }}
                    </a>
                    <button type="submit" class="btn btn-primary">{{ __('button.search') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- / Content -->
@endsection
