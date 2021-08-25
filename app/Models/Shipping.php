<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Shipping extends Authenticatable

{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name', 'price', 'dure', 'type', 'status', 'tarif', 'phone', 'email', 'password', 'city'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getOrderAnnulerAttribute()
    {
        return $this->orders->where('status', 'CANCELED')->count();
    }
    public function getOrderLivreAttribute()
    {
        return $this->orders->where('status', 'CLOSED')->count();
    }
    public function getCreditAttribute()
    {
        $order = $this->orders->where('status', 'PAID')->sum('total');
        $order_tarif = $this->orders->where('status', 'PAID')->sum('tarif');
        $tarif = $this->orders->where('status', 'PAID')->count();
        return $order - ($tarif * $this->price) - $order_tarif;
    }
    public function getOrderPayeAttribute()
    {
        return $this->orders->where('status', 'PAID')->count();
    }
    public function getOrderReportieAttribute()
    {
        return $this->orders->where('status', 'PROCESSED')->count();
    }
    public function getOrderPasReponseAttribute()
    {
        return $this->orders->where('status', 'NO ANSWER')->count();
    }
}
