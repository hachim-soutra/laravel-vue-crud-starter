<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id', 'text'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
