<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

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
            'users'         => User::where('city_id', 'like', "%{$this->id}%")->count(),
            'delivers'      => $this->delivers->count(),
            'created_at'    => $this->created_at->format('Y-m-d'),
        ];
    }
}
