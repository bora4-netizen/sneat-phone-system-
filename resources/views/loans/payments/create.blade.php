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
              <form id="formLoanPaymentRegister" method="POST" action="{{ route('loans.payments.store', withLang()) }}" enctype="multipart/form-data">
                @csrf
                <div class="card mb-4">
                    <h5 class="card-header">{{__('loan.register')}}</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="loan_id">{{__('loan.no')}}</label>
                                @if(isset($loanPayment->id))
                                  <input type="text" class="form-control" value="{{ $loanPayment->number }} ({{ $loanPayment->customer->name }})" disabled />
                                  <input type="hidden" class="form-control" value="{{ $loanPayment->id }}" id="loan_id" name="loan_id" data-value="[{{ $loanPayment->monthly_payment }}, {{ $loanPayment->remain }}, {{ $loanPayment->amount_paying_off }}]" data-date="{{ $loanPayment->next_payment_date }}"/>
                                @else
                                  <select id="loan_id" class="select2 form-select @error('loan_id') is-invalid @enderror" name="loan_id">
                                    <option value="" disabled selected>{{__('common.lbl_select')}}</option>
                                    @foreach ($loans as $loan)
                                        <option  value="{{ $loan->id }}" @if(old('loan_id') == $loan->id) selected @endif data-value="[{{ $loan->monthly_payment }}, {{ $loan->remain }}, {{ $loan->amount_paying_off }}]" data-date="{{ $loan->next_payment_date }}">{{ $loan->number }} ( {{ $loan->customer->name }} ) | ( {{ setToStringDolla($loan->payable_amount) }} )</option>
                                    @endforeach
                                </select>
                                @endif
                                @error('loan_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                              <label class="form-label" for="payment_status">{{__('loan.payment.status')}}</label>
                              <select id="status" class="select2 form-select @error('payment_status') is-invalid @enderror" name="payment_status">
                                  <option value="" disabled selected>{{__('common.lbl_select')}}</option>
                                  @foreach ($statuOptions as $key => $value)
                                      <option value="{{ $key }}" @if(old('payment_status') == $key) selected @endif> {{ $value }} </option>
                                  @endforeach
                              </select>
                              @error('payment_status')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>

                            <div class="mb-3 col-md-6">
                              <label class="form-label" for="loan_date">{{__('loan.payment.due_date')}}</label>
                              <input class="form-control @error('date') is-invalid @enderror" type="date" value="{{ old('date', $currentDate) }}" id="loan_date" name="date" readonly/>
                              @error('date')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="payment_type">{{__('loan.payment.types')}}</label>
                                <select id="payment_type" class="select2 form-select @error('payment_type') is-invalid @enderror" name="payment_type">
                                    @foreach ($typOptions as $key => $value)
                                        <option value="{{ $key }}" @if(old('payment_type') == $key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('payment_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                              <label class="form-label" for="amount">{{__('loan.amount')}}</label>
                                <div class="input-group input-group-merge">
                                  <input readonly class="form-control @error('amount') is-invalid @enderror" type="text" value="{{ old('amount', 0) }}" id="amount" name="amount"/>
                                  <span class="input-group-text">$</span>
                                  @error('amount')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                                </div>
                            </div>

                            <div class="mb-3 col-md-6">
                              <label class="form-label" for="remain">{{__('loan.payment.remain')}}</label>
                                <div class="input-group input-group-merge">
                                  <input readonly class="form-control @error('remain') is-invalid @enderror" type="text" value="{{ old('remain', 0) }}" id="remain" name="remain"/>
                                  <span class="input-group-text">$</span>
                                  @error('remain')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label" for="note">{{__('loan.payment.note')}}</label>
                                <textarea id="note" class="form-control" name="note">{{ old('note') }}</textarea>
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
@if(isset($loanPayment->id))
<script>
    $(document).ready(function() {
        $('#status').change(function() {
            var selectedValue = $(this).val();
            var loanNoDataValue = $('#loan_id').data('value');
            if (selectedValue == 2) {
                $('#amount').val(loanNoDataValue[2]);
                $('#remain').val(loanNoDataValue[2]);
            }else{
                $('#amount').val(loanNoDataValue[0]);
                $('#remain').val(loanNoDataValue[1] - loanNoDataValue[0]);
            }
        });
        $('#loan_date').val($('#loan_id').data('date'));
    });
</script>
@else
<script>
  $(document).ready(function() {
      $('#loan_id').change(function() {
          var selectedValue = $(this).val();
          var loanNoDataValue = $('option:selected', this).data('value');
          if ($('#status').val() == 2) {
              $('#amount').val(loanNoDataValue[2]);
              $('#remain').val(loanNoDataValue[2]);
          }else{
              $('#amount').val(loanNoDataValue[0]);
              $('#remain').val(loanNoDataValue[1] - loanNoDataValue[0]);
          }

          $('#loan_date').val($('option:selected', this).data('date'));
      });

      $('#status').change(function() {
          var selectedValue = $(this).val();
          var loanNoDataValue = $('option:selected', '#loan_id').data('value');
          if (selectedValue == 2) {
              $('#amount').val(loanNoDataValue[2]);
              $('#remain').val(loanNoDataValue[2]);
          }else{
              $('#amount').val(loanNoDataValue[0]);
              $('#remain').val(loanNoDataValue[1] - loanNoDataValue[0]);
          }
      });
  });
</script>
@endif

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
    $(document).ready(function() {

        $("#loan_id").select2({
            placeholder: "សូមជ្រើសរើសអតិថិជន",
            allowClear: true
        });
        $("#product_id").select2({
            placeholder: "សូមជ្រើសរើសផលិតផល",
            allowClear: true
        });
    })
</script>
@endpush
