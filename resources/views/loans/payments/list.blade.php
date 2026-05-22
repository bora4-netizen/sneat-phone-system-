@extends('layouts.app')
@push('styles')
@endpush

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    @can('loan-payment-create')
        <div class="row">
            <div class="col-lg-6 mb-3">
                <div class="pull-right">
                    @if($loan->remain > 0 && $loan->status == 2)
                    <a class="btn btn-outline-primary" href="{{ route('loans.payments.create', withLang(['loan' => $loan->id])) }}"> <i class='bx bx-plus-circle' ></i> {{ __('loan.payment.create')}}</a>
                    @endif
                </div>
            </div>
            <div class="col-lg-6 mb-3 text-end">
                <div class="pull-left">
                    <a target="_blank" href="{{ route('loans.payments.pdf', withLang(['loan' => $loan->id, 'type' => 'download'])) }}" class="btn btn-icon btn-outline-secondary">
                    <i class="fa-solid fa-file-pdf"></i>
                </a>
                <a target="_blank" href="{{ route('loans.payments.pdf', withLang(['loan' => $loan->id, 'type' => 'print'])) }}" class="btn btn-icon btn-outline-secondary">
                    <i class="fa-solid fa-print"></i>
                </a>
                </div>
            </div>
        </div>
    @endcan
    <!-- List Product Table -->
    <div class="card">
        <h5 class="card-header">{{ __('loan.payment.repayments_schedule')}}</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{__('loan.date')}}</th>
                            <th>{{__('loan.customer_name')}}</th>
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
                                    <td>{{ isset($dueDate) ? setToStringDateFormat($dueDate) : ''}}</td>
                                    <td>{{ $loan->customer->name ?? '' }}</td>
                                    <td>{{ setToStringDolla($payment->amount ?? 0) }}</td>
                                    <td>{{ $payment->type_name ?? '' }}</td>
                                    <td>{!! $payment->status_name ?? '' !!}</td>
                                    <td>{!! '<span class="badge bg-label-success">'.__('loan.payment.piad') .'</span>'!!}</td>
                                    <td>{!! $payment->employee->name ?? '' !!}</td>
                                    <td>{!! $payment->note ?? '' !!}</td>
                                </tr>
                            @endforeach
                            @for($i = count($payments); $i < $loan->duration; $i++)
                                @php
                                    $dueDate = \Carbon\Carbon::parse($loan->date ?? '')->addMonth($i + 1);
                                    $today = \Carbon\Carbon::now();
                                @endphp
                                <tr>
                                    <td>{{ isset($dueDate) ? setToStringDateFormat($dueDate) : '' }}</td>
                                    <td>{{ $loan->customer->name ?? '' }}</td>
                                    <td>$ 0</td>
                                    <td>{{ '-' }}</td>
                                    <td>{{ '-' }}</td>
                                    @if ($dueDate->gt($today))
                                    <td>{!! '<span class="badge bg-label-info">'.__('loan.payment.unpiad').'</span>'!!}</td>
                                    @else
                                    <td>{!! '<span class="badge bg-label-danger">'.__('loan.payment.miss_paid').'</span>'!!}</td>
                                    @endif
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endfor
                        </tbody>
                    </tbody>
                    <tfoot class="table-border-bottom-0">
                        <tr>
                            <th>{{__('loan.date')}}</th>
                            <th>{{__('loan.customer_name')}}</th>
                            <th>{{__('loan.amount')}}</th>
                            <th>{{__('loan.payment.types')}}</th>
                            <th>{{__('loan.status')}}</th>
                            <th>{{__('loan.date')}}</th>
                            <th>{{__('loan.recipient')}}</th>
                            <th>{{__('loan.notes')}}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!--/ List Product Table -->
    </div>
@endsection
@push('script')
    <script>
    </script>
@endpush
