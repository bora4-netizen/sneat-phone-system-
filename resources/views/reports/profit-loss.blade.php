@extends('layouts.app')

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
      <x-dashboard-stats-card badgeColor="bg-label-danger" badgeIcon="<i class='bx bxl-paypal'></i>" title="{{ __('dashboard.lbl_expenses') }}" value="{{ setToStringDolla($totalExpense) }}" />
      <x-dashboard-stats-card badgeColor="bg-label-info" badgeIcon="<i class='bx bxs-wallet'></i>" title="{{ __('dashboard.lbl_loan') }}" value="{{ setToStringDolla($totalLoanPaymentIncome) }}" />
      <x-dashboard-stats-card badgeColor="bg-label-primary" badgeIcon="<i class='bx bx-dollar text-primary'></i>" title="ការលក់" value="{{ setToStringDolla($totalOrderAmount) }}" />
      <x-dashboard-stats-card badgeColor="bg-label-success" badgeIcon="<i class='bx bx-money-withdraw'></i>" title="{{ __('dashboard.lbl_profit') }}" value="{{ setToStringDolla($totalProfit) }}" />
    </div>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <x-report-menu-bar />
                <!-- Action Buttons -->
                  <x-reports.action-buttons
                  :pdfRoute="'reports.profit-loss.pdf'"
                  :pdfData="array_merge(withLang(['type' => 'download']), $parameterNames)"
                  :printRoute="'reports.profit-loss.pdf'"
                  :printData="array_merge(withLang(['type' => 'print']), $parameterNames)"
                  :routeSelectSearch="'reports.profit-loss'"
                />
            </ul>
            <!-- Stock Report Table -->
            <div class="card">
                <h5 class="card-header">ចំណូល និងចំណាយ
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
                              <th>{{__('report.profit_loss.particulars')}}</th>
                              <th>{{__('report.profit_loss.amount')}}</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <tr>
                                <td><strong>{{__('report.sale.title_header')}} ( + )</strong> </td>
                                <td><strong>{{ setToStringDolla($totalOrderAmount) }}</strong> </td>
                            </tr>
                            <tr>
                                <td><strong>{{__('report.loan.title_header')}} (ប្រាក់ចំណេញពីតម្លៃទូរស័ព្ទនិងការប្រាក់) ( + )</strong> </td>
                                <td><strong>{{ setToStringDolla($totalLoanPaymentIncome) }}</strong> </td>
                            </tr>
                            <tr>
                                <td><strong>ប្រាក់ចំណេញពីតម្លៃទូរស័ព្ទក្នុងរំលោះ ( + )</strong> </td>
                                <td><strong>{{ setToStringDolla($loanPhoneProfit) }}</strong> </td>
                            </tr>
                            <tr>
                                <td><strong>{{__('report.expense.title_header')}} ( - )</strong> </td>
                                <td><strong>{{ setToStringDolla($totalExpense) }}</strong> </td>
                            </tr>
                            <tr>
                                <td><strong>ប្រាក់ចំនេញសរុប</strong> </td>
                                <td><strong>{{ setToStringDolla($totalProfit) }}</strong> </td>
                            </tr>
                        </tbody>
                    </table>
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
                        <label for="year" class="form-label">{{__('report.profit_loss.year')}}</label>
                        <select id="year" class="select2 form-select" name="year">
                            <option value=""> {{ __('common.lbl_select') }} </option>
                            @foreach ($years as $key => $value)
                                <option value="{{ $value->order_year }}" @if(isset($parameterNames['year']) && $parameterNames['year'] == $value->order_year) selected @endif>{{ $value->order_year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                  <div class="row g-2 mb-3">
                    <label for="from-date" class="form-label text-center">Or</label>
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
                  <a href="{{ route('reports.profit-loss', withLang()) }}" class="btn btn-outline-secondary">
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
