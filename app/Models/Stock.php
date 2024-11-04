<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['description', 'quantity']; // Include other relevant fields

    // Method to decrease stock quantity
    public function decreaseQuantity($amount)
    {
        $this->quantity -= $amount;
        $this->save();
    }
}
