<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class GestionResource extends JsonResource
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
            'username'          => $this->username,
            'nom'             => $this->nom,
            'city_id'             => $this->city_id,
            'prenom'             => $this->prenom,
            'email'             => $this->email,
            'phone'             => $this->phone,
            'ville'             => $this->ville,
            'adresse'           => $this->adresse,
            'country'           => $this->country ? $this->country->name : '',
            'orders-valide'     => $this->orders ? $this->orders->count() : '',
            'phone'             => $this->phone,
            'orders'            => Order::where('order_status_id', 1)->where('city_id', $this->city_id)->whereNull('gestion_id')->count(),
            // 'notificactions'    => $this->unreadNotifications,
            'created_at'        => $this->created_at ? $this->created_at->format('Y-m-d') : "",
        ];
    }
}
