<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingredient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['category_id', 'name', 'quantity', 'unit', 'price', 'unit_price'];

    public function category()
    {
        return $this->belongsTo(IngredientCategory::class, 'category_id');
    }

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'recipe_ingredients')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
