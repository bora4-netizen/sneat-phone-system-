<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Loan;
use App\Models\LoanPayment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:report-list', ['only' => ['index','report']]);
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(Request $request)
    {
        return redirect()->route('dashboard', $request->cookie('locale') ?? app()->getLocale());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
      $currentYear = date('Y');
      if($request->year){
        $currentYear = $request->year;
      }

      $years = DB::table('orders')
            ->select(DB::raw('YEAR(order_date) as order_year'))
            ->distinct()
            ->orderBy('order_year', 'desc')
            ->get();
      $totalExpense = Expense::whereYear('date', $currentYear)->sum('amount');
      $totalOrderIncome = Order::whereYear('order_date', $currentYear)->whereNull('deleted_at')->sum('total_amount');
      $totalLoanPaymentIncome = LoanPayment::whereYear('date', $currentYear)->whereHas('loan', function ($query) {
        $query->whereNotNull('loan_id')->where('loans.status', 2);
      })->sum('amount');

      $totalIncome = $totalOrderIncome + $totalLoanPaymentIncome;
      $totalProfit = $totalIncome - $totalExpense;
      $getRevenue = $this->setTotalRevenue($currentYear);

      if ($getRevenue['monthlyDifferenceLastYear']['total'] != 0) {
        $percentageChange = (($getRevenue['monthlyDifference']['total'] - $getRevenue['monthlyDifferenceLastYear']['total']) / $getRevenue['monthlyDifferenceLastYear']['total']) * 100;
      } else {$percentageChange = 0;
      }
      $orders = Order::limit(5)->orderBy('order_date', 'desc')->get();
      // $loanPayments = 0;
      // $loans = 0;
        $loanPayments = LoanPayment::with('loan.customer')->latest()->limit(5)->get();
        $loans = Loan::latest() ->limit(5)->get();
      $lateLoans = Loan::has('customer')->with('customer')->latePayment()->limit(5)->orderBy('next_payment_date', 'desc')->get();

      return view('home', [
        'totalExpense' => $totalExpense,
        'totalIncome' => $totalIncome,
        'totalLoanPaymentIncome' => $totalLoanPaymentIncome,
        'totalProfit' => $totalProfit,
        'monthlyDifferenceLastYear' => $getRevenue['monthlyDifferenceLastYear'],
        'monthlyDifference' => $getRevenue['monthlyDifference'],
        'percentageChange' => $percentageChange,
        'currentYear' => $currentYear,
        'years' => $years,
        'orders' => $orders,
        'loanPayments' => $loanPayments,
        'lateLoans' => $lateLoans,
        'loans' => $loans
        ]);
    }

    public function setTotalRevenue($currentYear)
    {
      $lastYear = $currentYear - 1;
      $currentYearData = DB::table('orders')
          ->select(DB::raw('MONTH(order_date) as month'), DB::raw('SUM(total_amount) as total_amount'))
          ->whereYear('order_date', $currentYear)
          ->groupBy(DB::raw('MONTH(order_date)'))
          ->whereNull('deleted_at')
          ->get();

      $lastYearData = DB::table('orders')
          ->select(DB::raw('MONTH(order_date) as month'), DB::raw('SUM(total_amount) as total_amount'))
          ->whereYear('order_date', $lastYear)
          ->groupBy(DB::raw('MONTH(order_date)'))
          ->whereNull('deleted_at')
          ->get();

      $currentYearLoanPayments = DB::table('loan_payments')
          ->select(DB::raw('MONTH(date) as month'), DB::raw('SUM(amount) as total_amount'))
          ->whereYear('date', $currentYear)
          ->groupBy(DB::raw('MONTH(date)'))
          ->get();

      $lastYearLoanPayments = DB::table('loan_payments')
          ->select(DB::raw('MONTH(date) as month'), DB::raw('SUM(amount) as total_amount'))
          ->whereYear('date', $lastYear)
          ->groupBy(DB::raw('MONTH(date)'))
          ->get();

        $currentYearData = $currentYearData->pluck('total_amount', 'month')->toArray();
        $lastYearData = $lastYearData->pluck('total_amount', 'month')->toArray();
        $currentYearLoanPayments = $currentYearLoanPayments->pluck('total_amount', 'month')->toArray();
        $lastYearLoanPayments = $lastYearLoanPayments->pluck('total_amount', 'month')->toArray();

        $dataCurrentYear = ['name' => $currentYear ,'data' => [], 'total' => 0];
        $dataLastYear = ['name' => $lastYear ,'data' => [], 'total' => 0];

        for ($i = 1; $i <= 12; $i++) {
          $setCurrentYearLoanPayment = 0;
          $setcurrentYearData = 0;
          if(isset($currentYearLoanPayments[$i])){
            $setCurrentYearLoanPayment = number_format(round($currentYearLoanPayments[$i], 2), 2, '.', '');
          }
          if(isset($currentYearData[$i])){
            $setcurrentYearData = number_format(round($currentYearData[$i], 2), 2, '.', '');
          }

          $dataCurrentYear['data'][] = ($setcurrentYearData ?? 0) + ($setCurrentYearLoanPayment ?? 0);
          $dataCurrentYear['total'] += ($currentYearData[$i] ?? 0) + ($setCurrentYearLoanPayment ?? 0);
      }

      for ($i = 1; $i <= 12; $i++) {
          $dataLastYear['data'][] = ($lastYearData[$i] ?? 0) + ($lastYearLoanPayments[$i] ?? 0);
          $dataLastYear['total'] += ($lastYearData[$i] ?? 0) + ($lastYearLoanPayments[$i] ?? 0);
      }
      return array('monthlyDifference' => $dataCurrentYear, 'monthlyDifferenceLastYear' => $dataLastYear);
    }
}
