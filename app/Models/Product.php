<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'cake_id',
        'ingredient_cost',
        'packaging_cost',
        'depreciation_cost',
        'quantity_sold',
        'total_cost',
        'selling_price'
    ];

    public function cake()
    {
        return $this->belongsTo(Cake::class);
    }
}
