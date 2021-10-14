<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Factory as Auth;
class LastActivityUser
{
     /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
    * Create a new middleware instance.
    *
    * @param  \Illuminate\Contracts\Auth\Factory  $auth
    * @return void
    */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
   public function handle($request, Closure $next)
   {
        app()->setLocale('fr');
        if ($this->auth->check() && $this->auth->user()->last_activity < now()->subMinutes(5)->format('Y-m-d H:i:s')) {
            $user = $this->auth->user();
            $user->last_activity = now();
            $user->timestamps = false;
            $user->save();
       }
       return $next($request);
   }
}
