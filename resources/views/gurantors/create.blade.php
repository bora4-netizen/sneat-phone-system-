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
                    <form id="formAccountSettings" method="POST" action="{{ route('customers.store', withLang()) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card mb-4">
                        <h5 class="card-header">{{__('customer.register_title')}}</h5>
                         <!-- Account -->
                         <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img
                                  src="{{ asset('/assets/img/blank-profile.png') }}"
                                    alt="user-avatar"
                                    class="d-block rounded"
                                    height="100"
                                    width="100"
                                    id="uploadedAvatar"
                                    onError="this.onerror=null;this.src='{{ asset('/assets/img/blank-profile.png') }}';"
                                />
                                <input type="hidden" value="{{ asset('/assets/img/blank-profile.png') }}" class="mediaUserdata" />
                                    <div class="button-wrapper">
                                        <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                            <span class="d-none d-sm-block">{{__('button.upload_new_photo')}}</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                            <input
                                                type="file"
                                                id="upload"
                                                name="profile"
                                                class="account-file-input"
                                                hidden
                                                accept="image/png, image/jpeg"
                                            />
                                        </label>
                                        <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                            <i class="bx bx-reset d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">{{__('button.reset')}}</span>
                                        </button>

                                        <p class="text-muted mb-0">Allowed JPG, GIF or PNG.</p>
                                    </div>
                                </div>
                            </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="customer-name" class="form-label">{{__('customer.name')}}</label>
                                    <input
                                        class="form-control @error('customer_name') is-invalid @enderror"
                                        type="text"
                                        id="customer-name"
                                        name="customer_name"
                                        value="{{ old('customer_name') }}"
                                        autofocus
                                    />
                                    @error('customer_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="gender" class="form-label">{{__('customer.gender')}}</label>
                                    <select id="gender" class="select2 form-select @error('gender') is-invalid @enderror" name="gender">
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="customer_type" class="form-label">{{__('customer.customer_type')}}</label>
                                    <select id="customer_type" class="select2 form-select @error('customer_type') is-invalid @enderror" name="customer_type">
                                        <option value="1" selected >Normal</option>
                                        <option value="2" selected >Loan</option>
                                    </select>
                                    @error('customer_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="nationality" class="form-label">{{__('customer.nationality')}}</label>
                                    <select id="nationality" class="select2 form-select @error('nationality') is-invalid @enderror" name="nationality">
                                        <option value="1" selected >Cambodian</option>
                                        <option value="2" selected >Foreigner</option>
                                    </select>
                                    @error('nationality')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="phone" class="form-label">{{__('customer.phone')}}</label>
                                    <input
                                        class="form-control @error('phone') is-invalid @enderror"
                                        type="text"
                                        id="phone"
                                        name="phone"
                                        value="{{ old('phone') }}"
                                        autofocus
                                    />
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="id-card-number" class="form-label">{{__('customer.name')}}</label>
                                    <input
                                        class="form-control @error('id_card_number') is-invalid @enderror"
                                        type="text"
                                        id="id_card_number"
                                        name="id_card_number"
                                        value="{{ old('id_card_number') }}"
                                        autofocus
                                    />
                                    @error('id_card_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="document" class="form-label">{{__('customer.document')}}</label>
                                    <input
                                        class="form-control @error('id_card_number') is-invalid @enderror"
                                        type="text"
                                        id="document"
                                        name="document"
                                        value="{{ old('document') }}"
                                        autofocus
                                    />
                                    @error('document')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="employee">{{__('customer.created_by')}}</label>

                                    <select id="employee" class="select2 form-select @error('employee') is-invalid @enderror" name="employee">
                                        <option value="">Select an option</option>
                                        @foreach ($employees as $key => $value)
                                            <option value="{{ $key }}" @if(old('employee') == $key) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('employee')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">{{__('button.save')}}</button>
                                <button type="reset" class="btn btn-outline-secondary">{{__('button.cancel')}}</button>
                            </div>
                    </div>
                    <!-- /Account -->
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

        $('#brand').change(function() {
            var brandID = $(this).val();
            $('#series').prop("disabled", false);
            if (brandID !== '') {
                $.ajax({
                    type: 'GET',
                    url: '/en/series/brand/' + brandID,
                    dataType: 'json',
                    success: function(data) {
                        // Clear and populate select2 with new data
                        var series = $('#series');
                        series.empty();
                        series.append('<option>Select an option</option>');
                        if (data.length > 0) {
                            $.each(data, function(key, value) {
                                series.append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    }
                });
            } else {
                // Reset select2 when nothing is selected in select1
                $('#series').empty().append('<option value="">Select an option</option>');
                $('#series').prop("disabled", true);
            }
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
