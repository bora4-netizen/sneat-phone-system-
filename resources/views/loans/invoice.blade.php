@extends('layouts.app')
@push('styles')
@endpush

@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="row invoice-preview">
            <div class="col-12 invoice-actions pb-2 text-end">
                <a target="_blank" href="{{ route('loans.invoice.pdf', withLang(['loan' => $loan->id, 'type' => 'download']))}}" class="btn btn-icon btn-outline-secondary">
                    <i class="fa-solid fa-file-pdf"></i>
                </a>
                <a target="_blank" href="{{ route('loans.invoice.pdf', withLang(['loan' => $loan->id, 'type' => 'print'])) }}" class="btn btn-icon btn-outline-secondary">
                    <i class="fa-solid fa-print"></i>
                </a>
                @can('loan-create')
                  @if($loan->status == 2 || $loan->status == 3)
                    <a href="{{ route('loans.agreement', withLang(['loan' => $loan->id])) }}" class="btn btn-icon btn-outline-secondary" target="_blank">
                      <i class="fa-solid fa-handshake"></i>
                    </a>
                  @endif
                @endcan
            </div>
            <!-- /Invoice Actions -->
            <div class="col-xl-12 col-md-8 col-12 mb-md-0 mb-4">
                <div class="card invoice-preview-card">
                  <x-invoice-header :company="$company" :invoice="$loan" :title="__('order.invoice')" :type="1"/>
                    <div class="card-body">
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
                                        <td class="text-nowrap">{{ $loan->product->product_name }} [ IMEI: {{ substr($loan->product->product_imei, -5) }} ]</td>
                                        <td class="text-nowrap">{{$loan->product->series->name ?? ''}}, {{$loan->product->storage->name  ?? ''}}, {{$loan->product->color->name  ?? ''}}</td>
                                        <td>{{ setToStringDolla($loan->product->selling_price) }}</td>
                                        <td>1</td>
                                        <td>{{ setToStringDolla($loan->product->selling_price) }}</td>
                                    <tr>
                                        <td colspan="2" class="align-top px-4 py-5">
                                            <p class="mb-2">
                                                <span class="fw-medium">{{ __('common.lbl_note') }} :</span>
                                                <span>{!! $loan->note  ?? ''!!}</span>
                                            </p>
                                        </td>
                                        <td></td>
                                        <td class="text-end px-4 py-5">
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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <p class="mb-2">
                                        <span class="me-1 fw-medium">{{ __('common.lbl_customer')}}</span>
                                        <p><strong>{{ $loan->customer->name }}</strong></p>
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-2">
                                        <span class="me-1 fw-medium">{{ __('common.lbl_the_seller')}}</span>
                                        <p><strong>{{ $loan->employee->name }}</strong></p>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Invoice -->
        </div>
    </div>
    <!-- / Content -->
  </div>
@endsection
