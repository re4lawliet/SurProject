<?php

namespace SUR\Http\Middleware;

use \Illuminate\Contracts\Auth\Guard;
use Closure;
use Session;

class Admin
{
    protected $auth;

    public function __construct(Guard $auth){

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
        if($this->auth->user()->rol == 'admin'){
            return $next($request);
        }elseif ($this->auth->user()->rol == 'colaborador'){
            return $next($request);
        }else{
            Session::flash('message-error','Sin Privilegios');
            return redirect()->to('/');
        }
        
    }
}
