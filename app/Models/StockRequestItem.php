<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockRequestItem extends Model
{
    use HasFactory;

    protected $fillable = ['stock_request_id', 'stock_id', 'quantity_requested'];

    public function stockRequest()
    {
        return $this->belongsTo(StockRequest::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}

