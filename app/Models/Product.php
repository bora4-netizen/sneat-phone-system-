<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    const CONDITION = [
      1 => 'Used',
      2 => 'New'
    ];
    const CONDITION_USED = 1; //USED
    const CONDITION_NEW = 2; //NEW

    const TYPE_OF_MACHINE = [
      1 => 'iClound',
      2 => 'Unlock',
      3 => 'Original',
      4 => 'Sim Lock'
    ];
    const TYPE_OF_MACHINE_ICLOUND = 1; //ICLOUND
    const TYPE_OF_MACHINE_UNLOCK = 2; //UNLOCK
    const TYPE_OF_MACHINE_ORIGINAL = 3; //ORIGINAL
    const TYPE_OF_MACHINE_SIM_LOCK = 4;

    const STATUS_ID_AVAILABLE = 1;
    const STATUS_ID_SOLD = 2;
    const STATUS_ID_BROKEN = 3;
    const STATUS_ID_LOAN = 4;


    const STATUS_AVAILABLE = 'Instock';
    const STATUS_SOLD = 'Sold';
    const STATUS_LOAN = 'Loan';
    const STATUS_BROKEN = 'Broken';

    public static function getStatuses()
    {
        return [
            '1' => self::STATUS_AVAILABLE,
            '2' => self::STATUS_SOLD,
            '3' => self::STATUS_BROKEN,
        ];
    }

    protected $fillable = [
      'product_code',
      'product_name',
      'product_imei',
      'brand_id',
      'series_id',
      'color_id',
      'model_type_id',
      'condition',
      'storage_id',
      'type_of_machine',
      'newtwork',
      'battery_percentage',
      'percentage',
      'purchase_price',
      'selling_price',
      'employee_id',
      'purchase_date',
      'status',
      'note'
  ];

    protected $dates = ['purchase_date', 'deleted_at'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function modelType()
    {
        return $this->belongsTo(ModelType::class);
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function network()
    {
        return $this->belongsTo(Network::class);
    }

    public function getConditionNameAttribute()
    {
      return self::CONDITION[$this->condition];
    }

    public function getTypeOfMachineNameAttribute()
    {
      return self::TYPE_OF_MACHINE[$this->type_of_machine];
    }

    public function getStatusNameAttribute(): string
    {
      $getStatus = self::getStatuses();
      return $getStatus[$this->status];
    }

    public function getConditionLabelBadgesNameAttribute()
    {
      if($this->condition == self::CONDITION_USED){
        return '<span class="badge bg-label-primary">'.self::CONDITION[$this->condition].'</span>';
      }else{
        return '<span class="badge bg-label-secondary">'.self::CONDITION[$this->condition].'</span>';
      }
    }

    public function getStatusBadgesNameAttribute()
    {
      $getStatus = self::getStatuses();
      if($this->status == self::STATUS_ID_AVAILABLE){
        return '<span class="badge bg-primary">'.$getStatus[$this->status].'</span>';
      }elseif($this->status == self::STATUS_ID_SOLD){
        return '<span class="badge bg-danger">'.$getStatus[$this->status].'</span>';
      }elseif($this->status == self::STATUS_ID_LOAN){
        return '<span class="badge bg-secondary">'.$getStatus[$this->status].'</span>';
      }elseif($this->status == self::STATUS_ID_BROKEN){
        return '<span class="badge bg-warning">'.$getStatus[$this->status].'</span>';
      }
      return  '<span class="badge bg-primary">'.$getStatus[$this->status].'</span>';
    }

    public function getImageNameAttribute()
    {
      if($this->image && $this->image != null && $this->image != ''){
        return asset('/images/product/'.$this->image);
      }
      return asset('/assets/img/blank-product.svg');
    }

    public function getSeriesNameAttribute()
    {
      return $this->series->name;
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', self::STATUS_ID_AVAILABLE);
    }
    public function scopeSold($query)
    {
        return $query->where('status', self::STATUS_ID_SOLD);
    }

    public function scopeBroken($query)
    {
        return $query->where('status', self::STATUS_ID_BROKEN);
    }

    public function isAvailable(){
      return $this->status == self::STATUS_ID_AVAILABLE;
    }

    public function isSoldOut(){
      return $this->status == self::STATUS_ID_SOLD;
    }
    public function products_status_instock_count()
    {
        return $this->hasMany(Product::class)->where('status', 1);
    }
}
