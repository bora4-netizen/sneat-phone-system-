@extends('layouts.app')
@push('styles')
@endpush

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="pull-right">
                @can(['order-create'])
                    <a class="btn btn-outline-primary" href="{{ route('sales.create', withLang()) }}"> <i class='bx bx-plus-circle' ></i> {{ __('order.create_sale')}}</a>
                @endcan
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productSearchModal">
                  <i class='bx bx-search' ></i>
                </button>
            </div>
        </div>
    </div>
     <!-- List Sales Table -->
     <div class="card">
      <h5 class="card-header">{{ __('sidebar.sales.list')}}</h5>
      <div class="table-responsive text-nowrap">
          <table class="table">
              <thead>
                  <tr>
                      <th>{{__('order.number')}}</th>
                      <th>{{__('order.customer')}}</th>
                      <th>{{__('order.amount')}}</th>
                      <th>{{__('order.payment_status')}}</th>
                      <th>{{__('order.payment_type')}}</th>
                      <th>{{__('order.sale_by')}}</th>
                      <th>{{__('order.sale_date')}}</th>
                      @can(['product-list'],['product-edit'], ['product-delete'], ['order-creat'])
                      <th>Actions</th>
                      @endcan
                  </tr>
              </thead>
              <tbody>
                  @forelse ($orders as $key => $order)
                      <tr>
                          <td><strong>{{ $order->id_number ?? ''}}</strong> </td>
                          <td><strong>{{ $order->customer_name ?? ''}}</strong> </td>
                          <td>{{ setToStringDolla($order->total_amount) ?? ''}}</td>
                          <td>{!! $order->payment_status_badges ?? ''!!}</td>
                          <td>{!! $order->payment_type_badges ?? '' !!}</td>
                          <td>{!! $order->employee_name ?? '' !!}</td>
                          <td>{!! '<span class="badge bg-label-info">'.setToStringDateFormat($order->order_date).'</span>'!!}</td>
                          <td>
                              @can('order-list')
                                <a href="{{ route('sales.show', withLang(['order' => $order->id])) }}" class="btn btn-icon btn-outline-secondary">
                                    <span class="tf-icons bx bx-detail"></span>
                                </a>
                              @endcan
                                <form method="POST" action="{{ route('sales.destroy', withLang(['order' => $order->id])) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-outline-danger" onclick="return confirm('Are you sure you want to delete this sale?')">
                                        <span class="tf-icons bx bx-trash"></span>
                                    </button>
                                </form>
                          </td>
                      </tr>
                      @empty
                      <tr class="no-data">
                        <th colspan="8" class="p-5 text-center">{{ __('common.lbl_no_data') }}</th>
                      </tr>
                  @endforelse

              </tbody>
              <tfoot class="table-border-bottom-0">
                  <tr>
                      <th>{{__('order.number')}}</th>
                      <th>{{__('order.customer')}}</th>
                      <th>{{__('order.amount')}}</th>
                      <th>{{__('order.payment_status')}}</th>
                      <th>{{__('order.payment_type')}}</th>
                      <th>{{__('order.sale_by')}}</th>
                      <th>{{__('order.sale_date')}}</th>
                      @can(['product-list'],['product-edit'], ['product-delete'], ['order-creat'])
                       <th>Actions</th>
                      @endcan
                  </tr>
              </tfoot>
          </table>
          <div class="pagination">
              {!! $orders->withQueryString()->appends(request()->except('page'))->links('pagination::bootstrap-5') !!}
          </div>
      </div>
    </div>
    <!--/ List Sale Table -->
    <div class="modal fade" id="productSearchModal" tabindex="-1" aria-hidden="true">
        <form method="GET" action="{{ url()->current() }}">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productSearchLabel">{{ __('order.search_invoices') }}</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="search" value="true"/>
                        <div class="row g-2 mb-3">
                            <div class="col mb-0">
                                <label for="customer" class="form-label">{{__('order.customer')}}</label>
                                <select id="customer" class="select2 form-select" name="customer">
                                    <option value="">Select Customer </option>
                                    @foreach ($customers as $key => $value)
                                        <option value="{{ $key }}" @if(isset($parameterNames['customer']) && $parameterNames['customer'] == $key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col mb-0">
                                <label for="from-date" class="form-label">{{__('order.search_to_date')}}</label>
                                <input class="form-control" type="date" value="@if(isset($parameterNames['from_date']) && $parameterNames['from_date'] != ''){{ $parameterNames['from_date'] }}@endif" id="from-date" name="from_date"/>
                            </div>
                            <div class="col mb-0">
                                <label for="to-date" class="form-label">{{__('order.search_from_date')}}</label>
                                <input class="form-control" type="date" value="@if(isset($parameterNames['to_date']) && $parameterNames['to_date'] != ''){{ $parameterNames['to_date'] }}@endif" id="to-date" name="to_date"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('orders.index', withLang()) }}" class="btn btn-outline-secondary">
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
