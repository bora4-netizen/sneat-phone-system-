@extends('layouts.app')
@push('styles')
@endpush

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="pull-right">
                @can('expense-create')
                    <a class="btn btn-outline-primary" href="{{ route('expenses.create', withLang()) }}"> <i class='bx bx-plus-circle' ></i> {{ __('expense.create')}}</a>
                @endcan
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#expenseSearchModal">
                  <i class='bx bx-search' ></i>
                </button>
            </div>
        </div>
    </div>
        <!-- List Product Table -->
        <div class="card">
          <h5 class="card-header">{{ __('expense.list')}}</h5>
          <div class="table-responsive text-nowrap">
              <table class="table">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>{{__('expense.name')}}</th>
                          <th>{{__('expense.category.title')}}</th>
                          <th>{{__('expense.amount')}}</th>
                          <th>{{__('expense.date')}}</th>
                          @can(['expense-list'],['expense-edit'], ['expense-delete'])
                          <th>Actions</th>
                          @endcan
                      </tr>
                  </thead>
                  <tbody>
                      @forelse ($expenses as $key => $expense)
                          <tr>
                              <td><strong>{{ $expense->id ?? ''}}</strong> </td>
                              <td><strong>{{ $expense->name ?? ''}}</strong> </td>
                              <td>{{ $expense->category_id ?? ''}}</td>
                              <td>{{ $expense->amount ?? ''}}</td>
                              <td>{{ setToStringDateFormat($expense->date ?? '')}}</td>
                              <td>
                                  @can('expense-edit')
                                  <a href="{{ route('expenses.edit', withLang(['expense' => $expense->id])) }}" class="btn btn-icon btn-outline-secondary">
                                      <span class="tf-icons bx bx-edit-alt"></span>
                                  </a>
                                  @endcan
                                  @can('expense-delete')

                                    <!-- Add a delete button/link -->
                                    <form method="POST" action="{{ route('expenses.destroy',withLang(['expense' =>  $expense->id])) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-outline-danger" onclick="return confirm('Are you sure you want to delete this expense?')">
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
                  <tfoot class="table-border-bottom-0">
                      <tr>
                        <th>No</th>
                        <th>{{__('expense.name')}}</th>
                        <th>{{__('expense.category.title')}}</th>
                        <th>{{__('expense.amount')}}</th>
                        <th>{{__('expense.date')}}</th>
                        @can(['expense-list'],['expense-edit'], ['expense-delete'])
                        <th>Actions</th>
                        @endcan
                      </tr>
                  </tfoot>
              </table>
              <div class="pagination">
                  {!! $expenses->withQueryString()->appends(request()->except('page'))->links('pagination::bootstrap-5') !!}
              </div>
          </div>
        </div>
        <!--/ List Product Table -->
      </div>
<!-- / Content -->
 <!--/ List Sale Table -->
 <div class="modal fade" id="expenseSearchModal" tabindex="-1" aria-hidden="true">
  <form method="GET" action="{{ url()->current() }}">
      <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="searchLabel">{{ __('common.lbl_search') }}</h5>
                  <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      aria-label="Close"
                  ></button>
              </div>
              <div class="modal-body">
                  <input type="hidden" class="form-control" name="search" value="true"/>
                  <div class="row">
                      <div class="col mb-3">
                          <label for="name" class="form-label">{{__('expense.title')}}</label>
                          <input type="text" id="name" name="name" value="@if(isset($parameterNames['name']) && $parameterNames['name'] != '') {{ $parameterNames['name'] }} @endif" class="form-control" placeholder="{{__('expense.placholder_search_name')}}" />
                      </div>
                  </div>
                  <div class="row g-2 mb-3">
                      <div class="col mb-0">
                          <label for="category" class="form-label">{{__('expense.category.title')}}</label>
                          <select id="category" class="select2 form-select" name="customer">
                              <option value=""> {{ __('common.lbl_select') }} </option>
                              @foreach ($expenseCategories as $key => $value)
                                  <option value="{{ $key }}" @if(isset($parameterNames['category']) && $parameterNames['category'] == $key) selected @endif>{{ $value }}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
                  <div class="row g-2 mb-3">
                      <div class="col mb-0">
                          <label for="from-date" class="form-label">{{__('expense.from_date')}}</label>
                          <input class="form-control" type="date" value="@if(isset($parameterNames['from_date']) && $parameterNames['from_date'] != ''){{ $parameterNames['from_date'] }}@endif" id="from-date" name="from_date"/>
                      </div>
                      <div class="col mb-0">
                          <label for="to-date" class="form-label">{{__('expense.to_date')}}</label>
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
@endsection
@push('script')
    <script>
    </script>
@endpush
