<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingredient extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'unit', 'price', 'quantity'];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'recipe_ingredients')
            ->withPivot('quantity');
    }
}
