<?php

namespace App\Http\Resources;

use Spatie\Permission\Models\Permission;
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
            'permissions'       => $this->getDirectPermissions(),
            'admin'             => $this->admin ? $this->admin->name : '',
            'isOnline'          => $this->last_activity ? true : false,
            'status'            => $this->status,
            'phone'             => $this->phone,
            'city_id'             => $this->city_id,
            'orders'            => 0,
            'notificactions'    => $this->unreadNotifications,
            'created_at'        => $this->created_at ? $this->created_at->format('Y-m-d') : "",
        ];
    }
}
