<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Loan;
use Illuminate\Support\Facades\Log;

class InsertDataInterestRemain extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:insert-data-interest-remain';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
      $loans = Loan::with('payments')->withCount('payments')
                ->where('status', 2)
                ->where('remain', '>', 0)
                ->get();
      foreach ($loans as $loan) {
          if ($loan->payments_count > 0) {
              $remainDuration = $loan->duration - $loan->payments_count;
          } else {
              $remainDuration = $loan->duration;
          }
          $remainInterest = $loan->amount_interest * $remainDuration;
          $loan->interest_remain = $remainInterest;
          $loan->save();
          Log::info("Loan ID: {$loan->id} - Remaining Interest: $remainInterest = $remainDuration = $loan->payments_count = $loan->amount_interest");
      }
    }
}
