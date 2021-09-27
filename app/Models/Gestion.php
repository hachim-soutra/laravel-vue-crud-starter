<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Gestion extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'prenom', 'nom', 'phone', 'ville', 'adresse', 'password', 'email', 'city_id'
    ];

    protected $appends = ['username'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getUsernameAttribute()
    {
        return $this->nom . " " . $this->prenom;
    }

    public function getOrderValideAttribute()
    {
        return $this->orders->where('order_status_id', 1)->first();
    }

    public function getOrderHistoriqueAttribute()
    {
        // dd($this->orders->where('order_status_id',1));
        return $this->orders()->where('order_status_id', '!=', 1)->where('dateConfirmation', '>', now()->subDays(3)->toDateTimeString())->get();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function country()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
