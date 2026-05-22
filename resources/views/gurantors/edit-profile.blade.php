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
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> {{__('customer.edit.account')}}</a>
                    </li>
                </ul>
                <form id="formAccountSettings" method="POST" action="{{ route('customers.update', withLang(['id' => $customer->id])) }}" enctype="multipart/form-data">
                  @csrf
                <div class="card mb-4">
                    <h5 class="card-header">{{__('customer.edit.detail')}}</h5>
                    <!-- Account -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                          <img
                            src="{{ $customer->getProfileImageAttribute() }}"
                            alt="customer-avatar"
                            class="d-block rounded"
                            height="100"
                            width="100"
                            id="uploadedAvatar"
                            onError="this.onerror=null;this.src='{{ asset('/images/blank-profile.png') }}';"
                        />
                        <input type="hidden" value="{{ $customer->getProfileImageAttribute() }}" class="mediaUserdata" />
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">{{ __('button.upload_new_photo') }}</span>
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
                                    <label for="name" class="form-label">{{__('customer.name')}}</label>
                                        <input
                                            class="form-control @error('name') is-invalid @enderror"
                                            type="text"
                                            id="name"
                                            name="name"
                                            value="{{ old('name', $customer->name ?? '') }}"
                                            autofocus
                                        />
                                        @error('name')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                </div>
                                
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="phone">{{__('customer.phone')}}</label>
                                    <div class="input-group input-group-merge">
                                        <input
                                            type="text"
                                            id="phone"
                                            name="phone"
                                            value="{{ old('phone', $customer->phone ?? '')}}"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            placeholder="000 000 0000"
                                        />
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="gender">{{__('customer.gender')}}</label>
                                    <select id="gender" class="select2 form-select @error('gender') is-invalid @enderror" name="gender">
                                        <option value="1" @if(old('gender', $customer->gender ?? '') == 1) selected @endif>Male</option>
                                        <option value="2" @if(old('gender', $customer->gender ?? '') == 2) selected @endif>Female</option>
                                    </select>
                                    @error('grnder')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="customer_type">{{__('customer.customer_type')}}</label>
                                    <select id="customer_type" class="select2 form-select @error('customer_type') is-invalid @enderror" name="customer_type">
                                        <option value="1" @if(old('customer_type', $customer->customer_type ?? '') == 1) selected @endif>Normal</option>
                                        <option value="2" @if(old('customer_type', $customer->customer_type ?? '') == 2) selected @endif>Loan</option>
                                    </select>
                                    @error('grnder')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                </div>

                                
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="id-card-no">{{__('customer.id_card_number')}}</label>
                                    <div class="input-group input-group-merge">
                                      <input
                                        type="text"
                                        id="id-card-number"
                                        name="id_card_number"
                                        value="{{ old('id_card_number', $customer->id_card_number ?? '')}}"
                                        class="form-control"
                                        placeholder=""
                                      />
                                      @error('id_card_number')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                    </div>
                                </div>


                                <div class="mb-3 col-md-6">
                                    <label for="document" class="form-label">{{__('customer.document')}}</label>
                                    <input type="text" class="form-control" id="document" name="document" value="{{ old('document', $customer->document ?? '')}}" placeholder="ID, Certificate" />
                                    @error('document')
                                          <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
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
                        <h5 class="card-header">Delete Account</h5>
                        <div class="card-body">
                            <div class="mb-3 col-12 mb-0">
                                <div class="alert alert-warning">
                                    <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete this account?</h6>
                                    <p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
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
                                    <label class="form-check-label" for="confirm">I confirm my account deactivation</label>
                                    @error('confirm')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-danger deactivate-account" disabled>Deactivate Account</button>
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
