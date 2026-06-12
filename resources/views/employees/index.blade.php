@extends('layouts.app')
@push('styles')
@endpush

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="pull-right">
                @can('user-create')
                    <a class="btn btn-outline-primary" href="{{ route('register', withLang()) }}"> <i class='bx bx-plus-circle' ></i> Create New User</a>
                @endcan
            </div>
        </div>
    </div>
    <!-- List User Table -->
    <div class="card">
        <h5 class="card-header">List of users</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Position</th>
                        <th>Status</th>
                        @can(['user-edit'])
                        <th>Actions</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <tr>
                            <td>
                                <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                    <li
                                        data-bs-toggle="tooltip"
                                        data-popup="tooltip-custom"
                                        data-bs-placement="top"
                                        class="avatar avatar-xs pull-up"
                                        title="{{$user->name}}"
                                        >
                                        <img src="{{ $user->getProfile() }}" alt="Avatar" class="rounded-circle" onError="this.onerror=null;this.src='{{ asset('/assets/img/blank-profile.png') }}';"/>
                                    </li>
                                </ul>
                            </td>
                            <td><strong>{{ $user->employee->name ?? ''}}</strong></td>
                            <td>{{ $user->employee->email ?? ''}}</td>
                            <td>{{ $user->employee->phone ?? '' }}</td>
                            <td>{{ $user->employee->position ?? ''}}</td>
                            <td>{!! $user->employee->statusname ?? ''!!}</td>
                            @can('user-edit')
                           <td>
    <!-- Edit Button -->
    <div class="d-flex align-items-center gap-1">
    
    {{-- Edit Button --}}
    <a href="{{ route('users.edit', withLang(['id' => $user->id])) }}"
       class="btn btn-icon btn-outline-secondary">
        <span class="tf-icons bx bx-edit-alt"></span>
    </a>

    {{-- Delete Button --}}
    <form action="{{ route('users.destroy', withLang(['id' => $user->id])) }}" 
          method="POST" 
          onsubmit="return confirm('Are you sure to delete this ?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-icon btn-outline-danger">
            <span class="tf-icons bx bx-trash"></span>
        </button>
    </form>

</div>
</td>
                            @endcan
                        </tr>
                    @endforeach

                </tbody>
                <tfoot class="table-border-bottom-0">
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Branch</th>
                        <th>Position</th>
                        @can(['user-edit'])
                        <th>Actions</th>
                        @endcan
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!--/ List User Table -->
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
