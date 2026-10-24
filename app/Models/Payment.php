<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'cash_account_id',
        'supplier_id',
        'currency_id',
        'curRate',
        'amount',
        'optional_bill',
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
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
