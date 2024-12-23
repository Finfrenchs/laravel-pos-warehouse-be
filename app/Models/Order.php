<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_note',
        'order_number',
        'total',
        'status',
        'payment_status',
        'payment_type',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
