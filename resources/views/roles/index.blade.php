@extends('layouts.app')
@push('styles')
@endpush

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="pull-right">
                @can('role-create')
                    <a class="btn btn-outline-primary" href="{{ route('roles.create', withLang()) }}"> <i class='bx bx-plus-circle' ></i> Create New Role</a>
                @endcan
            </div>
        </div>
    </div>
    <!-- List Role Table -->
    <div class="card">
        <h5 class="card-header">List Role</h5>
        <div class="table-responsive text-nowrap">
            <table class="table mb-5">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($roles as $key => $role)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td><strong>{{ $role->name }}</strong></td>
                            <td>
                                @can('role-list')
                                  <a href="{{ route('roles.show', withLang(['role' => $role->id])) }}" class="btn btn-icon btn-outline-secondary">
                                    <i class='bx bxs-spreadsheet'></i>
                                  </a>
                                @endcan
                                @can('role-edit')
                                  <a href="{{ route('roles.edit', withLang(['role' => $role->id])) }}" class="btn btn-icon btn-outline-secondary">
                                      <span class="tf-icons bx bx-edit-alt"></span>
                                  </a>
                                @endcan
                                @can('role-delete')
                                {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', withLang(['role' => $role->id])],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger d-none submit-delete']) !!}
                                    {{-- <a id="btn-delete" class="dropdown-item" href="javascript:submitForm()"><i class="bx bx-trash me-1"></i> Delete</a> --}}
                                    <button type="submit" class="btn btn-icon btn-outline-danger" onclick="return confirm('Are you sure you want to delete this expense?')">
                                      <span class="tf-icons bx bx-trash"></span>
                                    </button>
                                {!! Form::close() !!}
                              @endcan
                            </td>
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
