@extends('layouts.app')
@push('styles')
@endpush

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="pull-right">
                <a class="btn btn-outline-secondary" href="{{ route('roles.index', withLang()) }}"><i class='bx bxs-chevrons-left' ></i>&nbsp;  Back</a>
            </div>
        </div>
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Role</h5>
                </div>
                <div class="card-body">
                    {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', withLang(['role' => $role->id])]]) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label" for="basic-default-fullname">Name</label>
                                    <input id="name" type="text" name="name"  class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $role->name) }}" placeholder="Enter your role" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label" for="basic-default-fullname">Permission</label>
                                    <br/>
                                   @foreach($permission as $group => $perms)
    <div class="mb-3">

        {{-- PARENT checkbox --}}
        <!-- @php
            $allChecked = $perms->every(fn($p) => in_array($p->id, $rolePermissions));
        @endphp -->
        @php
    $allChecked = $perms->every(function ($p) use ($rolePermissions) {
        return in_array($p->id, $rolePermissions);
    });
@endphp
        <div class="form-check fw-bold mb-1">
            <input class="form-check-input parent-check"
                   type="checkbox"
                   id="parent_{{ $group }}"
                   data-group="{{ $group }}"
                   {{ $allChecked ? 'checked' : '' }}>
            <label class="form-check-label text-capitalize fw-semibold"
                   for="parent_{{ $group }}">
                {{ ucfirst($group) }}
            </label>
        </div>

        {{-- CHILDREN --}}
        <div class="ms-4">
            @foreach($perms as $value)
                <div class="form-check">
                    <input class="form-check-input child-check"
                           type="checkbox"
                           name="permission[]"
                           id="permission-{{ $value->id }}"
                           value="{{ $value->id }}"
                           data-group="{{ $group }}"
                           {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                    <label class="form-check-label"
                           for="permission-{{ $value->id }}">
                        {{ $value->name }}
                    </label>
                </div>
            @endforeach
        </div>

    </div>
@endforeach
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection
@push('script')
    <script>
        function submitForm(){
            $('.submit-delete').click();
        }
    </script>
@endpush
