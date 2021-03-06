<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryMenResource extends JsonResource
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
            'price'                 => $this->price,
            'type'                  => $this->type,
            'status'                => $this->status,
            'tarif'                 => $this->tarif,
            'phone'                 => $this->phone,
            'city'                  => $this->city,
            'city_id'               => $this->city_id,
            'country'               => $this->country->name,
            'name'                  => $this->name,
            'email'                 => $this->email,
            'created_at'            => $this->created_at->format('Y-m-d'),
            'updated_at'            => $this->updated_at,
            'order_annuler'         => $this->order_annuler,
            'order_livre'           => $this->order_livre,
            'credit'                => $this->credit,
            'order_total'            => $this->orders ? $this->orders->count() : 0,
            'order_paye'            => $this->order_paye,
            'order_retour'          => $this->order_retour,
            'order_expider'         => $this->order_expider,
            'order_reportie'        => $this->order_reportie,
            'order_pas_reponse'     => $this->order_pas_reponse,
        ];
    }
}
