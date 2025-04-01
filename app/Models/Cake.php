<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cake extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'recipe_id', 'depreciation'];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function packagings()
    {
        return $this->belongsToMany(Packaging::class, 'cake_packaging')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
