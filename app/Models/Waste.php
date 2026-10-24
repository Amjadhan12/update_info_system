<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waste extends Model
{
    use HasFactory;
    protected $fillable = [
        'stock_id',
        'item_id',
        'qty',
        'date',
        'details',
        'user_id'
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
    public function item()
    {
        return $this->belongsTo(item::class);
    }
}
