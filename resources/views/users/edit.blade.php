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
                    @can('user-profile-edit')
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Account</a>
                        </li>
                        @can('user-profile-password-edit')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.edit.profile.password', withLang())}}">
                                <i class="bx bxs-keyboard me-1"></i> Password
                            </a>
                        </li>
                        @endcan
                    @endcan
                </ul>
                @if(Auth::user()->can('user-profile-edit'))
                    <form id="formAccountSettings" method="POST" action="{{ route('users.update.profile', withLang()) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card mb-4">
                            <h5 class="card-header">Profile Details <small>( Login Name: {{ $user->name }} )</small></h5>
                            <!-- Account -->
                            <div class="card-body">
                                <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img
    src="{{ $user->getProfile() }}"
    alt="user-avatar"
    class="d-block rounded"
    height="100"
    width="100"
    id="uploadedAvatar"
    onError="this.onerror=null;this.src='{{ asset('/assets/img/blank-profile.png') }}';"
                                />
                                <input type="hidden" value="{{ $user->getProfile() }}" class="mediaUserdata" />
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload new photo</span>
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
                                        <label for="name" class="form-label">Name</label>
                                            <input
                                                class="form-control @error('name') is-invalid @enderror"
                                                type="text"
                                                id="name"
                                                name="name"
                                                value="{{ old('name', $user->employee->name ?? '') }}"
                                                autofocus
                                            />
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="latinName" class="form-label">latin Name</label>
                                        <input class="form-control @error('latin_name') is-invalid @enderror" type="text" name="latin_name" id="latin-name" value="{{ old('latin_name', $user->employee->latin_name ?? '') }}" />
                                        @error('latin_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input
                                            class="form-control"
                                            type="email"
                                            id="email"
                                            name="email"
                                            value="{{ old('email', $user->email)}}"
                                            placeholder="john.doe@example.com"
                                        />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="phone">Phone Number</label>
                                        <div class="input-group input-group-merge">
                                            <input
                                                type="text"
                                                id="phone"
                                                name="phone"
                                                value="{{ old('phone', $user->employee->phone ?? '')}}"
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
                                        <label class="form-label" for="position">Position</label>
                                        <input readonly type="text" name="position" class="form-control @can('role-edit') d-none @endcan" @can('role-edit') disabled @endcan value="{{ $user->employee->position ?? '' }}" />
                                        @can('role-edit')
                                            <select id="position" class="select2 form-select
                                                @error('position') is-invalid @enderror"
                                                    name="position"
                                                >
                                                @foreach ($roles as $key => $value)
                                                    <option value="{{ $key }}" @if(old('position', $user->employee->position_id ?? '') == $key) selected @endif>{{ $value }}</option>
                                                @endforeach
                                                @error('position')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </select>
                                        @endcan
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="gender">Gender</label>
                                        <select id="gender" class="select2 form-select @error('gender') is-invalid @enderror" name="gender">
                                            <option value="1" @if(old('gender', $user->employee->gender ?? '') == 1) selected @endif>Male</option>
                                            <option value="2" @if(old('gender', $user->employee->gender ?? '') == 2) selected @endif>Female</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="id-card-no">ID Card Number</label>
                                        <div class="input-group input-group-merge">
                                        <input
                                            type="text"
                                            id="id-card-no"
                                            name="id_card_no"
                                            value="{{ old('id_card_no', $user->employee->id_card_no ?? '')}}"
                                            class="form-control"
                                            placeholder=""
                                        />
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="dob">Birth of Date</label>
                                        <input class="form-control" type="date" value="{{ old('dob', $user->employee->dob ?? '')}}" id="dob" name="dob"/>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->employee->address ?? '')}}" placeholder="Address" />
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="birth-place" class="form-label">Birth Place</label>
                                        <input type="text" class="form-control" id="birth-place" name="birth_place" value="{{ old('birth_place', $user->employee->birth_place ?? '')}}" placeholder="Address" />
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="status">Status</label>
                                        <select id="status" class="select2 form-select" name="status">
                                            <option value="1" @if(old('status', $user->employee->status ?? '') == 1) selected @endif>Probationary Period</option>
                                            <option value="2" @if(old('status', $user->employee->status ?? '') == 2) selected @endif>Part Time</option>
                                            <option value="3" @if(old('status', $user->employee->status ?? '') == 3) selected @endif>Full Time</option>
                                            <option value="4" @if(old('status', $user->employee->status ?? '') == 4) selected @endif>Resign</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="start-working-date">Start Working Date</label>
                                        <input class="form-control" type="date" value="{{ old('start_working_date', $user->employee->start_working_date ?? '')}}" id="start-working-date" name="start_working_date"/>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                    <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                                </div>
                        </div>
                    </form>
                        <!-- /Account -->
                    </div>
                @else
                    <div class="card mb-4">
                        <h5 class="card-header">Profile Details <small>( Login Name: {{ $user->name }} )</small></h5>
                        <!-- Account -->
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img
                                src="{{ $user->getProfile() }}"
                                alt="user-avatar"
                                class="d-block rounded"
                                height="100"
                                width="100"
                                id="uploadedAvatar"
                                onError="this.onerror=null;this.src='{{ asset('/assets/img/blank-profile.png') }}';"
                            />
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">Name : </label>
                                <b>{{ $user->employee->name ?? '' }}</b>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="latinName" class="form-label">latin Name : </label>
                                <b>{{ $user->employee->latin_name ?? '' }}</b>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">E-mail : </label>
                                <b>{{ $user->email ?? ''}}</b>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="phone">Phone Number : </label>
                                <b>{{ $user->employee->phone ?? ''}}</b>
                             </div>
                             <div class="mb-3 col-md-6">
                                <label class="form-label" for="position">Position : </label>
                                <b>{{ $user->employee->position ?? '' }}</b>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="gender">Gender : </label>
                                <b>
                                    @if(old('gender', $user->employee->gender ?? '') == 2)
                                        Female
                                    @else
                                        Male
                                    @endif
                                </b>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="id-card-no">ID Card Number : </label>
                                <b>{{ $user->employee->id_card_no ?? '' }}</b>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="dob">Birth of Date : </label>
                                <b>{{ $user->employee->dob ?? '' }}</b>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="address" class="form-label">Address : </label>
                                <b>{{ $user->employee->address ?? '' }}</b>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="birth-place" class="form-label">Birth Place : </label>
                                {{ $user->employee->birth_place ?? '' }}</b>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="status">Status : </label>
                                <b>{{ $user->employee->statusText ?? ''}}</b>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="start-working-date">Start Working Date : </label>
                                <b>{{ $user->employee->start_working_date ?? '' }}</b>
                            </div>
                        </div>
                    </div>
                    <!-- /Account -->
                </div>
                @endif
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
