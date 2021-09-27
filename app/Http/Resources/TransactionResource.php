<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'contact'          => $this->contact,
            'total'          => $this->total,
            'quantity'          => $this->quantity,

            'date_payment'    => $this->date_payment ? $this->date_payment->format('Y-m-d') : '...',
            'date_recipient'    => $this->date_recipient ? $this->date_recipient->format('Y-m-d') : '....',
            'created_at'    => $this->created_at->format('Y-m-d'),
        ];
    }
}
