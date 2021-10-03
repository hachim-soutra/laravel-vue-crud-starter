<?php

namespace App\Http\Controllers\API\V1;

use App\Events\UserRegistred;
use App\Http\Requests\Users\UserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\newUser;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends BaseController
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

        // $this->authorize('isAdmin');

        $users = new UserCollection(User::latest()->get());

        return $this->sendResponse($users, 'Users list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Users\UserRequest  $request
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'city_id' => $request['city_id'],
            'role_id' => $request['role_id'],
            'user_id' => auth()->user()->id,
            'status' => $request['status'],
        ]);
        $user->assignRole(Role::find($request->input('role')));
        $user->givePermissionTo($request['permissions']);
        UserRegistred::dispatch(auth()->user());
        return $this->sendResponse($user, 'User Created Successfully');
    }
    public function show($id)
    {
        $user = new UserResource(User::findOrFail($id));

        return $this->sendResponse($user, 'user Details');
    }
    /**
     * Update the resource in storage
     *
     * @param  \App\Http\Requests\Users\UserRequest  $request
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if (!empty($request->password)) {
            $request->merge(['password' => Hash::make($request['password'])]);
        }
        $user->update($request->all());
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->roles()->detach();
        $user->assignRole(Role::find($request->input('role_id')));
        $user->permissions()->detach();
        if($request['permissions']) {
            foreach ($request['permissions'] as  $value) {
                $user->givePermissionTo($value['name']);
            };
        }
        return $this->sendResponse($user, 'User Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = User::findOrFail($id);

        $user->delete();

        return $this->sendResponse([$user], 'User has been Deleted');
    }

    public function verify()
    {
        $user = new UserResource(auth()->user());
        return $this->sendResponse($user, 'user Details');
    }

    public function markNotification(Request $request)
    {
        auth()->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

        return response()->noContent();
    }
}
