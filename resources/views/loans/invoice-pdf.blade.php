@extends('layouts.app-pdf')
@push('styles')
@endpush
@section('content')
<x-invoice-header :company="$company" :invoice="$loan" :title="__('order.invoice')" :type="1"/>
<div class="table-responsive">
    <table class="table border-top m-0">
        <thead>
            <tr>
                <th>{{__('invoice.item')}}</th>

                <th>{{__('invoice.description')}}</th>

                <th>{{__('invoice.cost')}}</th>

                <th>{{__('invoice.qty')}}</th>

                <th>{{__('invoice.price')}}</th>
                
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $loan->product->product_name }} [ IMEI: {{ substr($loan->product->product_imei, -5) }} ]</td>
                <td>{{$loan->product->series->name ?? ''}}, {{$loan->product->storage->name  ?? ''}}, {{$loan->product->color->name  ?? ''}}</td>
                <td>{{ setToStringDolla($loan->product->selling_price) }}</td>
                <td>1</td>
                <td>{{ setToStringDolla($loan->product->selling_price) }}</td>
            </tr>
            <tr>
                <td colspan="2" class="align-top px-4 py-5">
                    <p class="mb-2">
                        <span class="fw-medium">{{ __('common.lbl_note') }} :</span>
                        <span>{{ $loan->note ?? ''}}</span>
                    </p>
                </td>
                <td colspan="2" class="text-end px-4 py-5">
                    <p class="mb-1">{{ __('common.lbl_total') }}:</p>
                    <p class="mb-1">{{ __('common.lbl_deposit') }}:</p>
                    <p class="mb-0">{{ __('common.lbl_balance') }}:</p>
                </td>
                <td class="px-4 py-5">
                    <p class="fw-medium mb-1"><strong id="total-price" data-value="{{ $loan->amount ?? 0}}">{{ setToStringDolla($loan->amount ?? 0)}}</strong></p>
                    <p class="fw-medium mb-1"><strong id="deposit-price" data-value="{{ $loan->first_amount ?? 0 }}">{{ setToStringDolla($loan->first_amount ?? 0)}}</strong></p>
                    <p class="fw-medium mb-0"><strong id="balance-price" data-value="{{ $loan->total_balance ?? 0 }}">{{ setToStringDolla($loan->total_balance ?? 0)}}</strong></p>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<br>
<br>
<br>
<br>
<br>
<div class="row pt-5">
    <div class="col-6">
        <span class="fw-medium">{{ __('common.lbl_customer')}}:</span><br>
        <strong>{{ $loan->customer->name }}</strong>
    </div>
    <div class="col-6">
        <span class="fw-medium">{{ __('common.lbl_the_seller')}}:</span><br>
        <strong>{{ $loan->employee->name }}</strong>
    </div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<!-- /Invoice -->
<div class="mt-5">
    <div class="card-header d-flex align-items-center justify-content-center text-center">
        <h5 class="card-title p-5 text-uppercase">Loan Payment Statement</h5>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>{{__('loan.payment.collection_date')}}</th>
                    <th>{{__('loan.principal')}}</th>
                    <th>{{__('loan.interest')}}</th>
                    <th>{{__('loan.amount')}}</th>
                    <th>{{__('loan.recipient')}}</th>
                </tr>
            </thead>
            <tbody>
                <tbody>
                    @for($i = 0; $i < $loan->duration; $i++)
                        @php
                            $dueDate = \Carbon\Carbon::parse($loan->date ?? '')->addMonth($i + 1);
                            $today = \Carbon\Carbon::now();
                        @endphp
                        <tr>
                            <td>{{ isset($dueDate) ? $dueDate->format('Y-m-d') : '' }}</td>
                            <td>{{ setToStringDolla($loan->amount_principal ?? 0) }}</td>
                            <td>{{ setToStringDolla($loan->amount_interest ?? 0) }}</td>
                            <td>{{ setToStringDolla($loan->monthly_payment ?? 0) }}</td>
                            <td></td>
                        </tr>
                    @endfor
                </tbody>
            </tbody>
        </table>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="row">
        <div class="col-12">
            <span class="fw-medium">{{ __('common.lbl_note')}}:</span>
            <span class="text-danger">{!! $company->default_loan_note !!}</span>
        </div>
    </div>
    <div class="row pt-5">
        <div class="col-6">
            <span class="fw-medium">{{ __('common.lbl_customer')}}:</span><br>
            <strong>{{ $loan->customer->name }}</strong>
        </div>
        <div class="col-6">
            <span class="fw-medium">{{ __('common.lbl_the_seller')}}:</span><br>
            <strong>{{ $loan->employee->name }}</strong>
        </div>
    </div>
</div>
@endsection
