<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name'              => $this->name,
            'image'             => asset('storage/images/'.$this->image),
            'description'       => $this->description,
            'price'             => $this->price,
            'category'          => $this->category ?: "",
            'sell'              => $this->sell,
            'quantity'          => $this->quantity,
            'orders'            => $this->orders ?: "",
            'contact'           => $this->contact,
            'contact_name'      => $this->contact ? $this->contact->username : '',
            'created_at'        => $this->created_at ? $this->created_at->format('Y-m-d') : "",
        ];
    }
}
