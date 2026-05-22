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
  <x-invoice-header :company="$company" :invoice="$loan" :title="__('loan.payment.repayments_schedule')" :type="1"/>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>{{__('loan.payment.due_date')}}</th>
                    <th>{{__('loan.amount')}}</th>
                    <th>{{__('loan.payment.types')}}</th>
                    <th>{{__('loan.status')}}</th>
                    <th>{{__('loan.payment.paid_date')}}</th>
                    <th>{{__('loan.recipient')}}</th>
                    <th>{{__('loan.notes')}}</th>
                </tr>
            </thead>
            <tbody>
                <tbody>
                    @forelse ($payments as $key => $payment)
                        @php
                            $dueDate = \Carbon\Carbon::parse($loan->date ?? '')->addMonth($key + 1);
                        @endphp
                        <tr>
                            <td>{{ isset($dueDate) ? $dueDate->format('Y-m-d') : ''}}</td>
                            <td>{{ setToStringDolla($payment->amount ?? 0) }}</td>
                            <td>{{ $payment->type_name ?? '' }}</td>
                            <td>{!! $payment->status_name ?? '' !!}</td>
                            <td>{!! $payment->created_at ?? '' !!}</td>
                            <td>{!! $payment->employee->name ?? '' !!}</td>
                            <td>{!! $payment->note ?? '' !!}</td>
                        </tr>
                    @endforeach
                    @for($i = count($payments); $i <= $loan->duration; $i++)
                        @php
                            $dueDate = \Carbon\Carbon::parse($loan->date ?? '')->addMonth($i + 1);
                            $today = \Carbon\Carbon::now();
                        @endphp
                        <tr>
                            <td>{{ isset($dueDate) ? $dueDate->format('Y-m-d') : '' }}</td>
                            <td>$ 0</td>
                            <td>{{ '-' }}</td>
                            <td>{{ '-' }}</td>
                            <td>{{ '-' }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endfor
                </tbody>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-12">
            <span class="fw-medium">{{ __('common.lbl_note')}}:</span>
            <span class="text-danger">{!! $loan->note !!}</span>
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
@endsection
