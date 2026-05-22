@extends('layouts.app')


@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="pull-right">
                <a class="btn btn-outline-secondary" href="{{ route('roles.index', withLang()) }}"><i class='bx bxs-chevrons-left' ></i>&nbsp;  Back</a>
            </div>
        </div>
        <div class="col-12 mb-md-0 mb-4">
            <div class="card">
                <h5 class="card-header">{{ $role->name }}</h5>
                <div class="card-body">
                    <!-- Connections -->
                    <div class="d-flex mb-3">
                        <div class="flex-grow-1 row">
                            @if(!empty($rolePermissions))
                                @foreach($rolePermissions as $v)
                                    <div class="col-3 mb-2">
                                        <h6 class="mb-0"><i class='bx bx-check'></i>{{ $v->name }}</h6>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <!-- /Connections -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection
