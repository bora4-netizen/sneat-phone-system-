@extends('layouts.app')

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
      <x-dashboard-stats-card badgeColor="bg-label-danger" badgeIcon="<i class='bx bxl-paypal'></i>" title="{{ __('dashboard.lbl_expenses') }}" value="{{ setToStringDolla($totalExpense) }}" />
      <x-dashboard-stats-card badgeColor="bg-label-info" badgeIcon="<i class='bx bxs-wallet'></i>" title="{{ __('dashboard.lbl_loan') }}" value="{{ setToStringDolla($totalLoanPaymentIncome) }}" />
      <x-dashboard-stats-card badgeColor="bg-label-primary" badgeIcon="<i class='bx bx-dollar text-primary'></i>" title="{{ __('dashboard.lbl_sale') }}" value="{{ setToStringDolla($totalOrderAmount) }}" />
      <x-dashboard-stats-card badgeColor="bg-label-success" badgeIcon="<i class='bx bx-money-withdraw'></i>" title="{{ __('dashboard.lbl_profit') }}" value="{{ setToStringDolla($totalProfit) }}" />
    </div>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <x-report-menu-bar />
                <!-- Action Buttons -->
                  <x-reports.action-buttons
                  :pdfRoute="'reports.expense.pdf'"
                  :pdfData="array_merge(withLang(['type' => 'download']), $parameterNames)"
                  :printRoute="'reports.expense.pdf'"
                  :printData="array_merge(withLang(['type' => 'print']), $parameterNames)"
                  :routeSelectSearch="'reports.expense'"
                />
            </ul>
            <!-- Stock Report Table -->
            <div class="card">
                <h5 class="card-header">{{ __('report.expense.title_header') }}
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
                                <th>No</th>
                                <th>{{__('expense.name')}}</th>
                                <th>{{__('expense.category.title')}}</th>
                                <th>{{__('expense.amount')}}</th>
                                <th class="text-center">{{__('expense.date')}}</th>
                              </tr>
                          </thead>
                          <tbody class="table-border-bottom-0">
                            @forelse ($expenses as $key => $expense)
                                  <tr>
                                      <td><strong>{{ $expense->id ?? ''}}</strong> </td>
                                      <td><strong>{{ $expense->name ?? ''}}</strong> </td>
                                      <td>{{ $expense->category_id ?? ''}}</td>
                                      <td>{{ $expense->amount ?? ''}}</td>
                                      <td class="text-center">{!! '<span class="badge bg-label-info">'.setToStringDateFormat($expense->date).'</span>'!!}</td>
                                  </tr>
                              @empty
                                  <tr class="no-data">
                                    <th colspan="6" class="p-5 text-center">{{ __('common.lbl_no_data') }}</th>
                                  </tr>
                              @endforelse
                          </tbody>
                      </table>
                      <div class="pagination">
                        {!! $expenses->withQueryString()->appends(request()->except('page'))->links('pagination::bootstrap-5') !!}
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
                          <label for="name" class="form-label">{{__('expense.title')}}</label>
                          <input type="text" id="name" name="name" value="@if(isset($parameterNames['name']) && $parameterNames['name'] != '') {{ $parameterNames['name'] }} @endif" class="form-control" placeholder="{{__('expense.placholder_search_name')}}" />
                      </div>
                  </div>
                  <div class="row g-2 mb-3">
                      <div class="col mb-0">
                          <label for="category" class="form-label">{{__('expense.category.title')}}</label>
                          <select id="category" class="select2 form-select" name="customer">
                              <option value=""> {{ __('common.lbl_select') }} </option>
                              @foreach ($expenseCategories as $key => $value)
                                  <option value="{{ $key }}" @if(isset($parameterNames['category']) && $parameterNames['category'] == $key) selected @endif>{{ $value }}</option>
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
                  <a href="{{ route('reports.expense', withLang()) }}" class="btn btn-outline-secondary">
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
