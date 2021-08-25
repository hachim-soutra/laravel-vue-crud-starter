<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Pipeline\Pipeline;

class Consumer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prenom', 'nom', 'phone', 'ville', 'status', 'adresse'
    ];

    protected $appends = ['order', 'photo', 'username'];

    public function getPhotoAttribute()
    {
        return 'https://www.gravatar.com/avatar/' . md5(strtolower($this->email)) . '.jpg?s=200&d=mm';
    }
    public function getUsernameAttribute()
    {
        return $this->nom . " " . $this->prenom;
    }

    public function getOrderAttribute()
    {
        $orders = DB::table('orders')->where('consumer_id', $this->id)->sum('quantity');
        return $orders . " Orders";
    }

    public static function allPost()
    {
        $posts = app(Pipeline::class)
            ->send(\App\Models\Consumer::query())
            ->through([
                \App\QueryFilters\Search::class,
            ])
            ->thenReturn()
            ->get();
        return $posts;
    }
}
