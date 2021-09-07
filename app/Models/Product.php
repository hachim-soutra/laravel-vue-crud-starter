<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'price', 'photo', 'sell', 'quantity', 'offre_json','user_id','city_id'
    ];
    protected $appends = ['offres','quantityReste'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->select(['name as text', 'id']);
    }
    public function getOffresAttribute()
    {
        return json_decode($this->offre_json, true);
    }
    public function getQuantityResteAttribute()
    {
        return $this->quantity - $this->stocks->sum('quantity');
    }
    public function country()
    {
        return $this->belongsTo(City::class,'city_id');
    }
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
