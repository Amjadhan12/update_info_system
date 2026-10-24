<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'currency_id',
        'curRate',
        // 'barcode',
        'name',
        'pprice',
        'sprice',
        'details',
        'user_id'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
