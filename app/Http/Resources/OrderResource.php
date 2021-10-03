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
            'status'                => $this->status ? $this->status->id : 0,
            'statusLivraison'       => $this->statusLivraison ? $this->statusLivraison->id : 0,
            'statusLivraisonName'   => $this->statusLivraison ? $this->statusLivraison->name : '',
            'statusName'            => $this->status ? $this->status->name : '',
            'consumer_phone'        => $this->consumer_phone,
            'consumer_ville'        => $this->consumer_ville,
            'consumer_name'         => $this->consumer_name,
            'shipping_adresse'      => $this->shipping_adresse,
            'contact'               => $this->contact,
            'order_status_id'       => $this->order_status_id,
            'product_name'          => $this->product ? $this->quantity . '*' . $this->product->name : '',
            'product'               => $this->product,
            'historiques'           => $this->historiques,
            'product_array'         => $this->contact ? $this->contact->products : [],
            'product_id'            => $this->product_id,
            'quantity'              => $this->quantity,
            'total'                 => $this->total,
            'isCanRammasage'        => $this->isCanRammasage,
            'subTotal'              => $this->subTotal,
            'dateConfirmation'      => $this->dateConfirmation ? $this->dateConfirmation->format('Y-m-d\TH:i') : "",
            'city'                  => $this->city,
            'user'                  => $this->user,
            'gestion'               => $this->gestion,
            'username'              => $this->user ? $this->user->name : "###########",
            'note'                  => $this->note,
            'delivery_note'         => $this->delivery_note,
            'date_reporting'        => $this->date_reporting ? $this->date_reporting->format('Y-m-d') : null,
            'shipping_id'           => $this->shipping_id,
            'created_at'            => $this->created_at->format('Y-m-d'),
        ];
    }
}
