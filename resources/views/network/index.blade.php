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
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                        <i class='bx bx-plus-circle' ></i> {{__('common.lbl_add_new')}}
                    </button>
                @endcan
            </div>
        </div>
    </div>
    <!-- List Role Table -->
    <div class="card">
        <h5 class="card-header">{{__('network.locked.list')}}</h5>
        <div class="table-responsive text-nowrap">
            <table class="table mb-5">
                <thead>
                    <tr>
                        <th class="col-md-5">{{__('network.locked.locked_model')}}</th>
                        <th class="col-md-5">{{__('report.product.total_product')}}</th>
                        <th class="col-md-5">{{__('report.sale.total')}}</th>
                        <th class="col-md-5">{{__('report.loan.total')}}</th>
                        <th class="col-md-5">{{__('report.stock.instock')}}</th>
                        <th class="col-md-5">{{__('network.locked.action')}}</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($networks as $network)
                    <tr>
                        <td>{{ $network->name }}</td>
                        <td>{{ $network->products_count }}</td>
                        <td>{{ $network->products_status_sold_count }}</td>
                        <td>{{ $network->products_status_loan_count }}</td>
                        <td>{{ $network->products_status_instock_count }}</td>
                        <td>
                            <a href="#" class="btn btn-icon btn-outline-secondary edit-model-type" data-bs-toggle="modal" data-bs-target="#editModelType" data-id="{{ $network->id }}" data-value="{{ $network->name }}">
                                <span class="tf-icons bx bx-edit-alt"></span>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--/ List Role Table -->
         <!-- Modal Create-->
         <div class="col-lg-4 col-md-6">
            <div class="mt-3">
                <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form action="{{ route('network.store', withLang())}}" method="post">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">{{__('network.locked.add')}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="name" class="form-label">{{__('network.locked.locked_model')}}</label>
                                                <input type="text" id="name" name="name" class="form-control" placeholder="Ex: T-Mobile, AT&T,">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{__('button.close')}}</button>
                                        <button type="submit" class="btn btn-primary" onclick="">{{__('button.save_changes')}}</button>
                                    </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal Create -->

        <!-- Modal Edit-->
        <div class="col-lg-4 col-md-6">
            <div class="mt-3">
                <div class="modal fade" id="editModelType" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form action="{{ route('network.update', withLang())}}" method="post">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">{{__('network.locked.edit')}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col mb-3">
                                            <input type="hidden" id="brand-id" name="id" class="form-control" placeholder="" value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="brand-name" class="form-label">{{__('network.locked.locked_model')}}</label>
                                            <input type="text" id="brand-name" name="name" class="form-control  @error('name') is-invalid @enderror" placeholder="Ex: T&T, Beeline">
                                        </div>
                                        <div id="myDiv" style="display: none" class="text-danger">{{__('network.locked.exists')}}</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{__('button.close')}}</button>
                                    <button type="submit" class="btn btn-primary me-2">{{__('button.save_changes')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal Edit-->
</div>
<!-- / Content -->
@endsection
@push('script')
    <script>
        $( document ).ready(function() {
            $('.edit-model-type').click(function(){
                var id = $(this).attr("data-id");
                var name = $(this).attr("data-value");

                $('#editModelType #brand-id').val(id);
                $('#editModelType #brand-name').val(name);
            });


            $('#editModelType form').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting

                var name = $('#editModelType #brand-name').val();
                var id = $('#editModelType #brand-id').val();

                // Make an AJAX request to check for uniqueness
                $.ajax({
                    url: '{{ route('network.update', withLang()) }}',
                    method: 'POST',
                    data: { name: name, id: id },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.isUnique) {
                            // Field is unique, allow form submission

                        } else {
                            // Field is not unique, display an alert message
                            // alert('The name is not unique.');
                            // return Redirect::back()->with('message','Operation Successful !');
                            console.log('failed');
                            $('#editModelType form')[0].submit();
                        }
                    },
                    error: function() {
                        var div = document.getElementById('myDiv');
                        if (div.style.display === 'none' || div.style.display === '') {
                            div.style.display = 'block'; // Show the div
                        } else {
                            div.style.display = 'none'; // Hide the div
                        }
                    }
                });
            });



        });
        function submitForm(){
            $('.submit-delete').click();
        }

    </script>
@endpush
