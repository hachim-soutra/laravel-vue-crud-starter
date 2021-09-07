<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'id'                => $this->id,
            'nom'               => $this->nom,
            'prenom'            => $this->prenom,
            'email'             => $this->email,
            'username'          => $this->username,
            'phone'             => $this->phone,
            'ville'             => $this->ville,
            'adresse'           => $this->adresse,
            'orders'            => $this->orders,
            'stocks'             => new StockCollection($this->stocks),
            'ordersCount'       => $this->orders->count(),
            'created_at'        => $this->created_at ? $this->created_at->format('Y-m-d') : "",
        ];
    }
}
