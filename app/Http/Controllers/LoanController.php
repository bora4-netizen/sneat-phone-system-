<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanDetail;
use App\Models\LoanPayment;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class LoanController extends Controller
{
  function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:loan-list|loan-create|loan-edit|loan-delete', ['only' => ['index','store']]);
        $this->middleware('permission:loan-create', ['only' => ['create','store']]);
        $this->middleware('permission:loan-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:loan-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the loans.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Loan::query();
    }

    /**
     * Show the form for creating a new loan.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $currentNow = Carbon::now();
      $currentDate = $currentNow->format('d/m/Y');
      $customers = Customer::loanable()->get();
      $availableProducts = Product::available()->get();
      $statusOptions = Loan::STATUS;
      $defaultNote = Loan::latest()->first()->id ?? 0;

      return view('loans.create', compact('currentDate', 'customers', 'availableProducts', 'statusOptions', 'defaultNote'));
    }

    /**
     * Store a newly created loan in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $employeeId = Auth::user()->id;
        $request->merge(["employee_id"=> $employeeId]);
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'employee_id' => 'required|exists:employees,id',
            'product_id' => 'required|exists:products,id',
            'amount' => 'required',
            'first_amount' => 'required',
            'interest' => 'required',
            'duration' => 'required|not_in:0',
            'amount_principal' => 'required',
            'amount_interest' => 'required',
            'payable_amount' => 'required',
            'date' => 'required|date',
            'status' => 'required',
            'customer_id_card' => 'required',
            'customer_family_book' => 'required',
            'customer_birth_certificate' => 'required',
            'guarantor_id_card' => 'required',
            'guarantor_family_book' => 'required',
            'guarantor_birth_certificate' => 'required',
        ]);

        $loanDocumentData = [
          'customer_id_card' => $request->customer_id_card,
          'customer_family_book' => $request->customer_family_book,
          'customer_birth_certificate' => $request->customer_birth_certificate,
          'customer_other' => $request->customer_other,
          'guarantor_id_card' => $request->guarantor_id_card,
          'guarantor_family_book' => $request->guarantor_family_book,
          'guarantor_birth_certificate' => $request->guarantor_birth_certificate,
          'guarantor_other' => $request->guarantor_other,
        ];

        $data['note'] = $request->note;
        $data['remain'] = $request->payable_amount;
        $data['interest_remain'] = $request->duration * $request->amount_interest;
        $nextPaymentDate = date('Y-m-d', strtotime($request->date . ' +1 month'));
        $data['next_payment_date'] = $nextPaymentDate;
        $loan = Loan::create($data);
        $purchasedPrice = $loan->product->purchase_price;
        $soldPrice = $loan->product->selling_price;
        $phoneProfit = $soldPrice - $purchasedPrice;
        $data['phone_profit'] = $phoneProfit;
        $loan->update($data);
        if ($file = $request->file('file')) {
          $zipFileName = $this->uploadFileZip($loan, $file );
          $loan->file = $zipFileName;
          $loan->save();
        }
        $loan->product->update(['status' => Product::STATUS_ID_SOLD]);
        $loan->document()->create(
          $loanDocumentData
        );

        return redirect()->route('loans.invoice', withLang(['loan' => $loan->id]))->with('success', 'Loan created successfully');
    }

    /**
     * Show the form for editing the specified loan.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(string $lang, Loan $loan)
    {
      $customers = Customer::all();
      $availableProducts = Product::available()->get();
      $statusOptions = Loan::STATUS;;

      $currentNow = now();
      $currentDate = $currentNow->format('Y-m-d');
      $amountUpdate = LoanPayment::where('loan_id', $loan->id)->count();

      return view('loans.edit', compact('loan', 'customers', 'availableProducts', 'statusOptions', 'currentDate', 'amountUpdate'));
    }

    /**
     * Update the specified loan in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $lang, Loan $loan)
    {
        $data = $request->validate([
          'customer_id' => 'required|exists:customers,id',
          'product_id' => 'required|exists:products,id',
          'amount' => 'required',
          'first_amount' => 'required',
          'interest' => 'required',
          'duration' => 'required',
          'amount_principal' => 'required',
          'amount_interest' => 'required',
          'payable_amount' => 'required',
          'next_payment_date' => 'required|date',
          'status' => 'required',
          'customer_id_card' => 'required',
          'customer_family_book' => 'required',
          'customer_birth_certificate' => 'required',
          'guarantor_id_card' => 'required',
          'guarantor_family_book' => 'required',
          'guarantor_birth_certificate' => 'required',
        ]);

      $loanDocumentData = [
        'customer_id_card' => $request->customer_id_card,
        'customer_family_book' => $request->customer_family_book,
        'customer_birth_certificate' => $request->customer_birth_certificate,
        'customer_other' => $request->customer_other,
        'guarantor_id_card' => $request->guarantor_id_card,
        'guarantor_family_book' => $request->guarantor_family_book,
        'guarantor_birth_certificate' => $request->guarantor_birth_certificate,
        'guarantor_other' => $request->guarantor_other,
      ];

      $data['note'] = $request->note;
      $data['remain'] = $request->payable_amount;
      $data['interest_remain'] = $request->duration * $request->amount_interest;
      $loan->update($data);

      $loan->document()->update(
        $loanDocumentData
      );

      // Create or update the LoanDetail model
      $loanDetail = $loan->loanDetail()->create([
          'product_id' => $data['product_id'],
          'customer_id' => $data['customer_id'],
          'employee_id' => auth()->user()->id, // Assuming you want to associate the current user as the employee
          'status' => $data['status'],
          'amount' => $data['amount'],
          'first_amount' => $data['first_amount'],
          'interest' => $data['interest'],
          'duration' => $data['duration'],
          'date' => $data['next_payment_date'],
        ]);

        return redirect()->route('loans.index', withLang())->with('success', 'Loan updated successfully');
    }

    /**
     * Remove the specified loan from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $lang, Loan $loan)
    {
      // Delete related loan details
      $loan->loanDetails->each(function ($loanDetail) {
        $loanDetail->delete();
      });

      $loan->product->update(['status' => PRODUCT::STATUS_ID_AVAILABLE]);

      // Delete related payments
      $loan->payments->each(function ($payment) {
        $payment->delete();
      });

      // Delete the loan itself
      $loan->delete();

      return redirect()->route('loans.index', withLang())->with('success', 'Loan deleted successfully');
    }

    public function list(string $lang, Loan $loan)
    {
      $payments = LoanPayment::where('loan_id', $loan->id)->get();
      $customers = Customer::all();
      $availableProducts = Product::available()->get();
      $statusOptions = Loan::STATUS;
      $currentNow = Carbon::now();
      $currentDate = $currentNow->format('Y-m-d');
      return view('loans.payments.list', compact('loan', 'customers', 'availableProducts', 'statusOptions', 'currentDate', 'payments'));
    }

    public function pdf(Request $request,string $lang, Loan $loan)
    {
        $payments = LoanPayment::where('loan_id', $loan->id)->get();
        $customers = Customer::all();
        $availableProducts = Product::available()->get();
        $statusOptions = Loan::STATUS;
        $currentNow = Carbon::now();
        $currentDate = $currentNow->format('Y-m-d');
        $file_pdf = 'loan-payment-'.str_pad($loan->id, 5, '0', STR_PAD_LEFT).'.pdf';
        $type = $request->type ?? 'download';

        return view('loans.payments.pdf', compact('loan', 'customers', 'availableProducts', 'statusOptions', 'currentDate', 'payments', 'file_pdf', 'type'));
    }

    public function invoice(string $lang, Loan $loan)
    {
      $payments = LoanPayment::where('loan_id', $loan->id)->get();
      $customers = Customer::all();
      $availableProducts = Product::available()->get();
      $statusOptions = Loan::STATUS;
      $currentNow = Carbon::now();
      $currentDate = $currentNow->format('Y-m-d');
      return view('loans.invoice', compact('loan', 'customers', 'availableProducts', 'statusOptions', 'currentDate', 'payments'));
    }

    public function invoicePdf(Request $request,string $lang, Loan $loan)
    {
        $payments = LoanPayment::where('loan_id', $loan->id)->get();
        $customers = Customer::all();
        $availableProducts = Product::available()->get();
        $statusOptions = Loan::STATUS;
        $currentNow = Carbon::now();
        $currentDate = $currentNow->format('Y-m-d');
        $file_pdf = 'loan-payment-'.str_pad($loan->id, 5, '0', STR_PAD_LEFT).'.pdf';
        $type = $request->type ?? 'download';

        return view('loans.invoice-pdf', compact('loan', 'customers', 'availableProducts', 'statusOptions', 'currentDate', 'payments', 'file_pdf', 'type'));
    }
    public function uploadFileZip($loan, $file)
    {
        $originalName = $file->getClientOriginalName();
        $password = '1234';
         // Create a temporary directory to extract the contents of the ZIP file
         $tempDirectory = storage_path('app/temp_zip_extraction');
         Storage::makeDirectory($tempDirectory);
         $file->move($tempDirectory, $originalName);
         // Create a new ZIP archive
        $zip = new ZipArchive();
        $formattedNumber = str_pad($loan->id, 5, '0', STR_PAD_LEFT);
        $zipFileName = 'files/loan/'.$formattedNumber. "_" .md5(time()) . '.zip';

        if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $files = Storage::allFiles('temp_zip_extraction');
            foreach ($files as $file) {
                $zip->addFile(storage_path('app/' . $file), basename($file));
            }

            $zip->setPassword($password);
            $zip->close();
            Storage::deleteDirectory('temp_zip_extraction');
            return $zipFileName;
        } else {
            Storage::deleteDirectory('temp_zip_extraction');

            return response()->json(['error' => 'Failed to create ZIP file'], 500);
        }
    }

    public function agreement(string $lang, Loan $loan)
    {
      $payments = LoanPayment::where('loan_id', $loan->id)->get();
      $customers = Customer::all();
      $availableProducts = Product::available()->get();
      $statusOptions = Loan::STATUS;
      $currentNow = Carbon::now();
      $currentDate = $currentNow->format('Y-m-d');
      return view('loans.agreement', compact('loan', 'customers', 'availableProducts', 'statusOptions', 'currentDate', 'payments'));
    }
}
