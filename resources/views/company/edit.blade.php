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
                {{-- @can('company-setting-edit') --}}
                    <form id="formCompanySettings" method="POST" action="{{ route('company.update', withLang()) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card mb-4">
                            <h5 class="card-header">Company Details </h5>
                            <!-- Account -->
                            <div class="card-body">
                                <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img
                                    src="{{ $company->image_logo }}"
                                    alt="user-avatar"
                                    class="d-block rounded"
                                    height="100"
                                    width="100"
                                    id="uploadedAvatar"
                                    onError="this.onerror=null;this.src='{{ asset('/assets/img/blank-profile.png') }}';"
                                />
                                <input type="hidden" value="{{ $company->image_logo }}" class="mediaUserdata" />
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload new photo</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input
                                            type="file"
                                            id="upload"
                                            name="logo"
                                            class="account-file-input"
                                            hidden
                                            accept="image/png, image/jpeg"
                                        />
                                    </label>

                                    <!-- {{--  Reset Button - no change needed here --}} -->
                                    <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                        <i class="bx bx-reset d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">{{ __('common.lbl_reset') }}</span>
                                    </button>
                                    <p class="text-muted mb-0">{{ __('common.lbl_allow_image') }}</p>
                                </div>
                            </div>
                        </div>
                        <hr class="my-0" />
                        <div class="card-body">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Name</label>
                                            <input
                                                class="form-control @error('name') is-invalid @enderror"
                                                type="text"
                                                id="name"
                                                name="name"
                                                value="{{ old('name', $company->name ?? '') }}"
                                                autofocus
                                            />
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                      <label class="form-label" for="interest">Defual Interest</label>
                                      <div class="input-group input-group-merge">
                                          <input
                                              type="text"
                                              id="interest"
                                              name="interest"
                                              value="{{ old('interest', $company->interest ?? '')}}"
                                              class="form-control @error('interest') is-invalid @enderror"
                                              placeholder="0"
                                          />
                                          @error('interest')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="phone">Phone Number</label>
                                        <div class="input-group input-group-merge">
                                            <textarea class="form-control" id="phone" name="phone" placeholder="">{{ old('phone', $company->phone ?? '')}}</textarea>
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                      <label for="detail" class="form-label">Company Detail</label>
                                      <textarea class="form-control" id="detail" name="detail" placeholder="">{{ old('detail', $company->detail ?? '')}}</textarea>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                      <label for="default_loan_note" class="form-label">Defual Note Loan</label>
                                      <textarea class="form-control" id="default_loan_note" name="default_loan_note" placeholder="">{{ old('default_loan_note', $company->default_loan_note ?? '')}}</textarea>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                      <label for="default_invoice_note" class="form-label">Defual Note Invoice</label>
                                      <textarea class="form-control" id="default_invoice_note" name="default_invoice_note" placeholder="">{{ old('default_invoice_note', $company->default_invoice_note ?? '')}}</textarea>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                      <label for="address" class="form-label">Address</label>
                                      <textarea class="form-control" id="address" name="address" placeholder="Address">{{ old('address', $company->address ?? '')}}</textarea>
                                    </div>

                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                    <!-- {{--  FIXED: changed type="reset" to type="button" + added id="cancelBtn" --}} -->
                                    <button type="button" id="cancelBtn" class="btn btn-outline-secondary">Cancel</button>
                                </div>
                        </div>
                    </form>
                        <!-- /Account -->
                    </div>
                {{-- @endcan --}}
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

        //  Save original values when page loads
        var originalValues = {
            name: $('#name').val(),
            interest: $('#interest').val(),
            phone: $('#phone').val(),
            detail: $('#detail').val(),
            default_loan_note: $('#default_loan_note').val(),
            default_invoice_note: $('#default_invoice_note').val(),
            address: $('#address').val(),
            avatar: $('.mediaUserdata').val()
        };

        // Upload new photo preview
        $("#upload").on("change", function(e) {
            var file = e.target.files[0];
            getBase64(file).then(function(mediabase64data) {
                $('#uploadedAvatar').attr('src', mediabase64data);
            });
        });

        //  FIXED Reset Button — resets avatar + clears file input
        $('.account-image-reset').on('click', function() {
            var mediaUserdata = $('.mediaUserdata').val();
            $('#uploadedAvatar').attr('src', mediaUserdata);
            $('#upload').val(''); // ← this was missing before
        });

        //  FIXED Cancel Button — restores all fields to original values
        $('#cancelBtn').on('click', function() {
            $('#name').val(originalValues.name);
            $('#interest').val(originalValues.interest);
            $('#phone').val(originalValues.phone);
            $('#detail').val(originalValues.detail);
            $('#default_loan_note').val(originalValues.default_loan_note);
            $('#default_invoice_note').val(originalValues.default_invoice_note);
            $('#address').val(originalValues.address);
            $('#uploadedAvatar').attr('src', originalValues.avatar);
            $('#upload').val(''); // clear file input too
        });

        // Confirm checkbox (keep existing)
        $('#confirm').change(function() {
            if ($(this).is(':checked')) {
                $('.deactivate-account').prop('disabled', false);
            } else {
                $('.deactivate-account').prop('disabled', true);
            }
        });

        function getBase64(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = () => resolve(reader.result);
                reader.onerror = error => reject(error);
            });
        }
    });
</script>
@endpush