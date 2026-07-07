<?php

namespace App\Http\Controllers;

use App\Models\TblUsuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Session;
use Redirect;

class AuthController extends Controller
{
    public function login() {
        if (Session::has('token')) {
            return redirect()->route('dashboard');//cuando haya vista de dashboard se pone acá
        } else {
            return view('auth.login');
        }
    }

    public function authentication(Request $request) {
        $data = $request->all();
        $data['clave'] = md5(sha1($request->clave));
        $usuario = TblUsuario::where(DB::raw('BINARY `login`'), $data['usuario'])->where('estado', 0)->first();
        $errores = [];
        $inputs = [];


        if($usuario) {
            if($usuario->clave == $data['clave']) {
                $random = Str::random(40);
                Session::put('user', $usuario);
                Session::put('token', $random);
    
                if(isset($data['remember'])) {
                    $datatoken = ['id_usuario' => $usuario->id_usuario, 'token' => $random, 'created_at' => Carbon::now()];
                    DB::table('tbl_login_tokens')->insert(
                        $datatoken
                    );
                    Cookie::queue(Cookie::make('authCookie', json_encode($datatoken), 130000));
                }

                if (Session::has('url') && Session::get('url') != 'login') {
                    $url = Session::get('url');
                    Session::forget('url');
                    return redirect(url($url));
                } else {
                    return redirect()->route('dashboard');
                }
            } else {
                $errores = [ 'clave' => 'La contraseña es errónea' ];
                $inputs = [ 'usuario' => $request->usuario ];
            }
        } else {
            $errores = [
                'usuario' => 'El usuario no se encuentra registrado'
            ];
        }
        return view('auth.login')->withErrors($errores)->with(compact('inputs'));
    }

    public function logout() {
        Session::flush();
        Cookie::queue(Cookie::forget('authCookie'));
        return redirect(route('auth.login'));
    }
}
