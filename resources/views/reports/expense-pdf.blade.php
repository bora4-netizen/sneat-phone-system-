@extends('layouts.app-pdf')
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
            <span>{{ __('report.expense.total')}}:</span>
            <strong class="fw-medium">{{ setToStringDolla($totalExpense) }}</strong>
        </div>
        <div>
            <span>{{ __('report.total_profit')}}:</span>
            <strong class="fw-medium">{{ setToStringDolla($totalProfit) }}</strong>
        </div>
        @if ((isset($parameterNames['from_date']) &&  $parameterNames['from_date'])|| (isset($parameterNames['to_date']) && $parameterNames['to_date']))
        <div>
            <span>{{ __('report.purchased_date')}}:</span>
        </div>
        <div>
            <span class="fw-medium">{{ $parameterNames['from_date'] }}</span> -
            <span class="fw-medium">{{ $parameterNames['to_date'] }}</span>
        </div>
        @endif
    </div>
</div>
<div class="card-header d-flex align-items-center justify-content-center text-center">
    <h5 class="card-title m-0 p-5">{{ __('report.expense.title')}}</h5>
</div>
<table class="table table-bordered">
    <thead>
      <tr>
        <th>No</th>
        <th>{{__('expense.name')}}</th>
        <th>{{__('expense.category.title')}}</th>
        <th>{{__('expense.amount')}}</th>
        <th>{{__('expense.date')}}</th>
      </tr>
  </thead>
  <tbody class="table-border-bottom-0">
    @forelse ($expenses as $key => $expense)
        <tr>
            <td><strong>{{ $expense->id ?? ''}}</strong> </td>
            <td><strong>{{ $expense->name ?? ''}}</strong> </td>
            <td>{{ $expense->category_id ?? ''}}</td>
            <td>{{ $expense->amount ?? 0}}</td>
            <td>{{ setToStringDateFormat($expense->date ?? '')}}</td>
        </tr>
    @empty
        <tr class="no-data">
          <th colspan="6" class="p-5 text-center">{{ __('common.lbl_no_data') }}</th>
        </tr>
    @endforelse
  </tbody>
</table>
@endsection
