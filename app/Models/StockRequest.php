<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'status', 'catatan', 'request_date'];

    public function stockRequestItems()
    {
        return $this->hasMany(StockRequestItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

