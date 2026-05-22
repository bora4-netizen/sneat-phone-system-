@extends('layouts.app-pdf')
@section('content')
    <!-- Content -->
    <div class="d-flex justify-content-between flex-row">
        <x-reports.header-logo :company="$company" />
        <div>
            @if(isset($parameterNames['select']) &&  $parameterNames['select'])
                <div>
                    <span>{{ __('report.records_for')}}:</span>
                    @if($parameterNames['select'] == 1)
                        <span class="fw-medium">{{__('report.today')}}</span>
                    @elseif ($parameterNames['select'] == 2)
                        <span class="fw-medium">{{__('report.this_week')}}</span>
                    @elseif ($parameterNames['select'] == 3)
                        <span class="fw-medium">{{__('report.this_month')}}</span>
                    @elseif ($parameterNames['select'] == 4)
                        <span class="fw-medium">{{__('report.this_year')}}</span>
                    @endif
                </div>
            @elseif(isset($parameterNames['year']) &&  $parameterNames['year'])
                <div>
                    <span>{{ __('report.records_for')}}:</span>
                    <span class="fw-medium">{{ $parameterNames['year'] }}</span>
                </div>
            @elseif ((isset($parameterNames['from_date']) &&  $parameterNames['from_date'])|| (isset($parameterNames['to_date']) && $parameterNames['to_date']))
                <div><span>{{ __('report.records_for')}}:</span>
                    <span class="fw-medium">{{ $parameterNames['from_date'] }}</span> -
                    <span class="fw-medium">{{ $parameterNames['to_date'] }}</span>
                </div>
            @endif
            <div class="mb-2">
                <span>{{ __('report.issued_date') }}:</span>
                <span class="fw-medium">{{ $currentDate }}</span>
            </div>
            <div>
                <span>{{ __('report.sale.total')}}:</span>
                <strong class="fw-medium">{{ setToStringDolla($totalOrderAmount) }}</strong>
            </div>
            <div>
                <span>{{ __('report.total_profit')}}:</span>
                <strong class="fw-medium">{{ setToStringDolla($totalProfit) }}</strong>
            </div>
        </div>
    </div>
    <div class="card-header d-flex align-items-center justify-content-center text-center">
        <h5 class="card-title m-0 p-5">{{ __('report.profit_loss.title')}}</h5>
    </div>
    <table class="table table-bordered">
      <thead>
          <tr>
            <th>{{__('report.profit_loss.particulars')}}</th>
            <th>{{__('report.profit_loss.amount')}}</th>
          </tr>
      </thead>
      <tbody class="table">
          <tr>
              <td><strong>{{__('report.sale.title_header')}} ( + )</strong> </td>
              <td><strong>{{ setToStringDolla($totalOrderAmount) }}</strong> </td>
          </tr>
          <tr>
              <td><strong>{{__('report.loan.title_header')}} ( + )</strong> </td>
              <td><strong>{{ setToStringDolla($totalLoanPaymentIncome) }}</strong> </td>
          </tr>
          <tr>
              <td><strong>{{__('report.expense.title_header')}} ( - )</strong> </td>
              <td><strong>{{ setToStringDolla($totalExpense) }}</strong> </td>
          </tr>
          <tr>
              <td><strong>{{__('report.total_profit')}}</strong> </td>
              <td><strong>{{ setToStringDolla($totalProfit) }}</strong> </td>
          </tr>
      </tbody>
    </table>

@endsection
