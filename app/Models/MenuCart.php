<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity', 'user_id', 'menu_id'
    ];

    public function menu() {
        return $this->belongsTo(Menu::class);
    }

    public function users() {
        return $this->hasMany(User::class);
    }

}
