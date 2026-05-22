@extends('layouts.app')
@push('styles')
@endpush

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="pull-right">
                @can('customer-create')
                    <a class="btn btn-outline-primary" href="{{ route('customers.create', withLang()) }}"> <i class='bx bx-plus-circle' ></i>{{__('customer.create.title')}}</a>
                @endcan
            </div>
        </div>
    </div>
    <!-- List User Table -->
    <div class="card">
        <h5 class="card-header">{{__('customer.create.list')}}</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>{{__('customer.name')}}</th>
                        <th>{{__('customer.customer_type')}}</th>
                        <th>{{__('customer.gender')}}</th>
                        <th>{{__('customer.nationality')}}</th>
                        <th>{{__('customer.phone')}}</th>
                        <th>{{__('customer.id_card_number')}}</th>
                        @can(['customer-edit'])
                        <th>{{__('customer.action')}}</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    
                        <tr>
                            <td>
                                <ul class="list-unstyled customers-list m-0 avatar-group d-flex align-items-center">
                                    <li
                                        data-bs-toggle="tooltip"
                                        data-popup="tooltip-custom"
                                        data-bs-placement="top"
                                        class="avatar avatar-xs pull-up"
                                        title=""
                                        >
                                        <img src="" alt="Avatar" class="rounded-circle" onError="this.onerror=null;this.src='{{ asset('/images/blank-profile.png') }}';"/>
                                    </li>
                                </ul>
                            </td>
                            <td><strong></strong></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            
                            @can('customer-edit')
                            <td>
                                <a href="#" class="btn btn-icon btn-outline-secondary">
                                    <span class="tf-icons bx bx-edit-alt"></span>
                                </a>

                                <a href="#" class="btn btn-icon btn-outline-secondary">
                                    <span class="tf-icons bx bx-detail"></span>
                                </a>
                            </td>
                            
                            @endcan
                        </tr>
                    

                </tbody>
                <tfoot class="table-border-bottom-0">
                    <tr>
                        <th></th>
                        <th>{{__('customer.name')}}</th>
                        <th>{{__('customer.customer_type')}}</th>
                        <th>{{__('customer.gender')}}</th>
                        <th>{{__('customer.nationality')}}</th>
                        <th>{{__('customer.phone')}}</th>
                        <th>{{__('customer.id_card_number')}}</th>
                        @can(['customer-edit'])
                        <th>{{__('customer.action')}}</th>
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
