@extends('layouts.app-pdf')
@push('styles')
<style>
  #content-to-pdf {
      font-size: 100%;
  }
  #content-to-pdf table{
      font-size: 80%;
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
            <span>{{ __('report.sale.total')}}:</span>
            <strong class="fw-medium">{{ setToStringDolla($totalSellingPrice) }}</strong>
        </div>
        <div>
          <span>{{ __('report.total_profit')}}:</span>
          <strong class="fw-medium">{{ setToStringDolla($totalProfit) }}</strong>
        </div>
        @if ((isset($parameterNames['from_date']) &&  $parameterNames['from_date'])|| (isset($parameterNames['to_date']) && $parameterNames['to_date']))
            <div>
                <span>{{ __('report.order_date')}}:</span>
            </div>
            <div>
                <span class="fw-medium">{{ $parameterNames['from_date'] }}</span> -
                <span class="fw-medium">{{ $parameterNames['to_date'] ?? '' }}</span>
            </div>
        @endif
    </div>
</div>
<div class="card-header d-flex align-items-center justify-content-center text-center">
    <h5 class="card-title m-0 p-5">{{ __('report.sale.title')}}</h5>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>{{__('order.number')}}</th>
            <th>{{__('order.series')}} (IMEI)</th>
            <th>{{__('order.purchase_price')}}</th>
            <th>{{__('order.selling_price')}}</th>
            <th>{{__('order.payment_type')}}</th>
            <th>{{__('product.condition.title')}}</th>
            <th>{{__('order.sale_date')}}</th>
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @forelse ($orders as $key => $orderDetail)
        <tr>
            <td><strong>{{ $orderDetail->order->id_number ?? ''}}</strong> </td>
            <td>{!! $orderDetail->product->series_name ?? ''!!} ({{ $orderDetail->product->product_imei}})</td>
            <td>{{ setToStringDolla($orderDetail->product->purchase_price ?? 0)}}</td>
            <td>{{ setToStringDolla($orderDetail->unit_price ?? 0)}}</td>
            <td>{!! $orderDetail->order->payment_type_badges ?? '' !!}</td>
            <td>{!! $orderDetail->product->condition_label_badges_name ?? ''!!}</td>
            <td>{!! setToStringDateFormat($orderDetail->order->order_date) !!}</td>
        </tr>
        @empty
            <tr class="no-data">
                <th colspan="8" class="p-5 text-center">{{ __('common.lbl_no_data') }}</th>
            </tr>
        @endforelse
        <tr>
            <th><strong>តម្លៃដើមសរុប</strong></th>
            <th colspan="5"><strong>{{ setToStringDolla($totalPurchasePrice) }}</strong></th>
        </tr>
        <tr>
            <th><strong>តម្លៃលក់សរុប</strong></th>
            <th colspan="5"><strong>{{ setToStringDolla($totalSellingPrice) }}</strong></th>
        </tr>
    </tbody>
</table>
@endsection
