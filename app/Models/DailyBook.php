<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyBook extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'isCredit',
        'currency_id',
        'curRate',
        'amount',
        'date',
        'details'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
