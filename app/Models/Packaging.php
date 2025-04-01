<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Packaging extends Model
{
    use SoftDeletes;

    protected $table = 'packagings';

    protected $fillable = ['name', 'unit', 'price', 'quantity'];

    public function cakes()
    {
        return $this->belongsToMany(Cake::class, 'cake_packaging')
            ->withPivot('quantity');
    }
}
