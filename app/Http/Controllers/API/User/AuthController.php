<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Mail\NouveauMotDePasse as MailNouveauMotDePasse;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token'  => $tokenResult->accessToken,
            'user'          => auth()->user(),
            'space'         => 'agency',
            'token_type'    => 'Bearer',
            'expires_at'    => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    public function forgetPassword(Request $request)
    {
        $userModel = DB::table('users')->where('email', $request->email)->first();
        if ($userModel) {
            // Delete all old requests before to do the next
            DB::table('password_resets')->where('email', $request->email)->delete();
            //create a new token to be sent to the user.
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => Str::random(60),
                'created_at' => Carbon::now()
            ]);

            $tokenData = DB::table('password_resets')->latest()->where('email', $request->email)->first();
            $token = $tokenData->token;
            Mail::to($request->email)->send(new MailNouveauMotDePasse($token));

            return response()->json([
                'msg'   => 'ok'
            ], 201);
        } else {
            return  response()->json([
                'msg' => 'No'
            ], 404);
        }
    }

    public function changePassword(Request $request, $token)
    {
        $tokenData = DB::table('password_resets')->where('token', $token)->first();
        $user = User::where('email','like',$tokenData->email)->first();
        dd($user);
        if ($tokenData) {
            $user->password = bcrypt($request['password']);
            $user->save();
            DB::table('password_resets')->where('email',$tokenData->email)->delete();
            return response()->json(['msg' => 'Mot de pass mise a jour avec success'], 201);
        } else {
            return  response()->json([
                'msg' => 'Email incorrect'
            ], 404);
        }
    }

}
