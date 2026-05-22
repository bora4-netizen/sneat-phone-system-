@extends('layouts.app-pdf')
@push('styles')
<style>
  #content-to-pdf {
      font-size: 80%;
  }
  #content-to-pdf table{
      font-size: 50%;
  }
</style>
@endpush
@section('content')
    <!-- Content -->
    <div class="d-flex justify-content-between flex-row">
        <x-reports.header-logo :company="$company" />
        <div>
            <div class="mb-2">
                <span>{{ __('report.issued_date') }}:</span>
                <span class="fw-medium">{{ $currentDate }}</span>
            </div>
            <div>
                <span>{{ __('report.loan.total_principal')}}:</span>
                <strong class="fw-medium">{{ setToStringDolla($totalLoan) }}</strong>
            </div>
            <div>
                <span>{{ __('report.loan.total_remain')}}:</span>
                <strong class="fw-medium">{{ setToStringDolla($totalRemain) }}</strong>
            </div>
            <div>
                <span>{{ __('report.loan.total_income')}}:</span>
                <strong class="fw-medium">{{ setToStringDolla($totalIncome) }}</strong>
            </div>
            @if ((isset($parameterNames['from_date']) &&  $parameterNames['from_date'])|| (isset($parameterNames['to_date']) && $parameterNames['to_date']))
                <div>
                    <span>{{ __('report.loan_date')}}:</span>
                </div>
                <div>
                    <span class="fw-medium">{{ $parameterNames['from_date'] }}</span> -
                    <span class="fw-medium">{{ $parameterNames['to_date'] }}</span>
                </div>
            @endif
        </div>
    </div>
    <div class="card-header d-flex align-items-center justify-content-center text-center">
        <h5 class="card-title m-0 p-5">{{ __('report.loan.title')}}</h5>
    </div>
    <table class="table table-bordered">
        <thead>
          <tr>
            <th>{{__('loan.no')}}</th>
            <th>{{__('loan.customer_name')}}</th>
            <th>{{__('loan.amount')}}</th>
            <th>{{__('loan.interest')}}</th>
            <th>{{__('loan.payable')}}</th>
            <th>{{__('loan.remain')}}</th>
            <th>{{__('loan.installment')}}</th>
            <th class="text-center">{{__('loan.payment.next_payment')}}</th>
        </thead>
        <tbody class="table-border-bottom-0">
            @forelse ($loans as $key => $loan)
                <tr>
                    <td>{{ $loan->number ?? '' }}</td>
                    <td>{{ $loan->customer->name ?? '' }}</td>
                    <td>{{ setToStringDolla($loan->total_balance ?? 0) }}</td>
                    <td>{{ $loan->total_interest ?? 0 }}</td>
                    <td>{{ setToStringDolla($loan->payable_amount ?? 0) }}</td>
                    <td>{{ setToStringDolla($loan->remain ?? 0) }}</td>
                    <td>{{ $loan->total_monthly_payment ?? '' }}</td>
                    <td class="text-center">{!! setToStringDateFormat($loan->next_payment_date ?? '') !!}</td>
                </tr>
            @empty
                <tr class="no-data">
                <th colspan="7" class="p-5 text-center">{{ __('common.lbl_no_data') }}</th>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
