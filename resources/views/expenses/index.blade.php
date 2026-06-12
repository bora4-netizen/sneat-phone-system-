@extends('layouts.app')
@push('styles')
@endpush

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="pull-right">
                @can('expense-create')
                    <a class="btn btn-outline-primary" href="{{ route('expenses.create', withLang()) }}">
                        <i class='bx bx-plus-circle'></i> {{ __('expense.create') }}
                    </a>
                @endcan
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#expenseSearchModal">
                    <i class='bx bx-search'></i>
                </button>
            </div>
        </div>
    </div>

    <div class="card">
        <h5 class="card-header">{{ __('expense.list') }}</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>{{ __('expense.name') }}</th>
                        <th>{{ __('expense.category.title') }}</th>
                        <th>{{ __('expense.amount') }}</th>
                        <th>{{ __('expense.date') }}</th>
                        @canany(['expense-edit', 'expense-delete'])
                        <th>{{ __('common.lbl_actions') }}</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @forelse ($expenses as $key => $expense)
                        <tr>
                            <td><strong>{{ $expense->id ?? '' }}</strong></td>
                            <td><strong>{{ $expense->name ?? '' }}</strong></td>
                            {{-- FIX: show category name, not raw ID --}}
                            <td>{{ $expenseCategories[$expense->category_id] ?? '-' }}</td>
                            <td>{{ $expense->amount ?? '' }}</td>
                            <td>{{ setToStringDateFormat($expense->date ?? '') }}</td>
                            <td>
                                @can('expense-edit')
                                <a href="{{ route('expenses.edit', withLang(['expense' => $expense->id])) }}"
                                   class="btn btn-icon btn-outline-secondary">
                                    <span class="tf-icons bx bx-edit-alt"></span>
                                </a>
                                @endcan
                                @can('expense-delete')
                                <form method="POST"
                                      action="{{ route('expenses.destroy', withLang(['expense' => $expense->id])) }}"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-outline-danger"
                                            onclick="return confirm('{{ __('common.confirm_delete') }}')">
                                        <span class="tf-icons bx bx-trash"></span>
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr class="no-data">
                            <th colspan="6" class="p-5 text-center">{{ __('common.lbl_no_data') }}</th>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagination">
                {!! $expenses->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</div>

{{-- Search Modal --}}
<div class="modal fade" id="expenseSearchModal" tabindex="-1" aria-hidden="true">
    {{-- FIX: route with withLang() so lang param is preserved on search --}}
    <form method="GET" action="{{ route('expenses.index', withLang()) }}">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('common.lbl_search') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="search" value="true"/>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="name" class="form-label">{{ __('expense.title') }}</label>
                            <input type="text" id="name" name="name"
                                   value="{{ $parameterNames['name'] ?? '' }}"
                                   class="form-control"
                                   placeholder="{{ __('expense.placholder_search_name') }}"/>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col mb-0">
                            <label for="category" class="form-label">{{ __('expense.category.title') }}</label>
                            {{-- FIX: name was "customer", now correctly "category" --}}
                            <select id="category" class="select2 form-select" name="category">
                                <option value="">{{ __('common.lbl_select') }}</option>
                                @foreach ($expenseCategories as $key => $value)
                                    <option value="{{ $key }}"
                                        @if(isset($parameterNames['category']) && $parameterNames['category'] == $key) selected @endif>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col mb-0">
                            <label for="from-date" class="form-label">{{ __('expense.from_date') }}</label>
                            <input class="form-control" type="date" id="from-date" name="from_date"
                                   value="{{ $parameterNames['from_date'] ?? '' }}"/>
                        </div>
                        <div class="col mb-0">
                            <label for="to-date" class="form-label">{{ __('expense.to_date') }}</label>
                            <input class="form-control" type="date" id="to-date" name="to_date"
                                   value="{{ $parameterNames['to_date'] ?? '' }}"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- FIX: was wrongly pointing to orders.index --}}
                    <a href="{{ route('expenses.index', withLang()) }}" class="btn btn-outline-secondary">
                        {{ __('button.clear') }}
                    </a>
                    <button type="submit" class="btn btn-primary">{{ __('button.search') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('script')
<script></script>
@endpush