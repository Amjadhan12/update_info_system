<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
    use HasFactory;
    protected $fillable = [
        'from_stock_id',
        'to_stock_id',
        'item_id',
        'qty',
        'date',
        'details',
        'user_id',
        'unit_id'
    ];

    // Relationship with Stock (if both stocks are in a stock table)
    public function fromStock()
    {
        return $this->belongsTo(Stock::class, 'from_stock_id');
    }

    public function toStock()
    {
        return $this->belongsTo(Stock::class, 'to_stock_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
