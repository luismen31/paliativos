<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user()->ID_GRUPO_USUARIO != 1){
            
            $request->session()->flash('msj_error', 'No tiene permitido acceder a este modulo');
            return redirect()->to('/');
        }
        return $next($request);
    }
}
