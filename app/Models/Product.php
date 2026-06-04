<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    // =========================
    // CONDITIONS
    // =========================
    const CONDITION = [
        1 => 'Used',
        2 => 'New'
    ];

    const CONDITION_USED = 1;
    const CONDITION_NEW = 2;

    // =========================
    // TYPE OF MACHINE
    // =========================
    const TYPE_OF_MACHINE = [
        1 => 'iCloud',
        2 => 'Unlock',
        3 => 'Original',
        4 => 'Sim Lock'
    ];

    const TYPE_OF_MACHINE_ICLOUD = 1;
    const TYPE_OF_MACHINE_UNLOCK = 2;
    const TYPE_OF_MACHINE_ORIGINAL = 3;
    const TYPE_OF_MACHINE_SIM_LOCK = 4;

    // =========================
    // STATUS IDS
    // =========================
    const STATUS_ID_AVAILABLE = 1;
    const STATUS_ID_SOLD = 2;
    const STATUS_ID_BROKEN = 3;
    const STATUS_ID_LOAN = 4;

    // =========================
    // STATUS LABELS
    // =========================
    const STATUS_AVAILABLE = 'In Stock';
    const STATUS_SOLD = 'Sold';
    const STATUS_LOAN = 'Loan';
    const STATUS_BROKEN = 'Broken';

    public static function getStatuses()
    {
        return [
            '1' => self::STATUS_AVAILABLE,
            '2' => self::STATUS_SOLD,
            '3' => self::STATUS_BROKEN,
            '4' => self::STATUS_LOAN,
        ];
    }

    // =========================
    // FILLABLE
    // =========================
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
        'network', // FIXED TYPO
        'battery_percentage',
        'percentage',
        'purchase_price',
        'selling_price',
        'employee_id',
        'purchase_date',
        'status',
        'note',
        'image' // IMPORTANT FIX
    ];

    protected $dates = ['purchase_date', 'deleted_at'];

    // =========================
    // RELATIONS
    // =========================
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

    // =========================
    // ACCESSORS
    // =========================
    public function getConditionNameAttribute()
    {
        return self::CONDITION[$this->condition] ?? null;
    }

    public function getTypeOfMachineNameAttribute()
    {
        return self::TYPE_OF_MACHINE[$this->type_of_machine] ?? null;
    }

    public function getStatusNameAttribute(): string
    {
        $statuses = self::getStatuses();
        return $statuses[$this->status] ?? 'Unknown';
    }

    public function getSeriesNameAttribute()
    {
        return $this->series?->name;
    }

    public function getImageNameAttribute()
    {
        if (!empty($this->image)) {
            return asset('/images/product/' . $this->image);
        }
        return asset('/assets/img/blank-product.svg');
    }

    public function getConditionLabelBadgesNameAttribute()
    {
        if ($this->condition == self::CONDITION_USED) {
            return '<span class="badge bg-label-primary">' . self::CONDITION[$this->condition] . '</span>';
        }

        return '<span class="badge bg-label-secondary">' . self::CONDITION[$this->condition] . '</span>';
    }

    public function getStatusBadgesNameAttribute()
    {
        $statuses = self::getStatuses();

        return match ($this->status) {
            self::STATUS_ID_AVAILABLE => '<span class="badge bg-primary">'.$statuses[$this->status].'</span>',
            self::STATUS_ID_SOLD => '<span class="badge bg-danger">'.$statuses[$this->status].'</span>',
            self::STATUS_ID_LOAN => '<span class="badge bg-secondary">'.$statuses[$this->status].'</span>',
            self::STATUS_ID_BROKEN => '<span class="badge bg-warning">'.$statuses[$this->status].'</span>',
            default => '<span class="badge bg-primary">'.$statuses[$this->status].'</span>',
        };
    }

    // =========================
    // SCOPES
    // =========================
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

    public function scopeInStock($query)
    {
        return $query->where('status', self::STATUS_ID_AVAILABLE);
    }

    // =========================
    // HELPERS
    // =========================
    public function isAvailable()
    {
        return $this->status == self::STATUS_ID_AVAILABLE;
    }

    public function isSoldOut()
    {
        return $this->status == self::STATUS_ID_SOLD;
    }
}