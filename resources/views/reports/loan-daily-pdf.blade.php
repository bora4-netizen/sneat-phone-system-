@extends('layouts.app-pdf')
@push('styles')
<style>
    @media print {
    /* Your printing styles here */
    .table {
        border: 2px solid #000; /* Example darker border for tables */
    }
}
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
                <span>ប្រាក់ទទួលបានមកពីកម្ចីសរុប:</span>
                <strong class="fw-medium">{{ setToStringDolla($loans->sum('lastes_payment')) }}</strong>
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
        <h5 class="card-title m-0 p-5">បិទបញ្ជីរកម្ចី </h5>
    </div>
    <table class="table table-bordered">
        <thead>
          <tr>
            <th>{{__('loan.no')}}</th>
            <th>{{__('loan.customer_name')}}</th>
            <th>អំពីព័ត៌មានការរំលោះ</th>
            <th>កាលបរិច្ឆេទទូទាត់បន្ទាប់</th>
            <th class="text-center">ប្រាក់កម្ចីដើម</th>
            <th class="text-center">សល់ក្នុងកម្ចី</th>
            <th class="text-center">ចំនួនទឹកប្រាក់ដែលបានបង់</th>
        </thead>
        <tbody class="table-border-bottom-0">
            @forelse ($loans as $key => $loan)
                <tr>
                    <td class="text-center">{{ $loan->number ?? '' }}</td>
                    <td class="text-center">{{ $loan->customer->name ?? '' }}</td>
                    <td class="text-center">
                        @if ($loan->remain > 0) 
                            ការបង់លើកទី{{count($loan->payments)}} ក្នុង {{$loan->duration}} ដង</td>
                        @else 
                            <span class="badge bg-label-success">បានបង់ផ្តេច</span>
                        @endif
                    <!-- <td>
                        @if ($loan->payments->count() > 0)
                        ការបង់លើកទី{{ $loan->payments->count() }} ក្នុង {{$loan->duration}} ដង
                        @else
                            Not yet made payment
                        @endif
                    </td> -->

                        @if ($loan->remain > 0) 
                            <td class="text-center">{!! setToStringDateFormat($loan->next_payment_date ?? '') !!}</td>
                        @else
                            <td class="text-center"><span class="badge bg-label-success text-center">បានបង់ផ្តេច</span></td>  
                        @endif                   
                    <td class="text-center"> ${{ $loan->amount ?? '' }}</td>
                    <td class="text-center">{{ setToStringDolla($loan->remain ?? 0) }}</td>
                    <td  class="text-center">
                        @if (count($loan->payments) == 0)
                            មិនទាន់មានការបង់
                        @else
                            {{ setToStringDolla($loan->lastes_payment ?? 0) }}
                        @endif
                    </td>
                </tr>
            @empty
                <tr class="no-data">
                <th colspan="7" class="p-5 text-center">{{ __('common.lbl_no_data') }}</th>
                </tr>
            @endforelse

            <tr>
                <td colspan="5"></td>
                <td>សរុបការបង់</td>
                <td class="text-center">{{setToStringDolla($loans->sum('lastes_payment'))}}</td>
            </tr>
        </tbody>
    </table>
@endsection
