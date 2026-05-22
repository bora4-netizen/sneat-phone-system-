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
                <form id="formAccountSettings" method="POST" action="{{ route('customers.update', withLang(['id' => $customer->id])) }}" enctype="multipart/form-data">
                  @csrf
                <div class="card mb-4">
                    <h5 class="card-header">{{__('customer.edit.detail')}}</h5>
                    <!-- Account -->
                    @include('customers.includes.__form', ['customer' => $customer])
                    @include('customers.includes.__company-form', ['customer' => $customer])
                    @include('customers.includes.__guarantor-form', ['customer' => $customer])

                    <hr class="my-0" />
                    <div class="card-body">
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">{{__('button.save_changes')}}</button>
                                <button type="reset" class="btn btn-outline-secondary">{{__('button.cancel')}}</button>
                            </div>
                    </div>
                  </form>
                    <!-- /Account -->
                </div>
                @can('customer-delete')
                    <div class="card">
                        <h5 class="card-header">{{__('customer.delete')}}</h5>
                        <div class="card-body">
                            <div class="mb-3 col-12 mb-0">
                                <div class="alert alert-warning">
                                    <h6 class="alert-heading fw-bold mb-1">{{__('customer.want_to_delete')}}</h6>
                                    <p class="mb-0">{{__('customer.be_certain')}}</p>
                                </div>
                            </div>
                            <form id="formAccountDeactivation" method="POST" action="{{ route('customers.destroy', withLang(['id' => $customer->id])) }}">
                                @method('delete')
                                @csrf
                                <div class="form-check mb-3">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="confirm"
                                        id="confirm"
                                    />
                                    <label class="form-check-label" for="confirm">{{__('customer.confirm_delete')}}</label>
                                    @error('confirm')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-danger deactivate-account" disabled>{{__('customer.deactivate')}}</button>
                            </form>
                        </div>
                    </div>
                @endcan
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
          $('#customer_type').change(function() {
            var selectedOption = $(this).val();
            if (selectedOption === '2') {
                $('#loanInfo').show();
                $('#guarantorInfo').show();
                $('#storedDocs').show();

            } else {
                $('#loanInfo').hide();
                $('#guarantorInfo').hide();
                $('#storedDocs').hide();
            }
        });
        // Add an event listener to the "confirm" checkbox
        $('#confirm').change(function() {
            if ($(this).is(':checked')) {
                // If the checkbox is checked, enable the submit button
                $('.deactivate-account').prop('disabled', false);
            } else {
                // If the checkbox is not checked, disable the submit button
                $('.deactivate-account').prop('disabled', true);
            }
        });
        $("#upload").on("change", function(e){
            var file = e.target.files[0];
            var mediabase64data;
            getBase64(file).then(
                mediabase64data => $('#uploadedAvatar').attr('src', mediabase64data)
            );
        });
        $('.account-image-reset').click(function(){
            var mediaUserdata = $('.mediaUserdata').val();
            $('#uploadedAvatar').attr('src', mediaUserdata);
        });
    });
    function getBase64(file) {
              return new Promise((resolve, reject) => {
                  const reader = new FileReader();
                  reader.readAsDataURL(file);
                  reader.onload = () => resolve(reader.result);
                  reader.onerror = error => reject(error);
              });
          }


    </script>
@endpush
