<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'spice_level',
        'consistency',
        'total_price',
        'status',
        'payment_proof',
        'rejection_reason'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_REJECTED = 'rejected';

    protected $attributes = [
        'status' => self::STATUS_PENDING
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function toppings()
    {
        return $this->belongsToMany(Topping::class, 'order_toppings')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function getStatusColorAttribute()
{
    return match($this->status) {
        self::STATUS_PENDING => 'warning',
        self::STATUS_PROCESSING => 'primary',
        self::STATUS_COMPLETED => 'success',
        self::STATUS_CANCELLED => 'danger',
        self::STATUS_REJECTED => 'danger',
        default => 'secondary'
    };
}
}