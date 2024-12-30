<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
    protected $fillable = [
        'name',
        'price',
        'stock',
        'image',
        'is_available',
        'category_id'
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'price' => 'float',
        'stock' => 'integer'
    ];

    public function category()
    {
        return $this->belongsTo(ToppingCategory::class);
    }

    public function updateAvailability()
    {
        if ($this->stock <= 0) {
            $this->update(['is_available' => false]);
        }
    }

    public function decrementStock()
    {
        $this->decrement('stock');
        $this->updateAvailability();
        return $this;
    }
}