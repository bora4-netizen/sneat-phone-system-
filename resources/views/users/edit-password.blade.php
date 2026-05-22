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
                            <a class="nav-link" href="{{ route('users.edit.profile', withLang()) }}"><i class="bx bx-user me-1"></i> Account</a>
                        </li>
                        @can('user-profile-password-edit')
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);">
                                <i class="bx bxs-keyboard me-1"></i> Password
                            </a>
                        </li>
                        @endcan
                    @endcan
                </ul>
                <form id="formAccountSettings" method="POST" action="{{ route('users.update.password', withLang(['id' => $user->id]))}}" enctype="multipart/form-data">
                    @csrf
                    <div class="card mb-4">
                        <h5 class="card-header">Update Password</h5>
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
                            <div class="mb-3 form-password-toggle col-6">
                                <label for="current-password" class="form-label">Current Password</label>
                                <div class="input-group input-group-merge">
                                    <input id="current-password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required autocomplete="current-password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="current-password">
                                    @error('current_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3 form-password-toggle col-6">
                                  <label for="new-password" class="form-label">New Password</label>
                                  <div class="input-group input-group-merge">
                                      <input id="new-password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required autocomplete="new-password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="new-password">
                                      @error('new_password')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                      <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                  </div>
                            </div>
                            <div class="mb-3 form-password-toggle col-6">
                                <label for="password-confirm" class="form-label">Confriem Password</label>
                                <div class="input-group input-group-merge">
                                    <input id="password-confirm" type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" name="new_password_confirmation" required autocomplete="password-confirm" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password-confirm">
                                    @error('new_password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
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
    });
    </script>
@endpush
