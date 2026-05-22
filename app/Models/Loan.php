<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Loan extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_1 = 1; //PENDING
    const STATUS_2 = 2; //APPROVED
    const STATUS_3 = 3; //DONE
    const STATUS_4 = 4; //REJECT
    const STATUS = [
      1 => 'Pending',
      2 => 'Approved',
      3 => 'Done',
      4 => 'Reject',
    ];


    protected $fillable = [
      'customer_id',
      'employee_id',
      'product_id',
      'amount',
      'first_amount',
      'interest',
      'duration',
      'amount_principal',
      'amount_interest',
      'remain',
      'interest_remain',
      'payable_amount',
      'date',
      'next_payment_date',
      'status',
      'note',
      'phone_profit'
  ];

  protected $dates = ['deleted_at'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function payments()
    {
        return $this->hasMany(LoanPayment::class, 'loan_id');
    }

    public function loanDetail()
    {
        return $this->hasOne(LoanDetail::class);
    }

    public function loanDetails()
    {
        return $this->hasMany(LoanDetail::class, 'loan_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function document()
    {
        return $this->hasOne(LoanDocument::class);
    }

    public function getInstallmentNameAttribute()
    {
      return '$'.$this->pay_return.__('loan.installment_text').$this->interest;
    }
    public function getInterestNameAttribute()
    {
      $interest = $this->interest;
      $payableAmount = $this->payable_amount;
      $amount = $this->amount;
      $getInterest = $payableAmount - $amount;
      return '$' . $getInterest . ' (' . $interest . ' %)';
    }

    public function getStatusNameAttribute(): string
    {
      return self::STATUS[$this->status];
    }

    public function getStatusLabelAttribute()
    {
      if($this->status == self::STATUS_1){
        return '<span class="badge bg-label-info">'.self::STATUS[$this->status].'</span>';
      }elseif($this->status == self::STATUS_2){
        return '<span class="badge bg-label-primary">'.self::STATUS[$this->status].'</span>';
      }elseif($this->status == self::STATUS_3){
        return '<span class="badge bg-label-success">'.self::STATUS[$this->status].'</span>';
      }else{
        return '<span class="badge bg-label-danger">'.self::STATUS[$this->status].'</span>';
      }
    }
    public function getNumberAttribute()
    {
        return str_pad($this->id, 5, '0', STR_PAD_LEFT);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_2);
    }

    public function scopeLatePayment($query)
    {
        return $query->approved()->where('next_payment_date', '<', Carbon::now())->where('remain', '>', 0);
    }

    public function isApproved(){
      return $this->status == self::STATUS_2;
    }

    public function getMonthlyPaymentAttribute()
    {
      $amountPrincipal = floatval($this->amount_principal ?? 0);
      $amountInterest = floatval($this->amount_interest ?? 0);

      return $amountPrincipal + $amountInterest;
    }

    public function getTotalInterestAttribute()
    {
      $amountInterest = floatval($this->amount_interest ?? 0);
      $duration = floatval($this->duration ?? 0);

      $getInterest = $amountInterest * $duration;
      return '$' . number_format(round($getInterest, 2), 2) . ' (' . $this->interest . ' %)';
    }

    public function getTotalMonthlyPaymentAttribute()
    {
      $amountInterest = floatval($this->amount_interest ?? 0);
      $amountPrincipal = floatval($this->amount_principal ?? 0);

      $getMonthlyPayment = $amountInterest + $amountPrincipal;
      return '$'.number_format(round($getMonthlyPayment, 2), 2).__('loan.installment_text').$this->duration;
    }

    public function getAmountPayingOffAttribute()
    {
      $loanPaymentsCount = $this->payments()->count();
      $duration = floatval($this->duration ?? 0);
      $amountPrincipal = floatval($this->amount_principal ?? 0);
      $amountInterest = floatval($this->amount_interest ?? 0);

      if ($loanPaymentsCount > 0) {
        $amountPayingOff = ($duration - $loanPaymentsCount) * $amountPrincipal;
      } else {
        $amount = floatval($this->amount ?? 0);
        $firstAmount = floatval($this->first_amount ?? 0);
        $amountPayingOff = $amount - $firstAmount;
      }

      return ($amountPayingOff + $amountInterest);
    }

    public function getPayDateAttribute()
    {
      $nextPaymentDate = $this->next_payment_date;
      $formattedDate = Carbon::parse($nextPaymentDate)->format('Y - m - d');
      return $formattedDate;
    }

    public function getOverdueDaysAttribute()
    {
      $nextPaymentDate = $this->next_payment_date;
      $currentDate = Carbon::now();
      $nextPaymentDate = Carbon::parse($nextPaymentDate);
      $overdueDays = $nextPaymentDate->diffInDays($currentDate, false);
      return "{$overdueDays} day" . ($overdueDays > 1 ? "s" : "");
    }
    public function getIdNumberAttribute()
    {
      $currentOrderId = $this ? $this->id : 0;
      $newOrderId = $currentOrderId + 1;
      $formattedOrderId = str_pad($newOrderId, 5, '0', STR_PAD_LEFT);
      return $formattedOrderId;
    }

    public function getTotalBalanceAttribute()
    {
      $amount = floatval($this->amount ?? 0);
      $firstAmount = floatval($this->first_amount ?? 0);

      return $amount - $firstAmount;
    }

    public function loanPayments()
    {
        return $this->hasMany(LoanPayment::class);
    }

    public function getLastesPaymentAttribute()
    {
      $lastes = $this->loanPayments->sum('amount');

      if($lastes){

        return $lastes;
      }
      return 0;
    }

    public function getLoanInterestRemain()
    {
      if(count($this->payments) > 0){
        $remainDuration = $this->duration - count($this->payments);
      }else {
        $remainDuration = $this->duration;
      }
      if($remainDuration <= 0){
        return 0;
      }
      return $this->amount_interest * $remainDuration;;
    }
}
