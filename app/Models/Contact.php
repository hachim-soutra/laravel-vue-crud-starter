<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'prenom', 'nom', 'phone', 'ville', 'adresse','password','email'
    ];

    protected $appends = ['username'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getUsernameAttribute()
    {
        return $this->nom . " " . $this->prenom;
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
    public function products()
    {
        return Product::whereIn('id',$this->stocks()->pluck('product_id'))->get();
    }

}
