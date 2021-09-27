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

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
