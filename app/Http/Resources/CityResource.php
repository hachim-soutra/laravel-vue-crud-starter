<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
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
            'name'          => $this->name,
            'orders'        => $this->orders->count(),
            'users'        => $this->users->count(),
            'consumers'     => $this->consumers->count(),
            'delivers'      => $this->delivers->count(),
            'created_at'    => $this->created_at->format('Y-m-d'),
        ];
    }
}
