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
            $captchaImage = $this->nuevoCaptcha();
            return view('auth.login', compact('captchaImage'));
        }
    }

    public function authentication(Request $request) {
        $data = $request->all();
        $errores = [];
        $inputs = [];

        $captchaValido = Session::has('captcha_code') && strcasecmp((string) $request->captcha, Session::get('captcha_code')) === 0;
        Session::forget('captcha_code');

        if (!$captchaValido) {
            $errores['captcha'] = 'El código de verificación es incorrecto';
            $inputs = [ 'usuario' => $request->usuario ];
        } else {
            $data['clave'] = md5(sha1($request->clave));
            $usuario = TblUsuario::where(DB::raw('BINARY `login`'), $data['usuario'])->where('estado', 0)->first();

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
                    $errores['clave'] = 'La contraseña es errónea';
                    $inputs = [ 'usuario' => $request->usuario ];
                }
            } else {
                $errores['usuario'] = 'El usuario no se encuentra registrado';
            }
        }

        $captchaImage = $this->nuevoCaptcha();
        return view('auth.login')->withErrors($errores)->with(compact('inputs', 'captchaImage'));
    }

    public function captcha() {
        return response()->json(['image' => $this->nuevoCaptcha()]);
    }

    public function logout() {
        Session::flush();
        Cookie::queue(Cookie::forget('authCookie'));
        return redirect(route('auth.login'));
    }

    private function nuevoCaptcha(): string {
        $codigo = $this->generarCodigoCaptcha();
        Session::put('captcha_code', $codigo);
        return $this->generarImagenCaptcha($codigo);
    }

    private function generarCodigoCaptcha(int $longitud = 5): string {
        $caracteres = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; // sin O, I, 0, 1 para evitar ambigüedad
        $codigo = '';
        for ($i = 0; $i < $longitud; $i++) {
            $codigo .= $caracteres[random_int(0, strlen($caracteres) - 1)];
        }
        return $codigo;
    }

    private function generarImagenCaptcha(string $codigo): string {
        $ancho = 150;
        $alto = 50;
        $imagen = imagecreatetruecolor($ancho, $alto);

        $fondo = imagecolorallocate($imagen, 255, 255, 255);
        imagefilledrectangle($imagen, 0, 0, $ancho, $alto, $fondo);

        for ($i = 0; $i < 6; $i++) {
            $colorLinea = imagecolorallocate($imagen, random_int(150, 200), random_int(150, 200), random_int(150, 200));
            imageline($imagen, random_int(0, $ancho), random_int(0, $alto), random_int(0, $ancho), random_int(0, $alto), $colorLinea);
        }

        for ($i = 0; $i < 300; $i++) {
            $colorPunto = imagecolorallocate($imagen, random_int(180, 220), random_int(180, 220), random_int(180, 220));
            imagesetpixel($imagen, random_int(0, $ancho), random_int(0, $alto), $colorPunto);
        }

        $colorTexto = imagecolorallocate($imagen, 40, 40, 40);
        $x = 15;
        foreach (str_split($codigo) as $caracter) {
            $tamanoFuente = random_int(4, 5);
            $y = random_int(8, 18);
            imagestring($imagen, $tamanoFuente, $x, $y, $caracter, $colorTexto);
            $x += 25;
        }

        ob_start();
        imagepng($imagen);
        $datosImagen = ob_get_clean();
        imagedestroy($imagen);

        return base64_encode($datosImagen);
    }
}
