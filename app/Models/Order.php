<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name', 'table_id', 'status', 'note',
    ];

    public function menus() {
        return $this->belongsToMany(Menu::class,'menu_orders')->withPivot('quantity');
    }

    public function table() {
        return $this->belongsTo(Table::class);
    }

    public function payment(){
        return $this->hasOne(Payment::class);
    }
}
