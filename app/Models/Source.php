<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;


class Source extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'type', 'status', 'token'
    ];

    public static function allSource()
    {
        $posts = app(Pipeline::class)
            ->send(\App\Models\Source::query())
            ->through([
                // \App\QueryFilters\Search::class,
                // \App\QueryFilters\Type::class,
            ])
            ->thenReturn()
            ->get();
        return $posts;
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
