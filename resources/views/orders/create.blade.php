@extends('layouts.app')
@push('styles')
@endpush

@section('content')
<div class="content-wrapper">
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('sales.store', withLang())}}" method="POST" id="save-order">
                    @csrf
                    <div class="card mb-4">
                        <h5 class="card-header">{{__('order.sales.create')}}</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="order-date">{{__('order.sale_date')}}</label>
                                    <input class="form-control @error('order_date') is-invalid @enderror" type="date" value="{{ old('order_date', $currentDate)}}" id="order-date" name="order_date"/>
                                    @error('order_date')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="customer">{{__('order.customer')}}</label>
                                    <select id="customer" class="select2 form-select @error('customer') is-invalid @enderror" name="customer">
                                        @foreach ($customers as $key => $value)
                                            <option value="{{ $key }}" @if(old('customer') == $key) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('customer')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label class="form-label" for="product">{{__('product.name')}}</label>
                                    <select id="product" class="select2 form-select @error('product') is-invalid @enderror" name="product">
                                        <option value="" disabled selected>Select Order Product</option>
                                        @foreach ($products as $key => $value)
                                            <option value="{{ $value->id }}" @if(old('product') == $value->id) selected @endif>{{ $value->series->name}} {{ $value->storage->name}} {{ $value->color->name}} [ IMEI: {{ substr($value->product_imei, -5) }} ]</option>
                                        @endforeach
                                    </select>
                                    @error('product')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="my-3"></div>
                                <div class="card">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-sm" id="product-order-details-table">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('product.imei') }}</th>
                                                    <th>{{ __('product.name') }}</th>
                                                    <th>{{ __('product.lbl_detail') }}</th>
                                                    <th>{{ __('common.lbl_price') }} ($)</th>
                                                    <th>{{ __('common.lbl_actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                                @if($productOrder)
                                                  <tr data-product-id="{{$productOrder->id}}">
                                                    <td><strong>{{$productOrder->product_imei}}</strong></td>
                                                    <td>{{$productOrder->product_name}}</td>
                                                    <td>{{$productOrder->series->name ?? ''}} {{$productOrder->storage->name ?? ''}} {{$productOrder->color->name ?? ''}}</td>
                                                    <td>
                                                        <input type="hidden" name="product[]" value="{{ $productOrder->id }}" />
                                                        <input name="unit_price[]" class="form-control" value="{{$productOrder->selling_price}}"/>
                                                    </td>
                                                    <td><button type="button" class="btn btn-icon btn-outline-danger remove-product" data-product-id="{{$productOrder->id}}"><span class="tf-icons bx bx-x"></span></button></td>
                                                  </tr>
                                                @else
                                                  <tr class="no-data">
                                                    <th colspan="5" class="p-5 text-center">{{ __('common.lbl_no_data') }}</th>
                                                  </tr>
                                                @endif
                                            </tbody>
                                            <tfoot class="table-border-bottom-0 pt-3">
                                                <tr>
                                                    <th colspan="3" class="text-end"><h6 class="my-3">Total :</h6></th>
                                                    <th>
                                                        <input type="hidden" name="total_amount" value="{{ $totalPrice ?? ''}}" />
                                                        <h5 class="my-3"><strong id="total-price" data-value="{{ $totalPrice ?? ''}}">{{ $totalPrice ?? ''}}</strong></h5>
                                                    </th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <hr class="my-5" />
                                <div class="mb-3 col-md-12">
                                    <label class="form-label" for="note">{{__('order.note')}}</label>
                                    <textarea id="note" class="form-control" name="note" placeholder="" rows="5">{{ old('note') }}</textarea>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="button" class="btn btn-primary me-2" id="submit-order">{{__('common.lbl_submit_order')}}</button>
                                <a href="{{ route('sales.index', withLang()) }}" class="btn btn-outline-secondary">{{__('button.cancel')}}</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    $(document).ready(function() {
        function calculateAndDisplaySum() {
            var sum = 0;
            $("input[name='unit_price[]']").each(function() {
                var value = parseFloat($(this).val()) || 0;
                sum += value;
            });
            $('#total-price').text("$" + sum);
            $("input[name='total_amount']").val(sum);
        }

        $('#product').change(function() {
            var selectedProductId = $(this).val();
            var $productTable = $('#product-order-details-table');
            if ($productTable.find('tr[data-product-id="' + selectedProductId + '"]').length > 0) return;
            const url = `{{ route('get-product-by-id', withLang(['id' => ':id'])) }}`.replace(':id', selectedProductId);
            $.ajax({
                type: 'GET', url: url,
                success: function(product) {
                    $('#product-order-details-table tbody .no-data').remove();
                    var newRow = '<tr data-product-id="' + product.id + '">' +
                        '<td><strong>' + product.product_imei + '</strong></td>' +
                        '<td>' + product.product_name + '</td>' +
                        '<td>' + product.series.name + ' ' + product.storage.name + ' ' + product.color.name + '</td>' +
                        '<td><input type="hidden" name="product[]" value="' + product.id + '" /><input name="unit_price[]" class="form-control" value="' + product.selling_price + '" /></td>' +
                        '<td><button type="button" class="btn btn-icon btn-outline-danger remove-product" data-product-id="' + product.id + '"><span class="tf-icons bx bx-x"></span></button></td>' +
                        '</tr>';
                    $('#product-order-details-table tbody').append(newRow);
                    calculateAndDisplaySum();
                },
                error: function() { alert('Error fetching product details'); }
            });
        });

        $('#product-order-details-table').on('click', '.remove-product', function() {
            $(this).closest('tr').remove();
            if ($('#product-order-details-table tbody tr').length === 0) {
                $('#product-order-details-table tbody').append('<tr class="no-data"><th colspan="5" class="p-5 text-center">NO DATA AVAILABLE</th></tr>');
            }
            calculateAndDisplaySum();
        });

        $('#submit-order').click(function () {
    const productIds = $("input[name='product[]']").map(function(){ return $(this).val(); }).get();
    
    // Check if cart is empty
    if (productIds.length === 0) {
        alert('Please add at least one product.');
        return;
    }
    
    const url = `{{ route('sales.check.product', withLang()) }}`;
    $.ajax({
        url: url, type: 'GET', data: { productIds: productIds }, dataType: 'json',
        headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
        success: function () { $('#save-order').submit(); },
        error: function () { alert('Please check again, some of these products have been sold.'); }
    });
});

        $("input[name='unit_price[]']").on('input change', calculateAndDisplaySum);
        calculateAndDisplaySum();
        $("#product").select2({ placeholder: "សូមជ្រើសរើសផលិតផល", allowClear: true });
        $("#customer").select2({ placeholder: "សូមជ្រើសរើសអតិថិជន", allowClear: true });
    });
</script>
<style>
    .select2 { width: 100% !important; padding: .4375rem .875rem; font-size: 0.9375rem; font-weight: 400; line-height: 1.53; color: #697a8d; appearance: none; background-color: #fff; background-clip: padding-box; border: var(--bs-border-width) solid #d9dee3; border-radius: var(--bs-border-radius); transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out; }
    .select2-container--default .select2-selection--single { border: 0px; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { top: 8px; }
</style>
@if(isset($openNewTab) && $openNewTab)
<script>
    window.open("{{ route('sales.invoice', withLang(['order' => $order->id, 'type' => 'print'])) }}", "_blank");
</script>
@endif
@endpush