@props(['company', 'invoice', 'title', 'type', ])
<div class="card-body">
    <div class="mb-xl-0 mb-4">
        <div class="d-flex svg-illustration mb-3 gap-2 justify-content-center flex-column">
            <p class="app-brand-logo demo m-auto">
                <img src="{{ $company->image_logo }}" alt="logo" width="100px"/>
            </p>
            <p class="app-brand-text demo text-body fw-bold d-flex align-items-center text-center m-auto">{{ $company->name ?? '' }} <br> {{ $company->detail ?? '' }}</p>
        </div>
    </div>
    <div class="d-flex justify-content-between flex-row p-sm-3 p-0">
        <div class="mb-xl-0 mb-4">
            <p class="mb-1"><i class="fa-solid fa-phone me-2"></i> {!! nl2br($company->phone ?? '') !!}</p>
            <p class="mb-1"><i class="fa-solid fa-location-dot me-2"></i> {!! nl2br($company->address ?? '') !!}</p>
        </div>
        <div class="text-end">
            <div class="mb-2">
              <span class="me-1">{{ __('order.invoice')}}:</span>
              <span class="fw-medium">#{{ setToNumber($invoice->id) }}</span>
            </div>
            <div class="mb-2">
                <span class="me-1">{{ __('order.issued_date') }}:</span>
                <span class="fw-medium">{{ setToStringDateFormat($invoice->updated_at) }}</span>
            </div>
            @if($type == '1')
            <div>
                <span class="me-1">{{ __('order.order_date') }}:</span>
                <span class="fw-medium">{{ setToStringDateFormat($invoice->date) }}</span>
            </div>
            @else
            <div>
                <span class="me-1">{{ __('order.order_date') }}:</span>
                <span class="fw-medium">{{ setToStringDateFormat($invoice->order_date) }}</span>
            </div>
            @endif
        </div>
    </div>
</div>
<hr class="my-0">
<div class="card-body">
    <div class="row p-sm-3 p-0">
        <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
            <h6 class="pb-2">{{ __('common.lbl_customer')}}:</h6>
            <p class="mb-1">{{ $invoice->customer->name }}</p>
            <p class="mb-1">{{ $invoice->customer->address ?? '' }}</p>
            <p class="mb-1">{{ $invoice->customer->phone ?? '' }}</p>
            <p class="mb-0">{{ $invoice->customer->email ?? '' }}</p>
        </div>
    </div>
</div>
<div class="card-header d-flex align-items-center justify-content-center text-center">
    <h5 class="card-title pb-5 text-uppercase">{{ $title }}</h5>
</div>
