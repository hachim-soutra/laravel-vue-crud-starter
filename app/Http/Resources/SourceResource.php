<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SourceResource extends JsonResource
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
            'name'       => $this->name,
            'type'      => $this->type,
            'status'      => $this->status,
            'orders'       => $this->orders,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
