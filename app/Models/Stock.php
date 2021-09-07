<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id', 'quantity', 'product_id'
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class,'contact_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
