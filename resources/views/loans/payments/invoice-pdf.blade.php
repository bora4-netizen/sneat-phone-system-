@extends('layouts.app-pdf')
@push('styles')
@endpush
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="card-body">
        <div class="mb-xl-0 mb-4">
            <div class="d-flex svg-illustration mb-3 gap-2 justify-content-center flex-column">
                <p class="app-brand-logo demo m-auto">
                    <img src="{{ $company->image_logo }}" alt="logo" width="100px"/>
                </p>
                <p class="app-brand-text demo text-body fw-bold d-flex align-items-center text-center m-auto">{{ $company->name ?? '' }} <br> {{ $company->detail ?? '' }}</p>
            </div>
        </div>
        <div class="d-flex justify-content-between flex-row p-sm-3 p-0">
            <div class="mb-xl-0 mb-4">
                <p class="mb-1"><i class="fa-solid fa-phone me-2"></i> {!! nl2br($company->phone ?? '') !!}</p>
                <p class="mb-1"><i class="fa-solid fa-location-dot me-2"></i> {!! nl2br($company->address ?? '') !!}</p>
            </div>
            <div class="text-end">
                <div class="mb-2">
                <span class="me-1">{{ __('order.invoice')}}: #{{$loan->id}}</span>
                </div>
                <div class="mb-2">
                    <span class="me-1">{{ __('order.issued_date') }}: {{date('d-m-Y')}}</span>
                </div>
                
                <div>
                    <span class="me-1">{{ __('order.order_date') }}:  {{ $loanPayment->date }}</span>
                </div>
                
            </div>
        </div>
    </div>
    <hr class="my-0">
    <div class="card-body">
        <div class="row p-sm-3 p-0">
            <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                <h6 class="pb-2">លេខ​សម្គាល់​អតិថិជន : {{ $loan->id }}</h6>
                <h6 class="pb-2">{{ __('common.lbl_customer')}} : {{ $loan->customer->name }}</h6>
                <p class="mb-1">{{ $loan->customer->address ?? '' }}</p>
                <p class="mb-1">{{ $loan->customer->phone ?? '' }}</p>
                <p class="mb-0">{{ $loan->customer->email ?? '' }}</p>
            </div>
        </div>
    </div>
    <div class="card-header d-flex align-items-center justify-content-center text-center">
        <h5 class="card-title pb-5 text-uppercase"></h5>
    </div>
    <div class="table-responsive">
        <table class="table border-top m-0">
            <thead>
                <tr>
                    <th>ផលិតផល</th>
                    <th>អំពីព័ត៌មានផលិតផល</th>
                    <th>ចំនួនទឹកប្រាក់ដែលបានបង់</th>
                    <th>ស្ថានភាពការទូទាត់</th>
                    <th>កាលបរិច្ឆេទទូទាត់បន្ទាប់</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td> {{ $loan->product->product_name }} [ IMEI: {{ substr($loan->product->product_imei, -5) }} ] </td>
                    <td> ថ្ងៃបង់ប្រាក់ : {{ $loanPayment->date }} , បង់លើកទី : {{$countPaymentTimes}} </td>
                    <td> $ {{  number_format(round($loanPayment->amount, 2), 2) }}</td>
                    <td> {{ $loanPayment->status_name }}, Paid by {{$loanPayment->type_name}} </td>
                    <td> {{ $loan->next_payment_date }} </td>
                </tr>
                <tr>
                    <td colspan="2" class="align-top px-4 py-5">
                        <p class="mb-2">
                            <span class="fw-medium">{{ __('common.lbl_note') }} :</span>
                            <span>{{ $loan->note ?? ''}}</span>
                        </p>
                    </td>
                    <td colspan="2" class="text-end px-4 py-5">
                        <p class="mb-1">ចំនួនទឹកប្រាក់ដែលបានបង់:</p>
                    </td>
                    <td class="px-4 py-5">
                        <p class="fw-medium mb-1"><strong id="deposit-price" data-value="{{ $loan->first_amount ?? 0 }}">${{  number_format(round($loanPayment->amount, 2), 2) }}</strong></p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row pt-5">
        <div class="col-6">
            <span class="fw-medium">{{ __('common.lbl_customer')}}:</span><br>
            <strong> {{ $loan->customer->name }} </strong>
        </div>
        <div class="col-6">
            <span class="fw-medium">{{ __('common.lbl_the_seller')}}:</span><br>
            <strong>{{ $loanPayment->employee->name; }}</strong>
        </div>
    </div>
</div>    
<br>
<br>
<br>
<br>
<br>
<br>
<!-- /Invoice -->
@endsection
