@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <h3 class="fw-bold mb-4">{{ __('product.register_title') }}</h3>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('products.store', withLang()) }}" enctype="multipart/form-data">
                @csrf

                {{-- Photo Upload --}}
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="border rounded" style="width:64px;height:64px;overflow:hidden;background:#f8f9fa;display:flex;align-items:center;justify-content:center;">
                        <img id="previewImage" src="" style="display:none;width:100%;height:100%;object-fit:cover;">
                        <span id="thumbPlaceholder" class="text-muted" style="font-size:24px;"></span>
                    </div>
                    <div>
                        <div class="d-flex gap-2 mb-1">
                            <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('imageInput').click()">{{ __('product.allow_image_upload') }}</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="resetPhotoBtn">{{ __('button.reset') }}</button>
                        </div>
                        <small class="text-muted">{{ __('product.allow_image_upload') }}</small>
                    </div>
                    <input type="file" name="image" id="imageInput" accept="image/*" style="display:none;">
                </div>

                <div class="row g-3">

                    {{-- Product Name --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="product_name" value="{{ old('product_name') }}"
                            placeholder="{{ __('product.name') }}"
                            class="form-control @error('product_name') is-invalid @enderror">
                        @error('product_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- IMEI --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.imei') }}</label>
                        <input type="text" name="product_imei" value="{{ old('product_imei') }}"
                            placeholder="{{ __('product.imei') }}" class="form-control">
                    </div>

                    {{-- Product Code --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.code') }}</label>
                        <input type="text" name="product_code" value="{{ old('product_code') }}" class="form-control">
                    </div>

                    {{-- Condition --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.condition.title') }}</label>
                        <select name="condition" class="form-select">
                            <option value="">{{ __('product.condition.title') }}</option>
                            @foreach(\App\Models\Product::CONDITION as $key => $label)
                                <option value="{{ $key }}" {{ old('condition') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Brand --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.brand') }}</label>
                        <select name="brand" class="form-select">
                            <option value="">{{ __('product.brand') }}</option>
                            @foreach($brands as $id => $name)
                                <option value="{{ $id }}" {{ old('brand') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Series --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.series') }}</label>
                        <select name="series" class="form-select">
                            <option value="">{{ __('product.series') }}</option>
                            @foreach($series as $id => $name)
                                <option value="{{ $id }}" {{ old('series') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Color --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.color') }}</label>
                        <select name="color" class="form-select">
                            <option value="">{{ __('product.color') }}</option>
                            @foreach($colors as $id => $name)
                                <option value="{{ $id }}" {{ old('color') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Model Type --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.model') }}</label>
                        <select name="model_type" class="form-select">
                            <option value="">{{ __('product.model') }}</option>
                            @foreach($modelTypes as $id => $name)
                                <option value="{{ $id }}" {{ old('model_type') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Storage --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.storage') }}</label>
                        <select name="storage" class="form-select">
                            <option value="">{{ __('product.storage') }}</option>
                            @foreach($storage as $id => $name)
                                <option value="{{ $id }}" {{ old('storage') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Type of Machine --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">{{ __('product.type_of_machine') }}</label>
                        <select name="type_of_machine" class="form-select">
                            <option value="">{{ __('product.type_of_machine') }}</option>
                            @foreach(\App\Models\Product::TYPE_OF_MACHINE as $key => $label)
                                <option value="{{ $key }}" {{ old('type_of_machine') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Network / Locked --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">{{ __('product.machine') }}</label>
                        <select name="network" class="form-select">
                            <option value="">{{ __('product.machine') }}</option>
                            @foreach($networks as $id => $name)
                                <option value="{{ $id }}" {{ old('network') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Battery % --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.battery_percentage') }}</label>
                        <div class="input-group">
                            <input type="number" name="battery_percentage" value="{{ old('battery_percentage') }}"
                                placeholder="e.g. 85" min="0" max="100" class="form-control">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>

                    {{-- Percentage --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.percentage') }}</label>
                        <div class="input-group">
                            <input type="number" name="percentage" value="{{ old('percentage') }}"
                                placeholder="e.g. 90" min="0" max="100" class="form-control">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>

                    {{-- Purchase Price --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.purchase_price') }}</label>
                        <div class="input-group">
                            <input type="number" name="purchase_price" value="{{ old('purchase_price') }}"
                                placeholder="{{ __('product.purchase_price') }}" step="0.01" class="form-control">
                            <span class="input-group-text">$</span>
                        </div>
                    </div>

                    {{-- Selling Price --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.selling_price') }}</label>
                        <div class="input-group">
                            <input type="number" name="selling_price" value="{{ old('selling_price') }}"
                                placeholder="{{ __('product.selling_price') }}" step="0.01" class="form-control">
                            <span class="input-group-text">$</span>
                        </div>
                    </div>

                    {{-- Purchase Date --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.purchase_date') }}</label>
                        <input type="date" name="purchase_date" value="{{ old('purchase_date') }}"
                            class="form-control">
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.status') }} <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="">{{ __('product.status') }}</option>
                            @foreach(\App\Models\Product::getStatuses() as $key => $label)
                                <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Note --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">{{ __('product.note') }}</label>
                        <textarea name="note" rows="3" class="form-control"
                            placeholder="{{ __('product.note') }}">{{ old('note') }}</textarea>
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('products.index', withLang()) }}" class="btn btn-outline-secondary px-4">
                        {{ __('button.cancel') }}
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        {{ __('button.save') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('imageInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('previewImage');
                preview.src = e.target.result;
                preview.style.display = 'block';
                document.getElementById('thumbPlaceholder').style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('resetPhotoBtn').addEventListener('click', function() {
        document.getElementById('imageInput').value = '';
        document.getElementById('previewImage').src = '';
        document.getElementById('previewImage').style.display = 'none';
        document.getElementById('thumbPlaceholder').style.display = '';
    });
</script>
@endsection