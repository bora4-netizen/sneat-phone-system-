@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <h3 class="fw-bold mb-4">{{ __('product.edit_title') }}</h3>

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

            <form method="POST" action="{{ route('products.update', withLang(['product' => $product->id])) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    {{-- Product Name --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="product_name"
                            value="{{ old('product_name', $product->product_name) }}"
                            placeholder="{{ __('product.name') }}"
                            class="form-control @error('product_name') is-invalid @enderror">
                        @error('product_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- IMEI --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.imei') }}</label>
                        <input type="text" name="product_imei"
                            value="{{ old('product_imei', $product->product_imei) }}"
                            placeholder="{{ __('product.imei') }}" class="form-control">
                    </div>

                    {{-- Brand --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.brand') }}</label>
                        <select name="brand" class="form-select">
                            <option value="">{{ __('common.lbl_select') }}</option>
                            @foreach($brands as $id => $name)
                                <option value="{{ $id }}" {{ old('brand', $product->brand_id) == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Series --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.series') }}</label>
                        <select name="series" class="form-select">
                            <option value="">{{ __('common.lbl_select') }}</option>
                            @foreach($series as $id => $name)
                                <option value="{{ $id }}" {{ old('series', $product->series_id) == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Color --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.color') }}</label>
                        <select name="color" class="form-select">
                            <option value="">{{ __('common.lbl_select') }}</option>
                            @foreach($colors as $id => $name)
                                <option value="{{ $id }}" {{ old('color', $product->color_id) == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Model Type --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.model') }}</label>
                        <select name="model_type" class="form-select">
                            <option value="">{{ __('common.lbl_select') }}</option>
                            @foreach($modelTypes as $id => $name)
                                <option value="{{ $id }}" {{ old('model_type', $product->model_type_id) == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Storage --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.storage') }}</label>
                        <select name="storage" class="form-select">
                            <option value="">{{ __('common.lbl_select') }}</option>
                            @foreach($storage as $id => $name)
                                <option value="{{ $id }}" {{ old('storage', $product->storage_id) == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Network / Locked --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.machine') }}</label>
                        <select name="network" class="form-select">
                            <option value="">{{ __('common.lbl_select') }}</option>
                            @foreach($networks as $id => $name)
                                <option value="{{ $id }}" {{ old('network', $product->network_id) == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Condition --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.condition.title') }}</label>
                        <select name="condition" class="form-select">
                            <option value="">{{ __('common.lbl_select') }}</option>
                            @foreach(\App\Models\Product::CONDITION as $key => $label)
                                <option value="{{ $key }}" {{ old('condition', $product->condition) == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Type of Machine --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.type_of_machine') }}</label>
                        <select name="type_of_machine" class="form-select">
                            <option value="">{{ __('common.lbl_select') }}</option>
                            @foreach(\App\Models\Product::TYPE_OF_MACHINE as $key => $label)
                                <option value="{{ $key }}" {{ old('type_of_machine', $product->type_of_machine) == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.status') }} <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="">{{ __('common.lbl_select') }}</option>
                            @foreach(\App\Models\Product::getStatuses() as $key => $label)
                                <option value="{{ $key }}" {{ old('status', $product->status) == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Battery Percentage --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.battery_percentage') }}</label>
                        <div class="input-group">
                            <input type="number" name="battery_percentage"
                                value="{{ old('battery_percentage', $product->battery_percentage) }}"
                                placeholder="e.g. 85" min="0" max="100" class="form-control">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>

                    {{-- Percentage --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.percentage') }}</label>
                        <div class="input-group">
                            <input type="number" name="percentage"
                                value="{{ old('percentage', $product->percentage) }}"
                                placeholder="e.g. 90" min="0" max="100" class="form-control">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>

                    {{-- Purchase Price --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.purchase_price') }}</label>
                        <div class="input-group">
                            <input type="number" name="purchase_price"
                                value="{{ old('purchase_price', $product->purchase_price) }}"
                                placeholder="{{ __('product.purchase_price') }}" step="0.01" class="form-control">
                            <span class="input-group-text">$</span>
                        </div>
                    </div>

                    {{-- Selling Price --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.selling_price') }}</label>
                        <div class="input-group">
                            <input type="number" name="selling_price"
                                value="{{ old('selling_price', $product->selling_price) }}"
                                placeholder="{{ __('product.selling_price') }}" step="0.01" class="form-control">
                            <span class="input-group-text">$</span>
                        </div>
                    </div>

                    {{-- Purchase Date --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.purchase_date') }}</label>
                        <input type="date" name="purchase_date"
                            value="{{ old('purchase_date', $product->purchase_date) }}"
                            class="form-control">
                    </div>

                    {{-- Image --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('product.allow_image_upload') }}</label>
                        @if($product->image)
                            <div class="mb-2">
                                <img src="{{ asset('images/product/' . $product->image) }}"
                                    width="100" style="border-radius:8px;" id="previewImage">
                            </div>
                        @else
                            <div class="mb-2">
                                <img id="previewImage" src="" style="display:none; width:100px; border-radius:8px;">
                            </div>
                        @endif
                        <input type="file" name="image" id="imageInput" accept="image/*" class="form-control">
                    </div>

                    {{-- Note --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">{{ __('product.note') }}</label>
                        <textarea name="note" rows="3" class="form-control"
                            placeholder="{{ __('product.note') }}">{{ old('note', $product->note) }}</textarea>
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('products.index', withLang()) }}" class="btn btn-outline-secondary px-4">
                        {{ __('button.cancel') }}
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        {{ __('button.update') }}
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
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection