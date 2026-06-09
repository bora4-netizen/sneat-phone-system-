 <?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LoanPaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\ModelTypeController;
use App\Http\Controllers\SerialController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\NetworkController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Auth::routes();
Route::get('/', HomeController::class)->name('home');
Route::group([
  'prefix' => '{lang}',
  'where' => ['lang' => 'kh|en'],
  'middleware' => [ 'auth' , 'language' ]], function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    //Report Route
    Route::group(['prefix'=>'report','as'=>'reports.'], function(){
      Route::get('/stock', [ReportController::class, 'stock'])->name('stock');
      Route::get('/stock/pdf', [ReportController::class, 'stockPdf'])->name('stock.pdf');
      Route::get('/expense', [ReportController::class, 'expense'])->name('expense');
      Route::get('/expense/pdf', [ReportController::class, 'expensePdf'])->name('expense.pdf');
      Route::get('/sale', [ReportController::class, 'sale'])->name('sale');
      Route::get('/sale/pdf', [ReportController::class, 'salePdf'])->name('sale.pdf');
      Route::get('/loan', [ReportController::class, 'loan'])->name('loan');
      Route::get('/loan/pdf', [ReportController::class, 'loanPdf'])->name('loan.pdf');
      Route::get('/loan/daily-pdf', [ReportController::class, 'loanDailyPdf'])->name('loan.daily-pdf');
      Route::get('/profit-loss', [ReportController::class, 'profitLoss'])->name('profit-loss');
      Route::get('/profit-loss/pdf', [ReportController::class, 'profitLossPdf'])->name('profit-loss.pdf');
      Route::get('/product', [ReportController::class, 'product'])->name('product');
      Route::get('/product/pdf', [ReportController::class, 'productPdf'])->name('product.pdf');
      Route::get('/loan/list-loan', [ReportController::class, 'listLoan'])->name('loan.list-loan');
    });
    // Route::get('roles', RoleController::class);
    // Route::get('products', ProductController::class);
    // Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::resource('roles', RoleController::class);
    
    Route::resource('products', ProductController::class);
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');


    // Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::group(['prefix'=>'products','as'=>'products.'], function(){
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/store', [ProductController::class, 'store'])->name('store');

    Route::get('/show/{product}', [ProductController::class, 'show'])->name('show');
    Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('edit');
    // Route::post('/update/{product}', [ProductController::class, 'update'])->name('update');
    Route::put('/update/{product}', [ProductController::class, 'update'])->name('update');
    Route::delete('/destroy/{product}', [ProductController::class, 'destroy'])->name('destroy');
});
    Route::group(['prefix'=>'user','as'=>'users.'], function(){
        Route::get('/', [EmployeeController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [EmployeeController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [EmployeeController::class, 'destroy'])->name('destroy');
        Route::get('/password/edit/{id}', [EmployeeController::class, 'editPassword'])->name('edit.password');
        Route::post('/password/update/{id}', [EmployeeController::class, 'updatePassword'])->name('update.password');
        Route::get('/profile', [UserController::class, 'edit'])->name('edit.profile');
        Route::post('/profile/update', [UserController::class, 'update'])->name('update.profile');
        Route::get('/profile/edit/password', [UserController::class, 'editPassword'])->name('edit.profile.password');
        Route::post('/profile/update/password', [UserController::class, 'updatePassword'])->name('update.profile.password');
    });
    // Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::group(['prefix'=>'products','as'=>'products.'], function(){
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/store', [ProductController::class, 'store'])->name('store');
});
    Route::group(['prefix'=>'user','as'=>'users.'], function(){
        Route::get('/', [EmployeeController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [EmployeeController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [EmployeeController::class, 'destroy'])->name('destroy');
 Route::get('/password/edit/{id}', [EmployeeController::class, 'editPassword'])->name('edit.password');
        Route::post('/password/update/{id}', [EmployeeController::class, 'updatePassword'])->name('update.password');
        Route::get('/profile', [UserController::class, 'edit'])->name('edit.profile');
        Route::post('/profile/update', [UserController::class, 'update'])->name('update.profile');
        Route::get('/profile/edit/password', [UserController::class, 'editPassword'])->name('edit.profile.password');
        Route::post('/profile/update/password', [UserController::class, 'updatePassword'])->name('update.profile.password');
    });
    // Route::group(['prefix'=>'order','as'=>'orders.'], function(){
    //   Route::get('/', [OrderController::class, 'index'])->name('index');
    // });
    Route::group(['prefix'=>'order','as'=>'orders.'], function(){
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/create', [OrderController::class, 'create'])->name('create');
    Route::post('/store', [OrderController::class, 'store'])->name('store');
});


    // Route::group(['prefix'=>'sale','as'=>'sales.'], function(){
    //   Route::get('/', [OrderController::class, 'index'])->name('index');
     
    // });

    Route::group(['prefix'=>'sale','as'=>'sales.'], function(){
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/create', [OrderController::class, 'create'])->name('create');
    Route::post('/store', [OrderController::class, 'store'])->name('store');
   });
    Route::group(['prefix'=>'cart','as'=>'carts.'], function(){
      Route::post('/store', [CartController::class, 'store'])->name('store');
      Route::delete('/destroy', [CartController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix'=>'expense','as'=>'expenses.'], function(){
      Route::get('/', [ExpenseController::class, 'index'])->name('index');
      Route::get('/create', [ExpenseController::class, 'create'])->name('create');
      Route::post('/store', [ExpenseController::class, 'store'])->name('store');
      Route::get('{expense}/edit', [ExpenseController::class, 'edit'])->name('edit');
      Route::patch('/{expense}', [ExpenseController::class, 'update'])->name('update');
      Route::delete('/{expense}', [ExpenseController::class, 'destroy'])->name('destroy');
      Route::group(['prefix'=>'category','as'=>'categories.'], function(){
        Route::get('/', [ExpenseCategoryController::class, 'index'])->name('index');
        Route::get('/create', [ExpenseCategoryController::class, 'create'])->name('create');
        Route::post('/store', [ExpenseCategoryController::class, 'store'])->name('store');
        Route::get('/edit/{sale}', [ExpenseCategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{sale}', [ExpenseCategoryController::class, 'update'])->name('update');
      });
    });
 Route::group(['prefix'=>'model-type','as'=>'model_type.'], function(){
        Route::get('/', [ModelTypeController::class, 'index'])->name('index');
        Route::get('/create', [ModelTypeController::class, 'create'])->name('create');
        Route::post('/store', [ModelTypeController::class, 'store'])->name('store');
        Route::post('/update', [ModelTypeController::class, 'update'])->name('update');
    });
    Route::group(['prefix'=>'network','as'=>'network.'], function(){
      Route::get('/', [NetworkController::class, 'index'])->name('index');
      Route::get('/create', [NetworkController::class, 'create'])->name('create');
      Route::post('/store', [NetworkController::class, 'store'])->name('store');
      Route::post('/update', [NetworkController::class, 'update'])->name('update');
    });
    Route::group(['prefix'=>'serial','as'=>'serial.'], function(){
        Route::get('/', [SerialController::class, 'index'])->name('index');
        Route::get('/create', [SerialController::class, 'create'])->name('create');
        Route::post('/store', [SerialController::class, 'store'])->name('store');
        Route::post('/update', [SerialController::class, 'update'])->name('update');
    });
    Route::group(['prefix'=>'brand', 'as'=>'brand.'], function(){
        Route::get('/', [BrandController::class, 'index'])->name('index');
        Route::get('/create', [BrandController::class, 'create'])->name('create');
        Route::post('/store', [BrandController::class, 'store'])->name('store');
        Route::post('/update', [BrandController::class, 'update'])->name('update');
    });
    Route::group(['prefix'=>'color', 'as'=>'color.'], function(){
        Route::get('/', [ColorController::class, 'index'])->name('index');
        Route::get('/create', [ColorController::class, 'create'])->name('create');
        Route::post('/store', [ColorController::class, 'store'])->name('store');
        Route::post('/update', [ColorController::class, 'update'])->name('update');
    });
    Route::group(['prefix'=>'storage', 'as'=>'storage.'], function(){
        Route::get('/', [StorageController::class, 'index'])->name('index');
        Route::get('/create', [StorageController::class, 'create'])->name('create');
        Route::post('/store', [StorageController::class, 'store'])->name('store');
        Route::post('/update', [StorageController::class, 'update'])->name('update');
    });
    Route::group(['prefix'=>'loan','as'=>'loans.'], function(){
      Route::get('/', [LoanController::class, 'index'])->name('index');
      Route::get('/create', [LoanController::class, 'create'])->name('create');
      Route::post('/', [LoanController::class, 'store'])->name('store');
      Route::get('/{loan}/edit', [LoanController::class, 'edit'])->name('edit');
      Route::put('/{loan}', [LoanController::class, 'update'])->name('update');
      Route::delete('/{loan}', [LoanController::class, 'destroy'])->name('destroy');
      Route::get('{loan}/invoice/', [LoanController::class, 'invoice'])->name('invoice');
      Route::get('{loan}/invoice/pdf', [LoanController::class, 'invoicePdf'])->name('invoice.pdf');
      Route::get('{loan}/agreement/', [LoanController::class, 'agreement'])->name('agreement');
      Route::group(['prefix'=>'payment','as'=>'payments.'], function(){
        Route::get('/', [LoanPaymentController::class, 'index'])->name('index');
        Route::get('/create', [LoanPaymentController::class, 'create'])->name('create');
        Route::post('/', [LoanPaymentController::class, 'store'])->name('store');
        Route::get('/{loanPayment}/edit', [LoanPaymentController::class, 'edit'])->name('edit');
        Route::get('/{loanPayment}/invoice', [LoanPaymentController::class, 'invoice'])->name('invoice');
        Route::get('/{loanPayment}/invoice/pdf', [LoanPaymentController::class, 'invoicePdf'])->name('invoice.pdf');
        Route::put('/{loanPayment}', [LoanPaymentController::class, 'update'])->name('update');
        Route::delete('/{loanPayment}', [LoanPaymentController::class, 'destroy'])->name('destroy');
 Route::get('{loan}/list', [LoanController::class, 'list'])->name('list');
        Route::get('/{loan}/pdf', [LoanController::class,'pdf'])->name('pdf');
        Route::get('/late', [LoanPaymentController::class, 'late'])->name('late');
      });
    });
    Route::group(['prefix'=>'customer','as'=>'customers.'], function(){
      Route::get('/', [CustomerController::class, 'index'])->name('index');
      Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('edit');
      Route::get('/create', [CustomerController::class, 'create'])->name('create');
      Route::get('/show/{id}', [CustomerController::class, 'show'])->name('show');
      Route::post('/store', [CustomerController::class, 'store'])->name('store');
      Route::post('/update/{id}', [CustomerController::class, 'update'])->name('update');
      Route::delete('/destroy/{id}', [CustomerController::class, 'destroy'])->name('destroy');
      Route::get('/password/edit/{id}', [CustomerController::class, 'editPassword'])->name('edit.password');
      Route::post('/password/update/{id}', [CustomerController::class, 'updatePassword'])->name('update.password');
      Route::get('/profile', [CustomerController::class, 'edit'])->name('edit.profile');
      Route::post('/profile/update', [CustomerController::class, 'update'])->name('update.profile');
      Route::get('/profile/edit/password', [CustomerController::class, 'editPassword'])->name('edit.profile.password');
      Route::post('/profile/update/password', [CustomerController::class, 'updatePassword'])->name('update.profile.password');

      Route::group(['prefix'=>'gurantor', 'as'=>'gurantors.'], function(){
        Route::get('/', [CustomerController::class, 'index'])->name('index');
      });
  });
    Route::get('series/brand/{id}', [ProductController::class, 'getSeriesBybrand'])->name('get-series');
    Route::get('products/check/{id}', [ProductController::class, 'getProductById'])->name('get-product-by-id');
    Route::get('company/', [CompanySettingController::class, 'index'])->name('company.index');
    Route::put('company/', [CompanySettingController::class, 'update'])->name('company.update');
});