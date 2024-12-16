<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'requested_quantity', 'status', 'catatan', 'date', 'group_id'];

    public function stock()
{
    return $this->belongsTo(Stock::class, 'stock_id', 'stock_id');
}

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function groupedRequests()
    {
        return $this->hasMany(StockRequest::class, 'group_id', 'group_id');
    }
}
