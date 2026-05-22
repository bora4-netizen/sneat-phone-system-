@extends('layouts.app')
@push('styles')
@endpush

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="pull-right">
                @can('branch-create')
                    <a class="btn btn-outline-primary" href="{{ route('branches.create', withLang()) }}"> <i class='bx bx-plus-circle' ></i> Create New Branch</a>
                @endcan
            </div>
        </div>
    </div>
    <!-- List Role Table -->
    <div class="card">
        <h5 class="card-header">List Branch</h5>
        <div class="table-responsive text-nowrap">
            <table class="table mb-5">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name KH</th>
                        <th>Name EN</th>
                        @can(['branch-edit'], ['branch-delete'])
                        <th>Actions</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($branches as $key => $branch)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td><strong>{{ $branch->name_kh }}</strong></td>
                            <td><strong>{{ $branch->name_en }}</strong></td>
                            @can(['branch-edit'], ['branch-delete'])
                                <td>
                                    @can('branch-edit')
                                        <a href="{{ route('branches.edit', withLang(['id' => $branch->id])) }}" class="btn btn-icon btn-outline-secondary">
                                            <span class="tf-icons bx bx-edit-alt"></span>
                                        </a>
                                    @endcan
                                    @can('branch-delete')
                                        {!! Form::open(['method' => 'DELETE','route' => ['branches.destroy', $branch->id],'style'=>'display:inline']) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger d-none submit-delete']) !!}
                                            <a id="btn-delete" href="javascript:submitForm()" class="btn btn-icon btn-outline-secondary">
                                                <span class="tf-icons bx bx-trash-alt"></span>
                                            </a>
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--/ List Role Table -->
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
