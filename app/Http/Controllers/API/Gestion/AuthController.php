<?php

namespace App\Http\Controllers\API\Gestion;

use App\Http\Controllers\Controller;
use App\Http\Resources\GestionResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::guard('gestion')->attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = auth()->guard('gestion')->user();
        $tokenResult = $user->createToken('gestions');
        $token = $tokenResult->token;
        $token->save();
        return response()->json([
            'access_token'  => $tokenResult->accessToken,
            'user'          => $user,
            'space'         => 'gestion',
            'token_type'    => 'Bearer',
            'expires_at'    => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    public function verify()
    {
        $user = new GestionResource(auth()->user());
        return $this->sendResponse($user, 'Gestion Details');
    }
    public function updateInfo(Request $request)
    {
        $this->validate($request, [
            'city_id' => 'required|exists:cities,id',
            'nom' => 'required|string|max:191',
            'ville' => 'required|string|max:191',
            'adresse' => 'required|string|max:191',
            'prenom' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users'
        ]);
        $user = auth()->user()->update(
            $request->all()
        );
        return $this->sendResponse($user, 'Gestion Details');
    }
    public function getInfo(Request $request)
    {
        $user = auth()->user();
        return $this->sendResponse($user, 'Gestion Details');
    }
}
