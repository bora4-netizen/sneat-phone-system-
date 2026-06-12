@extends('layouts.app')
@push('styles')
@endpush

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="pull-right">
                @can('customer-create')
                    <a class="btn btn-outline-primary" href="{{ route('customers.create', withLang()) }}"> <i class='bx bx-plus-circle' ></i>{{__('customer.create.title')}}</a>
                @endcan
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#customerSearchModal">
                  <i class='bx bx-search' ></i>
                </button>
            </div>
        </div>
    </div>
    <!-- List User Table -->
    <div class="card">
        <h5 class="card-header">{{__('customer.create.list')}}</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>{{__('customer.name')}}</th>
                        <th>{{__('customer.customer_type')}}</th>
                        <th>{{__('customer.gender')}}</th>
                        <th>{{__('customer.nationality')}}</th>
                        <th>{{__('customer.phone')}}</th>
                        <th>{{__('customer.id_card_number')}}</th>
                        @can(['customer-edit'])
                        <th>{{__('customer.action')}}</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $key => $customer)
                        <tr>
                            <td>
                                <ul class="list-unstyled customers-list m-0 avatar-group d-flex align-items-center">
                                    <li
                                        data-bs-toggle="tooltip"
                                        data-popup="tooltip-custom"
                                        data-bs-placement="top"
                                        class="avatar avatar-xs pull-up"
                                        title="{{$customer->name}}"
                                        >
                                        <img src="{{ $customer->getProfileImageAttribute() }}" alt="Avatar" class="rounded-circle" onError="this.onerror=null;this.src='{{ asset('/assets/img/blank-profile.png') }}';"/>
                                    </li>
                                </ul>
                            </td>
                            <td><strong>{{ $customer->name ?? ''}}</strong></td>
                            <td>{{ $customer->customer_type == 1 ? 'Normal' : 'Loan'}}</td>
                            <td>{{ $customer->gender == 1 ? 'Male' : 'Female' }}</td>
                            <td>{{ $customer->nationality == 1 ? 'Cambodian' : 'Foreignner'}}</td>
                            <td>{{ $customer->phone ?? ''}}</td>
                            <td>{{ $customer->id_card_number ?? ''}}</td>

                            @can('customer-edit')
                            <td>
                                <a href="{{ route('customers.edit', withLang(['id' => $customer->id])) }}" class="btn btn-icon btn-outline-secondary">
                                    <span class="tf-icons bx bx-edit-alt"></span>
                                </a>

                                <a href="{{ route('customers.show', withLang(['id' => $customer->id])) }}" class="btn btn-icon btn-outline-secondary">
                                    <span class="tf-icons bx bx-detail"></span>
                                </a>
                            </td>

                            @endcan
                        </tr>
                    @endforeach

                </tbody>
                <tfoot class="table-border-bottom-0">
                    <tr>
                        <!-- <th></th>
                        <th>{{__('customer.name')}}</th>
                        <th>{{__('customer.customer_type')}}</th>
                        <th>{{__('customer.gender')}}</th>
                        <th>{{__('customer.nationality')}}</th>
                        <th>{{__('customer.phone')}}</th>
                        <th>{{__('customer.id_card_number')}}</th>
                        @can(['customer-edit'])
                        <th>{{__('customer.action')}}</th>
                        @endcan -->
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!--/ List User Table -->
    <div class="modal fade" id="customerSearchModal" tabindex="-1" aria-hidden="true">
        <form method="GET" action="{{ url()->current() }}">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="customerSearchLabel">{{ __('product.serahc_title') }}</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="view" value="{{ $view ?? ''}}"/>
                        <input type="hidden" class="form-control" name="search" value="true"/>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="name" class="form-label">Search Customer Name</label>
                                <!-- <input type="text" id="customer-name" name="search_customer" value="@if(isset($parameterNames['search_customer']) && $parameterNames['search_customer'] != '') {{ $parameterNames['search_customer'] }} @endif" class="form-control" placeholder="{{__('customer.placholder_search_name_or_imei')}}" /> -->
                                <select id="name" class="select2 form-select" name="name">
                                    <option></option>
                                    <option value="">{{ __('common.lbl_select') }} </option>
                                    @foreach ($selectCustomer as $key => $value)
                                        <option value="{{ $value->id }}" @if(isset($parameterNames['name']) && $parameterNames['name'] == $key) selected @endif>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col mb-0">
                                <label for="customer-phone" class="form-label">លេខទូរស័ព្ទ</label>
                                <input type="text" id="phone" name="phone" value="@if(isset($parameterNames['phone']) && $parameterNames['phone'] != '') {{ $parameterNames['search_customer'] }} @endif" class="form-control" placeholder="លេខទូរស័ព្ទអតិថិជន" />
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col mb-0">
                                <label for="customer-type" class="form-label">Customer Type</label>
                                <select id="customer_type" class="select2 form-select" name="customer_type">
                                    <option value="">{{ __('common.lbl_select')}}</option>
                                    <option value="1">Normal</option>
                                    <option value="2">Loan</option>
                                </select>
                            </div>
                            <div class="col mb-0">
                                <label for="gender" class="form-label">Gender</label>
                                <select id="gender" class="select2 form-select" name="gender">
                                    <option value="">{{ __('common.lbl_select')}}</option>
                                    <option value="1">Normal</option>
                                    <option value="2">Loan</option>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="row g-2">
                            <div class="col mb-0">
                                <select id="customer_id_number" class="select2 form-select" name="customer_id_number">
                                    <option></option>
                                    <option value=""> Customer Id Number </option>
                                    @foreach ($customers as $key => $value)
                                        <option value="{{ $key }}" @if(isset($parameterNames['customer_id_number']) && $parameterNames['customer_id_number'] == $key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> -->
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('customers.index', withLang()) }}" class="btn btn-outline-secondary">
                            {{ __('button.clear') }}
                        </a>
                        <button type="submit" class="btn btn-primary">{{ __('button.search') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- / Content -->
@endsection
@push('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.js"></script>
<style>
    .select2{
        width: 100% !important;
        padding: .4375rem .875rem;
        font-size: 0.9375rem;
        font-weight: 400;
        line-height: 1.53;
        color: #697a8d;
        appearance: none;
        background-color: #fff;
        background-clip: padding-box;
        border: var(--bs-border-width) solid #d9dee3;
        border-radius: var(--bs-border-radius);
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    .select2-container--default .select2-selection--single{
        border: 0px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        top: 8px;
    }
</style>
    <script>
        function submitForm(){
            $('.submit-delete').click();
        }
        $(document).ready( function(){
            $("#name").select2({
            dropdownParent: $('#customerSearchModal'),
            placeholder: "សូមជ្រើសរើសអតិថិជន",
            allowClear: true
        });
        })
    </script>
@endpush
