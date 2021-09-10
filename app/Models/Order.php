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
        'order_status_id', 'tarif', 'package', 'source_id', 'consumer_id', 'product_id', 'upsell_json', 'note_json', 'shipping_id', 'shipping_json', 'quantity', 'total', 'subTotal', 'dateConfirmation', 'city', 'city_id', 'user_id', 'gestion_id','shipping_adresse','contact_id','status_livraison_id'
    ];

    protected $appends = array('consumer_name', 'product_name');

    protected $dates = array('dateConfirmation');

    protected $casts = [
        // 'dateConfirmation' => 'datetime:Y-m-d H:m:s',
    ];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }
    public function consumer()
    {
        return $this->belongsTo(Consumer::class);
    }
    public function gestion()
    {
        return $this->belongsTo(Gestion::class, 'gestion_id');
    }
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function status()
    {
        return $this->belongsTo(OrderStatus::class,'order_status_id');
    }
    public function statusLivraison()
    {
        return $this->belongsTo(StatusLivraison::class,'status_livraison_id');
    }
    public function getNoteAttribute()
    {
        return json_decode($this->note_json, true);
    }
    public function country()
    {
        return $this->belongsTo(City::class,'city_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getConsumerNameAttribute()
    {
        return $this->consumer->prenom . ' ' . $this->consumer->nom;
    }
    public function getProductNameAttribute()
    {
        $product_names = json_decode($this->upsell_json, true);
        $product_name = null;
        if ($product_names) {
            foreach ($product_names as $key => $value) {
                $product_name .= $value['quantity'] . " * " . $value['product_name'];
                if ($key !== array_key_last($product_names))
                    $product_name .= " ,";
            }

            return $product_name;
        }
        return "";
    }
    public static function allOrder()
    {
        $posts = app(Pipeline::class)
            ->send(\App\Models\Order::query())
            ->thenReturn()
            ->get();
        return $posts;
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
