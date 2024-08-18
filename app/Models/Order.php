<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_id',
        'start_time',
        'end_time',
        'product_id',
        'product_total',
        'status',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function porders()
    {
        return $this->hasMany(Porder::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
