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
        <h5 class="card-title m-0 p-5">បញ្ជីរកាលបរិច្ឆេទកម្ចី</h5>
    </div>
    <table class="table table-bordered">
        <tr>
            <td>ID</td>
            <td colspan="100%">Payment Dates</td>
        </tr>
        @foreach($loans as $key => $loan)
            @php
                // Calculate due date based on loan date and loop index
                $dueDate = \Carbon\Carbon::parse($loan->date ?? '')->addMonths($key + 1);
                $today = \Carbon\Carbon::now();
            @endphp
            <tr>
                <td class="font-weight-bold"> <strong>{{ $loan->id }}</strong></td>
                @for($i = 0; $i < $loan->duration; $i++)
                    @php
                        // Calculate due date for each payment iteration
                        $dueDate = $dueDate->addMonth();
                    @endphp
                    <td>
                        {{ isset($dueDate) ? $dueDate->format('Y-m-d') : '' }}
                    </td>
                @endfor
            </tr>
        @endforeach
    </table>

@endsection
