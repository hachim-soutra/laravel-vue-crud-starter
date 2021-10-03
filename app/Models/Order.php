<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pipeline\Pipeline;

class Order extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'order_status_id', 'tarif', 'consumer_phone', 'consumer_name', 'consumer_ville', 'product_id', 'note', 'shipping_id',
        'delivery_note', 'quantity', 'total', 'subTotal', 'dateConfirmation',
        'city_id', 'user_id', 'gestion_id', 'shipping_adresse', 'contact_id', 'status_livraison_id',
        'date_reporting', 'transaction_id'
    ];

    protected $dates = array('dateConfirmation', 'date_reporting');

    protected $casts = [
        // 'dateConfirmation' => 'datetime:Y-m-d H:m:s',
    ];

    public function historiques()
    {
        return $this->hasMany(Historique::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function gestion()
    {
        return $this->belongsTo(Gestion::class, 'gestion_id');
    }
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }
    public function statusLivraison()
    {
        return $this->belongsTo(StatusLivraison::class, 'status_livraison_id');
    }

    public function country()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function getIsCanRammasageAttribute()
    {
        return $this->product->stocks->where('contact_id', $this->contact_id)->sum('quantity') >= $this->quantity;
    }

    public function getProductNameAttribute()
    {
        return $this->product->name;
    }
    public static function allOrder()
    {
        if (auth()->user()->roles->first()->id == 1){
            $orders = app(Pipeline::class)
                ->send(\App\Models\Order::query())
                ->thenReturn()
                ->get();
        }else {
            $orders = app(Pipeline::class)
                ->send(\App\Models\Order::query()->whereIn('city_id',auth()->user()->city_id))
                ->thenReturn()
                ->get();
        }
        return $orders;
    }
    public static function delivryOrder($id)
    {
        $posts = app(Pipeline::class)
            ->send(\App\Models\Order::query()->where('shipping_id', $id))
            ->through([
                \App\QueryFilters\Status::class,
            ])
            ->thenReturn()
            ->latest()
            ->get();
        return $posts;
    }
    public static function delivryOrderExpide($id)
    {
        $posts = app(Pipeline::class)
            ->send(\App\Models\Order::query()->where('shipping_id', $id))
            ->through([
                \App\QueryFilters\statusLivraison::class,
            ])
            ->thenReturn()
            ->latest()
            ->get();
        return $posts;
    }
}
