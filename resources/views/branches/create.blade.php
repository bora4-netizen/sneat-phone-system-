@extends('layouts.app')

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add New Branch</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('branches.store', withLang() }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="name_kh">{{ __('Name ( ខ្មែរ )') }}</label>
                            <div class="input-group input-group-merge">
                                <input
                                    type="text"
                                    class="form-control @error('name_kh') is-invalid @enderror"
                                    id="name_kh"
                                    placeholder="ខ្មែរ"
                                    aria-label="ខ្មែរ"
                                    aria-describedby="name_kh"
                                    name="name_kh" value="{{ old('name_kh') }}"
                                    required
                                    autocomplete="name_kh"
                                    autofocus
                                />
                                @error('name_kh')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="name_en">{{ __('Name ( English )') }}</label>
                            <div class="input-group input-group-merge">
                                <input
                                    type="text"
                                    class="form-control @error('name_en') is-invalid @enderror"
                                    id="fullname"
                                    placeholder="English"
                                    aria-label="English"
                                    name="name_en" value="{{ old('name_en') }}"
                                    required
                                    autocomplete="name_en"
                                    autofocus
                                />
                                @error('name_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
