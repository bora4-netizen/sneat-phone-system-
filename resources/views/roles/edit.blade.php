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
                                    @foreach($permission as $value)
                                        <input class="form-check-input @error('permission') is-invalid @enderror" type="checkbox" name="permission[]" id="permission-{{ $value->id }}" value="{{ $value->id }}"
                                            {{ in_array($value->id, old('permission', $rolePermissions)) ? 'checked' : '' }}>
                                        <label for="permission-{{ $value->id }}">{{ $value->name }}</label>
                                        <br/>
                                    @endforeach
                                    @error('permission')
                                        <span class="invalid-feedback" role="alert">
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
        function submitForm(){
            $('.submit-delete').click();
        }
    </script>
@endpush
