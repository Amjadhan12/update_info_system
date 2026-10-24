<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateSale extends Model
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
}
