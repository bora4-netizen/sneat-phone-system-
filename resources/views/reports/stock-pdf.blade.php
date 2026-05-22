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
            <th rowspan="">{{ __('report.stock.series') }}</th>
            <th rowspan="">{{ __('report.stock.brand') }}</th>
            <th colspan="4" class="text-center">{{ __('report.stock.used') }}</th>
            <th colspan="4" class="text-center">{{ __('report.stock.new') }}</th>
            <th colspan="" class="text-center">{{ __('report.total') }}</th>
            {{-- <th rowspan="" class="text-center">{{ __('report.stock.total_price') }}</th> --}}
          </tr>
          <tr>
              <th></th>
              <th></th>
              <th class="text-center">{{ __('report.stock.sold') }}</th>
              <th class="text-center">{{ __('report.stock.instock') }} ( {{ __('report.stock.unlock') }} )</th>
              <th class="text-center">{{ __('report.stock.broken') }}</th>
              <th class="text-center">{{ __('report.total') }}</th>
              <th class="text-center">{{ __('report.stock.sold') }}</th>
              <th class="text-center">{{ __('report.stock.instock') }} ( {{ __('report.stock.unlock') }} )</th>
              <th class="text-center">{{ __('report.stock.broken') }}</th>
              <th class="text-center">{{ __('report.total') }}</th>
              <th></th>
              {{-- <th></th> --}}
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @forelse ($seriesCounts as $series)
                <tr>
                    <td><strong>{{ $series->series_name }}</strong></td>
                    <td>{{ $series->brand_name }}</td>
                    <td class="text-center">{{ $series->condition_count_sold_used }}</td>
                    <td class="text-center">{{ $series->condition_count_instock_used }} ( {{ $series->condition_count_instock_unlock_used }} ) </td>
                    <td class="text-center">{{ $series->condition_count_broken_used }}</td>
                    <td class="text-center">{{ $series->condition_count_1 }}</td>
                    <td class="text-center">{{ $series->condition_count_sold_new }}</td>
                    <td class="text-center">{{ $series->condition_count_instock_new }}  ( {{ $series->condition_count_instock_unlock_new }} )</td>
                    <td class="text-center">{{ $series->condition_count_broken_new }}</td>
                    <td class="text-center">{{ $series->condition_count_2 }}</td>
                    <td class="text-center">{{ $series->product_count }}</td>
                    {{-- <td class="text-center">{{ setToStringDolla($series->total_selling_price) }}</td> --}}
                </tr>
            @empty
                <tr class="no-data">
                  <th colspan="9" class="p-5 text-center">{{ __('common.lbl_no_data') }}</th>
                </tr>
            @endforelse
        </tbody>
      </table>
@endsection
