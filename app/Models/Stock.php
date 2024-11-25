<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $primaryKey = 'stock_id';
    protected $fillable = ['description', 'quantity', 'image']; // Include other relevant fields

    // Method to decrease stock quantity
    public function decreaseQuantity($amount)
    {
        $this->quantity -= $amount;
        $this->save();
    }
    public function stockRequests()
{
    return $this->hasMany(StockRequest::class, 'stock_id');
}

}
