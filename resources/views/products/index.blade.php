@extends('layouts.app')
@push('styles')
@endpush

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="pull-right">
                @can('product-create')
                    <a class="btn btn-outline-primary" href="{{ route('products.create', withLang()) }}"> <i class='bx bx-plus-circle' ></i> {{ __('product.btn_create_title')}}</a>
                @endcan
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productSearchModal">
                  <i class='bx bx-search' ></i>
                </button>
            </div>
        </div>
    </div>
    <div class="col-xl-12 mb-3 d-flex justify-content-end align-items-center">
      <div class="btn-toolbar demo-inline-spacing" role="toolbar" aria-label="Toolbar with button groups">
        <div class="btn-group" role="group" aria-label="First group">
            @if($view == 'gride')
                <a href="{{ $url }}" class="btn btn-outline-secondary">
                    <i class='bx bx-list-ul'></i>
                </a>
            @else
                <a href="{{ $url }}" class="btn btn-outline-secondary">
                    <i class='bx bxs-grid-alt'></i>
                </a>
            @endif
        </div>
      </div>
    </div>


    @if($view == 'gride')
        <h6>ផលិតផលក្នុងស្តុកសរុប :  {{$totalProductAvailable}} (លក់ចេញ:{{$totalProductSold}}) </h6>
        <!-- Gride Product  -->
        <div class="row row-cols-1 row-cols-md-4 g-4 mb-5">
          @foreach ($products as $key => $product)
          <div class="col">
              <div class="card h-100">
              <img class="card-img-top img-product" src="{{ $product->image_name }}" alt="Product image" onError="this.onerror=null;this.src='{{ asset('/assets/img/blank-product.svg') }}';">
              <div class="card-body">
                  <h5 class="card-title"><strong>{{ $product->product_name ?? ''}}</strong> </h5>
                  <p class="card-text">
                    <small class="mx-2">{!! $product->condition_label_badges_name ?? ''!!}</small><small>{!! $product->status_badges_name ?? ''!!}</small>
                  <!-- <h4 class="mb-1 text-danger text-end"><small class="text-muted"></small>$ {{ $product->selling_price ?? ''}} </h4> -->
                  <h4 class="mb-1 text-danger text-end"><small class="text-muted"></small>{{ setToStringDolla($product->selling_price ?? 0)}} </h4>
                  <h6 class="mb-1"><small class="text-muted">{{__('product.imei')}} :</small> {{ $product->product_imei ?? ''}} </h6>
                  <h6 class="mb-1"><small class="text-muted">{{__('product.series')}} :</small> {{ $product->series->name ?? ''}} </h6>
                  <h6 class="mb-1"><small class="text-muted">{{__('product.color')}} :</small> {{ $product->color->name ?? ''}} </h6>
                  <h6 class="mb-1"><small class="text-muted">{{__('product.model')}} :</small> {{ $product->modelType->name ?? ''}} </h6>
                  <h6 class="mb-1"><small class="text-muted">{{__('product.percentage')}} :</small> {{ $product->percentage ?? ''}} </h6>
                  <h6 class="mb-1"><small class="text-muted">{{__('product.battery_percentage')}} :</small> {{ $product->battery_percentage ?? ''}} </h6>
                  <h6 class="mb-1"><small class="text-muted">{{__('product.storage')}} :</small> {{ $product->storage->name ?? '' }} </h6>
                  <h6 class="mb-1"><small class="text-muted">{{__('product.locked')}} :</small> {{ $product->network->name ?? '' }} </h6>
                  </p>
                  <div class="text-end">
                  <span class="text-end">
                      @can('product-list')
                      <a href="{{ route('products.show', withLang(['product' => $product->id])) }}" class="btn btn-icon btn-outline-secondary">
                          <span class="tf-icons bx bx-detail"></span>
                      </a>
                      @endcan
                      @can('product-edit')
                        <a href="{{ route('products.edit', withLang(['product' => $product->id])) }}" class="btn btn-icon btn-outline-secondary">
                            <span class="tf-icons bx bx-edit-alt"></span>
                        </a>
                      @endcan

                        @can('order-create')
                          @if(!$product->isSoldOut())
                            <a href="{{ route('sales.create', withLang(['id' => $product->id])) }}" class="btn btn-icon btn-outline-secondary">
                              <span class="tf-icons bx bxs-cart-alt"></span>
                            </a>
                          @endif
                        @endcan

                  </span>
                  </div>
              </div>
              </div>
          </div>
          @endforeach
        </div>

        <div class="pagination">
        {!! $products->withQueryString()->appends(request()->except('page'))->links('pagination::bootstrap-5') !!}
        </div>
        <!--/ Gride Product  -->
    @else
        <!-- List Product Table -->
        <div class="card">
          <div class="card-header"> 
            <h5>{{ __('product.list_title')}}</h5> 
            <h6>ផលិតផលក្នុងស្តុកសរុប : ក្នុងស្តុក {{$totalProductAvailable}} (លក់ចេញ:{{$totalProductSold}})</h6>
          </div>
          <div class="table-responsive text-nowrap">
              <table class="table">
                  <thead>
                      <tr>
                          <th></th>
                          <th>{{__('product.name')}}</th>
                          <th>{{__('product.imei')}}</th>
                          <th>{{__('product.series')}}</th>
                          <th>{{__('product.color')}}</th>
                          <th>{{__('product.model')}}</th>
                          <th>{{__('product.storage')}}</th>
                          <th>{{__('product.condition.title')}}</th>
                          <th>{{__('product.machine')}}</th>
                          <th>{{__('product.status')}}</th>
                          @can(['product-list'],['product-edit'], ['product-delete'], ['order-creat'])
                          <th>Actions</th>
                          @endcan
                      </tr>
                  </thead>
                  <tbody>
                      @forelse ($products as $key => $product)
                          <tr>
                              <td>
                                  <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                      <li
                                          data-bs-toggle="tooltip"
                                          data-popup="tooltip-custom"
                                          data-bs-placement="top"
                                          class="avatar avatar-xs pull-up"
                                          title="{{$product->name}}"
                                          >
                                          <img src="{{ $product->image_name }}" alt="Product" class="rounded-circle" onError="this.onerror=null;this.src='{{ asset('/assets/img/blank-product.svg') }}';"/>
                                      </li>
                                  </ul>
                              </td>
                              <td><strong>{{ $product->product_name ?? ''}}</strong> </td>
                              <td>{{ $product->product_imei ?? ''}}</td>
                              <td>{{ $product->series->name ?? ''}}</td>
                              <td>{{ $product->color->name ?? ''}}</td>
                              <td>{{ $product->modelType->name ?? ''}}</td>
                              <td>{{ $product->storage->name ?? '' }}</td>
                              <td>{!! $product->condition_label_badges_name ?? ''!!}</td>
                              <td>{{ $product->network->name ?? '' }}</td>
                              <td>{!! $product->status_badges_name ?? ''!!}</td>

                              <td>
                                  @can('product-list')
                                  <a href="{{ route('products.show', withLang(['product' => $product->id])) }}" class="btn btn-icon btn-outline-secondary">
                                      <span class="tf-icons bx bx-detail"></span>
                                  </a>
                                  @endcan
                                  @can('product-edit')
                                  <a href="{{ route('products.edit', withLang(['product' => $product->id])) }}" class="btn btn-icon btn-outline-secondary">
                                      <span class="tf-icons bx bx-edit-alt"></span>
                                  </a>
                                  @endcan

                                  @can('order-create')
                                    @if(!$product->isSoldOut())
                                      <a href="{{ route('sales.create', withLang(['id' => $product->id])) }}" class="btn btn-icon btn-outline-secondary">
                                        <span class="tf-icons bx bxs-cart-alt"></span>
                                      </a>
                                    @endif
                                  @endcan

                                    <form method="POST" action="{{ route('products.destroy', withLang(['product' => $product->id])) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-outline-danger" onclick="return confirm('Are you sure you want to delete this product?')">
                                            <span class="tf-icons bx bx-trash"></span>
                                        </button>
                                    </form>

                              </td>
                          </tr>
                          @empty
                            <tr class="no-data">
                              <th colspan="10" class="p-5 text-center">{{ __('common.lbl_no_data') }}</th>
                            </tr>
                        @endforelse

                  </tbody>
                  <tfoot class="table-border-bottom-0">
                      <tr>
                          <th></th>
                          <th>{{__('product.name')}}</th>
                          <th>{{__('product.imei')}}</th>
                          <th>{{__('product.series')}}</th>
                          <th>{{__('product.color')}}</th>
                          <th>{{__('product.model')}}</th>
                          <th>{{__('product.storage')}}</th>
                          <th>{{__('product.condition.title')}}</th>
                          <th>{{__('product.machine')}}</th>
                          <th>{{__('product.status')}}</th>
                          @can(['product-list'],['product-edit'], ['product-delete'], ['order-creat'])
                          <th>Actions</th>
                          @endcan
                      </tr>
                  </tfoot>
              </table>
              <div class="pagination">
                  {!! $products->withQueryString()->appends(request()->except('page'))->links('pagination::bootstrap-5') !!}
              </div>
          </div>
        </div>
        <!--/ List Product Table -->
    @endif
    <div class="modal fade" id="productSearchModal" tabindex="-1" aria-hidden="true">
        <form method="GET" action="{{ url()->current() }}">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="productSearchLabel">{{ __('product.serahc_title') }}</h5>
                      <button
                          type="button"
                          class="btn-close"
                          data-bs-dismiss="modal"
                          aria-label="Close"
                      ></button>
                  </div>
                  <div class="modal-body">
                      <input type="hidden" class="form-control" name="view" value="{{ $view ?? ''}}"/>
                      <input type="hidden" class="form-control" name="search" value="true"/>
                      <div class="row">
                          <div class="col mb-3">
                              <label for="product-name" class="form-label">{{__('product.label_search_name_or_imei')}}</label>
                              <input type="text" id="product-name" name="search_product" value="@if(isset($parameterNames['search_product']) && $parameterNames['search_product'] != '') {{ $parameterNames['search_product'] }} @endif" class="form-control" placeholder="{{__('product.placholder_search_name_or_imei')}}" />
                          </div>
                      </div>
                      <div class="row g-2 mb-3">
                          <div class="col mb-0">
                              <label for="Condition" class="form-label">{{__('product.condition.title')}}</label>
                              <select id="condition" class="select2 form-select" name="condition">
                                  <option value="">{{ __('common.lbl_select')}} </option>
                                  @foreach ($conditions as $key => $value)
                                      <option value="{{ $key }}" @if(isset($parameterNames['condition']) && $parameterNames['condition'] == $key) selected @endif>{{ $value }}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="col mb-0">
                              <label for="brand" class="form-label">{{__('product.brand')}}</label>
                              <select id="brand" class="select2 form-select" name="brand_id">
                                  <option value="">{{ __('common.lbl_select')}}</option>
                                  @foreach ($brands as $key => $value)
                                      <option value="{{ $key }}" @if(isset($parameterNames['brand_id']) && $parameterNames['brand_id'] == $key) selected @endif>{{ $value }}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="col mb-0">
                              <label for="series" class="form-label">{{__('product.series')}}</label>
                              <select id="series" class="select2 form-select" name="series_id">
                                  <option value="">{{ __('common.lbl_select')}}</option>
                                  @foreach ($series as $key => $value)
                                      <option value="{{ $key }}" @if(isset($parameterNames['series_id']) && $parameterNames['series_id'] == $key) selected @endif>{{ $value }}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="col mb-0">
                            <label for="type_of_machine" class="form-label">{{__('product.type_of_machine')}}</label>
                            <select id="type_of_machine" class="select2 form-select" name="type_of_machine">
                                <option value="">{{ __('common.lbl_select')}}</option>
                                @foreach ($type_of_machines as $key => $value)
                                    <option value="{{ $key }}" @if(isset($parameterNames['type_of_machine']) && $parameterNames['type_of_machine'] == $key) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                      </div>
                      <div class="row g-2">
                          <div class="col mb-0">
                              <label for="color" class="form-label">{{__('product.color')}}</label>
                              <select id="color" class="select2 form-select" name="color_id">
                                  <option value="">Select Product Color</option>
                                  @foreach ($colors as $key => $value)
                                      <option value="{{ $key }}" @if(isset($parameterNames['color_id']) && $parameterNames['color_id'] == $key) selected @endif>{{ $value }}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="col mb-0">
                              <label for="storage" class="form-label">{{__('product.storage')}}</label>
                              <select id="storage" class="select2 form-select" name="storage_id">
                                  <option value="">Select Product Storage</option>
                                  @foreach ($storage as $key => $value)
                                      <option value="{{ $key }}" @if(isset($parameterNames['storage_id']) && $parameterNames['storage_id'] == $key) selected @endif>{{ $value }}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="col mb-0">
                              <label for="status" class="form-label">{{__('product.status')}}</label>
                              <select id="status" class="select2 form-select" name="status">
                                  <option value="">Select Product Status</option>
                                  @foreach ($status as $key => $value)
                                      <option value="{{ $key }}" @if(isset($parameterNames['status']) && $parameterNames['status'] == $key) selected @endif>{{ $value }}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <a href="{{ route('products.index', withLang(['view' => $view])) }}" class="btn btn-outline-secondary">
                          {{ __('button.clear') }}
                      </a>
                      <button type="submit" class="btn btn-primary">{{ __('button.search') }}</button>
                  </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- / Content -->
@endsection
@push('script')
    <script>
      $(document).ready(function() {
       $('#brand').change(function() {
            var brandID = $(this).val();
            $('#series').prop("disabled", false);
            if (brandID !== '') {
                $.ajax({
                    type: 'GET',
                    url: '/en/series/brand/' + brandID,
                    dataType: 'json',
                    success: function(data) {
                        // Clear and populate select2 with new data
                        var series = $('#series');
                        series.empty();
                        series.append('<option>Select an option</option>');
                        if (data.length > 0) {
                            $.each(data, function(key, value) {
                                series.append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    }
                });
            } else {
                // Reset select2 when nothing is selected in select1
                $('#series').empty().append('<option value="">Select an option</option>');
                $('#series').prop("disabled", true);
            }
        });
      });
        function submitForm(){
            $('.submit-delete').click();
        }
    </script>
@endpush
