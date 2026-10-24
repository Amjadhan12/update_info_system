<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenPayable extends Model
{
    use HasFactory;
    protected $fillable = [
        'supplier_id',
        'currency_id',
        'curRate',
        'amount',
        'date',
        'details',
        'user_id'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
   
}
