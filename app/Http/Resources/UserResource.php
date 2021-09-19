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
            'role_id'           => $this->role_id ? $this->role_id : 2,
            'admin'             => $this->admin ? $this->admin->name : '',
            'status'            => $this->status,
            'phone'             => $this->phone,
            'city_id'             => $this->city_id,
            'orders'            => 0,

            'canShowPays'    => $this->can(Permission::find(9)->name),
            'canAddPays'     => $this->can(Permission::find(10)->name),
            'canUpdatePays'  => $this->can(Permission::find(11)->name),

            'canShowPartner'    => $this->can(Permission::find(12)->name),
            'canAddPartner'     => $this->can(Permission::find(13)->name),
            'canUpdatePartner'  => $this->can(Permission::find(14)->name),

            'canShowUser'    => $this->can(Permission::find(15)->name),
            'canAddUser'     => $this->can(Permission::find(16)->name),
            'canUpdateUser'  => $this->can(Permission::find(17)->name),

            'canShowProduit'    => $this->can(Permission::find(18)->name),
            'canAddProduit'     => $this->can(Permission::find(19)->name),
            'canUpdateProduit'  => $this->can(Permission::find(20)->name),

            'canShowLivreur'    => $this->can(Permission::find(21)->name),
            'canAddLivreur'     => $this->can(Permission::find(22)->name),
            'canUpdateLivreur'  => $this->can(Permission::find(23)->name),

            'canShowGestion'    => $this->can(Permission::find(24)->name),
            'canAddGestion'     => $this->can(Permission::find(25)->name),
            'canUpdateGestion'  => $this->can(Permission::find(26)->name),

            'canShowCmd'    => $this->can(Permission::find(27)->name),
            'canShowCmdR'    => $this->can(Permission::find(28)->name),
            'canShowCmdRe'    => $this->can(Permission::find(29)->name),
            'canAddCmd'     => $this->can(Permission::find(30)->name),
            'canUpdateCmd'  => $this->can(Permission::find(31)->name),

            'notificactions'    => $this->unreadNotifications,
            'created_at'        => $this->created_at ? $this->created_at->format('Y-m-d') : "",

        ];
    }
}
