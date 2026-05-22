@extends('layouts.app')
@push('styles')
@endpush

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="pull-right">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loanSearchModal">
                  <i class='bx bx-search' ></i>
                </button>
            </div>
        </div>
    </div>
        <!-- List Product Table -->
        <div class="card">
          <h5 class="card-header">{{ __('loan.late_payment')}}</h5>
          <div class="table-responsive text-nowrap">
              <table class="table">
                  <thead>
                      <tr>
                        <th>#</th>
                        <th>{{__('loan.no')}}</th>
                        <th>{{__('loan.customer_name')}}</th>
                        <th>{{__('loan.amount')}}</th>
                        <th>{{__('loan.interest')}}</th>
                        <th>{{__('loan.payable')}}</th>
                        <th>{{__('loan.remain')}}</th>
                        <th>{{__('loan.installment')}}</th>
                        <th>{{__('loan.payment.pay_date')}}</th>
                          @can(['loan-list'],['loan-edit'], ['loan-delete'],['loan-payment-list'],['loan-payment-create'])
                          <th>Actions</th>
                          @endcan
                      </tr>
                  </thead>
                  <tbody>
                    <tbody>
                        @forelse ($loans as $key => $loan)
                            <tr>
                                <td><strong>{{ $key + 1 }}</strong></td>
                                <td>{{ $loan->number ?? '' }}</td>
                                <td>{{ $loan->customer->name ?? '' }}</td>
                                <td>{{ setToStringDolla($loan->total_balance ?? 0) }}</td>
                                <td>{{ $loan->total_interest ?? '' }}</td>
                                <td>{{ setToStringDolla($loan->payable_amount ?? 0) }}</td>
                                <td>{{ setToStringDolla($loan->remain ?? 0) }}</td>
                                <td>{{ $loan->total_monthly_payment ?? '' }}</td>
                                <td><div class="badge bg-label-danger rounded-pill">{{ $loan->pay_date }} ( {{ $loan->overdue_days }} )</div></td>
                                <td>
                                    <!-- Add edit and delete buttons/links here -->
                                    @can('loan-list')
                                      @if($loan->status == 2 || $loan->status == 3)
                                          <a href="{{ route('loans.payments.list', withLang(['loan' => $loan->id])) }}" class="btn btn-icon btn-outline-secondary">
                                              <span class="tf-icons fa-solid fa-list-check"></span>
                                          </a>
                                        @endif
                                    @endcan
                                    @can('loan-create')
                                        @if($loan->status == 2)
                                          <a href="{{ route('loans.payments.create', withLang(['loan' => $loan->id])) }}" class="btn btn-icon btn-outline-secondary">
                                              <span class="tf-icons fa-solid fa-money-check-dollar"></span>
                                          </a>
                                        @endif
                                    @endcan
                                    @can('loan-edit')
                                        <a href="{{ route('loans.edit', withLang(['loan' => $loan->id])) }}" class="btn btn-icon btn-outline-secondary">
                                            <span class="tf-icons bx bx-edit-alt"></span>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                        <tr class="no-data">
                            <td colspan="10" class="p-5 text-center">{{ __('common.lbl_no_data') }}</td>
                        </tr>
                    @endforelse
                </tbody>
                  </tbody>
                  <tfoot class="table-border-bottom-0">
                      <tr>
                        <th>#</th>
                        <th>{{__('loan.no')}}</th>
                        <th>{{__('loan.customer_name')}}</th>
                        <th>{{__('loan.amount')}}</th>
                        <th>{{__('loan.interest')}}</th>
                        <th>{{__('loan.payable')}}</th>
                        <th>{{__('loan.remain')}}</th>
                        <th>{{__('loan.installment')}}</th>
                        <th>{{__('loan.payment.pay_date')}}</th>
                          @can(['loan-list'],['loan-edit'], ['loan-delete'],['loan-payment-list'],['loan-payment-create'])
                          <th>Actions</th>
                          @endcan
                      </tr>
                  </tfoot>
              </table>
              <div class="pagination">
                  {!! $loans->withQueryString()->appends(request()->except('page'))->links('pagination::bootstrap-5') !!}
              </div>
          </div>
        </div>
        <!--/ List Product Table -->
      </div>
<!-- / Content -->
<div class="modal fade" id="loanSearchModal" tabindex="-1" aria-hidden="true">
  <form method="GET" action="{{ url()->current() }}">
      <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="productSearchLabel">{{ __('common.lbl_search') }}</h5>
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
                        <label for="loan-name" class="form-label">{{__('loan.label_search_name')}}</label>
                        <input type="text" id="loan-name" name="search_loan" value="@if(isset($parameterNames['search_loan']) && $parameterNames['search_loan'] != ''){{ $parameterNames['search_loan'] }}@endif" class="form-control" placeholder="{{__('loan.label_search_name')}}" />
                    </div>
                </div>
                  <div class="row g-2 mb-3">
                      <div class="col mb-0">
                          <label for="customer" class="form-label">{{__('loan.customer')}}</label>
                          <select id="customer" class="select2 form-select" name="customer">
                              <option value="">{{ __('common.lbl_select') }} </option>
                              @foreach ($customers as $key => $value)
                                  <option value="{{ $key }}" @if(isset($parameterNames['customer']) && $parameterNames['customer'] == $key) selected @endif>{{ $value }}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
                  <div class="row g-2 mb-3">
                      <div class="col mb-0">
                          <label for="from-date" class="form-label">{{__('common.lbl_from_date')}}</label>
                          <input class="form-control" type="date" value="@if(isset($parameterNames['from_date']) && $parameterNames['from_date'] != ''){{ $parameterNames['from_date'] }}@endif" id="from-date" name="from_date"/>
                      </div>
                      <div class="col mb-0">
                          <label for="to-date" class="form-label">{{__('common.lbl_to_date')}}</label>
                          <input class="form-control" type="date" value="@if(isset($parameterNames['to_date']) && $parameterNames['to_date'] != ''){{ $parameterNames['to_date'] }}@endif" id="to-date" name="to_date"/>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <a href="{{ route('loans.payments.index', withLang()) }}" class="btn btn-outline-secondary">
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
