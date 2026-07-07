<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\TblUsuario;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Session;

class CheckAuth
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
        // Se guarda la url
        $url = $request->path();

        // Inicializamos la paginación
        if (!Session::has('pagination')) {
            Session::put('pagination', 10);
        }

        // Obtiene la Sesión
        if (Session::has('token') && Session::has('user')) { 
            $tokenSession = Session::get('token'); 
        } else {
            $tokenSession = null;
        }

        // Valida la Sesión y después la Cookie
        if(!$tokenSession) {
            // Obtiene la Cookie
            $authCookie = Cookie::get('authCookie');
            if($authCookie) {
                // Busca el token de la Cookie en la BD
                $authCookie = json_decode($authCookie);
                $tokenBD = DB::table('tbl_login_tokens')->where('token', $authCookie->token)->first();

                // Valida si el token existe y si el usuario coincide
                if($tokenBD && ($authCookie->id_usuario == $tokenBD->id_usuario)) {
                    $user = TblUsuario::find($tokenBD->id_usuario);
                    if(!$user || $user->estado == 1){
                        // Borra todo y redirige a login
                        $this->resetCookieSession($request);
                        Session::put('url', $url);
                        return redirect(route('auth.login'));
                    } else {
                        // Crea la sesión con el token y el usuario
                        Session::put('token', $authCookie->token);
                        Session::put('user', $user);
                        return $next($request);
                    }
                } else {
                    Session::put('url', $url);
                    return redirect(route('auth.login'));
                }
            }
            Session::put('url', $url);
            return redirect(route('auth.login'));
        }

        // Si la Sesión existe lo deja pasar
        return $next($request);
    }

    // Borra la cookie y las Sesiones del Login
    public function resetCookieSession($request) {
        Cookie::queue(Cookie::forget('authCookie'));
        Session::forget('token');
        Session::forget('user');
    }
}
