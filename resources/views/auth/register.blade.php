@extends('layouts.app')

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add New Account</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register', withLang()) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="fullname">{{ __('Login Name') }}</label>
                            <div class="input-group input-group-merge">
                                <span id="fullname2" class="input-group-text">
                                    <i class="bx bx-user"></i>
                                </span>
                                <input
                                    type="text"
                                    id="fullname"
                                    name="name"
                                    value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Full Name"
                                    aria-label="Full Name"
                                    aria-describedby="fullname2"
                                    required
                                    autocomplete="name"
                                    autofocus
                                />
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-text">You can use lowercase letters, numbers & underscores</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <div class="input-group input-group-merge">
                                <span id="email2" class="input-group-text"><i class="bx bx-envelope"></i></span>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="riscydo"
                                    aria-label="riscydo"
                                    aria-describedby="email2"
                                />
                                <span id="basic-icon-default-email2" class="input-group-text">@example.com</span>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-text">You can use letters, numbers & periods</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="position">Position</label>
                            <div class="input-group input-group-merge">
                                <span id="email2" class="input-group-text"><i class="bx bx-envelope"></i></span>
                                <select id="position" class="select2 form-select @error('position') is-invalid @enderror" name="position">
                                    @foreach ($roles as $key => $value)
                                        <option value="{{ $key }}" @if(old('position', $user->employee->position_id ?? '') == $key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password">{{ __('Password') }}</label>
                            <div class="input-group input-group-merge">
                                <span id="password2" class="input-group-text">
                                    <i class="bx bx-key"></i>
                                </span>
                                <input
                                    type="password"
                                    id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-label="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password2"
                                    name="password"
                                    required
                                    autocomplete="new-password"
                                />
                                <input id="new-password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required autocomplete="new-password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password-confirm">{{ __('Confirm Password') }}</label>
                            <div class="input-group input-group-merge">
                                <span id="password-confirm2" class="input-group-text">
                                    <i class="bx bx-key"></i>
                                </span>
                                <input
                                    type="password"
                                    id="password-confirm"
                                    class="form-control form-control"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-label="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password-confirm2"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password"
                                />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection
