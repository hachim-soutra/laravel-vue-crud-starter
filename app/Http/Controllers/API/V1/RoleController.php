<?php
namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends BaseController
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
        $roles = Role::all();
        // $permission = Permission::get();
        return $this->sendResponse($roles, 'Roles list');
    }

    public function store(Request $request)

    {

        $this->validate($request, [

            'name' => 'required|unique:roles,name',

            'permission' => 'required',

        ]);



        $role = Role::create(['name' => $request->input('name')]);

        $role->syncPermissions($request->input('permission'));



        return redirect()->route('roles.index')

                        ->with('success','Role created successfully');

    }
    public function show($id)

    {

        $role = Role::find($id);

        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")

            ->where("role_has_permissions.role_id",$id)

            ->get();



        return view('roles.show',compact('role','rolePermissions'));

    }

    public function update(Request $request, $id)

    {

        $this->validate($request, [

            'name' => 'required',

            'permission' => 'required',

        ]);



        $role = Role::find($id);

        $role->name = $request->input('name');

        $role->save();



        $role->syncPermissions($request->input('permission'));



        return redirect()->route('roles.index')

                        ->with('success','Role updated successfully');

    }

}
