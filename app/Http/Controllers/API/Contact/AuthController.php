<?php

namespace App\Http\Controllers\API\Contact;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
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
        if (!auth()->guard('contact')->attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        $user = auth()->guard('contact')->user();
        $tokenResult = $user->createToken('contact');
        $token = $tokenResult->token;
        $token->save();
        return response()->json([
            'access_token'  => $tokenResult->accessToken,
            'user'          => $user,
            'space'         => 'contact',
            'token_type'    => 'Bearer',
            'expires_at'    => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    public function verify()
    {
        $user = new ContactResource(auth()->user());
        return $this->sendResponse($user, 'contact Details');
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
        $user = auth()->guard('contact')->user()->update(
            $request->all()
        );
        return $this->sendResponse($user, 'contact Details');
    }
    public function getInfo(Request $request)
    {
        $user = auth()->guard('contact')->user();
        return $this->sendResponse($user, 'contact Details');
    }
}
