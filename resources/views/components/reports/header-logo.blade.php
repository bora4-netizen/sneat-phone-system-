<div class="mb-4">
    <div class="d-flex svg-illustration mb-3 gap-2">
        <span class="app-brand-logo demo">
            <img src="{{ $company->image_logo }}" alt="logo" width="50px"/>
        </span>
        <p class="app-brand-text demo text-body fw-bold d-flex align-items-center text-center">{{ $company->name ?? '' }} <br> {{ $company->detail ?? '' }}</p>
    </div>
    <div class="mb-xl-0 mb-4">
        <p class="mb-1"><i class="fa-solid fa-phone me-2"></i> {!! nl2br($company->phone ?? '') !!}</p>
        <p class="mb-1"><i class="fa-solid fa-location-dot me-2"></i> {!! nl2br($company->address ?? '') !!}</p>
    </div>
</div>
