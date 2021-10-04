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
        'name', 'description', 'price', 'photo', 'sell', 'quantity', 'offre_json','user_id','contact_id','city_id','image'
    ];
    protected $appends = ['quantityReste'];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
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
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
