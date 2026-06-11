@extends('layouts.app')
@push('styles')
@endpush

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="pull-right">
                <a class="btn btn-outline-secondary" href="{{ route('roles.index', withLang()) }}"><i class='bx bxs-chevrons-left'></i>&nbsp; Back</a>
            </div>
        </div>
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create New Role</h5>
                </div>
                <div class="card-body">
                    {!! Form::open(array('route' => ['roles.store', withLang()] ,'method'=>'POST')) !!}
                    <div class="row">
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label" for="basic-default-fullname">Name</label>
                                    <input id="name" type="text" name="name"  class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter your role" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Permission</label>
                                <br />

                                @foreach($permission as $group => $perms)
                                <div class="mb-3">

                                    <div class="form-check fw-bold mb-1">
                                        <input class="form-check-input parent-check"
                                            type="checkbox"
                                            id="parent_{{ $group }}"
                                            data-group="{{ $group }}">
                                        <label class="form-check-label text-capitalize fw-semibold"
                                            for="parent_{{ $group }}">
                                            {{ ucfirst($group) }}
                                        </label>
                                    </div>

                                    <div class="ms-4">
                                        @foreach($perms as $value)
                                        <div class="form-check">
                                            <input class="form-check-input child-check
                                          @error('permission') is-invalid @enderror"
                                                type="checkbox"
                                                name="permission[]"
                                                id="permission-{{ $value->id }}"
                                                value="{{ $value->id }}"
                                                data-group="{{ $group }}">
                                            <label class="form-check-label"
                                                for="permission-{{ $value->id }}">
                                                {{ $value->name }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>

                                </div>
                                @endforeach

                                @error('permission')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
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
    // Parent → check/uncheck all children in its group
    document.querySelectorAll('.parent-check').forEach(function(parent) {
        parent.addEventListener('change', function() {
            const group = this.dataset.group;
            document.querySelectorAll('.child-check[data-group="' + group + '"]')
                .forEach(function(child) {
                    child.checked = parent.checked;
                });
        });
    });

    // Child → auto-check parent if ALL siblings checked; uncheck if any unchecked
    document.querySelectorAll('.child-check').forEach(function(child) {
        child.addEventListener('change', function() {
            const group = this.dataset.group;
            const siblings = document.querySelectorAll('.child-check[data-group="' + group + '"]');
            const allChecked = Array.from(siblings).every(function(c) {
                return c.checked;
            });
            document.getElementById('parent_' + group).checked = allChecked;
        });
    });

    function submitForm() {
        $('.submit-delete').click();
    }
</script>
@endpush