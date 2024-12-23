<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDraftItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_draft_id',
        'product_id',
        'quantity',
        'price',
        'total',
    ];

    public function draftOrder()
    {
        return $this->belongsTo(OrderDraft::class, 'order_draft_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
