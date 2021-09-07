<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email'             => $this->email,
            'country'           => $this->country ? $this->country->name : '',
            'role'              => $this->getRoleNames(),
            'role_id'           => $this->role_id ? $this->role_id : 2,
            'admin'             => $this->admin ? $this->admin->name : '',
            'status'            => $this->status,
            'phone'             => $this->phone,
            'orders'            => 0,
            'notificactions'    => $this->unreadNotifications,
            'created_at'        => $this->created_at ? $this->created_at->format('Y-m-d') : "",
        ];
    }
}
