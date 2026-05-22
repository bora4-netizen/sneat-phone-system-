@extends('layouts.app')

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
      <x-dashboard-stats-card badgeColor="bg-label-danger" badgeIcon="<i class='fa-solid fa-money-check-dollar'></i>" title="{{ __('report.loan.total_loan_amount') }}" value="{{ setToStringDolla($totalLoanAmount) }}" />
      <x-dashboard-stats-card badgeColor="bg-label-info" badgeIcon="<i class='fa-solid fa-filter-circle-dollar'></i>" title="{{ __('report.loan.total_loan_profit') }}" value="{{ setToStringDolla($totalLoanProfit) }}" />
      <x-dashboard-stats-card badgeColor="bg-label-primary" badgeIcon="<i class='fa-solid fa-piggy-bank'></i>" title="{{ __('report.loan.total_remain') }}" value="{{ setToStringDolla($totalInterestRemain) }}" />
      <x-dashboard-stats-card badgeColor="bg-label-success" badgeIcon="<i class='bx bx-money-withdraw'></i>" title="{{ __('report.loan.total_income') }}" value="{{ setToStringDolla($totalIncome) }}" />
    </div>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <x-report-menu-bar />
                <li class="px-2">
                    <a target="_blank" href="{{ route('reports.loan.daily-pdf', array_merge(withLang(['type' => 'print']), $parameterNames)) }}" class="btn btn-icon btn-outline-secondary">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                    </a>
                </li>                <li>
                    <a target="_blank" href="{{ route('reports.loan.list-loan', array_merge(withLang(['type' => 'print']), $parameterNames)) }}" class="btn btn-icon btn-outline-secondary">
                        <i class="fa-solid fa-clipboard-list"></i>
                    </a>
                </li>
                <!-- Action Buttons -->
                  <x-reports.action-buttons
                    :pdfRoute="'reports.loan.pdf'"
                    :pdfData="array_merge(withLang(['type' => 'download']), $parameterNames)"
                    :printRoute="'reports.loan.pdf'"
                    :printData="array_merge(withLang(['type' => 'print']), $parameterNames)"
                    :routeSelectSearch="'reports.loan'"
                />

            </ul>
            <!-- Stock Report Table -->
            <div class="card">
                <h5 class="card-header">{{ __('report.loan.title_header') }}
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
                                <th>{{__('loan.no')}}</th>
                                <th>{{__('loan.customer_name')}}</th>
                                <th>{{__('loan.amount_loan')}}</th>
                                <th>{{__('loan.interest')}}</th>
                                <th>{{__('loan.payable')}}</th>
                                <th>{{__('loan.remain')}}</th>
                                <th>{{__('loan.installment')}}</th>
                                <th>{{__('loan.payment.next_payment')}}</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                          @forelse ($loans as $key => $loan)
                            <tr>
                                <td> <a href="{{route('loans.payments.list', withLang(['loan' => $loan->id]))}}"> {{ $loan->number ?? '' }} </a></td>
                                <td>{{ $loan->customer->name ?? '' }}</td>
                                <td>{{ setToStringDolla($loan->total_balance ?? 0) }}</td>
                                <td>{{ $loan->total_interest ?? '' }}</td>
                                <td>{{ setToStringDolla($loan->payable_amount ?? 0) }}</td>
                                <td>{{ setToStringDolla($loan->remain ?? 0 )}}</td>
                                <td>{{ $loan->total_monthly_payment ?? '' }}</td>
                                <td class="text-center">
                                    @if($loan->remain == 0)
                                        {!! $loan->status_label ?? '' !!}
                                    @else
                                        {!! $loan->next_payment_date ?? '' !!}
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="no-data">
                                <td colspan="10" class="p-5 text-center">{{ __('common.lbl_no_data') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="pagination">
                      {!! $loans->withQueryString()->appends(request()->except('page'))->links('pagination::bootstrap-5') !!}
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
                  <div class="row">
                      <div class="col mb-3">
                          <label for="number" class="form-label">{{__('report.loan.number')}}</label>
                          <input type="text" id="number" name="number" value="@if(isset($parameterNames['number']) && $parameterNames['number'] != '') {{ $parameterNames['number'] }} @endif" class="form-control" placeholder="" />
                      </div>
                  </div>
                  <div class="row g-2 mb-3">
                      <div class="col mb-0">
                          <label for="customer" class="form-label">{{__('report.loan.customer')}}</label>
                          <select id="customer" class="select2 form-select" name="customer">
                              <option value=""> {{ __('common.lbl_select') }} </option>
                              @foreach ($customers as $key => $value)
                                  <option value="{{ $key }}" @if(isset($parameterNames['customer']) && $parameterNames['customer'] == $key) selected @endif>{{ $value }}</option>
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
                  <a href="{{ route('reports.loan', withLang()) }}" class="btn btn-outline-secondary">
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
