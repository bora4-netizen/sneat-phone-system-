@extends('layouts.app')
@push('styles')
@endpush

@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <form id="formExpenRegister" method="POST" action="{{ route('expenses.store', withLang()) }}" enctype="multipart/form-data">
                @csrf
                    <div class="card mb-4">
                        <h5 class="card-header">{{__('expense.register')}}</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="date">{{__('expense.date')}}</label>
                                    <input class="form-control @error('date') is-invalid @enderror" type="date" value="{{ old('date', $currentDate)}}" id="date" name="date"/>
                                    @error('date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">{{__('expense.name')}}</label>
                                    <input
                                        class="form-control @error('name') is-invalid @enderror"
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name') }}"
                                        autofocus
                                    />
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="category">{{__('expense.category.title')}}</label>
                                    <select id="category" class="select2 form-select @error('category_id') is-invalid @enderror" name="category_id">
                                        @foreach ($expenseCategories as $key => $value)
                                            <option value="{{ $key }}" @if(old('category_id') == $key) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="amount" class="form-label">{{__('expense.amount')}}</label>
                                    <div class="input-group input-group-merge">
                                    <input
                                        class="form-control @error('amount') is-invalid @enderror"
                                        type="text"
                                        id="amount"
                                        name="amount"
                                        value="{{ old('amount') }}"
                                        autofocus
                                    />
                                    <span class="input-group-text">$</span>
                                    @error('amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-12">
                                    <label class="form-label" for="note">{{__('expense.note')}}</label>
                                    <textarea id="note" class="form-control" name="note" placeholder=""></textarea>
                                </div>
                            </div>

                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">{{__('button.save')}}</button>
                                <button type="reset" class="btn btn-outline-secondary">{{__('button.cancel')}}</button>
                            </div>
                    </div>

                </div>
              </form>
            </div>
        </div>
    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->
@endsection
@push('script')
@endpush
