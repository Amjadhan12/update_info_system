<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_account_id',
        'to_account_id',
        'currency_id',
        'curRate',
        'amount',
        'date',
        'details',
        'user_id'
    ];


    public function cashAccount()
    {
        return $this->belongsTo(CashAccount::class);
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
