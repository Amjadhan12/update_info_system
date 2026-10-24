<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_category_id',
        'currency_id',
        'cash_account_id',
        'curRate',
        'amount',
        'date',
        'details',
        'user_id'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function cashAccount()
    {
        return $this->belongsTo(CashAccount::class);
    }
    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }
   
}
