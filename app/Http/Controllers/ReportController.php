<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Loan;
use App\Models\LoanPayment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Series;
use App\Models\Product;
use App\Models\ExpenseCategory;
use App\Models\Customer;

class ReportController extends Controller
{
    // ─────────────────────────────────────────────
    //  HELPER: apply shared date/search filters
    // ─────────────────────────────────────────────
    private function applySelectFilter($query, int $select, string $col): void
    {
        if ($select === 1) {
            $query->whereDate($col, now()->toDateString());
        } elseif ($select === 2) {
            $query->whereBetween($col, [
                now()->copy()->startOfWeek()->toDateString(),
                now()->copy()->endOfWeek()->toDateString(),
            ]);
        } elseif ($select === 3) {
            $query->whereMonth($col, now()->month)->whereYear($col, now()->year);
        } elseif ($select === 4) {
            $query->whereYear($col, now()->year);
        }
    }

    private function applyDateRangeFilter($query, array $filters, string $col): void
    {
        if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
            $query->whereBetween($col, [$filters['from_date'], $filters['to_date']]);
        } elseif (!empty($filters['from_date'])) {
            $query->where($col, '>=', $filters['from_date']);
        } elseif (!empty($filters['to_date'])) {
            $query->where($col, '<=', $filters['to_date']);
        }
    }

    // ═══════════════════════════════════════════════
    //  STOCK
    // ═══════════════════════════════════════════════
    public function stock(Request $request)
    {
        $status     = Product::getStatuses();
        $statusID   = Product::STATUS_ID_AVAILABLE;
        $statusName = $status[$statusID];
        $parameterNames = [];

        $query = Series::leftJoin('products', 'series.id', '=', 'products.series_id')
            ->leftJoin('brands', 'series.brand_id', '=', 'brands.id')
            ->select(
                'series.id as series_id',
                'series.name as series_name',
                'brands.name as brand_name',
                DB::raw('count(products.id) as product_count'),
                DB::raw('sum(case when products.status = 2 and products.condition = 1 then 1 else 0 end) as condition_count_sold_used'),
                DB::raw('sum(case when products.status = 1 and products.condition = 1 then 1 else 0 end) as condition_count_instock_used'),
                DB::raw('sum(case when products.status = 1 and products.condition = 1 and products.type_of_machine = 4 then 1 else 0 end) as condition_count_instock_unlock_used'),
                DB::raw('sum(case when products.status = 3 and products.condition = 1 then 1 else 0 end) as condition_count_broken_used'),
                DB::raw('sum(case when products.status = 2 and products.condition = 2 then 1 else 0 end) as condition_count_sold_new'),
                DB::raw('sum(case when products.status = 1 and products.condition = 2 then 1 else 0 end) as condition_count_instock_new'),
                DB::raw('sum(case when products.status = 1 and products.condition = 2 and products.type_of_machine = 4 then 1 else 0 end) as condition_count_instock_unlock_new'),
                DB::raw('sum(case when products.status = 3 and products.condition = 2 then 1 else 0 end) as condition_count_broken_new'),
                DB::raw('sum(case when products.condition = 1 then 1 else 0 end) as condition_count_1'),
                DB::raw('sum(case when products.condition = 2 then 1 else 0 end) as condition_count_2'),
                DB::raw('sum(case when products.status != 0 then products.selling_price else 0 end) as total_selling_price')
            );

        if ($request->search) {
            $parameterNames['search'] = true;
            $filters = $request->only(['search_name', 'status', 'from_date', 'to_date']);

            if (!empty($filters['search_name'])) {
                $query->where('series.name', 'like', '%' . $filters['search_name'] . '%');
                $parameterNames['search_name'] = $filters['search_name'];
            }

            if (!empty($filters['status']) && $filters['status'] !== 'all') {
                $statusID   = $filters['status'];
                $statusName = $status[$statusID];
                $parameterNames['status'] = $filters['status'];
                $query->where('products.status', $statusID);
            }

            $this->applyDateRangeFilter($query, $filters, 'products.created_at');
            if (!empty($filters['from_date'])) $parameterNames['from_date'] = $filters['from_date'];
            if (!empty($filters['to_date']))   $parameterNames['to_date']   = $filters['to_date'];
        }

        $seriesCounts          = $query->groupBy('series.id', 'series.name', 'brands.name')
                                       ->orderBy('brands.name')->orderBy('series.name')
                                       ->paginate(20);
        $totalProduct          = Product::count();
        $totalProductAviable   = Product::available()->count();
        $totalProductSold      = Product::sold()->count();
        $totalProductBroken    = Product::broken()->count();
        $totalSoldProductPrice = Product::where('status', 2)->sum('selling_price');

        return view('reports.stock', compact(
            'status', 'statusName', 'totalProduct', 'totalProductAviable',
            'totalProductSold', 'totalProductBroken', 'seriesCounts',
            'parameterNames', 'totalSoldProductPrice'
        ));
    }

    // ═══════════════════════════════════════════════
    //  STOCK PDF
    // ═══════════════════════════════════════════════
    public function stockPdf(Request $request)
    {
        $status     = Product::getStatuses();
        $statusID   = Product::STATUS_ID_AVAILABLE;
        $statusName = $status[$statusID];
        $parameterNames = [];

        $query = Series::leftJoin('products', 'series.id', '=', 'products.series_id')
            ->leftJoin('brands', 'series.brand_id', '=', 'brands.id')
            ->select(
                'series.id as series_id',
                'series.name as series_name',
                'brands.name as brand_name',
                DB::raw('count(products.id) as product_count'),
                DB::raw('sum(case when products.status = 2 and products.condition = 1 then 1 else 0 end) as condition_count_sold_used'),
                DB::raw('sum(case when products.status = 1 and products.condition = 1 then 1 else 0 end) as condition_count_instock_used'),
                DB::raw('sum(case when products.status = 1 and products.condition = 1 and products.type_of_machine = 4 then 1 else 0 end) as condition_count_instock_unlock_used'),
                DB::raw('sum(case when products.status = 3 and products.condition = 1 then 1 else 0 end) as condition_count_broken_used'),
                DB::raw('sum(case when products.status = 2 and products.condition = 2 then 1 else 0 end) as condition_count_sold_new'),
                DB::raw('sum(case when products.status = 1 and products.condition = 2 then 1 else 0 end) as condition_count_instock_new'),
                DB::raw('sum(case when products.status = 1 and products.condition = 2 and products.type_of_machine = 4 then 1 else 0 end) as condition_count_instock_unlock_new'),
                DB::raw('sum(case when products.status = 3 and products.condition = 2 then 1 else 0 end) as condition_count_broken_new'),
                DB::raw('sum(case when products.condition = 1 then 1 else 0 end) as condition_count_1'),
                DB::raw('sum(case when products.condition = 2 then 1 else 0 end) as condition_count_2'),
                DB::raw('sum(case when products.status != 0 then products.selling_price else 0 end) as total_selling_price')
            );

        if ($request->search) {
            $parameterNames['search'] = true;
            $filters = $request->only(['search_name', 'status', 'from_date', 'to_date']);

            if (!empty($filters['search_name'])) {
                $query->where('series.name', 'like', '%' . $filters['search_name'] . '%');
                $parameterNames['search_name'] = $filters['search_name'];
            }

            if (!empty($filters['status']) && $filters['status'] !== 'all') {
                $statusID   = $filters['status'];
                $statusName = $status[$statusID];
                $parameterNames['status'] = $filters['status'];
                $query->where('products.status', $statusID);
            }

            $this->applyDateRangeFilter($query, $filters, 'products.created_at');
            if (!empty($filters['from_date'])) $parameterNames['from_date'] = $filters['from_date'];
            if (!empty($filters['to_date']))   $parameterNames['to_date']   = $filters['to_date'];
        }

        $seriesCounts        = $query->groupBy('series.id', 'series.name', 'brands.name')
                                     ->orderBy('brands.name')->orderBy('series.name')
                                     ->get();
        $totalProduct        = Product::count();
        $totalProductAviable = Product::available()->count();
        $totalProductSold    = Product::sold()->count();
        $totalProductBroken  = Product::broken()->count();
        $currentDate         = Carbon::now()->format('Y-m-d');
        $file_pdf            = 'reports-stock-' . $currentDate . '.pdf';
        $type                = $request->type ?? 'download';

        return view('reports.stock-pdf', compact(
            'status', 'statusName', 'totalProduct', 'totalProductAviable',
            'totalProductSold', 'totalProductBroken', 'seriesCounts',
            'parameterNames', 'type', 'file_pdf', 'currentDate'
        ));
    }

    // ═══════════════════════════════════════════════
    //  EXPENSE
    // ═══════════════════════════════════════════════
    public function expense(Request $request)
    {
        $query      = Expense::query();
        $loanQuery  = LoanPayment::query()->whereHas('loan', fn($q) =>
                          $q->whereNotNull('loan_id')->where('loans.status', 2));
        $orderQuery = Order::query();
        $expenseCategories = ExpenseCategory::pluck('name', 'id');
        $parameterNames    = [];
        $currentDate       = Carbon::now()->format('Y-m-d');

        if ($request->search) {
            $parameterNames['search'] = true;
            $filters = $request->only(['name', 'category', 'from_date', 'to_date', 'select']);

            if (!empty($filters['select'])) {
                $this->applySelectFilter($query,      (int)$filters['select'], 'date');
                $this->applySelectFilter($loanQuery,  (int)$filters['select'], 'date');
                $this->applySelectFilter($orderQuery, (int)$filters['select'], 'order_date');
                $parameterNames['select'] = $filters['select'];
            } else {
                if (!empty($filters['name'])) {
                    $query->where('name', 'like', '%' . $filters['name'] . '%');
                    $parameterNames['name'] = $filters['name'];
                }
                if (!empty($filters['category'])) {
                    $query->where('category_id', $filters['category']);
                    $parameterNames['category'] = $filters['category'];
                }
                $this->applyDateRangeFilter($query,      $filters, 'date');
                $this->applyDateRangeFilter($loanQuery,  $filters, 'date');
                $this->applyDateRangeFilter($orderQuery, $filters, 'order_date');
                if (!empty($filters['from_date'])) $parameterNames['from_date'] = $filters['from_date'];
                if (!empty($filters['to_date']))   $parameterNames['to_date']   = $filters['to_date'];
            }
        }

        $totalOfExpenses  = (clone $query)->sum('amount');
        $sumOfLoanAmount  = (clone $loanQuery)->sum('amount');
        $sumOfOrderAmount = (clone $orderQuery)->sum('total_amount');
        $sumOfProfit      = ($sumOfLoanAmount + $sumOfOrderAmount) - $totalOfExpenses;
        $expenses         = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('reports.expense', compact(
            'expenses', 'expenseCategories', 'parameterNames', 'currentDate',
            'totalOfExpenses', 'sumOfLoanAmount', 'sumOfOrderAmount', 'sumOfProfit'
        ) + [
            'totalExpense'           => $totalOfExpenses,
            'totalLoanPaymentIncome' => $sumOfLoanAmount,
            'totalOrderAmount'       => $sumOfOrderAmount,
            'totalProfit'            => $sumOfProfit,
        ]);
    }

    // ═══════════════════════════════════════════════
    //  EXPENSE PDF
    // ═══════════════════════════════════════════════
    public function expensePdf(Request $request)
    {
        $query      = Expense::query();
        $loanQuery  = LoanPayment::query()->whereHas('loan', fn($q) =>
                          $q->whereNotNull('loan_id')->where('loans.status', 2));
        $orderQuery = Order::query();
        $expenseCategories = ExpenseCategory::pluck('name', 'id');
        $parameterNames    = [];
        $currentDate       = Carbon::now()->format('Y-m-d');

        if ($request->search) {
            $parameterNames['search'] = true;
            $filters = $request->only(['name', 'category', 'from_date', 'to_date', 'select']);

            if (!empty($filters['select'])) {
                $this->applySelectFilter($query,      (int)$filters['select'], 'date');
                $this->applySelectFilter($loanQuery,  (int)$filters['select'], 'date');
                $this->applySelectFilter($orderQuery, (int)$filters['select'], 'order_date');
                $parameterNames['select'] = $filters['select'];
            } else {
                if (!empty($filters['name'])) {
                    $query->where('name', 'like', '%' . $filters['name'] . '%');
                    $parameterNames['name'] = $filters['name'];
                }
                if (!empty($filters['category'])) {
                    $query->where('category_id', $filters['category']);
                    $parameterNames['category'] = $filters['category'];
                }
                $this->applyDateRangeFilter($query,      $filters, 'date');
                $this->applyDateRangeFilter($loanQuery,  $filters, 'date');
                $this->applyDateRangeFilter($orderQuery, $filters, 'order_date');
                if (!empty($filters['from_date'])) $parameterNames['from_date'] = $filters['from_date'];
                if (!empty($filters['to_date']))   $parameterNames['to_date']   = $filters['to_date'];
            }
        }

        $totalOfExpenses  = (clone $query)->sum('amount');
        $sumOfLoanAmount  = (clone $loanQuery)->sum('amount');
        $sumOfOrderAmount = (clone $orderQuery)->sum('total_amount');
        $sumOfProfit      = ($sumOfLoanAmount + $sumOfOrderAmount) - $totalOfExpenses;
        $expenses         = $query->orderBy('created_at', 'desc')->get();
        $file_pdf         = 'reports-expense-' . $currentDate . '.pdf';
        $type             = $request->type ?? 'download';

        return view('reports.expense-pdf', [
            'expenses'               => $expenses,
            'expenseCategories'      => $expenseCategories,
            'parameterNames'         => $parameterNames,
            'currentDate'            => $currentDate,
            'totalExpense'           => $totalOfExpenses,
            'totalLoanPaymentIncome' => $sumOfLoanAmount,
            'totalOrderAmount'       => $sumOfOrderAmount,
            'totalProfit'            => $sumOfProfit,
            'file_pdf'               => $file_pdf,
            'type'                   => $type,
        ]);
    }

    // ═══════════════════════════════════════════════
    //  SALE
    // ═══════════════════════════════════════════════
    public function sale(Request $request)
    {
        $query      = OrderDetail::query()->whereHas('order')->with(['order', 'product']);
        $conditions = Product::CONDITION;
        $series     = Series::pluck('name', 'id');
        $parameterNames = [];
        $currentDate    = now()->format('Y-m-d');
        $filters        = $request->only(['condition', 'series', 'from_date', 'to_date', 'select']);

        if ($request->search) {
            $parameterNames['search'] = true;
            if (!empty($filters['select'])) {
                $select = (int)$filters['select'];
                $query->whereHas('order', function ($q) use ($select) {
                    $this->applySelectFilter($q, $select, 'order_date');
                });
                $parameterNames['select'] = $filters['select'];
            } else {
                if (!empty($filters['condition'])) {
                    $query->whereHas('product', fn($q) => $q->where('condition', $filters['condition']));
                    $parameterNames['condition'] = $filters['condition'];
                }
                if (!empty($filters['series'])) {
                    $query->whereHas('product', fn($q) => $q->where('series_id', $filters['series']));
                    $parameterNames['series'] = $filters['series'];
                }
                if (!empty($filters['from_date'])) {
                    $query->whereHas('order', fn($q) => $q->where('order_date', '>=', $filters['from_date']));
                    $parameterNames['from_date'] = $filters['from_date'];
                }
                if (!empty($filters['to_date'])) {
                    $query->whereHas('order', fn($q) => $q->where('order_date', '<=', $filters['to_date']));
                    $parameterNames['to_date'] = $filters['to_date'];
                }
            }
        }

        $allOrders          = $query->with('product')->get();
        $totalSellingPrice  = $allOrders->sum('unit_price');
        $totalPurchasePrice = $allOrders->sum(fn($d) => optional($d->product)->purchase_price ?? 0);
        $totalProfit        = $totalSellingPrice - $totalPurchasePrice;
        $orders             = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('reports.sale', compact(
            'orders', 'series', 'conditions', 'parameterNames', 'currentDate',
            'totalPurchasePrice', 'totalSellingPrice', 'totalProfit'
        ));
    }

    // ═══════════════════════════════════════════════
    //  SALE PDF
    // ═══════════════════════════════════════════════
    public function salePdf(Request $request)
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        $query       = OrderDetail::query()->whereHas('order')->whereHas('product')->with(['order', 'product']);
        $conditions  = Product::CONDITION;
        $series      = Series::pluck('name', 'id');
        $parameterNames = [];
        $filters        = $request->only(['condition', 'series', 'from_date', 'to_date', 'select']);

        if ($request->search) {
            $parameterNames['search'] = true;
            if (!empty($filters['select'])) {
                $select = (int)$filters['select'];
                $query->whereHas('order', function ($q) use ($select) {
                    $this->applySelectFilter($q, $select, 'order_date');
                });
                $parameterNames['select'] = $filters['select'];
            } else {
                if (!empty($filters['condition'])) {
                    $query->whereHas('product', fn($q) => $q->where('condition', $filters['condition']));
                    $parameterNames['condition'] = $filters['condition'];
                }
                if (!empty($filters['series'])) {
                    $query->whereHas('product', fn($q) => $q->where('series_id', $filters['series']));
                    $parameterNames['series'] = $filters['series'];
                }
                if (!empty($filters['from_date'])) {
                    $query->whereHas('order', fn($q) => $q->where('order_date', '>=', $filters['from_date']));
                    $parameterNames['from_date'] = $filters['from_date'];
                }
                if (!empty($filters['to_date'])) {
                    $query->whereHas('order', fn($q) => $q->where('order_date', '<=', $filters['to_date']));
                    $parameterNames['to_date'] = $filters['to_date'];
                }
            }
        }

        $orders             = $query->orderBy('created_at', 'desc')->get();
        $totalSellingPrice  = $orders->sum('unit_price');
        $totalPurchasePrice = $orders->sum(fn($d) => optional($d->product)->purchase_price ?? 0);
        $totalProfit        = $totalSellingPrice - $totalPurchasePrice;
        $file_pdf           = 'reports-sale-' . $currentDate . '.pdf';
        $type               = $request->type ?? 'download';

        return view('reports.sale-pdf', compact(
            'orders', 'series', 'conditions', 'parameterNames', 'currentDate',
            'totalSellingPrice', 'totalPurchasePrice', 'totalProfit', 'file_pdf', 'type'
        ));
    }

    // ═══════════════════════════════════════════════
    //  LOAN
    // ═══════════════════════════════════════════════
    public function loan(Request $request)
    {
        $parameterNames  = [];
        $currentDate     = now()->format('Y-m-d');
        $query           = Loan::query()->where('status', 2);
        $customers       = Customer::pluck('name', 'id');
        $totalPaidAmount = LoanPayment::sum('amount');
        $filters         = $request->only(['number', 'customer', 'from_date', 'to_date', 'select']);

        if ($request->search) {
            $parameterNames['search'] = true;
            if (!empty($filters['select'])) {
                $this->applySelectFilter($query, (int)$filters['select'], 'date');
                $parameterNames['select'] = $filters['select'];
            } else {
                if (!empty($filters['number'])) {
                    $query->where('id', 'like', '%' . $filters['number'] . '%');
                    $parameterNames['number'] = $filters['number'];
                }
                if (!empty($filters['customer'])) {
                    $query->where('customer_id', $filters['customer']);
                    $parameterNames['customer'] = $filters['customer'];
                }
                $this->applyDateRangeFilter($query, $filters, 'date');
                if (!empty($filters['from_date'])) $parameterNames['from_date'] = $filters['from_date'];
                if (!empty($filters['to_date']))   $parameterNames['to_date']   = $filters['to_date'];
            }
        }

        $base = clone $query;

        $totalWholeInterest = (clone $base)->sum(DB::raw('amount_interest * duration'));

        $loansPrincipalsPaids     = Loan::where('remain', '>', 0)->withCount('payments')->get();
        $totalLoanPrincipalsPaids = $loansPrincipalsPaids->sum(fn($l) => $l->amount_principal * $l->payments_count);
        $paidInterest             = $totalPaidAmount - $totalLoanPrincipalsPaids;
        $totalRemainInterest      = $totalWholeInterest - $paidInterest;

        $totalLoan         = (clone $base)->sum('amount');
        $totalPayable      = (clone $base)->sum('payable_amount');
        $totalRemain       = (clone $base)->sum('remain');
        $totalFirstAmount  = (clone $base)->sum('first_amount');
        $totalLoanAmount   = $totalLoan - $totalFirstAmount;
        $totalInterest     = $totalPayable - $totalLoan;
        $totalInterestShow = abs($totalInterest);
        $totalIncome       = ($totalLoan + $totalInterest) - $totalRemain;
        $totalLoanProfit   = $totalIncome - $totalLoanAmount;
        $loans             = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('reports.loan', compact(
            'loans', 'customers', 'parameterNames', 'currentDate',
            'totalLoan', 'totalInterest', 'totalRemain', 'totalIncome',
            'totalInterestShow', 'totalLoanAmount', 'totalLoanProfit', 'totalRemainInterest'
        ));
    }

    // ═══════════════════════════════════════════════
    //  LOAN PDF
    // ═══════════════════════════════════════════════
    public function loanPdf(Request $request)
    {
        $query          = Loan::query()->where('status', 2);
        $parameterNames = [];
        $currentDate    = Carbon::now()->format('Y-m-d');
        $customers      = Customer::pluck('name', 'id');
        $filters        = $request->only(['number', 'customer', 'from_date', 'to_date', 'select']);

        if ($request->search) {
            $parameterNames['search'] = true;
            if (!empty($filters['select'])) {
                $this->applySelectFilter($query, (int)$filters['select'], 'date');
                $parameterNames['select'] = $filters['select'];
            } else {
                if (!empty($filters['number'])) {
                    $query->where('id', 'like', '%' . $filters['number'] . '%');
                    $parameterNames['number'] = $filters['number'];
                }
                if (!empty($filters['customer'])) {
                    $query->where('customer_id', $filters['customer']);
                    $parameterNames['customer'] = $filters['customer'];
                }
                $this->applyDateRangeFilter($query, $filters, 'date');
                if (!empty($filters['from_date'])) $parameterNames['from_date'] = $filters['from_date'];
                if (!empty($filters['to_date']))   $parameterNames['to_date']   = $filters['to_date'];
            }
        }

        $base          = clone $query;
        $totalLoan     = (clone $base)->sum('amount');
        $totalPayable  = (clone $base)->sum('payable_amount');
        $totalRemain   = (clone $base)->sum('remain');
        $totalInterest = $totalPayable - $totalLoan;
        $totalIncome   = ($totalLoan + $totalInterest) - $totalRemain;
        $loans         = $query->orderBy('created_at', 'desc')->get();
        $file_pdf      = 'reports-loan-' . $currentDate . '.pdf';
        $type          = $request->type ?? 'download';

        return view('reports.loan-pdf', compact(
            'loans', 'customers', 'parameterNames', 'currentDate',
            'totalLoan', 'totalPayable', 'totalRemain', 'totalInterest',
            'totalIncome', 'file_pdf', 'type'
        ));
    }

    // ═══════════════════════════════════════════════
    //  LOAN DAILY PDF
    // ═══════════════════════════════════════════════
    public function loanDailyPdf(Request $request)
    {
        $query          = Loan::query()->where('status', 2)->with('payments');
        $parameterNames = [];
        $currentDate    = Carbon::now()->format('Y-m-d');
        $customers      = Customer::pluck('name', 'id');
        $loanPayments   = LoanPayment::get();
        $filters        = $request->only(['number', 'customer', 'from_date', 'to_date', 'select']);

        if ($request->search) {
            $parameterNames['search'] = true;
            if (!empty($filters['select'])) {
                $this->applySelectFilter($query, (int)$filters['select'], 'date');
                $parameterNames['select'] = $filters['select'];
            } else {
                if (!empty($filters['number'])) {
                    $query->where('id', 'like', '%' . $filters['number'] . '%');
                    $parameterNames['number'] = $filters['number'];
                }
                if (!empty($filters['customer'])) {
                    $query->where('customer_id', $filters['customer']);
                    $parameterNames['customer'] = $filters['customer'];
                }
                $this->applyDateRangeFilter($query, $filters, 'date');
                if (!empty($filters['from_date'])) $parameterNames['from_date'] = $filters['from_date'];
                if (!empty($filters['to_date']))   $parameterNames['to_date']   = $filters['to_date'];
            }
        }

        $loans    = $query->orderBy('created_at', 'desc')->get();
        $file_pdf = 'reports-daily-loan-' . $currentDate . '.pdf';
        $type     = $request->type ?? 'print';

        return view('reports.loan-daily-pdf', [
            'loans'          => $loans,
            'loanPayments'   => $loanPayments,
            'customers'      => $customers,
            'parameterNames' => $parameterNames,
            'currentDate'    => $currentDate,
            'totalLoan'      => 0,
            'totalPayable'   => 0,
            'totalRemain'    => 0,
            'totalInterest'  => 0,
            'totalIncome'    => 0,
            'file_pdf'       => $file_pdf,
            'type'           => $type,
        ]);
    }

    // ═══════════════════════════════════════════════
    //  LIST LOAN
    // ═══════════════════════════════════════════════
    public function listLoan(Request $request, string $lang, Loan $loan)
    {
        $query          = Loan::query()->where('status', 2)->with('payments');
        $parameterNames = [];
        $currentDate    = Carbon::now()->format('Y-m-d');
        $customers      = Customer::pluck('name', 'id');
        $loanPayments   = LoanPayment::where('loan_id', $loan->id)->get();
        $filters        = $request->only(['number', 'customer', 'from_date', 'to_date', 'select']);

        if ($request->search) {
            $parameterNames['search'] = true;
            if (!empty($filters['select'])) {
                $this->applySelectFilter($query, (int)$filters['select'], 'date');
                $parameterNames['select'] = $filters['select'];
            } else {
                if (!empty($filters['number'])) {
                    $query->where('id', 'like', '%' . $filters['number'] . '%');
                    $parameterNames['number'] = $filters['number'];
                }
                if (!empty($filters['customer'])) {
                    $query->where('customer_id', $filters['customer']);
                    $parameterNames['customer'] = $filters['customer'];
                }
                $this->applyDateRangeFilter($query, $filters, 'date');
                if (!empty($filters['from_date'])) $parameterNames['from_date'] = $filters['from_date'];
                if (!empty($filters['to_date']))   $parameterNames['to_date']   = $filters['to_date'];
            }
        }

        $loans    = $query->orderBy('created_at', 'desc')->get();
        $file_pdf = 'reports-daily-loan-' . $currentDate . '.pdf';
        $type     = $request->type ?? '';

        return view('reports.list-loan', [
            'loans'          => $loans,
            'loanPayments'   => $loanPayments,
            'customers'      => $customers,
            'parameterNames' => $parameterNames,
            'currentDate'    => $currentDate,
            'totalLoan'      => 0,
            'totalPayable'   => 0,
            'totalRemain'    => 0,
            'totalInterest'  => 0,
            'totalIncome'    => 0,
            'file_pdf'       => $file_pdf,
            'type'           => $type,
        ]);
    }

    // ═══════════════════════════════════════════════
    //  PROFIT & LOSS
    // ═══════════════════════════════════════════════
    public function profitLoss(Request $request)
    {
        $query            = Order::query();
        $expenseQuery     = Expense::query();
        $loanPaymentQuery = LoanPayment::query()->whereHas('loan', fn($q) =>
                                $q->whereNotNull('loan_id')->where('loans.status', 2));
        $loanQuery        = Loan::query()->where('status', 2);
        $parameterNames   = [];
        $currentDate      = now()->format('Y-m-d');
        $years = DB::table('orders')
            ->select(DB::raw('YEAR(order_date) as order_year'))
            ->distinct()
            ->orderBy('order_year', 'desc')
            ->get();

        $filters = $request->only(['select', 'year', 'from_date', 'to_date']);

        if ($request->search) {
            $parameterNames['search'] = true;
            if (!empty($filters['select'])) {
                $select = (int)$filters['select'];
                $this->applySelectFilter($query,            $select, 'order_date');
                $this->applySelectFilter($loanPaymentQuery, $select, 'created_at');
                $this->applySelectFilter($expenseQuery,     $select, 'date');
                $this->applySelectFilter($loanQuery,        $select, 'date');
                $parameterNames['select'] = $filters['select'];
            } elseif (!empty($filters['year'])) {
                $y = $filters['year'];
                $query->whereYear('order_date', $y);
                $loanPaymentQuery->whereYear('created_at', $y);
                $expenseQuery->whereYear('date', $y);
                $loanQuery->whereYear('date', $y);
                $parameterNames['year'] = $y;
            } elseif (!empty($filters['from_date']) || !empty($filters['to_date'])) {
                if (!empty($filters['from_date'])) {
                    $query->where('order_date', '>=', $filters['from_date']);
                    $loanPaymentQuery->where('created_at', '>=', $filters['from_date']);
                    $expenseQuery->where('date', '>=', $filters['from_date']);
                    $loanQuery->where('date', '>=', $filters['from_date']);
                    $parameterNames['from_date'] = $filters['from_date'];
                }
                if (!empty($filters['to_date'])) {
                    $query->where('order_date', '<=', $filters['to_date']);
                    $loanPaymentQuery->where('created_at', '<=', $filters['to_date']);
                    $expenseQuery->where('date', '<=', $filters['to_date']);
                    $loanQuery->where('date', '<=', $filters['to_date']);
                    $parameterNames['to_date'] = $filters['to_date'];
                }
            }
        }

        $totalOrderAmount       = $query->sum('total_amount');
        $totalLoanPaymentIncome = $loanPaymentQuery->sum('amount');
        $loanPhoneProfit        = $loanQuery->sum('phone_profit');
        $totalExpense           = $expenseQuery->sum('amount');
        $totalProfit            = ($totalLoanPaymentIncome + $totalOrderAmount + $loanPhoneProfit) - $totalExpense;

        return view('reports.profit-loss', compact(
            'parameterNames', 'currentDate', 'totalExpense',
            'totalLoanPaymentIncome', 'totalOrderAmount', 'loanPhoneProfit',
            'totalProfit', 'years'
        ));
    }

    // ═══════════════════════════════════════════════
    //  PROFIT & LOSS PDF
    // ═══════════════════════════════════════════════
    public function profitLossPdf(Request $request)
    {
        $query            = Order::query();
        $expenseQuery     = Expense::query();
        $loanPaymentQuery = LoanPayment::query()->whereHas('loan', fn($q) =>
                                $q->whereNotNull('loan_id')->where('loans.status', 2));
        $parameterNames = [];
        $currentDate    = Carbon::now()->format('Y-m-d');
        $filters        = $request->only(['select', 'year', 'from_date', 'to_date']);

        if ($request->search) {
            $parameterNames['search'] = true;
            if (!empty($filters['select'])) {
                $select = (int)$filters['select'];
                $this->applySelectFilter($query,            $select, 'order_date');
                $this->applySelectFilter($loanPaymentQuery, $select, 'created_at');
                $this->applySelectFilter($expenseQuery,     $select, 'date');
                $parameterNames['select'] = $filters['select'];
            } elseif (!empty($filters['year'])) {
                $y = $filters['year'];
                $query->whereYear('order_date', $y);
                $loanPaymentQuery->whereYear('created_at', $y);
                $expenseQuery->whereYear('date', $y);
                $parameterNames['year'] = $y;
            } elseif (!empty($filters['from_date']) || !empty($filters['to_date'])) {
                if (!empty($filters['from_date'])) {
                    $query->where('order_date', '>=', $filters['from_date']);
                    $loanPaymentQuery->where('created_at', '>=', $filters['from_date']);
                    $expenseQuery->where('date', '>=', $filters['from_date']);
                    $parameterNames['from_date'] = $filters['from_date'];
                }
                if (!empty($filters['to_date'])) {
                    $query->where('order_date', '<=', $filters['to_date']);
                    $loanPaymentQuery->where('created_at', '<=', $filters['to_date']);
                    $expenseQuery->where('date', '<=', $filters['to_date']);
                    $parameterNames['to_date'] = $filters['to_date'];
                }
            }
        }

        $totalOrderAmount       = $query->sum('total_amount');
        $totalLoanPaymentIncome = $loanPaymentQuery->sum('amount');
        $totalExpense           = $expenseQuery->sum('amount');
        $totalProfit            = ($totalLoanPaymentIncome + $totalOrderAmount) - $totalExpense;
        $file_pdf               = 'reports-profit-loss-' . $currentDate . '.pdf';
        $type                   = $request->type ?? 'download';

        return view('reports.profit-loss-pdf', compact(
            'parameterNames', 'currentDate', 'totalExpense',
            'totalLoanPaymentIncome', 'totalOrderAmount', 'totalProfit',
            'file_pdf', 'type'
        ));
    }

    // ═══════════════════════════════════════════════
    //  PRODUCT
    // ═══════════════════════════════════════════════
    public function product(Request $request)
    {
        $query          = Product::query();
        $parameterNames = [];

        if ($request->search) {
            $parameterNames['search'] = true;
            $filters = $request->only(['search_name', 'from_date', 'to_date', 'select']);

            if (!empty($filters['select'])) {
                $this->applySelectFilter($query, (int)$filters['select'], 'created_at');
                $parameterNames['select'] = $filters['select'];
            } else {
                if (!empty($filters['search_name'])) {
                    $query->where('product_name', 'like', '%' . $filters['search_name'] . '%');
                    $parameterNames['search_name'] = $filters['search_name'];
                }
                $this->applyDateRangeFilter($query, $filters, 'created_at');
                if (!empty($filters['from_date'])) $parameterNames['from_date'] = $filters['from_date'];
                if (!empty($filters['to_date']))   $parameterNames['to_date']   = $filters['to_date'];
            }
        }

        $base = clone $query;

        $totalProduct             = (clone $base)->count();
        $totalSellingPrice        = (clone $base)->sum('selling_price');
        $totalPurchasePrice       = (clone $base)->sum('purchase_price');
        $totalProductConditionNew = (clone $base)->where('condition', Product::CONDITION_NEW)->count();

        $products = $query->paginate(20);

        return view('reports.product', [
            'products'                 => $products,
            'totalProduct'             => $totalProduct,
            'totalSellingPrice'        => $totalSellingPrice,
            'totalPurchasePrice'       => $totalPurchasePrice,
            'totalProductConditionNew' => $totalProductConditionNew,
            'parameterNames'           => $parameterNames,
        ]);
    }

    // ═══════════════════════════════════════════════
    //  PRODUCT PDF
    // ═══════════════════════════════════════════════
    public function productPdf(Request $request)
    {
        $query          = Product::query();
        $parameterNames = [];

        if ($request->search) {
            $parameterNames['search'] = true;
            $filters = $request->only(['search_name', 'from_date', 'to_date', 'select']);

            if (!empty($filters['select'])) {
                $this->applySelectFilter($query, (int)$filters['select'], 'created_at');
                $parameterNames['select'] = $filters['select'];
            } else {
                if (!empty($filters['search_name'])) {
                    $query->where('product_name', 'like', '%' . $filters['search_name'] . '%');
                    $parameterNames['search_name'] = $filters['search_name'];
                }
                $this->applyDateRangeFilter($query, $filters, 'created_at');
                if (!empty($filters['from_date'])) $parameterNames['from_date'] = $filters['from_date'];
                if (!empty($filters['to_date']))   $parameterNames['to_date']   = $filters['to_date'];
            }
        }

        $base = clone $query;

        $totalProduct             = (clone $base)->count();
        $totalSellingPrice        = (clone $base)->sum('selling_price');
        $totalPurchasePrice       = (clone $base)->sum('purchase_price');
        $totalProductConditionNew = (clone $base)->where('condition', Product::CONDITION_NEW)->count();
        $products                 = $query->get();

        $currentDate = Carbon::now()->format('Y-m-d');
        $file_pdf    = 'reports-product-' . $currentDate . '.pdf';
        $type        = $request->type ?? 'download';

        return view('reports.product-pdf', [
            'products'                 => $products,
            'totalProduct'             => $totalProduct,
            'totalSellingPrice'        => $totalSellingPrice,
            'totalPurchasePrice'       => $totalPurchasePrice,
            'totalProductConditionNew' => $totalProductConditionNew,
            'parameterNames'           => $parameterNames,
            'file_pdf'                 => $file_pdf,
            'type'                     => $type,
            'currentDate'              => $currentDate,
        ]);
    }
}