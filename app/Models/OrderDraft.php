<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDraft extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
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
        return $this->hasMany(OrderDraftItem::class, 'order_draft_id');
    }
}
