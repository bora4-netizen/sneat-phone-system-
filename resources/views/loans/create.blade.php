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

                <form id="formLoanRegister" method="POST" action="{{ route('loans.store', withLang()) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card mb-4">
                        <h5 class="card-header">{{__('loan.register')}}</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="customer_id">{{__('loan.customer')}}</label>
                                    <select id="customer_id"
                                        class="select2 form-select @error('customer_id') is-invalid @enderror"
                                        name="customer_id">

                                        <option value=""></option>

                                        @foreach ($customers as $customer)

                                        <option value="{{ $customer->id }}"
                                            {{ old('customer_id') == $customer->id ? 'selected' : '' }}>

                                            {{ $customer->name }}

                                        </option>

                                        @endforeach

                                    </select>

                                    @error('customer_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="product_id">{{__('loan.product')}}</label>
                                    <select id="product_id" name="product_id" class="form-select">
                                        <option value="">Select Product</option>
<!-- <option value="1">iPhone</option>
<option value="2">Samsung</option> -->
                                        @foreach($availableProducts as $product)
                                        <option value="{{ $product->id }}">
                                            {{ $product->product_name }}
                                            
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="amount">{{__('loan.amount')}}</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control @error('amount') is-invalid @enderror" type="text" value="{{ old('amount', 0) }}" id="amount" name="amount" />
                                        <span class="input-group-text">$</span>
                                        @error('amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="first_amount">{{__('loan.first_amount')}}</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control @error('first_amount') is-invalid @enderror" type="text" value="{{ old('first_amount', 0) }}" id="first_amount" name="first_amount" />
                                        <span class="input-group-text">$</span>
                                        @error('first_amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="interest">{{__('loan.interest')}}</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control @error('interest') is-invalid @enderror" type="text" value="{{ old('interest', $company->interest) }}" id="interest" name="interest" />
                                        <span class="input-group-text">%</span>
                                        @error('interest')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="duration">{{__('loan.duration')}}</label>
                                    <input class="form-control @error('duration') is-invalid @enderror" type="text" value="{{ old('duration', 0) }}" id="duration" name="duration" />
                                    @error('duration')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="amount_principal">{{__('loan.principal')}}</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control" type="text" readonly id="amount_principal" name="amount_principal" value="{{ old('amount_principal')}}" />
                                        <span class="input-group-text">$</span>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="amount_interest">{{__('loan.interest')}}</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control" type="text" readonly id="amount_interest" name="amount_interest" value="{{ old('amount_interest')}}" />
                                        <span class="input-group-text">$</span>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="monthly_payment">{{__('loan.monthly_payment')}}</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control" type="text" readonly id="monthly_payment" name="monthly_payment" value="{{ old('monthly_payment')}}" />
                                        <span class="input-group-text">$</span>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="payable_amount">{{__('loan.payable_amount')}}</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control" type="text" readonly id="payable_amount" name="payable_amount" value="{{ old('payable_amount')}}" />
                                        <span class="input-group-text">$</span>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="loan_date">{{__('loan.date')}}</label>
                                    <input class="form-control @error('date') is-invalid @enderror" type="date" value="{{ old('date', $currentDate) }}" id="loan_date" name="date" />
                                    @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="status">{{__('loan.status')}}</label>
                                    <select id="status" class="select2 form-select @error('status') is-invalid @enderror" name="status">
                                        @foreach ($statusOptions as $key => $value)
                                        <option value="{{ $key }}" @if(old('status')==$key) @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label class="form-label" for="note">{{__('loan.note')}}</label>
                                    <textarea id="note" class="form-control" name="note">{{ old('note', setToIdNumber($defaultNote)) }}</textarea>
                                </div>

                                <h5 class="py-3">{{__('loan.loan_document')}}</h5>

                                <div class="col-md-12">
                                    <label class="form-label" for="status">{{__('loan.loaner')}}</label>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <small class="text-light fw-medium">{{__('loan.document_id_card')}}</small>
                                    <div class="mt-3">
                                        <select id="customer_id_card" class="select2 form-select @error('customer_id_card') is-invalid @enderror" name="customer_id_card">
                                            <option value="0" selected>{{__('loan.document_none')}}</option>
                                            <option value="1" @if(old('customer_id_card'==1)) selected @endif>{{__('loan.document_original')}}</option>
                                            <option value="2" @if(old('customer_id_card'==2)) selected @endif>{{__('loan.document_copy')}}</option>
                                        </select>
                                        @error('customer_id_card')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <small class="text-light fw-medium">{{__('loan.document_familybook')}}</small>
                                    <div class="mt-3">
                                        <select id="customer_family_book" class="select2 form-select @error('customer_family_book') is-invalid @enderror" name="customer_family_book">
                                            <option value="0" selected>{{__('loan.document_none')}}</option>
                                            <option value="1" @if(old('customer_family_book'==1)) selected @endif>{{__('loan.document_original')}}</option>
                                            <option value="2" @if(old('customer_family_book'==2)) selected @endif>{{__('loan.document_copy')}}</option>
                                        </select>
                                        @error('customer_family_book')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <small class="text-light fw-medium">{{__('loan.document_birth_certificate')}}</small>
                                    <div class="mt-3">
                                        <select id="customer_birth_certificate" class="select2 form-select @error('customer_birth_certificate') is-invalid @enderror" name="customer_birth_certificate">
                                            <option value="0" selected>{{__('loan.document_none')}}</option>
                                            <option value="1" @if(old('customer_birth_certificate'==1)) selected @endif>{{__('loan.document_original')}}</option>
                                            <option value="2" @if(old('customer_birth_certificate'==2)) selected @endif>{{__('loan.document_copy')}}</option>
                                        </select>
                                        @error('customer_birth_certificate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <small class="text-light fw-medium">{{__('loan.document_other')}}</small>
                                    <div class="mt-3">
                                        <input class="form-control" type="text" id="customer_other" name="customer_other" value="{{ old('customer_other')}}" />
                                        @error('customer_other')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="status">{{__('loan.guarantor')}}</label>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <small class="text-light fw-medium">{{__('loan.document_id_card')}}</small>
                                    <div class="mt-3">
                                        <select id="guarantor_id_card" class="select2 form-select @error('guarantor_id_card') is-invalid @enderror" name="guarantor_id_card">
                                            <option value="0" selected>{{__('loan.document_none')}}</option>
                                            <option value="1" @if(old('guarantor_id_card'==1)) selected @endif>{{__('loan.document_original')}}</option>
                                            <option value="2" @if(old('guarantor_id_card'==2)) selected @endif>{{__('loan.document_copy')}}</option>
                                        </select>
                                        @error('guarantor_id_card')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <small class="text-light fw-medium">{{__('loan.document_familybook')}}</small>
                                    <div class="mt-3">
                                        <select id="guarantor_family_book" class="select2 form-select @error('guarantor_family_book') is-invalid @enderror" name="guarantor_family_book">
                                            <option value="0" selected>{{__('loan.document_none')}}</option>
                                            <option value="1" @if(old('guarantor_family_book'==1)) selected @endif>{{__('loan.document_original')}}</option>
                                            <option value="2" @if(old('guarantor_family_book'==2)) selected @endif>{{__('loan.document_copy')}}</option>
                                        </select>
                                        @error('guarantor_family_book')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <small class="text-light fw-medium">{{__('loan.document_birth_certificate')}}</small>
                                    <div class="mt-3">
                                        <select id="guarantor_birth_certificate" class="select2 form-select @error('guarantor_birth_certificate') is-invalid @enderror" name="guarantor_birth_certificate">
                                            <option value="0" selected>{{__('loan.document_none')}}</option>
                                            <option value="1" @if(old('guarantor_birth_certificate'==1)) selected @endif>{{__('loan.document_original')}}</option>
                                            <option value="2" @if(old('guarantor_birth_certificate'==2)) selected @endif>{{__('loan.document_copy')}}</option>
                                        </select>
                                        @error('guarantor_birth_certificate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <small class="text-light fw-medium">{{__('loan.document_other')}}</small>
                                    <div class="mt-3">
                                        <input class="form-control" type="text" id="guarantor_other" name="guarantor_other" value="{{ old('guarantor_other')}}" />
                                        @error('guarantor_other')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">{{__('button.save')}}</button>
                                <button type="reset" class="btn btn-outline-secondary">{{__('button.cancel')}}</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->
@endsection
@push('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.js"></script>
<style>
    .select2 {
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
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .select2-container--default .select2-selection--single {
        border: 0px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 8px;
    }
</style>
<script>
    $(document).ready(function() {

        $(document).ready(function() {

            $('#customer_id').select2({
                placeholder: "សូមជ្រើសរើសអតិថិជន",
                allowClear: true,
                width: '100%'
            });

        });
        $(document).ready(function() {
            $('#product_id').select2({
                placeholder: "Select Product",
                allowClear: true
            });
        });

        $('#status').change(function() {
            var selectedOption = $(this).val();
            if (selectedOption === '2') {
                $('#storedDocs').show();

            } else {
                $('#storedDocs').hide();
            }
        });

        // Select the product dropdown and the Amount input field
        var $productDropdown = $('#product_id');
        var $amountInput = $('#amount');

        // Event handler for product dropdown change
        $productDropdown.on('change', function() {
            // Get the selected option's data-value attribute
            var selectedOption = $productDropdown.find('option:selected');
            var dataValue = selectedOption.data('value');

            // Set the value of the Amount input field
            $amountInput.val(dataValue);
        });

        // Select the input fields for Amount, Interest, and Duration
        var $amount = $('#amount');
        var $firstAmount = $('#first_amount');
        var $interest = $('#interest');
        var $duration = $('#duration');
        var $amountInterestMonth = $('#amount_interest');
        var $amountPrincipaltMonth = $('#amount_principal');
        var $payPerMonth = $('#monthly_payment');
        var $payableAmount = $('#payable_amount');

        // Function to calculate the Pay Per Month and Payable Amount
        function calculateLoanValues() {
            var amount = parseFloat($amount.val()) || 0;
            var firstAmount = parseFloat($firstAmount.val()) || 0;
            var interest = parseFloat($interest.val()) || 0;
            var duration = parseFloat($duration.val()) || 0;

            var interestRate = interest / 100;
            var balance = amount - firstAmount;
            var monthlyPrincipal = balance / duration;
            var numberOfPayments = duration;

            if (interestRate === 0) {
                var monthlyInterest = 0;
                var payPerMonth = monthlyPrincipal;
            } else {
                var monthlyInterest = balance * interestRate;
                if (monthlyInterest < 5) {
                    monthlyInterest = 5;
                }
                var payPerMonth = monthlyPrincipal + monthlyInterest;
            }

            var payableAmount = payPerMonth * numberOfPayments;

            $amountPrincipaltMonth.val(monthlyPrincipal);
            $amountInterestMonth.val(monthlyInterest);
            $payPerMonth.val(payPerMonth);
            $payableAmount.val(payableAmount);
        }

        $amount.on('input', calculateLoanValues);
        $interest.on('input', calculateLoanValues);
        $duration.on('input', calculateLoanValues);
        $firstAmount.on('input', calculateLoanValues);
    });
</script>

@endpush