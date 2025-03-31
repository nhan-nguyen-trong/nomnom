<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cake extends Model
{
    protected $fillable = ['name'];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'cake_recipes')
            ->withPivot('quantity');
    }

    public function packagings()
    {
        return $this->belongsToMany(Packaging::class, 'cake_packaging')
            ->withPivot('quantity', 'depreciation');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
