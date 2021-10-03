<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Contact extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    protected $fillable = [
        'prenom', 'nom', 'phone', 'ville', 'adresse', 'password', 'email', 'transaction_id'
    ];

    protected $appends = ['username'];


    protected $hidden = [
        'password', 'remember_token',
    ];
    public function getAuthPassword()
    {
        return $this->password;
    }
    public function getUsernameAttribute()
    {
        return $this->nom . " " . $this->prenom;
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
    // public function products()
    // {
    //     return Product::whereIn('id', $this->stocks()->pluck('product_id'))->get();
    // }

    public function ordersNotPaye()
    {
        return $this->orders->whereNull('transaction_id')->where('status_livraison_id', 2);
    }
}
