<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'stock_id' ,'requested_quantity', 'status', 'catatan', 'date', 'group_id', 'date_approved', 'received_quantity'];

    // Define the relationship to the Stock model
    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stock_id');
    }    

    // Define the relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship to grouped requests
    public function groupedRequests()
    {
        return $this->hasMany(StockRequest::class, 'group_id', 'group_id');
    }

    public function stockRequest()
    {
    return $this->belongsTo(StockRequest::class);
    }   
}
