@extends('layouts.app')

@push('styles')
@endpush

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="pull-right">
                @can('role-create')
                    <a class="btn btn-outline-primary" href="{{ route('roles.create', withLang()) }}">
                        <i class='bx bx-plus-circle'></i> Create New Role
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="card">
        <h5 class="card-header">List Role</h5>
        <div class="table-responsive text-nowrap">
            <table class="table mb-5" style="vertical-align: middle;">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Name</th>  {{-- Fixed: was "text-cen@endsectionter" --}}
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($roles as $key => $role)
                        <tr>
                            <td class="text-center">{{ ++$i }}</td>
                            <td class="text-center"><strong>{{ $role->name }}</strong></td>
                            <td class="text-center">

                                @can('role-list')
                                    <a href="{{ route('roles.show', withLang(['role' => $role->id])) }}"
                                       class="btn btn-icon btn-outline-secondary">
                                        <i class='bx bxs-spreadsheet'></i>
                                    </a>
                                @endcan

                                @can('role-edit')
                                    <a href="{{ route('roles.edit', withLang(['role' => $role->id])) }}"
                                       class="btn btn-icon btn-outline-secondary">
                                        <span class="tf-icons bx bx-edit-alt"></span>
                                    </a>
                                @endcan

                                @can('role-delete')  {{-- Added: was missing permission guard --}}
                                    <form action="{{ route('roles.destroy', ['lang' => app()->getLocale(), 'role' => $role->id]) }}"
                                          method="POST"
                                          style="display:inline"
                                          onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-outline-danger">
                                            <span class="tf-icons bx bx-trash"></span>
                                        </button>
                                    </form>
                                @endcan

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    function submitForm() {
        $('.submit-delete').click();
    }
</script>
@endpush






