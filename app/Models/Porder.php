<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Porder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'product_id',
        'product_total',
        'product_summ',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Optional: agar jadval nomi Porders bo'lsa, quyidagi qatorlarni qo'shing:
    // protected $table = 'porders';
}
