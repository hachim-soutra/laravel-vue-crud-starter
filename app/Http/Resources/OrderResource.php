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
            'id'         => $this->id,
            'tarif'       => $this->tarif,
            'package'      => $this->package,
            'status'      => $this->status,
            'source'       => $this->source,
            'consumer'     => $this->consumer,
            'product'      => $this->product_name,
            'quantity'      => $this->quantity,
            'total'      => $this->total,
            'subTotal'      => $this->subTotal,
            'dateConfirmation'      => $this->dateConfirmation ? $this->dateConfirmation->format('Y-m-d\TH:i') : "",
            'city'      => $this->city,
            'user'      => $this->user,
            'note'      => $this->note,
            'shipping_id'      => $this->shipping_id,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
