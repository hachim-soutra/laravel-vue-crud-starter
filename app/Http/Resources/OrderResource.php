<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id'                    => $this->id,
            'tarif'                 => $this->tarif,
            'package'               => $this->package,
            'status'                => $this->status ? $this->status->id : 0,
            'statusName'            => $this->status ? $this->status->name : '',
            'source'                => $this->source,
            'consumer'              => $this->consumer,
            'contact'               => $this->contact,
            'product_name'          => $this->product_name,
            'consumer_name'         => $this->consumer_name,
            'shipping_adresse'      => $this->shipping_adresse,
            'product'               => $this->product_name,
            'product_array'         => json_decode($this->upsell_json),
            'quantity'              => $this->quantity,
            'total'                 => $this->total,
            'subTotal'              => $this->subTotal,
            'dateConfirmation'      => $this->dateConfirmation ? $this->dateConfirmation->format('Y-m-d\TH:i') : "",
            'city'                  => $this->city,
            'user'                  => $this->user,
            'username'              => $this->user ? $this->user->name : "###########",
            'note'                  => $this->note,
            'shipping_id'           => $this->shipping_id,
            'created_at'            => $this->created_at->format('Y-m-d'),
        ];
    }
}
