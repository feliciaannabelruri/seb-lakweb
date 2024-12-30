<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToppingCategory extends Model
{
    protected $fillable = ['name'];

    public function toppings()
    {
        return $this->hasMany(Topping::class, 'category_id');
    }
} 