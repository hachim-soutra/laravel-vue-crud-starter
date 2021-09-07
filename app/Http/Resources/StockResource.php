<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource
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
            'quantity'          => $this->quantity,
            'produit'           => $this->product ? $this->product->name  : "",
            'contact'           => $this->contact ? $this->contact->username : "",
            'created_at'        => $this->created_at ? $this->created_at->format('Y-m-d') : "",
        ];
    }
}
