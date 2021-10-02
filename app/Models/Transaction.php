<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'total', 'quantity', 'contact_id', 'date_payment', 'date_recipient'
    ];

    protected $dates = array('date_payment', 'date_recipient');

    protected $casts = [
        'date_recipient' => 'datetime:Y-m-d H:m:s',
        'date_payment' => 'datetime:Y-m-d H:m:s',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
