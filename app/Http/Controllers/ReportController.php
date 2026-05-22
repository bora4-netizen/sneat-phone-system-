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
    public function stock(Request $request)
    {
        $status = Product::getStatuses();
        $statusID = Product::STATUS_ID_AVAILABLE;
        $statusName = $status[$statusID];
        $parameterNames = [];

        // Start building the query
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
            if (!empty($filters['search_name']) && $filters['search_name'] != '') {
              $query->where('series.name', 'like', '%' . $filters['search_name'] . '%',);
              $parameterNames['search_name'] = $filters['search_name'];
            }

            if (!empty($filters['status']) && $filters['status'] != 'all') {
                $statusID = $filters['status'];
                $statusName =  $status[$statusID];
                $parameterNames['status'] = $filters['status'];
                $query->where('products.status', $statusID);
            }

            if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
                $query->whereBetween('purchase_date', [$filters['from_date'], $filters['to_date']]);
                $parameterNames['from_date'] = $filters['from_date'];
                $parameterNames['to_date'] = $filters['to_date'];
            } elseif (!empty($filters['from_date'])) {
                $query->where('purchase_date', '>=', $filters['from_date']);
                $parameterNames['from_date'] = $filters['from_date'];
            } elseif (!empty($filters['to_date'])) {
                $query->where('purchase_date', '<=', $filters['to_date']);
                $parameterNames['to_date'] = $filters['to_date'];
            }
        }

        $seriesCounts = $query->groupBy('series.id', 'series.name', 'brands.name')->orderBy('brands.name', 'asc')->orderBy('series.name', 'asc')->paginate(20);
        $totalProduct = Product::count();
        $totalProductAviable = Product::available()->count();
        $totalProductSold = Product::sold()->count();
        $totalProductBroken = Product::broken()->count();
        $totalSold = Product::where('status', 2)->get();
        $totalSoldProductPrice = $totalSold->sum('selling_price');

        return view('reports.stock', [
            'status' =>  $status,
            'statusName' => $statusName,
            'totalProduct' => $totalProduct,
            'totalProductAviable' => $totalProductAviable,
            'totalProductSold' => $totalProductSold,
            'totalProductBroken' => $totalProductBroken,
            'seriesCounts' => $seriesCounts,
            'parameterNames' => $parameterNames,
            'totalSoldProductPrice' => $totalSoldProductPrice,
        ]);
    }

    public function stockPdf(Request $request)
    {
        $status = Product::getStatuses();
        $statusID = Product::STATUS_ID_AVAILABLE;
        $statusName = $status[$statusID];
        $parameterNames = [];
        // Start building the query
        if ($request->search) {
        $parameterNames['search'] = true;
            $filters = $request->only(['search_name', 'status', 'from_date', 'to_date']);
            if (!empty($filters['search_name']) && $filters['search_name'] != '') {
              $query->where('series.name', 'like', '%' . $filters['search_name'] . '%',);
              $parameterNames['search_name'] = $filters['search_name'];
            }
            if (!empty($filters['status'])) {
                $statusID = $filters['status'];
                $statusName =  $status[$statusID];
                $parameterNames['status'] = $filters['status'];
                $query->where('products.status', $statusID);
            }

            if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
                $query->whereBetween('purchase_date', [$filters['from_date'], $filters['to_date']]);
                $parameterNames['from_date'] = $filters['from_date'];
                $parameterNames['to_date'] = $filters['to_date'];
            } elseif (!empty($filters['from_date'])) {
                $query->where('purchase_date', '>=', $filters['from_date']);
                $parameterNames['from_date'] = $filters['from_date'];
            } elseif (!empty($filters['to_date'])) {
                $query->where('purchase_date', '<=', $filters['to_date']);
                $parameterNames['to_date'] = $filters['to_date'];
            }
        }
        $seriesCounts = $query->groupBy('series.id', 'series.name', 'brands.name')->orderBy('brands.name', 'asc')->orderBy('series.name', 'asc')->get();
        $totalProduct = Product::count();
        $totalProductAviable = Product::available()->count();
        $totalProductSold = Product::sold()->count();
        $totalProductBroken = Product::broken()->count();
        $currentNow = Carbon::now();
        $currentDate = $currentNow->format('Y-m-d');
        $file_pdf = 'reports-stock-'.$currentDate.'.pdf';
        $type = $request->type ?? 'download';

        return view('reports.stock-pdf', [
            'status' =>  $status,
            'statusName' => $statusName,
            'totalProduct' => $totalProduct,
            'totalProductAviable' => $totalProductAviable,
            'totalProductSold' => $totalProductSold,
            'totalProductBroken' => $totalProductBroken,
            'seriesCounts' => $seriesCounts,
            'parameterNames' => $parameterNames,
            'type' => $type,
            'file_pdf' => $file_pdf,
            'currentDate' => $currentDate
        ]);
    }

    public function expense(Request $request)
    {
        $query = Expense::query();
        $loanQuery = LoanPayment::query()->whereHas('loan', function ($query) {
            $query->whereNotNull('loan_id')->where('loans.status', 2);
        });
        $orderQuery = Order::query();
        $expenseCategories = ExpenseCategory::pluck('name', 'id');
        $parameterNames = [];
        $currentNow = Carbon::now();
        $currentDate = $currentNow->format('Y-m-d');
        if ($request->search) {
            $parameterNames['search'] = true;
            $filters = $request->only(['name','category', 'from_date', 'to_date', 'select']);
            if(!empty($filters['select'])){
                if($filters['select'] == 1){
                    $query->whereDate('date', now()->toDateString());
                    $loanQuery->whereDate('date', now()->toDateString());
                    $orderQuery->whereDate('order_date', now()->toDateString());

                }elseif($filters['select'] == 2){
                    $query->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);
                    $loanQuery->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);
                    $orderQuery->whereBetween('order_date', [now()->startOfWeek(), now()->endOfWeek()]);

                }elseif($filters['select'] == 3){
                    $query->whereMonth('date', now()->month);
                    $loanQuery->whereMonth('date', now()->month);
                    $orderQuery->whereMonth('order_date', now()->month);

                }elseif($filters['select'] == 4){
                    $query->whereYear('date', now()->year);
                    $loanQuery->whereYear('date', now()->year);
                    $orderQuery->whereYear('order_date', now()->year);
                }
                $parameterNames['select'] = $filters['select'];
            }else{
                if (!empty($filters['name'])) {
                    $query->where('name', 'like', '%' . $filters['name'] . '%');
                    $parameterNames['name'] = $filters['name'];
                }

                if (!empty($filters['category'])) {
                    $query->where('category_id', $filters['category']);
                    $parameterNames['category'] = $filters['category'];
                }

                if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
                    $query->whereBetween('date', [$filters['from_date'], $filters['to_date']]);
                    $parameterNames['from_date'] = $filters['from_date'];
                    $parameterNames['to_date'] = $filters['to_date'];
                } elseif (!empty($filters['from_date'])) {
                    $query->where('date', '>=', $filters['from_date']);
                    $parameterNames['from_date'] = $filters['from_date'];
                } elseif (!empty($filters['to_date'])) {
                    $query->where('date', '<=', $filters['to_date']);
                    $parameterNames['to_date'] = $filters['to_date'];
                }

                if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
                    $loanQuery->whereBetween('date', [$filters['from_date'], $filters['to_date']]);
                } elseif (!empty($filters['from_date'])) {
                    $loanQuery->where('date', '>=', $filters['from_date']);
                } elseif (!empty($filters['to_date'])) {
                    $loanQuery->where('date', '<=', $filters['to_date']);
                }

                if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
                    $orderQuery->whereBetween('order_date', [$filters['from_date'], $filters['to_date']]);
                } elseif (!empty($filters['from_date'])) {
                    $orderQuery->where('order_date', '>=', $filters['from_date']);
                } elseif (!empty($filters['to_date'])) {
                    $orderQuery->where('order_date', '<=', $filters['to_date']);
                }
            }
        }

        $totalOfExpenses = $query->sum('amount');
        $sumOfLoanAmount = $loanQuery->sum('amount');
        $sumOfOrderAmount = $orderQuery->sum('total_amount');
        $sumOfProfit = ($sumOfLoanAmount + $sumOfOrderAmount) - $totalOfExpenses;
        $expenses = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('reports.expense', [
            'expenses' =>  $expenses,
            'expenseCategories' => $expenseCategories,
            'parameterNames' => $parameterNames,
            'currentDate' => $currentDate,
            'totalExpense' => $totalOfExpenses,
            'totalLoanPaymentIncome' => $sumOfLoanAmount,
            'totalOrderAmount' => $sumOfOrderAmount,
            'totalProfit' => $sumOfProfit
        ]);
    }

    public function expensePdf(Request $request)
    {
        $query = Expense::query();
        $loanQuery = LoanPayment::query()->whereHas('loan', function ($query) {
            $query->whereNotNull('loan_id')->where('loans.status', 2);
        });
        $orderQuery = Order::query();
        $expenseCategories = ExpenseCategory::pluck('name', 'id');
        $parameterNames = [];
        $currentNow = Carbon::now();
        $currentDate = $currentNow->format('Y-m-d');
        if ($request->search) {
            $parameterNames['search'] = true;
            $filters = $request->only(['name','category', 'from_date', 'to_date', 'select']);
            if(!empty($filters['select'])){
                if($filters['select'] == 1){
                    $query->whereDate('date', now()->toDateString());
                    $loanQuery->whereDate('date', now()->toDateString());
                    $orderQuery->whereDate('order_date', now()->toDateString());

                }elseif($filters['select'] == 2){
                    $query->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);
                    $loanQuery->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);
                    $orderQuery->whereBetween('order_date', [now()->startOfWeek(), now()->endOfWeek()]);

                }elseif($filters['select'] == 3){
                    $query->whereMonth('date', now()->month);
                    $loanQuery->whereMonth('date', now()->month);
                    $orderQuery->whereMonth('order_date', now()->month);

                }elseif($filters['select'] == 4){
                    $query->whereYear('date', now()->year);
                    $loanQuery->whereYear('date', now()->year);
                    $orderQuery->whereYear('order_date', now()->year);
                }
                $parameterNames['select'] = $filters['select'];
            }else{
                if (!empty($filters['name'])) {
                    $query->where('name', 'like', '%' . $filters['name'] . '%');
                    $parameterNames['name'] = $filters['name'];
                }

                if (!empty($filters['category'])) {
                    $query->where('category_id', $filters['category']);
                    $parameterNames['category'] = $filters['category'];
                }

                if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
                    $query->whereBetween('date', [$filters['from_date'], $filters['to_date']]);
                    $parameterNames['from_date'] = $filters['from_date'];
                    $parameterNames['to_date'] = $filters['to_date'];
                } elseif (!empty($filters['from_date'])) {
                    $query->where('date', '>=', $filters['from_date']);
                    $parameterNames['from_date'] = $filters['from_date'];
                } elseif (!empty($filters['to_date'])) {
                    $query->where('date', '<=', $filters['to_date']);
                    $parameterNames['to_date'] = $filters['to_date'];
                }

                if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
                    $loanQuery->whereBetween('date', [$filters['from_date'], $filters['to_date']]);
                } elseif (!empty($filters['from_date'])) {
                    $loanQuery->where('date', '>=', $filters['from_date']);
                } elseif (!empty($filters['to_date'])) {
                    $loanQuery->where('date', '<=', $filters['to_date']);
                }

                if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
                    $orderQuery->whereBetween('order_date', [$filters['from_date'], $filters['to_date']]);
                } elseif (!empty($filters['from_date'])) {
                    $orderQuery->where('order_date', '>=', $filters['from_date']);
                } elseif (!empty($filters['to_date'])) {
                    $orderQuery->where('order_date', '<=', $filters['to_date']);
                }
            }
        }

        $totalOfExpenses = $query->sum('amount');
        $sumOfLoanAmount = $loanQuery->sum('amount');
        $sumOfOrderAmount = $orderQuery->sum('total_amount');
        $sumOfProfit = ($sumOfLoanAmount + $sumOfOrderAmount) - $totalOfExpenses;
        $expenses = $query->orderBy('created_at', 'desc')->get();
        $file_pdf = 'reports-expense-'.$currentDate.'.pdf';
        $type = $request->type ?? 'download';

        return view('reports.expense-pdf', [
            'expenses' =>  $expenses,
            'expenseCategories' => $expenseCategories,
            'parameterNames' => $parameterNames,
            'currentDate' => $currentDate,
            'totalExpense' => $totalOfExpenses,
            'totalLoanPaymentIncome' => $sumOfLoanAmount,
            'totalOrderAmount' => $sumOfOrderAmount,
            'totalProfit' => $sumOfProfit,
            'file_pdf' => $file_pdf,
            'type' => $type
        ]);
    }

    public function sale(Request $request)
    {
        $query = OrderDetail::query()->whereHas('order')->with(['order', 'product']);
        $conditions = Product::CONDITION;
        $series = Series::pluck('name', 'id');
        $parameterNames = [];
        $currentDate = now()->format('Y-m-d');
        $filters = $request->only(['condition', 'series', 'from_date', 'to_date', 'select']);
        if ($request->search) {
            $parameterNames['search'] = true;
            if(!empty($filters['select'])){
                if($filters['select'] == 1){
                    $query->whereHas('order', function ($productQuery) use ($filters) {
                        $productQuery->whereDate('order_date', now()->toDateString());
                    });

                }elseif($filters['select'] == 2){
                    $query->whereHas('order', function ($productQuery) use ($filters) {
                        $productQuery->whereBetween('order_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    });

                }elseif($filters['select'] == 3){
                    $query->whereHas('order', function ($productQuery) use ($filters) {
                        $productQuery->whereMonth('order_date', now()->month);
                    });

                }elseif($filters['select'] == 4){
                    $query->whereHas('order', function ($productQuery) use ($filters) {
                        $productQuery->whereYear('order_date', now()->year);
                    });
                }
                $parameterNames['select'] = $filters['select'];
            }else{
                if (!empty($filters['condition'])) {
                    $query->whereHas('product', function ($productQuery) use ($filters) {
                        $productQuery->where('condition', $filters['condition']);
                    });

                    $parameterNames['condition'] = $filters['condition'];
                }

                if (!empty($filters['series'])) {
                    $query->whereHas('product', function ($productQuery) use ($filters) {
                        $productQuery->where('series_id', $filters['series']);
                    });

                    $parameterNames['series'] = $filters['series'];
                }

                if (!empty($filters['from_date'])) {
                    $query->whereHas('order', function ($productQuery) use ($filters) {
                        $productQuery->where('order_date', '>=',$filters['from_date']);
                    });
                    $parameterNames['from_date'] = $filters['from_date'];
                }

                if (!empty($filters['to_date'])) {
                    $query->whereHas('order', function ($productQuery) use ($filters) {
                        $productQuery->where('order_date', '<=', $filters['to_date']);
                    });
                    $parameterNames['to_date'] = $filters['to_date'];
                }
            }

        }

        $totalSellingPrice = $query->sum('unit_price');
        $totalPurchasePrice = $query->withSum('product', 'purchase_price')->get()->sum('product.purchase_price');
        $totalProfit = ($totalSellingPrice - $totalPurchasePrice);
        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('reports.sale', compact(
        'orders',
        'series',
        'conditions',
        'parameterNames',
        'currentDate',
        'totalPurchasePrice',
        'totalSellingPrice',
        'totalProfit'
        ));
    }

    public function salePdf(Request $request)
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        $query = OrderDetail::query()->whereHas('order') ->whereHas('product')->with(['order', 'product']);

        $conditions = Product::CONDITION;
        $series = Series::pluck('name', 'id');
        $parameterNames = [];

        $filters = $request->only(['condition', 'series', 'from_date', 'to_date', 'select']);
        if ($request->search) {
            $parameterNames['search'] = true;
            if(!empty($filters['select'])){
                if($filters['select'] == 1){
                    $query->whereHas('order', function ($productQuery) use ($filters) {
                        $productQuery->whereDate('order_date', now()->toDateString());
                    });

                }elseif($filters['select'] == 2){
                    $query->whereHas('order', function ($productQuery) use ($filters) {
                        $productQuery->whereBetween('order_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    });

                }elseif($filters['select'] == 3){
                    $query->whereHas('order', function ($productQuery) use ($filters) {
                        $productQuery->whereMonth('order_date', now()->month);
                    });

                }elseif($filters['select'] == 4){
                    $query->whereHas('order', function ($productQuery) use ($filters) {
                        $productQuery->whereYear('order_date', now()->year);
                    });
                }
                $parameterNames['select'] = $filters['select'];
            }else{
                if (!empty($filters['condition'])) {
                    $query->whereHas('product', function ($productQuery) use ($filters) {
                        $productQuery->where('condition', $filters['condition']);
                    });

                    $parameterNames['condition'] = $filters['condition'];
                }

                if (!empty($filters['series'])) {
                    $query->whereHas('product', function ($productQuery) use ($filters) {
                        $productQuery->where('series_id', $filters['series']);
                    });

                    $parameterNames['series'] = $filters['series'];
                }

                if (!empty($filters['from_date'])) {
                    $query->whereHas('order', function ($productQuery) use ($filters) {
                        $productQuery->where('order_date', '>=',$filters['from_date']);
                    });
                    $parameterNames['from_date'] = $filters['from_date'];
                }

                if (!empty($filters['to_date'])) {
                    $query->whereHas('order', function ($productQuery) use ($filters) {
                        $productQuery->where('order_date', '<=', $filters['to_date']);
                    });
                    $parameterNames['to_date'] = $filters['to_date'];
                }
            }
        }

        $totalSellingPrice = $query->sum('unit_price');
        $totalPurchasePrice = $query->withSum('product', 'purchase_price')->get()->sum('product.purchase_price');
        $totalProfit = ($totalSellingPrice - $totalPurchasePrice);

        $orders = $query->orderBy('created_at', 'desc')->get();
        $file_pdf = 'reports-sale-'.$currentDate.'.pdf';
        $type = $request->type ?? 'download';

        return view('reports.sale-pdf', compact('orders', 'series', 'conditions', 'parameterNames', 'currentDate', 'totalSellingPrice', 'totalPurchasePrice', 'totalProfit', 'file_pdf', 'type'));
    }

    public function loan(Request $request)
    {
        $parameterNames = [];
        $currentDate = now()->format('Y-m-d');
        $query = Loan::query()->where('status', 2);
        $customers = Customer::pluck('name', 'id');
        $queryLoanPayment = LoanPayment::query()->get();
        $totalPaidAmount = $queryLoanPayment->sum('amount');

        $filters = $request->only(['number', 'customer', 'from_date', 'to_date', 'select']);
        if ($request->search) {
            $parameterNames['search'] = true;
            if(!empty($filters['select'])){
                if($filters['select'] == 1){
                    $query->whereDate('date', now()->toDateString());

                }elseif($filters['select'] == 2){
                    $query->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);

                }elseif($filters['select'] == 3){
                    $query->whereMonth('date', now()->month);

                }elseif($filters['select'] == 4){
                    $query->whereYear('date', now()->year);
                }
                $parameterNames['select'] = $filters['select'];
            }else{
                if (!empty($filters['number'])) {
                    $query->where('id', 'like', '%' . $filters['number'] . '%');
                    $parameterNames['number'] = $filters['number'];
                }

                if (!empty($filters['customer'])) {
                    $query->where('customer_id', $filters['customer']);
                    $parameterNames['customer'] = $filters['customer'];
                }

                if (!empty($filters['from_date'])) {
                    $query->where('date', '>=', $filters['from_date']);
                    $parameterNames['from_date'] = $filters['from_date'];
                }

                if (!empty($filters['to_date'])) {
                    $query->where('date', '<=', $filters['to_date']);
                    $parameterNames['to_date'] = $filters['to_date'];
                }
            }
        }


        $totalWholeInterest = $query->sum(DB::raw('amount_interest * duration'));
        $loansPrincipalsPaids = Loan::query()->where('remain','>', 0)->withCount('payments')->get();
        $totalLoanPrincipalsPaids = $loansPrincipalsPaids->sum(function ($loan) {
            return $loan->amount_principal * $loan->payments_count;
        });

        $paidInterest = $totalPaidAmount - $totalLoanPrincipalsPaids;
        $totalRemainInterest = $totalWholeInterest - $paidInterest;
        // dd($totalRemainInterest);

        $totalLoan = $query->sum('amount');
        $totalPayable = $query->sum('payable_amount');
        $totalRemain = $query->sum('remain');
        $totalInterestRemain = $query->sum('interest_remain');
        $totalFirstAmount = $query->sum('first_amount');
        $totalLoanAmount = $totalLoan - $totalFirstAmount;
        $totalInterest = $totalPayable - $totalLoan;
        $totalInterestShow = abs($totalInterest);
        $totalIncome = ($totalLoan + $totalInterest) - $totalRemain;
        $totalLoanProfit = $totalIncome - $totalLoanAmount;
        $loans = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('reports.loan', compact(
        'loans',
        'customers',
        'parameterNames',
        'currentDate',
        'totalLoan',
        'totalInterest',
        'totalRemain',
        'totalIncome',
        'totalInterestShow',
        'totalLoanAmount',
        'totalLoanProfit',
        'totalInterestRemain'
        ));
    }

    public function loanPdf(Request $request)
    {
        $query = Loan::query()->where('status', 2);
        $parameterNames = [];
        $currentDate = Carbon::now()->format('Y-m-d');
        $customers = Customer::pluck('name', 'id');

        $filters = $request->only(['number', 'customer', 'from_date', 'to_date', 'select']);
        if ($request->search) {
            $parameterNames['search'] = true;
            if(!empty($filters['select'])){
                if($filters['select'] == 1){
                    $query->whereDate('date', now()->toDateString());

                }elseif($filters['select'] == 2){
                    $query->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);

                }elseif($filters['select'] == 3){
                    $query->whereMonth('date', now()->month);

                }elseif($filters['select'] == 4){
                    $query->whereYear('date', now()->year);
                }
                $parameterNames['select'] = $filters['select'];
            }else{
                if (!empty($filters['number'])) {
                    $query->where('id', 'like', '%' . $filters['number'] . '%');
                    $parameterNames['number'] = $filters['number'];
                }

                if (!empty($filters['customer'])) {
                    $query->where('customer_id', $filters['customer']);
                    $parameterNames['customer'] = $filters['customer'];
                }

                if (!empty($filters['from_date'])) {
                    $query->where('date', '>=', $filters['from_date']);
                    $parameterNames['from_date'] = $filters['from_date'];
                }

                if (!empty($filters['to_date'])) {
                    $query->where('date', '<=', $filters['to_date']);
                    $parameterNames['to_date'] = $filters['to_date'];
                }
            }
        }

        $totalLoan = $query->sum('amount');
        $totalPayable = $query->sum('payable_amount');
        $totalRemain = $query->sum('remain');
        $totalInterest = $totalPayable - $totalLoan;
        $totalIncome = ($totalLoan + $totalInterest) - $totalRemain;

        $loans = $query->orderBy('created_at', 'desc')->get();
        $file_pdf = 'reports-loan-'.$currentDate.'.pdf';
        $type = $request->type ?? 'download';

        return view('reports.loan-pdf', compact('loans', 'customers', 'parameterNames', 'currentDate', 'totalLoan', 'totalPayable', 'totalRemain', 'totalInterest', 'totalIncome', 'file_pdf', 'type'));
    }

    public function loanDailyPdf(Request $request)
    {
        $query = Loan::query()->where('status', 2)->with('payments');
        $parameterNames = [];
        $currentDate = Carbon::now()->format('Y-m-d');
        $customers = Customer::pluck('name', 'id');
        $queryLoanPayment = LoanPayment::query();
        $loanPayments = $queryLoanPayment->get();
        // $query->whereDate('date', now()->toDateString());

        $filters = $request->only(['number', 'customer', 'from_date', 'to_date', 'select']);
        if ($request->search) {
            $parameterNames['search'] = true;
            if(!empty($filters['select'])){
                if($filters['select'] == 1){
                    $query->whereDate('date', now()->toDateString());

                }elseif($filters['select'] == 2){
                    $query->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);

                }elseif($filters['select'] == 3){
                    $query->whereMonth('date', now()->month);

                }elseif($filters['select'] == 4){
                    $query->whereYear('date', now()->year);
                }
                $parameterNames['select'] = $filters['select'];
            }else{
                if (!empty($filters['number'])) {
                    $query->where('id', 'like', '%' . $filters['number'] . '%');
                    $parameterNames['number'] = $filters['number'];
                }

                if (!empty($filters['customer'])) {
                    $query->where('customer_id', $filters['customer']);
                    $parameterNames['customer'] = $filters['customer'];
                }

                if (!empty($filters['from_date'])) {
                    $query->where('date', '>=', $filters['from_date']);
                    $parameterNames['from_date'] = $filters['from_date'];
                }

                if (!empty($filters['to_date'])) {
                    $query->where('date', '<=', $filters['to_date']);
                    $parameterNames['to_date'] = $filters['to_date'];
                }
            }
        }

        $totalLoan = 0;
        $totalPayable = 0;
        $totalRemain = 0;
        $totalInterest = 0;
        $totalIncome = 0;

        $loans = $query->orderBy('created_at', 'desc')->get();

        $file_pdf = 'reports-daily-loan'.$currentDate.'.pdf';
        $type = $request->type ?? 'print';

        return view('reports.loan-daily-pdf', compact('loans', 'loanPayments', 'customers', 'parameterNames', 'currentDate', 'totalLoan', 'totalPayable', 'totalRemain', 'totalInterest', 'totalIncome', 'file_pdf', 'type'));
    }

    public function listLoan(Request $request, string $lang, Loan $loan)
    {

        $payments = LoanPayment::get();
        $loanQuery = $loan->query();
        $customers = Customer::where('customer_type', 2)->get();
        $availableProducts = Product::available()->get();
        $statusOptions = Loan::STATUS;
        $currentNow = Carbon::now();
        $dueDate = \Carbon\Carbon::parse($loan->date ?? '')->addMonth(1);
        $currentDate = $currentNow->format('Y-m-d');


        $query = Loan::query()->where('status', 2)->with('payments');
        $parameterNames = [];
        $currentDate = Carbon::now()->format('Y-m-d');
        $customers = Customer::pluck('name', 'id');
        $queryLoanPayment = LoanPayment::query();
        $loanPayments = $queryLoanPayment->where('loan_id', $loan->id)->get();
        // $query->whereDate('date', now()->toDateString());

        $filters = $request->only(['number', 'customer', 'from_date', 'to_date', 'select']);
        if ($request->search) {
            $parameterNames['search'] = true;
            if(!empty($filters['select'])){
                if($filters['select'] == 1){
                    $query->whereDate('date', now()->toDateString());

                }elseif($filters['select'] == 2){
                    $query->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);

                }elseif($filters['select'] == 3){
                    $query->whereMonth('date', now()->month);

                }elseif($filters['select'] == 4){
                    $query->whereYear('date', now()->year);
                }
                $parameterNames['select'] = $filters['select'];
            }else{
                if (!empty($filters['number'])) {
                    $query->where('id', 'like', '%' . $filters['number'] . '%');
                    $parameterNames['number'] = $filters['number'];
                }

                if (!empty($filters['customer'])) {
                    $query->where('customer_id', $filters['customer']);
                    $parameterNames['customer'] = $filters['customer'];
                }

                if (!empty($filters['from_date'])) {
                    $query->where('date', '>=', $filters['from_date']);
                    $parameterNames['from_date'] = $filters['from_date'];
                }

                if (!empty($filters['to_date'])) {
                    $query->where('date', '<=', $filters['to_date']);
                    $parameterNames['to_date'] = $filters['to_date'];
                }
            }
        }

        $totalLoan = 0;
        $totalPayable = 0;
        $totalRemain = 0;
        $totalInterest = 0;
        $totalIncome = 0;

        $loans = $query->orderBy('created_at', 'desc')->get();
        
        $file_pdf = 'reports-daily-loan'.$currentDate.'.pdf';
        $type = $request->type ?? '';

        return view('reports.list-loan', compact('loans', 'loanPayments', 'customers', 'parameterNames', 'currentDate', 'totalLoan', 'totalPayable', 'totalRemain', 'totalInterest', 'totalIncome', 'file_pdf', 'type'));
    }

    public function profitLoss(Request $request)
    {
        $query = Order::query();
        $expenseQuery = Expense::query();
        $loanPaymentQuery = LoanPayment::query()->whereHas('loan', function ($query) {
            $query->whereNotNull('loan_id')->where('loans.status', 2);
        });
        $loanQuery = Loan::query()->where('status', 2);
        $parameterNames = [];
        $currentDate = now()->format('Y-m-d');
        $years = DB::table('orders')
            ->select(DB::raw('YEAR(order_date) as order_year'))
            ->distinct()
            ->orderBy('order_year', 'desc')
            ->get();
        $filters = $request->only(['select', 'year', 'from_date', 'to_date']);
        if ($request->search) {
            $parameterNames['search'] = true;
            if(!empty($filters['select'])){
                if($filters['select'] == 1){
                    $query->whereDate('order_date', now()->toDateString());
                    $loanPaymentQuery->whereDate('created_at', now()->toDateString());
                    $expenseQuery->whereDate('date', now()->toDateString());
                    $loanQuery->whereDate('date', now()->toDateString());

                }elseif($filters['select'] == 2){
                    $query->whereBetween('order_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    $loanPaymentQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    $expenseQuery->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);

                }elseif($filters['select'] == 3){
                    $query->whereMonth('order_date', now()->month);
                    $loanPaymentQuery->whereMonth('created_at', now()->month);
                    $expenseQuery->whereMonth('date', now()->month);
                    $loanQuery->whereMonth('date', now()->month);

                }elseif($filters['select'] == 4){
                    $query->whereYear('order_date', now()->year);
                    $loanPaymentQuery->whereYear('created_at', now()->year);
                    $expenseQuery->whereYear('date', now()->year);
                    $loanQuery->whereYear('date', now()->year);
                }
                $parameterNames['select'] = $filters['select'];
            }elseif (!empty($filters['year'])) {
                $query->whereYear('order_date', $filters['year']);
                $loanPaymentQuery->whereYear('created_at', $filters['year']);
                $expenseQuery->whereYear('date', $filters['year']);
                $loanQuery->whereYear('date', $filters['year']);
                $parameterNames['year'] = $filters['year'];
            }elseif(!empty($filters['from_date']) ||!empty($filters['to_date']) ){
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

        $totalOrderAmount = $query->sum('total_amount');
        $totalLoanPaymentIncome = $loanPaymentQuery->sum('amount');
        $loanPhoneProfit = $loanQuery->sum('phone_profit');
        $totalExpense = $expenseQuery->sum('amount');
        $totalProfit = ($totalLoanPaymentIncome + $totalOrderAmount + $loanPhoneProfit) - $totalExpense;

        return view('reports.profit-loss', compact(
        'parameterNames',
        'currentDate',
        'totalExpense',
        'totalLoanPaymentIncome',
        'totalOrderAmount',
        'loanPhoneProfit',
        'totalProfit',
        'years'
        ));
    }

    public function profitLossPdf(Request $request)
    {
        $query = Order::query();
        $expenseQuery = Expense::query();
        $loanPaymentQuery = LoanPayment::query()->whereHas('loan', function ($query) {
            $query->whereNotNull('loan_id')->where('loans.status', 2);
        });

        $parameterNames = [];
        $currentDate = Carbon::now()->format('Y-m-d');

        $filters = $request->only(['select', 'year', 'from_date', 'to_date']);
        if ($request->search) {
            $parameterNames['search'] = true;
            if(!empty($filters['select'])){
                if($filters['select'] == 1){
                    $query->whereDate('order_date', now()->toDateString());
                    $loanPaymentQuery->whereDate('date', now()->toDateString());
                    $expenseQuery->whereDate('date', now()->toDateString());

                }elseif($filters['select'] == 2){
                    $query->whereBetween('order_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    $loanPaymentQuery->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);
                    $expenseQuery->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);

                }elseif($filters['select'] == 3){
                    $query->whereMonth('order_date', now()->month);
                    $loanPaymentQuery->whereMonth('date', now()->month);
                    $expenseQuery->whereMonth('date', now()->month);

                }elseif($filters['select'] == 4){
                    $query->whereYear('order_date', now()->year);
                    $loanPaymentQuery->whereYear('date', now()->year);
                    $expenseQuery->whereYear('date', now()->year);
                }
                $parameterNames['select'] = $filters['select'];
            }elseif (!empty($filters['year'])) {
                $query->whereYear('order_date', $filters['year']);
                $loanPaymentQuery->whereYear('date', $filters['year']);
                $expenseQuery->whereYear('date', $filters['year']);
                $parameterNames['year'] = $filters['year'];
            }elseif(!empty($filters['from_date']) ||!empty($filters['to_date']) ){
                if (!empty($filters['from_date'])) {
                    $query->where('order_date', '>=', $filters['from_date']);
                    $loanPaymentQuery->where('date', '>=', $filters['from_date']);
                    $expenseQuery->where('date', '>=', $filters['from_date']);
                    $parameterNames['from_date'] = $filters['from_date'];
                }

                if (!empty($filters['to_date'])) {
                    $query->where('order_date', '<=', $filters['to_date']);
                    $loanPaymentQuery->where('date', '<=', $filters['to_date']);
                    $expenseQuery->where('date', '<=', $filters['to_date']);
                    $parameterNames['to_date'] = $filters['to_date'];
                }
            }
        }

        $totalOrderAmount = $query->sum('total_amount');
        $totalLoanPaymentIncome = $loanPaymentQuery->sum('amount');
        $totalExpense = $expenseQuery->sum('amount');
        $totalProfit = ($totalLoanPaymentIncome + $totalOrderAmount) - $totalExpense;

        $file_pdf = 'reports-profit-loss-'.$currentDate.'.pdf';
        $type = $request->type ?? 'download';

        return view('reports.profit-loss-pdf', compact('parameterNames', 'currentDate', 'totalExpense', 'totalLoanPaymentIncome', 'totalOrderAmount', 'totalProfit', 'file_pdf', 'type'));
    }

    public function product(Request $request)
    {
        $query = Product::query();
        $parameterNames = [];
        if ($request->search) {
          $parameterNames['search'] = true;
          $filters = $request->only(['name', 'from_date', 'to_date', 'select']);
          if(!empty($filters['select'])){
              if($filters['select'] == 1){
                  $query->whereDate('purchase_date', now()->toDateString());

              }elseif($filters['select'] == 2){
                  $query->whereBetween('purchase_date', [now()->startOfWeek(), now()->endOfWeek()]);

              }elseif($filters['select'] == 3){
                  $query->whereMonth('purchase_date', now()->month);

              }elseif($filters['select'] == 4){
                  $query->whereYear('purchase_date', now()->year);
              }
              $parameterNames['select'] = $filters['select'];
          }else{
              if (!empty($filters['name'])) {
                  $query->where('name', 'like', '%' . $filters['name'] . '%');
                  $parameterNames['name'] = $filters['name'];
              }

              if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
                  $query->whereBetween('purchase_date', [$filters['from_date'], $filters['to_date']]);
                  $parameterNames['from_date'] = $filters['from_date'];
                  $parameterNames['to_date'] = $filters['to_date'];
              } elseif (!empty($filters['from_date'])) {
                  $query->where('purchase_date', '>=', $filters['from_date']);
                  $parameterNames['from_date'] = $filters['from_date'];
              } elseif (!empty($filters['to_date'])) {
                  $query->where('purchase_date', '<=', $filters['to_date']);
                  $parameterNames['to_date'] = $filters['to_date'];
              }
          }
        }else{
          $query->whereDate('purchase_date', now()->toDateString());
        }

        $totalProduct = $query->count();
        $totalSellingPrice = $query->sum('selling_price');
        $totalPurchasePrice = $query->sum('purchase_price');
        $products = $query->paginate(2);
        $totalProductConditionNew = $query->where('condition', Product::CONDITION_NEW)->count();

        return view('reports.product', [
            'products' => $products,
            'totalProduct' => $totalProduct,
            'totalSellingPrice' => $totalSellingPrice,
            'totalPurchasePrice' => $totalPurchasePrice,
            'totalProductConditionNew' => $totalProductConditionNew,
            'parameterNames' => $parameterNames,
        ]);
    }

    public function productPdf(Request $request)
    {
      $query = Product::query();
      $parameterNames = [];
      if ($request->search) {
        $parameterNames['search'] = true;
        $filters = $request->only(['name', 'from_date', 'to_date', 'select']);
        if(!empty($filters['select'])){
            if($filters['select'] == 1){
                $query->whereDate('purchase_date', now()->toDateString());

            }elseif($filters['select'] == 2){
                $query->whereBetween('purchase_date', [now()->startOfWeek(), now()->endOfWeek()]);

            }elseif($filters['select'] == 3){
                $query->whereMonth('purchase_date', now()->month);

            }elseif($filters['select'] == 4){
                $query->whereYear('purchase_date', now()->year);
            }
            $parameterNames['select'] = $filters['select'];
        }else{
            if (!empty($filters['name'])) {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
                $parameterNames['name'] = $filters['name'];
            }

            if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
                $query->whereBetween('purchase_date', [$filters['from_date'], $filters['to_date']]);
                $parameterNames['from_date'] = $filters['from_date'];
                $parameterNames['to_date'] = $filters['to_date'];
            } elseif (!empty($filters['from_date'])) {
                $query->where('purchase_date', '>=', $filters['from_date']);
                $parameterNames['from_date'] = $filters['from_date'];
            } elseif (!empty($filters['to_date'])) {
                $query->where('purchase_date', '<=', $filters['to_date']);
                $parameterNames['to_date'] = $filters['to_date'];
            }
        }
    }else{
      $query->whereDate('purchase_date', now()->toDateString());
    }

      $totalProduct = $query->count();
      $totalSellingPrice = $query->sum('selling_price');
      $totalPurchasePrice = $query->sum('purchase_price');
      $products = $query->get();
      $totalProductConditionNew = $query->where('condition', Product::CONDITION_NEW)->count();
      $currentNow = Carbon::now();
      $currentDate = $currentNow->format('Y-m-d');
      $file_pdf = 'reports-product-'.$currentDate.'.pdf';
      $type = $request->type ?? 'download';

        return view('reports.product-pdf', [
            'products' => $products,
            'totalProduct' => $totalProduct,
            'totalSellingPrice' => $totalSellingPrice,
            'totalPurchasePrice' => $totalPurchasePrice,
            'totalProductConditionNew' => $totalProductConditionNew,
            'parameterNames' => $parameterNames,
            'file_pdf' => $file_pdf,
            'type' => $type,
            'currentDate' => $currentDate
        ]);
    }
}
