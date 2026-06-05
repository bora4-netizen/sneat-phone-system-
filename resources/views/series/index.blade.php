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
                    <!-- <a class="btn btn-outline-primary" href=""> <i class='bx bx-plus-circle' ></i> Add New Product Model</a> -->
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                        <i class='bx bx-plus-circle' ></i> {{ __('common.lbl_add_new')}}
                    </button>
                @endcan
            </div>
        </div>
    </div>
    <!-- List Role Table -->
    <div class="card">
        <h5 class="card-header">{{__('category.series.list')}}</h5>
        <div class="table-responsive text-nowrap">
            <table class="table mb-5">
                <thead>
                    <tr>
                        <th class="col-md-5">Product Series</th>
                        <th class="col-md-5">{{__('report.product.total_product')}}</th>
                        <th class="col-md-5">{{__('report.sale.total')}}</th>
                        <th class="col-md-5">{{__('report.loan.total')}}</th>
                        <th class="col-md-5">{{__('report.stock.instock')}}</th>
                        <th class="col-md-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($serials as $serial)
                    <tr>
                        <td>{{ $serial->name }}</td>
                        <td>{{ $serial->products_count }}</td>
                        <td>{{ $serial->products_status_sold_count }}</td>
                        <td>{{ $serial->products_status_loan_count }}</td>
                        <td>{{ $serial->products_status_instock_count }}</td>
                        <td>
                            <div class="">
                            <a href="{{ route('serial.index', withLang()) }}" class="btn btn-icon btn-outline-secondary edit-series" data-bs-toggle="modal" data-bs-target="#editSeries" data-id="{{ $serial->id }}" data-value="{{ $serial->name }}">
                                <span class="tf-icons bx bx-edit-alt"></span>
                            </a>
                            <form action="{{ route('serial.destroy', withLang(['serial' => $serial->id])) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-icon btn-outline-danger" onsubmit="return confirm('Are you sure?');">
                                        <span class="tf-icons bx bx-trash"></span>
                                    </button>
                            </form>
                            </div>
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
                        <form action="{{ route('serial.store', withLang())}}" method="post">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">{{__('category.add_new')}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="name" class="form-label">{{__('category.series.product_series')}}</label>
                                                <input type="text" id="name" name="name" class="form-control" placeholder="Ex: iPhone 13, 14, 14 Pro">
                                            </div>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label" for="brand">{{__('product.brand')}}</label>
                                            <select id="brand" class="select2 form-select @error('brand') is-invalid @enderror" name="brand">
                                                <option value="">{{__('category.pick')}}</option>
                                                @foreach ($brands as $key => $value)
                                                    <option value="{{ $key }}" @if(old('brand') == $key) selected @endif>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                            @error('brand')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                        <div class="row g-2">
                                            <div class="col mb-0">
                                                <label for="emailBasic" class="form-label">Email</label>
                                                <input type="text" id="emailBasic" class="form-control" placeholder="xxxx@xxx.xx">
                                            </div>
                                            <div class="col mb-0">
                                                <label for="dobBasic" class="form-label">DOB</label>
                                                <input type="text" id="dobBasic" class="form-control" placeholder="DD / MM / YY">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{__('button.close')}}</button>
                                        <button type="submit" class="btn btn-primary" onclick="">{{__('button.save')}}</button>
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
                <div class="modal fade" id="editSeries" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form action="{{ route('serial.update', withLang())}}" method="post">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">{{__('category.series.edit')}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col mb-3">
                                            <input type="hidden" id="serial-id" name="id" class="form-control" placeholder="" value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="serial-name" class="form-label">{{__('category.add_new')}}</label>
                                            <input type="text" id="serial-name" name="name" class="form-control  @error('name') is-invalid @enderror" placeholder="Ex: iPhone 13, 14, 14 Pro">
                                        </div>
                                        <div id="myDiv" style="display: none" class="text-danger">{{__('category.series.exists')}}</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{__('button.close')}}</button>
                                    <button type="submit" class="btn btn-primary" onclick="">{{__('button.save')}}</button>
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
            $('.edit-series').click(function(){
                var id = $(this).attr("data-id");
                var name = $(this).attr("data-value");

                $('#editSeries #serial-id').val(id);
                $('#editSeries #serial-name').val(name);
            });


            $('#editSeries form').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting

                var name = $('#editSeries #serial-name').val();
                var id = $('#editSeries #serial-id').val();

                // Make an AJAX request to check for uniqueness
                $.ajax({
                    url: "{{ route('serial.update', withLang()) }}",
                    method: 'POST',
                    data: { name: name, id: id },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.isUnique) {
                            // Field is unique, allow form submission
                            // $('#editSeries form')[0].submit();
                            var div = document.getElementById('myDiv');
                            div.style.display = 'block';
                        } else {
                            // Field is not unique, display an alert message
                            // alert('The name is not unique.');
                            // redirect(Request::url(response));
                            $('#editSeries form')[0].submit();
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
