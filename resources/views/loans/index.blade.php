@extends('layouts.app')
@push('styles')
@endpush

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="pull-right">
                @can('loan-create')
                    <a class="btn btn-outline-primary" href="{{ route('loans.create', withLang()) }}"> <i class='bx bx-plus-circle' ></i> {{ __('loan.create')}}</a>
                @endcan
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loanSearchModal">
                  <i class='bx bx-search' ></i>
                </button>
            </div>
        </div>
    </div>
        <!-- List Product Table -->
        <div class="card">
          <h5 class="card-header">{{ __('loan.list')}}</h5>
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
                        <th>{{__('loan.status')}}</th>
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
                                <td>{{ setToStringDolla($loan->remain ?? 0 )}}</td>
                                <td>{{ $loan->total_monthly_payment ?? '' }}</td>
                                <td>{!! $loan->status_label ?? '' !!}</td>
                                <td>
                                    <!-- Add edit and delete buttons/links here -->
                                    @can('loan-list')
                                      @if($loan->status == 2 || $loan->status == 3)
                                          <a href="{{ route('loans.invoice', withLang(['loan' => $loan->id])) }}" class="btn btn-icon btn-outline-secondary">
                                            <i class="fa-solid fa-receipt"></i>
                                          </a>
                                          <a href="{{ route('loans.payments.list', withLang(['loan' => $loan->id])) }}" class="btn btn-icon btn-outline-secondary">
                                              <span class="tf-icons fa-solid fa-list-check"></span>
                                          </a>
                                      @endif
                                    @endcan
                                    @can('loan-create')
                                      @if($loan->status == 2 || $loan->status == 3)
                                          <a href="{{ route('loans.agreement', withLang(['loan' => $loan->id])) }}" class="btn btn-icon btn-outline-secondary" target="_blank">
                                            <i class="fa-solid fa-handshake"></i>
                                          </a>
                                      @endif
                                    @endcan
                                    @can('loan-payment-create')
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

                                    @can('loan-delete')
                                        <form method="POST" action="{{ route('loans.destroy', withLang(['loan' => $loan->id])) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-outline-danger" onclick="return confirm('Are you sure you want to delete this loan?')">
                                                <span class="tf-icons bx bx-trash"></span>
                                            </button>
                                        </form>
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
<form method="GET" action="{{ route('loans.index', withLang()) }}">
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
                              <option></option>
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
                  <a href="{{ route('loans.index', withLang()) }}" class="btn btn-outline-secondary">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.js"></script>

<style>
    .select2{
        width: 100% !important;
        padding: .4375rem .875rem;
        font-size: 0.9375rem;
        font-weight: 400;
        line-height: 1.53;
        color: #697a8d;
        appearance: none;
        background-color: #fff;
        background-clip: padding-box;
        border: var(--bs-border-width) solid #d9dee3;
        border-radius: var(--bs-border-radius);
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    .select2-container--default .select2-selection--single{
        border: 0px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        top: 8px;
    }
</style>
  <script>
    $(document).ready(function(){
        $('#loanSearchModal').on('shown.bs.modal', function() {
            $("#customer").select2({
                dropdownParent: $('#loanSearchModal'),
                placeholder: "សូមជ្រើសរើសអតិថិជន",
                allowClear: true
            });
        });

        $(document).on('submit', '#loanSearchModal form', function(e){
            e.stopPropagation();
        });
    });
</script>
@endpush
