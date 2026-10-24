<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateSaleBill extends Model
{
    use HasFactory;


    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
