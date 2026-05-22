<?php

namespace App\Providers;

use App\Models\CompanySetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Loan;
use Carbon\Carbon;


class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hastable('company_settings')) {
            $company  = (new CompanySetting())->first();
            $query = Loan::query()->where('next_payment_date', '<', Carbon::now()->subDays(7)->toDateString());
            $overdueLoans = $query->take(5)->get();
            $countOverdueLoans = $query->count();


            View::composer('*', function ($view) use ($company, $overdueLoans, $countOverdueLoans) {
                $view->with(['company' => $company, 'overdueLoans' => $overdueLoans, 'countOverdueLoans' => $countOverdueLoans]);
            });
        }
    }
}
