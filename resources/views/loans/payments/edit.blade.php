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
              <form id="formLoanPaymentEdit" method="POST" action="{{ route('loans.payments.update', withLang(['loanPayment' => $loanPayment])) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card mb-4">
                    <h5 class="card-header">{{ __('loan.payment.edit') }}</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="loan_id">{{ __('loan.no') }}</label>
                                @if($loanPayment->loan->status == 2)
                                <select id="loan_id" class="select2 form-select @error('loan_id') is-invalid @enderror" name="loan_id">
                                    <option value="" disabled>{{ __('common.lbl_select') }}</option>
                                    @foreach ($loans as $loan)
                                        <option value="{{ $loan->id }}" @if(old('loan_id', $loanPayment->loan_id) == $loan->id) selected @endif data-value="[{{ $loan->monthly_payment }}, {{ $loan->remain }}, {{ $loan->amount_paying_off }}]">
                                            {{ $loan->number }} ({{ $loan->customer->name }})
                                        </option>
                                    @endforeach
                                </select>
                                @else
                                  <input type="text" class="form-control" value="{{ $loanPayment->loan->number }} ({{ $loanPayment->loan->customer->name }})" disabled />
                                  <input type="hidden" class="form-control" value="{{ $loanPayment->loan->id }}" name="loan_id"/>
                                @endif
                                @error('loan_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="payment_status">{{ __('loan.payment.status') }}</label>
                                <select id="payment_status" class="select2 form-select @error('payment_status') is-invalid @enderror" name="payment_status">
                                    <option value="" disabled>{{ __('common.lbl_select') }}</option>
                                    @foreach ($statusOptions as $key => $value)
                                        <option value="{{ $key }}" @if(old('payment_status', $loanPayment->payment_status) == $key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('payment_status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="payment_date">{{ __('loan.payment.due_date') }}</label>
                                <input class="form-control @error('date') is-invalid @enderror" type="date" value="{{ old('date', $loanPayment->date) }}" id="date" name="date" />
                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="payment_type">{{ __('loan.payment.types') }}</label>
                                <select id="payment_type" class="select2 form-select @error('payment_type') is-invalid @enderror" name="payment_type">
                                    @foreach ($typeOptions as $key => $value)
                                        <option value="{{ $key }}" @if(old('payment_type', $loanPayment->payment_type) == $key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('payment_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="amount">{{ __('loan.amount') }}</label>
                                <div class="input-group input-group-merge">
                                    <input readonly class="form-control" type="text" value="{{ old('amount', $loanPayment->amount) }}" id="amount" name="amount" />
                                    <span class="input-group-text">$</span>
                                </div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="remain">{{ __('loan.payment.remain') }}</label>
                                <div class="input-group input-group-merge">
                                    <input readonly class="form-control" type="text" value="{{ old('remain', $loanPayment->loan->remain) }}" id="remain" name="remain" />
                                    <span class="input-group-text">$</span>
                                </div>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label class="form-label" for="note">{{ __('loan.payment.note') }}</label>
                                <textarea id="note" class="form-control" name="note">{{ old('note', $loanPayment->note) }}</textarea>
                            </div>
                        </div>

                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">{{ __('button.save') }}</button>
                            <button type="reset" class="btn btn-outline-secondary">{{ __('button.cancel') }}</button>
                        </div>
                    </div>
                </div>
            </form>


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
<script>
  $(document).ready(function() {
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
      var $payPerMonth = $('#pay_return');
      var $payableAmount = $('#payable_amount');

      // Function to calculate the Pay Per Month and Payable Amount
      function calculateLoanValues() {
          var amount = parseFloat($amount.val()) || 0;
          var firstAmount = parseFloat($firstAmount.val()) || 0;
          var interest = parseFloat($interest.val()) || 0;
          var duration = parseFloat($duration.val()) || 0;

          var interestRate = interest / 100;
          var monthlyInterestRate = interestRate / 12;
          var numberOfPayments = duration;

          if (interestRate === 0) {
              var payPerMonth = (amount - firstAmount) / numberOfPayments;
          } else {
              var payPerMonth = (amount - firstAmount) * monthlyInterestRate / (1 - Math.pow(1 + monthlyInterestRate, -numberOfPayments));
          }

          var payableAmount = payPerMonth * numberOfPayments;

          // Update the Pay Per Month and Payable Amount fields
          $payPerMonth.val(payPerMonth.toFixed(2));
          $payableAmount.val(payableAmount.toFixed(2));
      }

      // Attach the calculation function to input events
      $amount.on('input', calculateLoanValues);
      $interest.on('input', calculateLoanValues);
      $duration.on('input', calculateLoanValues);
      $firstAmount.on('input', calculateLoanValues);
  });
</script>
@endpush
