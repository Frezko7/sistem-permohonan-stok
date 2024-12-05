<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'stock_id', 'requested_quantity', 'status','catatan','date'];

    public function stock()
{
    return $this->belongsTo(Stock::class, 'stock_id');
}
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

