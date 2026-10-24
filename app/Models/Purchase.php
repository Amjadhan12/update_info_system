<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
