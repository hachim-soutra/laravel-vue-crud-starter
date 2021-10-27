<?php

namespace App\Http\Resources;

use DateTime;
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
            'role_id'           => $this->roles->first() ? $this->roles->first()->id : 1,
            'role_name'         =>  $this->roles->first() ? $this->roles->first()->name : '',
            'role'              => $this->getRoleNames(),
            'permissions'       => $this->getDirectPermissions(),
            'admin'             => $this->admin ? $this->admin->name : '',
            'isOnline'          => $this->last_activity ? $this->last_activity < now()->subMinutes(5)->format('Y-m-d H:i:s') : false,
            'status'            => $this->status,
            'phone'             => $this->phone,
            'city_id'             => $this->city_id,
            'city'             => $this->country,
            'orders'            => 0,
            'rammasage'            => $this->rammasage(),
            'notificactions'    => $this->unreadNotifications,
            // 'created_at'        => $this->created_at ? $this->created_at->format('Y-m-d') : "",
        ];
    }
}
