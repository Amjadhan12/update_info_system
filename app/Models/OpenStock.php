<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'stock_id',
        'currency_id',
        'unit_id',
        'unit_size',
        'curRate',
        'qty',
        'pprice',
        'sprice',
        'date',
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
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
