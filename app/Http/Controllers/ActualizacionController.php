<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TblUsuario;
use Session;

class ActualizacionController extends Controller
{
    // Middleware que valida si el usuario está autenticado antes de acceder a cualquier método
    public function __construct()
    {
        $this->middleware('auth.check');
    }

    // Define que vista renderizar y con que información
    public function show()
    {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        if ($usuario->nivel == 'u_administrador') {
            if (strtolower(PHP_OS) == 'linux') {
                $pwd = trim(shell_exec('pwd'));
                if (str_contains($pwd, '/public')) {
                    $pwd = substr($pwd, 0, strrpos($pwd, '/public', strlen($pwd) - 8));
                    $fetch = shell_exec('cd ' . $pwd . ' && sudo -u soporte git fetch origin 2>&1');
                    $status = shell_exec('cd ' . $pwd . ' && sudo -u soporte git diff origin/master master 2>&1');
                } else {
                    
                    $fetch = shell_exec('sudo -u soporte git fetch origin 2>&1');
                    $fetch = shell_exec('ATBB3TEu72V5cwNsrqxmShy5zEqj0FB0F4DF');
                    $status = shell_exec('sudo -u soporte git diff origin/master master 2>&1');
                    if (str_contains($fetch, 'not found')) {
                        $idMenu = 'actualizar';
                        $mensaje = 'La actualización desde la interfaz no está disponible para deployados en Shared Hosting.';
                        return view('error')->with(compact('usuario', 'mensaje', 'idMenu'));
                    }
                }
                if ($status) {
                    $detalles = [];
                    foreach (explode("\n",$status) as $linea) {
                        if (str_contains($linea, '---') || str_contains($linea, '+++')) {
                            array_push($detalles, $linea);
                        }
                    }
                    return view('actualizaciones.actualizar')->with(compact('usuario', 'status', 'detalles'));
                } else {
                    return view('actualizaciones.actualizado')->with(compact('usuario'));
                }
            } else {
                $idMenu = 'actualizar';
                $mensaje = 'La actualización desde la interfaz sólo está disponible para deployados en Linux.';
                return view('error')->with(compact('usuario', 'mensaje', 'idMenu'));
            }
        } else {
            abort(403);
        }
    }

    public function update(Request $request)
    {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        if ($usuario->nivel == 'u_administrador') {
            $pwd = trim(shell_exec('pwd'));
            if (strrpos($pwd, '/public', strlen($pwd) - 8)) {
                $pwd = substr($pwd, 0, strrpos($pwd, '/public', strlen($pwd) - 8));
                $pull = shell_exec('cd ' . $pwd . ' && sudo -u soporte git pull origin master 2>&1');
            } else {
                $pull = shell_exec('sudo -u soporte git pull origin master 2>&1');
                if (str_contains($pull, 'not found')) {
                    $idMenu = 'actualizar';
                    $mensaje = 'La actualización desde la interfaz no está disponible para deployados en Shared Hosting.';
                    return view('error')->with(compact('usuario', 'mensaje', 'idMenu'));
                }
            }
            if (str_contains($pull, 'Actualizando')) {
                $detalle = explode("\n",$pull);
                $data = json_encode(compact('data', 'detalle'));
                Session::put('actualizacion', $data);
            }
            return redirect(route('actualizar'));
        } else {
            abort(403);
        }
    }

    public function ipbd() {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        if ($usuario->nivel == 'u_administrador') {
            if (strtolower(PHP_OS) == 'linux') {
                $pwd = trim(shell_exec('pwd'));
                if (strrpos($pwd, '/public', strlen($pwd) - 8)) {
                    $pwd = substr($pwd, 0, strrpos($pwd, '/public', strlen($pwd) - 8));
                    $cd = shell_exec('cd ' . $pwd . ' && ls -a');
                } else {
                    $cd = shell_exec('ls -a');
                }
                $list = preg_split("/\r\n|\n|\r/", $cd);
            } elseif(strtolower(PHP_OS) == 'winnt') {
                $pwd = trim(shell_exec('cd'));
                $pwd = substr($pwd, 0, strrpos($pwd, '\\public', strlen($pwd) - 8));
                $cd = shell_exec('cd ' . $pwd . ' && dir');
                $list = preg_split("/\r\n|\n|\r/", $cd);
            } else {
                $idMenu = 'ipbd';
                $mensaje = 'El cambio de ip de la Base de Datos desde la interfaz sólo está disponible para deployados en Linux y en Windows.';
                return view('error')->with(compact('usuario', 'mensaje', 'idMenu'));
            }

            $archivos = [];
            $actual = '';
            for ($i=0; $i < count($list); $i++) {
                if (str_contains($list[$i], '.env')) {
                    $servidor_bd = '';
                    $nombre_bd = '';
                    $servidor_bdpqrs = '';
                    $nombre_bdpqrs = '';
                    if (strtolower(PHP_OS) == 'linux') {
                        $nombre = trim($list[$i]);
                        if (sha1_file($pwd . '/' . $nombre) == sha1_file($pwd . '/.env')) {
                            $actual = $nombre;
                        }
                    } else {
                        $nombre = trim(substr($list[$i], strpos($list[$i], '.env')));
                        if (sha1_file($pwd . '\\' . $nombre) == sha1_file($pwd . '\\.env')) {
                            $actual = $nombre;
                        }
                    }
                    if ($nombre != '.env.example' && $nombre != '.env') {
                        if (strtolower(PHP_OS) == 'linux') {
                            $ruta = $pwd . '/' . $nombre;
                        } else {
                            $ruta = $pwd . '\\' . $nombre;
                        }
                        $archivo = fopen($ruta, 'r');
                        $totalLineas = 0;
                        while (!feof($archivo)) {
                            $linea = fgets($archivo);
                            $totalLineas++;
                            if (strlen($linea)) {
                                switch ($linea) {
                                    case str_contains($linea, 'DB_HOST'):
                                        $servidor_bd = trim(substr($linea, strpos($linea, '=') + 1));
                                        break;
                                    case str_contains($linea, 'DB_DATABASE'):
                                        $nombre_bd = trim(substr($linea, strpos($linea, '=') + 1));
                                        break;
                                    case str_contains($linea, 'PQRS_HOST'):
                                        $servidor_bdpqrs = trim(substr($linea, strpos($linea, '=') + 1));
                                        break;
                                    case str_contains($linea, 'PQRS_DATABASE'):
                                        $nombre_bdpqrs = trim(substr($linea, strpos($linea, '=') + 1));
                                        break;
                                    default:
                                        break;
                                }
                            }
                        }
                        array_push($archivos, compact('nombre', 'servidor_bd', 'nombre_bd', 'servidor_bdpqrs', 'nombre_bdpqrs'));
                        fclose($archivo);
                    }
                }
            }

            return view('actualizaciones.ipbd')->with(compact('usuario', 'actual', 'archivos'));
        } else {
            abort(403);
        }
    }
    
    public function ipbdupdate(Request $request) {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        if ($usuario->nivel == 'u_administrador') {
            if (strtolower(PHP_OS) == 'linux') {
                $pwd = trim(shell_exec('pwd'));
                if (strrpos($pwd, '/public', strlen($pwd) - 8)) {
                    $pwd = substr($pwd, 0, strrpos($pwd, '/public', strlen($pwd) - 8));
                    $copy = shell_exec('cd ' . $pwd . ' && cp ' . $request->archivo . ' .env');
                } else {
                    $copy = shell_exec('cp ' . $request->archivo . ' .env');
                }
                return redirect(route('ipbd'));
            } elseif(strtolower(PHP_OS) == 'winnt') {
                $pwd = trim(shell_exec('cd'));
                $pwd = substr($pwd, 0, strrpos($pwd, '\\public', strlen($pwd) - 8));
                $copy = shell_exec('copy ' . $pwd . '\\' . $request->archivo . ' ' . $pwd . '\\.env && S');
                return redirect(route('ipbd'));
            } else {
                $idMenu = 'ipbd';
                $mensaje = 'El cambio de ip de la Base de Datos desde la interfaz sólo está disponible para deployados en Linux y en Windows.';
                return view('error')->with(compact('usuario', 'mensaje', 'idMenu'));
            }
        } else {
            abort(403);
        }
    }
}
