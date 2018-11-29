<?php

namespace SUR\Http\Middleware;

use \Illuminate\Contracts\Auth\Guard;
use Closure;
use Session;

class Compras
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function __construct(Guard $auth){

        $this->auth = $auth;

    }
    public function handle($request, Closure $next)
    {
        if($this->auth->user()->rol != 'compras'){
            Session::flash('message-error','Sin Privilegios');
            return redirect()->to('/');
        }
        return $next($request);
    }
}
