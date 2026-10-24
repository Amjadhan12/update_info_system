<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturnDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'stock_id',
        'unit_id',
        'unit_size',
        'qty',
        'price',
        'pprice'
    ];

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
