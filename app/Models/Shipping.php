<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Shipping extends Authenticatable

{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    protected $fillable = [
        'name', 'price', 'status', 'tarif', 'phone', 'email', 'password', 'city', 'city_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function country()
    {
        return $this->belongsTo(City::class,'city_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }



    public function getCreditAttribute()
    {
        $order          = $this->orders->where('order_status_id', 6)->count() * $this->price;
        $order_tarif    = $this->orders->where('order_status_id', 6)->sum('tarif');
        return $order + $order_tarif;
    }

    public function getOrderExpiderAttribute()
    {
        return $this->orders->where('order_status_id', 3)->where('status_livraison_id',1)->count();
    }
    public function getOrderLivreAttribute()
    {
        return $this->orders->where('order_status_id', 3)->where('status_livraison_id',2)->count();
    }
    public function getOrderReportieAttribute()
    {
        return $this->orders->where('order_status_id', 3)->where('status_livraison_id',3)->count();
    }
    public function getOrderPasReponseAttribute()
    {
        return $this->orders->where('order_status_id', 3)->where('status_livraison_id',4)->count();
    }
    public function getOrderAnnulerAttribute()
    {
        return $this->orders->where('order_status_id', 3)->where('status_livraison_id',5)->count();
    }
    public function getOrderPayeAttribute()
    {
        return $this->orders->where('order_status_id', 3)->where('status_livraison_id',6)->count();
    }
    public function getOrderRetourAttribute()
    {
        return $this->orders->where('order_status_id', 3)->where('status_livraison_id',7)->count();
    }
}
