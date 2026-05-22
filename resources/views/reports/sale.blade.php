@extends('layouts.app')

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
      <x-dashboard-stats-card badgeColor="bg-label-danger" badgeIcon="<i class='bx bxl-paypal'></i>" title="{{ __('report.sale.product_sale') }}" value="{{ count($orders) }}" />
      <x-dashboard-stats-card badgeColor="bg-label-info" badgeIcon="<i class='bx bxs-wallet'></i>" title="{{ __('report.sale.total_product_expense') }}" value="{{ setToStringDolla($totalPurchasePrice) }}" />
      <x-dashboard-stats-card badgeColor="bg-label-primary" badgeIcon="<i class='bx bx-dollar text-primary'></i>" title="{{ __('report.sale.total_product_income') }}" value="{{ setToStringDolla($totalSellingPrice) }}" />
      <x-dashboard-stats-card badgeColor="bg-label-success" badgeIcon="<i class='bx bx-money-withdraw'></i>" title="{{ __('dashboard.lbl_profit') }}" value="{{ setToStringDolla($totalProfit) }}" />
    </div>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <x-report-menu-bar />
                <!-- Action Buttons -->
                  <x-reports.action-buttons
                  :pdfRoute="'reports.sale.pdf'"
                  :pdfData="array_merge(withLang(['type' => 'download']), $parameterNames)"
                  :printRoute="'reports.sale.pdf'"
                  :printData="array_merge(withLang(['type' => 'print']), $parameterNames)"
                  :routeSelectSearch="'reports.sale'"
                />
            </ul>
            <!-- Stock Report Table -->
            <div class="card">
                <h5 class="card-header">{{ __('report.sale.title_header') }}
                    @if(isset($parameterNames['from_date']) && $parameterNames['from_date'] != '')
                      {{ $parameterNames['from_date'] }}
                    @endif
                    @if(isset($parameterNames['to_date']) && $parameterNames['to_date'] != '')
                      - {{ $parameterNames['to_date'] }}
                    @endif
                </h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                      <table class="table table-bordered">
                          <thead>
                              <tr>
                                <th>{{__('order.number')}}</th>
                                <th>{{__('order.customer')}}</th>
                                <th>{{__('order.series')}} (IMEI)</th>
                                <th>{{__('order.purchase_price')}}</th>
                                <th>{{__('order.selling_price')}}</th>
                                <th class="text-center">{{__('order.payment_type')}}</th>
                                <th class="text-center">{{__('product.condition.title')}}</th>
                                <th class="text-center">{{__('order.sale_date')}}</th>
                            </tr>
                          </thead>
                          <tbody class="table-border-bottom-0">
                            @forelse ($orders as $key => $orderDetail)
                              <tr>
                                  <td><strong>{{ $orderDetail->order->id_number ?? ''}}</strong> </td>
                                  <td><strong>{{ $orderDetail->order->customer_name ?? ''}}</strong> </td>
                                  <td>{!! $orderDetail->product->series_name ?? ''!!} ({{ $orderDetail->product->product_imei ?? ''}} )</td>                                  
                                  <td>{{ setToStringDolla($orderDetail->product->purchase_price ?? 0)}}</td>
                                  <td>{{ setToStringDolla($orderDetail->unit_price ?? 0)}}</td>
                                  <td class="text-center">{!! $orderDetail->order->payment_type_badges ?? '' !!}</td>
                                  <td class="text-center">{!! $orderDetail->product->condition_label_badges_name ?? ''!!}</td>
                                  <td class="text-center">{!! '<span class="badge bg-label-info">'.setToStringDateFormat($orderDetail->order->order_date).'</span>'!!}</td>
                              </tr>
                              @empty
                                  <tr class="no-data">
                                    <th colspan="8" class="p-5 text-center">{{ __('common.lbl_no_data') }}</th>
                                  </tr>
                              @endforelse
                          </tbody>
                      </table>
                      <div class="pagination">
                        {!! $orders->withQueryString()->appends(request()->except('page'))->links('pagination::bootstrap-5') !!}
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
                        <label for="condition" class="form-label">{{__('product.condition.title')}}</label>
                        <select id="condition" class="select2 form-select" name="condition">
                            <option value=""> {{ __('common.lbl_select') }} </option>
                            @foreach ($conditions as $key => $value)
                                <option value="{{ $key }}" @if(isset($parameterNames['condition']) && $parameterNames['condition'] == $key) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                  <div class="row g-2 mb-3">
                      <div class="col mb-0">
                          <label for="series" class="form-label">{{__('product.series')}}</label>
                          <select id="series" class="select2 form-select" name="series">
                              <option value=""> {{ __('common.lbl_select') }} </option>
                              @foreach ($series as $key => $value)
                                  <option value="{{ $key }}" @if(isset($parameterNames['series']) && $parameterNames['series'] == $key) selected @endif>{{ $value }}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
                  <div class="row g-2 mb-3">
                      <div class="col mb-0">
                          <label for="from-date" class="form-label">{{__('expense.from_date')}}</label>
                          <input class="form-control" type="date" value="@if(isset($parameterNames['from_date']) && $parameterNames['from_date'] != ''){{ $parameterNames['from_date'] }}@endif" id="from-date" name="from_date"/>
                      </div>
                      <div class="col mb-0">
                          <label for="to-date" class="form-label">{{__('expense.to_date')}}</label>
                          <input class="form-control" type="date" value="@if(isset($parameterNames['to_date']) && $parameterNames['to_date'] != ''){{ $parameterNames['to_date'] }}@endif" id="to-date" name="to_date"/>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <a href="{{ route('reports.sale', withLang()) }}" class="btn btn-outline-secondary">
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
