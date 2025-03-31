<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cake extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['name'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array<string>
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the recipes used for this cake.
     */
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'cake_recipes')
            ->withPivot('quantity');
    }

    /**
     * Get the packagings used for this cake.
     */
    public function packagings()
    {
        return $this->belongsToMany(Packaging::class, 'cake_packaging')
            ->withPivot('quantity', 'depreciation');
    }

    /**
     * Get the products (sales) of this cake.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
