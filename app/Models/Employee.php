<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_1 = 1; //Probationary Period
    const STATUS_2 = 2; // Part Time
    const STATUS_3 = 3; //Full time
    const STATUS_4 = 4; //Resign
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'position_id',
        'id_card_no',
        'name',
        'latin_name',
        'phone',
        'email',
        'gender',
        'nationality',
        'dob',
        'birth_place',
        'address',
        'profile',
        'status',
        'start_working_date'
    ];

    protected $dates = ['start_working_date', 'dob'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'position_id', 'id');
    }

    public function getPositionAttribute(): string
    {
        return $this->role->name;
    }

    public function getStatusNameAttribute(): string
    {
        if($this->status == self::STATUS_1){
            return "<span class='badge bg-label-secondary me-1'>Probationary Period</span> ";
        }if($this->status == self::STATUS_2){
            return "<span class='badge bg-label-primary me-1'>Part Time</span> ";
        }if($this->status == self::STATUS_3){
            return "<span class='badge bg-label-success me-1'>Full Time</span> ";
        }if($this->status == self::STATUS_4){
            return "<span class='badge bg-label-danger me-1'>Resign</span> ";
        }
        return '';
    }
    public function getStatusTextAttribute(): string
    {
      if($this->status == self::STATUS_1){
        return "Probationary Period";
      }if($this->status == self::STATUS_2){
          return "Part Time";
      }if($this->status == self::STATUS_3){
          return "Full Time";
      }if($this->status == self::STATUS_4){
          return "Resign";
      }
      return '';
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
