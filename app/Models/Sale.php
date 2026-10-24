<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    public function item()
    {
        return $this->belongsTo(item::class);
    }
    public function stock()
    {
        return $this->belongsTo(stock::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
