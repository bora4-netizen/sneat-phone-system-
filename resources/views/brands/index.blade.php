@extends('layouts.app')
@push('styles')
@endpush

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">{{__('category.brand.brands_management')}}</h4>
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="pull-right">
                @can('role-create')
                    <!-- <a class="btn btn-outline-primary" href=""> <i class='bx bx-plus-circle' ></i> Add New Product Model</a> -->
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                        <i class='bx bx-plus-circle' ></i>{{__('category.add_new')}}
                    </button>
                @endcan
            </div>
        </div>
    </div>
    <!-- List Role Table -->
    <div class="card">
        <h5 class="card-header">{{__('category.brand.list')}}</h5>
        <div class="table-responsive text-nowrap">
            <table class="table mb-5">
                <thead>
                    <tr>
                        <th class="col-md-5">{{__('category.brand.product_brands')}}</th>
                        <th class="col-md-5">{{__('category.count')}}</th>
                        <th class="col-md-2">{{ __('common.lbl_actions') }}</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($brands as $brand)
                    <tr>
                        <td>{{ $brand->name }}</td>
                        <td>{{ $brand->products_count }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ url((request()->lang ?? 'en') . '/brands/' . $brand->id) }}" class="btn btn-icon btn-outline-secondary edit-model-type" data-bs-toggle="modal" data-bs-target="#editModelType" data-id="{{ $brand->id }}" data-value="{{ $brand->name }}">
                                    <span class="tf-icons bx bx-edit-alt"></span>
                                </a>
                                <form action="{{ route('brand.destroy', withLang(['brand' => $brand->id])) }}" method="POST" style="display: inline-block;">
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
                        <form action="{{ route('brand.store', withLang())}}" method="post">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">{{__('category.add_new')}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="name" class="form-label">{{__('category.brand.product_brands')}}</th></label>
                                                <input type="text" id="name" name="name" class="form-control" placeholder="Ex: ZA, ZP, LLA">
                                            </div>
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
                <div class="modal fade" id="editModelType" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form action="{{ route('brand.update', withLang())}}" method="post">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">{{__('category.brand.edit')}}</h5>
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
                                            <label for="brand-name" class="form-label">{{__('category.model_type.edit')}}</label>
                                            <input type="text" id="brand-name" name="name" class="form-control  @error('name') is-invalid @enderror" placeholder="Ex: Apple, OPPO, ">
                                        </div>
                                        <div id="myDiv" style="display: none" class="text-danger">{{__('category.model_type.edit')}}</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" onclick="">Save changes</button>
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
                    url: "{{ route('brand.update', withLang()) }}",
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
