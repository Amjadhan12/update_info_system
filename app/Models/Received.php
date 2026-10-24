<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Received extends Model
{
    use HasFactory;
    protected $fillable = [
        'cash_account_id',
        'customer_id',
        'currency_id',
        'curRate',
        'rasid_no',
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
    public function customer()
    {
        return $this->belongsTo(customer::class);
    }
}
