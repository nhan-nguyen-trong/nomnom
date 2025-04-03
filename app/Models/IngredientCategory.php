<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IngredientCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class, 'category_id');
    }
}
