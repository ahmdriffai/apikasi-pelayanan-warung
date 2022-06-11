<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'telp', 'image_url', 'image_path','user_id', 'address',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
