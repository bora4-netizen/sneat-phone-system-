@extends('layouts.app')
@push('style')
<link rel="stylesheet" href="{{ asset('/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
@endpush
@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="badge bg-label-danger p-2"><i class='bx bxl-paypal'></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">{{ __('dashboard.lbl_expenses')}}</span>
                    <h3 class="card-title text-nowrap mb-1">{{  setToStringDolla($totalExpense) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12 mb-4">
          <div class="card">
              <div class="card-body">
                  <div class="card-title d-flex align-items-start justify-content-between">
                      <div class="avatar flex-shrink-0">
                        <span class="badge bg-label-info p-2"><i class='bx bxs-wallet' ></i></span>
                      </div>
                  </div>
                  <span class="fw-semibold d-block mb-1">{{ __('dashboard.lbl_loan') }}</span>
                  <h3 class="card-title text-nowrap mb-1">{{ setToStringDolla($totalLoanPaymentIncome) }}</h3>
              </div>
          </div>
      </div>
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">{{ __('dashboard.lbl_income')}}</span>
                    <h3 class="card-title text-nowrap mb-1">{{  setToStringDolla($totalIncome) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="badge bg-label-success p-2"><i class='bx bx-money-withdraw' ></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">{{ __('dashboard.lbl_profit')}}</span>
                    <h3 class="card-title text-nowrap mb-1">{{ setToStringDolla($totalProfit) }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Total Revenue -->
        <div class="col-12 col-lg-12 order-0 mb-4">
            <div class="card">
                <div class="row row-bordered g-0">
                    <div class="col-md-8">
                        <h5 class="card-header m-0 me-2 pb-3">{{__('dashboard.lbl_total_revenue')}}</h5>
                        <div id="totalRevenueChart" class="px-2"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="dropdown">
                                    <button
                                        class="btn btn-sm btn-outline-primary dropdown-toggle"
                                        type="button"
                                        id="growthReportId"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                    >{{ $currentYear }}
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">
                                        @foreach ($years as $key => $value)
                                          <a class="dropdown-item" href="{{ route('dashboard', withLang(['year' => $value->order_year])) }}">{{ $value->order_year }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="growthChart"></div>
                        <div class="text-center fw-semibold pt-3 mb-2">{{ setToStringPercentageChange($percentageChange) }}</div>
                        <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                            <div class="d-flex">
                                <div class="me-2">
                                    <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <small>{{ $monthlyDifference['name'] }}</small>
                                    <h6 class="mb-0">{{ setToStringDolla($monthlyDifference['total']) }}</h6>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="me-2">
                                    <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <small>{{ $monthlyDifferenceLastYear['name'] }}</small>
                                    <h6 class="mb-0">{{ setToStringDolla($monthlyDifferenceLastYear['total']) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Total Revenue -->
    </div>
    <div class="row">
      <!-- Loan Payment -->
      <div class="col-12 col-md-6 col-lg-8 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">{{ __('loan.payment.latest')}}</h5>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="loanPaymentList" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="loanPaymentList">
                        <a class="dropdown-item" href="{{ route('loans.payments.index', withLang())}}">{{ __('loan.payment.view_all')}}</a>
                        <a class="dropdown-item" href="{{ route('loans.payments.create', withLang())}}">{{ __('loan.payment.place_new')}}</a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('loan.no')}}</th>
                            <th>{{ __('loan.customer')}}</th>
                            <th>{{ __('loan.amount')}}</th>
                            <th>{{ __('loan.status')}}</th>
                            @can('loan-edit')<th class="cell-fit"></th>@endcan
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($loanPayments as $payment)
                            <tr>
                                <td>
                                    <strong>{{ $payment->loan->number ?? '' }}</strong>
                                </td>
                                <td>{{ $payment->loan->customer->name ?? '' }}</td>
                                <td>{{ setToStringDolla($payment->amount ?? 0) }}</td>
                                <td>
                                    {!! $payment->status_name ?? '' !!}
                                </td>
                                @can('loan-edit')
                                <td>
                                    <a href="{{ route('loans.payments.edit', withLang(['loanPayment' => $payment->id])) }}" class="btn btn-icon btn-outline-secondary">
                                        <i class="fa-solid fa-file-pen"></i>
                                    </a>
                                </td>
                                @endcan
                            </tr>
                          @empty
                            <tr class="no-data">
                              <th colspan="6" class="p-5 text-center">{{ __('common.lbl_no_data') }}</th>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/ Loan Payment -->
      <!-- Loan Late Paymet -->
      <div class="col-12 col-md-6 col-lg-4 mb-4">
          <div class="card h-100">
              <div class="card-header d-flex align-items-center justify-content-between">
                  <h5 class="card-title m-0 me-2">{{ __('loan.payment.late') }}</h5>
                  <div class="dropdown">
                      <button class="btn p-0" type="button" id="lastestSale" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="lastestSale">
                          <a class="dropdown-item" href="{{ route('loans.index', withLang())}}">{{ __('loan.view_all')}}</a>
                      </div>
                  </div>
              </div>
              <div class="card-body">
                  <ul class="p-0 m-0">
                      @forelse ($lateLoans as $lateLone)
                          <li class="d-flex mb-4 pb-2">
                              <div class="avatar flex-shrink-0 me-3">
                                  <img src="{{ $lateLone->customer->profile_image }}" alt="avatar" class="rounded-circle">
                              </div>
                              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                              <div class="me-2">
                                  <h6 class="mb-0">{{ $lateLone->customer->name }}</h6>
                                  <small>
                                  <i class="mdi mdi-calendar-blank-outline mdi-14px"></i>
                                  <span><div class="badge bg-label-danger rounded-pill">{{ $lateLone->pay_date }} ( {{ $lateLone->overdue_days }} )</div></span>
                                  </small>
                              </div>
                                  @can('loan-create')
                                      <td>
                                          <a href="{{ route('loans.payments.create', withLang(['loan' => $lateLone->id])) }}" class="btn btn-icon btn-outline-secondary">
                                              <i class="fa-solid fa-file-invoice-dollar"></i>
                                          </a>
                                      </td>
                                  @endcan
                              </div>
                          </li>
                      @empty
                          <tr class="no-data">
                            <th colspan="6" class="p-5 text-center">{{ __('common.lbl_no_data') }}</th>
                          </tr>
                      @endforelse
                  </ul>
              </div>
          </div>
      </div>
      <!--/ Loan Late Paymet -->
  </div>
    <div class="row">
        <!-- Customer Table -->
        @if($orders)
          <div class="col-12 mb-4">
              <div class="card">
                  <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="card-title m-0 me-2">{{ __('order.latest_sales')}}</h5>
                      <div class="dropdown">
                          <button class="btn p-0" type="button" id="lastestSale" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="lastestSale">
                              <a class="dropdown-item" href="{{ route('orders.index', withLang())}}">{{ __('order.view_all')}}</a>
                              <a class="dropdown-item" href="{{ route('sales.create', withLang())}}">{{ __('order.place_new')}}</a>
                          </div>
                      </div>
                  </div>
                  <div class="card-datatable table-responsive">
                      <table class="invoice-list-table table">
                          <thead>
                              <tr>
                              <th>{{ __('order.customer') }}</th>
                              <th>{{ __('order.amount') }}</th>
                              <th>{{ __('order.sale_by') }}</th>
                              <th class="cell-fit">{{ __('order.payment_type') }}</th>
                                  @can('order-list')<th class="cell-fit"></th>@endcan
                              </tr>
                          </thead>
                          <tbody class="table-border-bottom-0">
                              @forelse ($orders as $order)
                                  <tr>
                                      <td>
                                          <div class="d-flex justify-content-start align-items-center">
                                              <div class="avatar-wrapper">
                                                  <div class="avatar avatar-sm me-2"><img src="{!! $order->customer->profile_image ?? '' !!}" alt="Avatar" class="rounded-circle"></div>
                                              </div>
                                              <div class="d-flex flex-column">
                                                  <a href="{{ route('customers.show', withLang(['id' => $order->customer_id]))}}" class="text-body text-truncate fw-medium">{{ $order->customer_name ?? ''}}</a>
                                              </div>
                                          </div>
                                      </td>
                                      <td>{{ setToStringDolla($order->total_amount ?? 0)}}</td>
                                      <td>{!! $order->employee_name ?? '' !!} </td>
                                      <td>{!! $order->payment_type_badges ?? '' !!}</td>
                                      @can('order-list')
                                      <td>
                                          <a href="{{ route('sales.show', withLang(['order' => $order->id])) }}" class="btn btn-icon btn-outline-secondary">
                                              <i class="fa-solid fa-receipt"></i>
                                          </a>
                                      </td>
                                      @endcan
                                  </tr>
                              @empty
                                  <tr class="no-data">
                                    <th colspan="6" class="p-5 text-center">{{ __('common.lbl_no_data') }}</th>
                                  </tr>
                              @endforelse
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
        @endif
        <!--/ Customer Table -->
        @if($loans)
          <!-- New Loan -->
          <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">{{ __('loan.latest')}}</h5>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="lastestSale" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="lastestSale">
                            <a class="dropdown-item" href="{{ route('loans.index', withLang())}}">{{ __('loan.view_all')}}</a>
                            <a class="dropdown-item" href="{{ route('loans.create', withLang())}}">{{ __('loan.place_new')}}</a>
                        </div>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="invoice-list-table table">
                        <thead>
                            <tr>
                            <th>{{ __('loan.customer') }}</th>
                            <th>{{ __('loan.amount') }}</th>
                            <th>{{ __('loan.interest') }}</th>
                            <th>{{__('loan.installment')}}</th>
                            <th class="cell-fit">{{ __('loan.payment.pay_date') }}</th>
                                @can('order-list')<th class="cell-fit"></th>@endcan
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($loans as $loan)
                                <tr>
                                    <td>
                                        <div class="d-flex justify-content-start align-items-center">
                                            <div class="avatar-wrapper">
                                                <div class="avatar avatar-sm me-2"><img src="{!! $loan->customer->profile_image ?? '' !!}" alt="Avatar" class="rounded-circle"></div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="{{ route('customers.show', withLang(['id' => $loan->customer_id]))}}" class="text-body text-truncate fw-medium">{{ $loan->customer->name ?? ''}}</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ setToStringDolla($loan->amount ?? 0)}}</td>
                                    <td>{!! $loan->total_interest ?? '' !!} </td>
                                    <td>{{ $loan->total_monthly_payment ?? '' }}</td>
                                    <td>{!! $loan->next_payment_date ?? '-' !!}</td>
                                    @can('loan-list')
                                    <td>
                                        <a href="{{ route('loans.payments.list', withLang(['loan' => $loan->id])) }}" class="btn btn-icon btn-outline-secondary">
                                            <i class="tf-icons fa-solid fa-list-check"></i>
                                        </a>
                                    </td>
                                    @endcan
                                </tr>
                            @empty
                                <tr class="no-data">
                                  <th colspan="6" class="p-5 text-center">{{ __('common.lbl_no_data') }}</th>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
          </div>
        @endif
        <!--/ New Loan -->
    </div>
</div>
@endsection
@push('script')
    <script>
        var monthlyDifference = @json($monthlyDifference);
        var monthlyDifferenceLastYear = @json($monthlyDifferenceLastYear);
        var percentageChange = Math.floor(Math.abs({{ $percentageChange }}));
        var percentageStatus = "{{ setStatusPercentage($percentageChange)}}";
        config.colors.growth = "{{ setColorPercentage($percentageChange)}}";

    </script>
    <!-- Vendors JS -->
    <script src="{{ asset('/assets/vendor/libs/apex-charts/apexcharts.js') }} "></script>
    <!-- Page JS -->
    <script src="{{ asset('/assets/js/dashboards-analytics.js') }} "></script>
@endpush
