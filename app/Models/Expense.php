<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
      'date',
      'name',
      'category_id',
      'employee_id',
      'amount',
      'note',
    ];

    protected $dates = [
        'date', // Specify that 'date' should be cast as a date
    ];


    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }
}
