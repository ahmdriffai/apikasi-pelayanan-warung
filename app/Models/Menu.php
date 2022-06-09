<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'price', 'description', 'imageUrl', 'category_id'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function menuChart() {
        return $this->hasMany(MenuCart::class);
    }

    public function orders() {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }
}
