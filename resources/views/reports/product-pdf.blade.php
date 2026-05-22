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
        <h5 class="card-title m-0 p-5">{{ __('report.stock.title')}}</h5>
    </div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th></th>
          <th>{{ __('report.stock.series') }}</th>
          <th>{{ __('report.stock.brand') }}</th>
          <th>{{ __('product.storage') }}</th>
          <th>{{ __('product.imei') }}</th>
          <th>{{ __('product.color') }}</th>
          <th class="text-center">{{ __('product.condition.title') }}</th>
          <th class="text-center">{{ __('product.selling_price') }}</th>
          <th class="text-center">{{ __('product.purchase_price') }}</th>
          <th class="text-center">{{ __('product.note') }}</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
          @forelse ($products as $product)
              <tr>
                  <td><strong>{{ $product->id }}</strong></td>
                  <td><strong>{{ $product->series_name }}</strong></td>
                  <td>{{ $product->brand->name }}</td>
                  <td>{{ $product->storage->name }}</td>
                  <td>{{ $product->product_imei }}</td>
                  <td>{{ $product->color->name }}</td>
                  <td>{!! $product->condition_label_badges_name ?? ''!!}</td>
                  <td class="text-center"><strong>{{ setToStringDolla($product->selling_price) }}</strong></td>
                  <td class="text-center"><strong>{{ setToStringDolla($product->purchase_price) }}</strong></td>
                  <td>{!! $product->note !!}</td>
              </tr>
          @empty
              <tr class="no-data">
                <th colspan="10" class="p-5 text-center">{{ __('common.lbl_no_data') }}</th>
              </tr>
          @endforelse
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td class="text-end" colspan="2"><strong>{{ __('report.product.total_product') }}: {{ $totalProduct }}</strong></td>
              <td class="text-end"><strong>{{ setToStringDolla($totalPurchasePrice) }}</strong></td>
              <td class="text-end"><strong>{{ setToStringDolla($totalSellingPrice) }}</strong></td>
              <td></td>
            </tr>
      </tbody>
      </table>
@endsection
