<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'cake_id',
        'ingredient_cost',
        'packaging_cost',
        'depreciation_cost',
        'quantity_sold',
        'total_cost',
        'selling_price'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array<string>
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the cake associated with this product.
     */
    public function cake()
    {
        return $this->belongsTo(Cake::class);
    }
}
