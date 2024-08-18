<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'price', 'total', 'user_id'
    ];

    // User bilan bog'langan
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getNameAttribute()
    {
        return $this->attributes['name'];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function porders()
    {
        return $this->hasMany(Porder::class);
    }
}
