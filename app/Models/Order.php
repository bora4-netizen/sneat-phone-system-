<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_ACTIVE = 1; //ACTIVE
    const STATUS_INACTIVE = 2; //INACTIVE

    const PAYMENT_STATUS_PAID = 1; //PAID
    const PAYMENT_STATUS_UNPAID = 2; //UNPAID

    const PAYMENT_TYPE_CASH = 1; //CASH
    const PAYMENT_TYPE_BANK= 2; //BANK
    const PAYMENT_TYPE_OTHER= 3; //OTHER

    protected $fillable = [
      'customer_id',
      'employee_id',
      'status',
      'total_amount',
      'payment_status',
      'payment_type',
      'note',
      'order_date'
  ];

    protected $dates = 
    [
      'order_date',
      'deleted_at',
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function getIdNumberAttribute()
    {
      $currentOrderId = $this ? $this->id : 0;
      $newOrderId = $currentOrderId + 1;
      $formattedOrderId = str_pad($newOrderId, 5, '0', STR_PAD_LEFT);
      return $formattedOrderId;
    }

    public function getCustomerNameAttribute()
    {
      return $this->customer ? $this->customer->name : '';
    }

    public function getEmployeeNameAttribute()
    {
      return $this->employee ? $this->employee->name : '';
    }

    public function getPaymentStatusBadgesAttribute()
    {
      if($this->payment_status == self::PAYMENT_STATUS_UNPAID){
        return '<span class="badge bg-label-danger">'.__('order.unpaid').'</span>';
      }else{
        return '<span class="badge bg-label-success">'.__('order.paid').'</span>';
      }
    }

    public function getPaymentTypeBadgesAttribute()
    {
      if($this->payment_type == self::PAYMENT_TYPE_CASH){
        return '<span class="badge bg-label-primary">'.__('order.cash').'</span>';
      }elseif($this->payment_type == self::PAYMENT_TYPE_BANK){
        return '<span class="badge bg-label-secondary">'.__('order.bank').'</span>';
      }else{
        return '<span class="badge bg-label-info">'.__('order.other').'</span>';
      }
    }

    public function getOrderDateDmyAttribute()
    {
      $date = Carbon::parse($this->order_date);
      return $date->format('d/m/Y');
    }
}
