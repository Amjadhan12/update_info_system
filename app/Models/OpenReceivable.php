<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenReceivable extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'currency_id',
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
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
