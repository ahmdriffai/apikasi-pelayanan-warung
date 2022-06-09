<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'number', 'name', 'is_available'
    ];

    public function order() {
        return $this->hasOne(Order::class);
    }
}
