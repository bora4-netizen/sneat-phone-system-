@extends('layouts.app')
@push('styles')
@endpush

@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-fluid flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h5 class="card-header">{{__('customer.menu.title')}}</h5>
                         <!-- Account -->
                         <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img
                                  src="{{ $customerimg }}"
                                  alt="user-avatar"
                                  class="d-block rounded"
                                  height="100"
                                  width="100"
                                  id="uploadedAvatar"
                                  onError="this.onerror=null;this.src='{{ asset('/assets/img/blank-customer.svg') }}';"
                                />
                              </div>
                            </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="customer-name" class="form-label">{{__('customer.info.name')}} : </label>
                                    <label class="fw-bolder"> {{ $customer->name }} </label>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="customer-imei" class="form-label">{{__('customer.info.phone')}} : </label>
                                    <label class="fw-bolder"> {{ $customer->phone }} </label>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="customer-imei" class="form-label">{{__('customer.info.id_card_number')}} : </label>
                                    <label class="fw-bolder"> {{ $customer->id_card_number }} </label>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="customer-code" class="form-label">{{__('customer.info.gender')}} : </label>
                                    <label class="fw-bolder"> {{ $customer->gender == 1 ? 'Male' : 'Female' }} </label>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="condition">{{__('customer.info.nationality')}} : </label>
                                    <label class="fw-bolder"> {{ $customer->nationality == 1 ? 'Cambodian' : 'Foreignner' }} </label>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="brand">{{__('customer.info.customer_type')}} : </label>
                                    <label class="fw-bolder"> {{ $customer->customer_type == 1 ? 'Normal' : 'Loan'}} </label>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="series">{{__('customer.info.document')}} : </label>
                                    <label class="fw-bolder"> {{ $customer->document ?? '' }} </label>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="color">{{__('customer.info.created_by')}} : </label>
                                    <label class="fw-bolder"> {{ $customer->employee->name ?? '' }} </label>
                                </div>
                            </div>

                            <div class="mt-2">
                                <a href="{{ route('customers.index', withLang()) }}" class="btn btn-outline-secondary me-2">{{__('customer.btn_lists')}}</a>
                                
                            </div>
                    </div>
                    <!-- /Account -->
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->
@endsection
@push('script')
@endpush
