<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Resources\PermissionCollection;
use App\Http\Resources\PermissionResource;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class PermissionController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $Permissions = new PermissionCollection(Permission::latest()->get());
          return $this->sendResponse($Permissions, 'Permissions list');
    }
    public function indexByRole($id)
    {
        $role = Role::find($id);
        $Permissions = new PermissionCollection($role->permissions);
        return $this->sendResponse($Permissions, 'Permissions list');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Permission = Permission::create([
            'name' => $request['name'],
            'role_id' => $request['role_id'],
        ]);
        return $this->sendResponse($Permission, 'Permission Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Permission = new PermissionResource(Permission::findOrFail($id));
        return $this->sendResponse($Permission, 'Permission Details');

    }

    public function update(Request $request, $id)
    {

        $user = Permission::findOrFail($id);

        $user->update($request->all());

        return $this->sendResponse($user, 'Permission Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Permission::findOrFail($id);
        // delete the user

        $user->delete();

        return $this->sendResponse([$user], 'Permission has been Deleted');
    }
}
