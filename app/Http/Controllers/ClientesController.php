<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Ciudad;
use App\Models\TblCliente;
use App\Models\TblListaPrecio;
use App\Models\TblNoCompra;
use App\Models\TblSemanaRutero;
use App\Models\TblTipoCliente;
use App\Models\TblUsuario;
use Carbon\Carbon;
use Session;

use App\Mail\CorreoCliente;
use App\Jobs\CorreoClienteJob;
use Illuminate\Support\Facades\Mail;

class ClientesController extends Controller
{
    // Middleware que valida si el usuario está autenticado antes de acceder a cualquier método
    public function __construct()
    {
        $this->middleware('auth.check');
    }

    // Define que vista renderizar y con que información
    public function rutero($codigo_vendedor = null) {
        $hoy = Carbon::now();
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $orden = (isset($_GET['orden']) ? substr($_GET['orden'], 0, strpos($_GET['orden'], '|')) : 'secuencia');
        $sort = (isset($_GET['orden']) ? substr($_GET['orden'], strpos($_GET['orden'], '|') + 1) : 'asc');
        $estado = (isset($_GET['estado']) ? $_GET['estado'] : null);
        $busqueda = (isset($_GET['busqueda']) ? $_GET['busqueda'] : null);
        $fecha = (isset($_GET['fecha']) ? Carbon::parse($_GET['fecha']) : Carbon::now());
        $semana = Carbon::parse($fecha)->startofWeek()->next('thursday');
        $dia = substr($fecha->dayName, 0, 2);
        $vendedor = $usuario;

        if ($codigo_vendedor) {
            if ($usuario->nivel == 'u_administrador' || $usuario->nivel == 'u_supervisor') {
                $vendedor = TblUsuario::where('codigo_vendedor', $codigo_vendedor)->firstOrFail();
            } else {
                abort(403);
            }
        }

        $motivos = DB::table('tbl_no_compra_motivos')->orderBy('motivo')->get();
        $pqrs = Session::get('pqrs');
        if ($pqrs) {
            Session::forget('pqrs');
        }
        $clientes = TblCliente::from('tbl_cliente AS cli')
            ->leftJoin('tbl_comercial AS com', function ($join) use ($fecha) {
                $join->on('cli.id_cliente', 'com.id_cliente')
                    ->where('com.estado', 1)
                    ->whereDate('com.fecha_ingreso', $fecha->format('Y-m-d'));
            })
            ->leftJoin('tbl_no_compra AS noc', function ($join) use ($fecha) {
                $join->on('cli.id_cliente', 'noc.id_cliente')
                    ->whereDate('noc.fecha_no_compra', $fecha->format('Y-m-d'));
            })
            ->select(
                'cli.id_cliente',
                'cli.cc_nit',
                DB::raw('TRIM(cli.nombre_cliente) AS nombre_cliente'),
                DB::raw('TRIM(cli.telefono) AS telefono'),
                'cli.latitud',
                'cli.longitud',
                DB::raw('CASE WHEN cli.sec_' . $dia . ' > 0 THEN cli.sec_' . $dia . ' ELSE 999 END AS secuencia'),
                DB::raw('CASE WHEN COUNT(com.id_comercial) > 0 THEN 3 ELSE CASE WHEN noc.id_no_compra IS NOT NULL THEN 2 ELSE 1 END END AS estado_cli')
            )
            ->where('cli.codigo_vendedor', $vendedor->codigo_vendedor)
            ->where('cli.inactivo', 0)
            ->where($dia, 1)
            ->where('s' . $semana->weekOfMonth, 1)
            ->when($busqueda, function ($query) use ($busqueda) {
                return $query->where(function($query2) use ($busqueda) {
                    return $query2->whereRaw('UPPER(cli.nombre_cliente) LIKE ?', '%' . mb_strtoupper(str_replace(' ', '%', $busqueda)) . '%')
                        ->orWhereRaw('UPPER(cli.cc_nit) LIKE ?', '%' . mb_strtoupper(str_replace(' ', '%', $busqueda)) . '%');
                });
            })
            ->groupBy('cli.id_cliente', 'cli.cc_nit', 'cli.nombre_cliente', 'cli.telefono', 'cli.latitud', 'cli.longitud', 'cli.sec_' . $dia, 'noc.id_no_compra')
            ->when($estado, function ($query) use ($estado) {
                return $query->having('estado_cli', $estado);
            })
            ->orderBy($orden, $sort)
            ->orderBy('secuencia', 'asc')
            ->orderBy('cli.cc_nit', 'asc')
            ->distinct()
            ->get();

        $totalClientes = TblCliente::from('tbl_cliente AS cli')
            ->leftJoin('tbl_comercial AS com', function ($join) use ($fecha) {
                $join->on('cli.id_cliente', 'com.id_cliente')
                    ->where('com.estado', 1)
                    ->whereDate('com.fecha_ingreso', $fecha->format('Y-m-d'));
            })
            ->leftJoin('tbl_no_compra AS noc', function ($join) use ($fecha) {
                $join->on('cli.id_cliente', 'noc.id_cliente')
                    ->whereDate('noc.fecha_no_compra', $fecha->format('Y-m-d'));
            })
            ->select(
                'cli.id_cliente', 'cli.latitud', 'cli.longitud', DB::raw('CASE WHEN cli.sec_' . $dia . ' > 0 THEN cli.sec_' . $dia . ' ELSE 999 END AS secuencia'), DB::raw('CASE WHEN COUNT(com.id_comercial) > 0 THEN 3 ELSE CASE WHEN noc.id_no_compra IS NOT NULL THEN 2 ELSE 1 END END AS estado_cli')
            )
            ->where('cli.codigo_vendedor', $vendedor->codigo_vendedor)
            ->where('cli.inactivo', 0)
            ->where($dia, 1)
            ->where('s' . $semana->weekOfMonth, 1)
            ->groupBy('cli.id_cliente', 'cli.latitud', 'cli.longitud', 'cli.sec_' . $dia, 'noc.id_no_compra')
            ->orderBy($orden, $sort)
            ->orderBy('secuencia', 'asc')
            ->orderBy('cli.cc_nit', 'asc')
            ->distinct()
            ->get();

        $destino = null;
        $waypoints = '&waypoints=';
        foreach ($clientes as $key => $cliente) {
            if ($cliente->latitud && $cliente->longitud) {
                if ($destino) {
                    $waypoints = $waypoints . $destino . '|';
                }
                $destino = $cliente->latitud . ',' . $cliente->longitud;
            }
        }
        return view('clientes.rutero')->with(compact('hoy', 'usuario', 'vendedor', 'motivos', 'pqrs', 'clientes', 'semana', 'totalClientes', 'destino', 'waypoints', 'orden', 'sort', 'estado', 'busqueda', 'fecha'));
    }

    // Renderiza la vista de crear pedido
    public function create()
    {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $hoy = Carbon::now();
        $idMenu = 'crear-clientes';

        if ($usuario->crea_clientes != 1) {
            $mensaje = 'Hola <b class="capitalize">'. mb_strtolower($usuario->nombres). '</b>, al parecer te perdiste. No estás autorizado para crear clientes.';
            return view('error')->with(compact('usuario', 'mensaje'));
        }

        if ($usuario->nivel == 'u_comercial') {
            switch ($hoy->dayOfWeek) {
                case 7:
                    $mensaje = 'Hola <b class="capitalize">'. mb_strtolower($usuario->nombres). '</b>, la función de crear clientes no está disponible porque es domingo.';
                    return view('errorfull')->with(compact('usuario', 'mensaje'));
                    break;

                case 6:
                    if(Carbon::now()->diffInMinutes($usuario->limite_clientes_sa, false) < 0) {
                        $mensaje = 'Hola <b class="capitalize">'. mb_strtolower($usuario->nombres). '</b>, el día de hoy la función de crear clientes está disponible hasta las ' .Carbon::parse($usuario->limite_clientes_sa)->format('h:i a'). '.';
                        return view('errorfull')->with(compact('usuario', 'mensaje'));
                    }
                    break;

                default:
                    if(Carbon::now()->diffInMinutes($usuario->limite_clientes_lv, false) < 0) {
                        $mensaje = 'Hola <b class="capitalize">'. mb_strtolower($usuario->nombres). '</b>, el día de hoy la función de crear clientes está disponible hasta la ' .Carbon::parse($usuario->limite_clientes_lv)->format('h:i a'). '.';
                        return view('errorfull')->with(compact('usuario', 'mensaje'));
                    }
                    break;
            }
            $ciudades = Ciudad::orderBy('ciudad')->get();
            $tiposCliente = TblTipoCliente::where('id_canal', 5)->orderBy('clase')->get();
            return view('clientes.pdvnuevo')->with(compact('usuario', 'ciudades', 'tiposCliente'));
        } else {
            switch ($hoy->dayOfWeek) {
                case 7:
                    $mensaje = 'Hola <b class="capitalize">'. mb_strtolower($usuario->nombres). '</b>, la función de crear clientes no está disponible porque es domingo.';
                    return view('error')->with(compact('usuario', 'mensaje', 'idMenu'));
                    break;

                case 6:
                    if(Carbon::now()->diffInMinutes($usuario->limite_clientes_sa, false) < 0) {
                        $mensaje = 'Hola <b class="capitalize">'. mb_strtolower($usuario->nombres). '</b>, el día de hoy la función de crear clientes está disponible hasta las ' .Carbon::parse($usuario->limite_clientes_sa)->format('h:i a'). '.';
                        return view('error')->with(compact('usuario', 'mensaje', 'idMenu'));
                    }
                    break;

                default:
                    if(Carbon::now()->diffInMinutes($usuario->limite_clientes_lv, false) < 0) {
                        $mensaje = 'Hola <b class="capitalize">'. mb_strtolower($usuario->nombres). '</b>, el día de hoy la función de crear clientes está disponible hasta la ' .Carbon::parse($usuario->limite_clientes_lv)->format('h:i a'). '.';
                        return view('error')->with(compact('usuario', 'mensaje', 'idMenu'));
                    }
                    break;
            }
            $ciudades = Ciudad::orderBy('ciudad')->get();
            $listasPrecio = TblListaPrecio::where('codigo', '<>', '')->orderBy('codigo')->get();
            $tiposCliente = TblTipoCliente::where('sigla', '<>', '')->orderBy('sigla', 'asc')->get();
            return view('clientes.nuevo')->with(compact('usuario', 'ciudades', 'listasPrecio', 'tiposCliente'));
        }
    }

    public function store(Request $request) {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $hoy = Carbon::now();
        $idMenu = 'crear-clientes';
        if ($usuario->crea_clientes != 1) {
            $mensaje = 'Hola <b class="capitalize">'. mb_strtolower($usuario->nombres). '</b>, al parecer te perdiste. No estás autorizado para crear clientes.';
            return view('error')->with(compact('usuario', 'mensaje'));
        }

        switch ($hoy->dayOfWeek) {
            case 7:
                $mensaje = 'Hola <b class="capitalize">'. mb_strtolower($usuario->nombres). '</b>, la función de crear clientes no está disponible porque es domingo.';
                return view('error')->with(compact('usuario', 'mensaje', 'idMenu'));
                break;

            case 6:
                if(Carbon::now()->diffInMinutes($usuario->limite_clientes_sa, false) < 0) {
                    $mensaje = 'Hola <b class="capitalize">'. mb_strtolower($usuario->nombres). '</b>, el día de hoy la función de crear clientes está disponible hasta las ' .Carbon::parse($usuario->limite_clientes_sa)->format('h:i a'). '.';
                    return view('error')->with(compact('usuario', 'mensaje', 'idMenu'));
                }
                break;

            default:
                if(Carbon::now()->diffInMinutes($usuario->limite_clientes_lv, false) < 0) {
                    $mensaje = 'Hola <b class="capitalize">'. mb_strtolower($usuario->nombres). '</b>, el día de hoy la función de crear clientes está disponible hasta la ' .Carbon::parse($usuario->limite_clientes_lv)->format('h:i a'). '.';
                    return view('error')->with(compact('usuario', 'mensaje', 'idMenu'));
                }
                break;
        }
        $cliente = new TblCliente();
        $cliente->fill($request->all());

        // Convierte todos los atributos a mayúscula
        foreach ($cliente->getAttributes() as $el => $val) {
            $cliente->$el = mb_strtoupper($val);
        }

        $cliente->sucursal = str_pad($cliente->sucursal, 2, "0", STR_PAD_LEFT);
        $cliente->cc_nit = $cliente->codigo_cli .'.'. $cliente->sucursal;
        $cliente->nombre_cliente = mb_strtoupper($request->apellidos .' '. $request->nombres);
        $cliente->codigo_vendedor = $usuario->codigo_vendedor;
        $cliente->fecha_creacion = date('Y-m-d');
        $cliente->estado_cliente = 0;
        $cliente->aprobado_com = 0;
        $cliente->inactivo = 0;

        // Variables obligatorias pero que no se como llenar
        $cliente->interno = 0;
        $cliente->ruta = '';
        $cliente->fecha_modificacion = '1970-01-01';
        $cliente->fecha_descuento = '';
        $cliente->latitud = '';
        $cliente->longitud = '';
        $cliente->precision = '';
        $cliente->cedula = $cliente->codigo_cli;
        $cliente->tipo_cliente = $cliente->tipoCliente->clase;

        if($request->firma){
            $image_64 = $request->firma;
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
            $replace = substr($image_64, 0, strpos($image_64, ',')+1);

            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $nombre = $cliente->cc_nit.'.'.$extension;
            Storage::disk('private')->put('/clientes/firmas/' . $nombre, base64_decode($image));
            $cliente->firma = 'clientes/firmas/' . $nombre;
        }
        $cliente->save();

        try {
            dispatch(new CorreoClienteJob($usuario, $cliente));
            //Mail::to($usuario->correo_jefe)->send(new CorreoCliente($usuario, $cliente));
        } catch (\Throwable $th) {
            //throw $th;
        }
        $variablesUrl = 'cliente=' .$cliente->id_cliente. '&hora=' .date('Y-m-d H:i:s');
        return redirect(route('dashboard', $variablesUrl));
    }

    public function storePdv(Request $request) {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $hoy = Carbon::now();
        if ($usuario->crea_clientes != 1) {
            $mensaje = 'Hola <b class="capitalize">'. mb_strtolower($usuario->nombres). '</b>, al parecer te perdiste. No estás autorizado para crear clientes.';
            return view('errorfull')->with(compact('usuario', 'mensaje'));
        }

        switch ($hoy->dayOfWeek) {
            case 7:
                $mensaje = 'Hola <b class="capitalize">'. mb_strtolower($usuario->nombres). '</b>, la función de crear clientes no está disponible porque es domingo.';
                return view('errorfull')->with(compact('usuario', 'mensaje'));
                break;

            case 6:
                if(Carbon::now()->diffInMinutes($usuario->limite_clientes_sa, false) < 0) {
                    $mensaje = 'Hola <b class="capitalize">'. mb_strtolower($usuario->nombres). '</b>, el día de hoy la función de crear clientes está disponible hasta las ' .Carbon::parse($usuario->limite_clientes_sa)->format('h:i a'). '.';
                    return view('errorfull')->with(compact('usuario', 'mensaje'));
                }
                break;

            default:
                if(Carbon::now()->diffInMinutes($usuario->limite_clientes_lv, false) < 0) {
                    $mensaje = 'Hola <b class="capitalize">'. mb_strtolower($usuario->nombres). '</b>, el día de hoy la función de crear clientes está disponible hasta la ' .Carbon::parse($usuario->limite_clientes_lv)->format('h:i a'). '.';
                    return view('errorfull')->with(compact('usuario', 'mensaje'));
                }
                break;
        }
        $cliente = new TblCliente();
        $cliente->fill($request->all());

        // Convierte todos los atributos a mayúscula
        foreach ($cliente->getAttributes() as $el => $val) {
            $cliente->$el = mb_strtoupper($val);
        }

        $cliente->sucursal = '00';
        $cliente->cc_nit = $cliente->codigo_cli .'.'. $cliente->sucursal;
        $cliente->nombre_cliente = mb_strtoupper($request->apellidos .' '. $request->nombres);
        $cliente->codigo_vendedor = $usuario->codigo_vendedor;
        $cliente->fecha_creacion = date('Y-m-d');
        $cliente->id_tipo_cliente = 56;
        $cliente->estado_cliente = 0;
        $cliente->aprobado_com = 1;
        $cliente->inactivo = 0;
        $cliente->lista_precio = $usuario->lista_precio;

        // Variables obligatorias pero que no se como llenar
        $cliente->interno = 0;
        $cliente->ruta = '';
        $cliente->fecha_modificacion = '1970-01-01';
        $cliente->fecha_descuento = '';
        $cliente->latitud = '';
        $cliente->longitud = '';
        $cliente->precision = '';
        $cliente->cedula = $cliente->codigo_cli;

        if($request->firma){
            $image_64 = $request->firma;
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
            $replace = substr($image_64, 0, strpos($image_64, ',')+1);

            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $nombre = $cliente->cc_nit.'.'.$extension;
            Storage::disk('private')->put('/clientes/firmas/' . $nombre, base64_decode($image));
            $cliente->firma = 'clientes/firmas/' . $nombre;
        }
        $cliente->save();

        // Valida si hay imágen adjunta
        if($request->imagen_cedula){
            // dd($request->imagen_cedula);
            $extension = $request->imagen_cedula->getClientOriginalExtension();
            // dd($extension);
            // Crea el nombre, guarda la imágen y guarda la ruta en la BD
            $nombre = $cliente->id_cliente .'-'. $cliente->cedula .'.'. $extension;
            Storage::disk('private')->put('/clientes/cedulas/' . $nombre, \File::get($request->imagen_cedula));
            $cliente->imagen_cedula = 'clientes/cedulas/' . $nombre;
            $cliente->save();
        }

        try {
            dispatch(new CorreoClienteJob($usuario, $cliente));
            //Mail::to($usuario->correo_jefe)->send(new CorreoCliente($usuario, $cliente));
        } catch (\Throwable $th) {
            //throw $th;
        }
        Session::put('cliente_creado', $cliente);
        return redirect(route('clientes.create'));
    }

    public function show($cc_nit) {
        $hoy = Carbon::now();
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $cliente = TblCliente::where('cc_nit', $cc_nit)->firstOrFail();
        if ($usuario->nivel != 'u_administrador' && $usuario->nivel != 'u_supervisor') {
            if (trim($cliente->codigo_vendedor) != trim($usuario->codigo_vendedor))
                abort(403);
        }
        $noCompras = TblNoCompra::where('id_cliente', $cliente->id_cliente)->get();
        return view('clientes.ver')->with(compact('usuario', 'cliente', 'hoy'));
    }

    public function correo($idCliente) {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        if ($usuario->nivel != 'u_administrador') {
            abort(404);
        }
        $cliente = TblCliente::find($idCliente);
        dispatch(new CorreoClienteJob($usuario, $cliente));
        //Mail::to($usuario->correo_jefe)->send(new CorreoCliente($usuario, $cliente));
        return view('correos.nuevocliente')->with(compact('usuario', 'cliente'));
    }

    public function validarCliente($codigo_cli, $sucursal) {
        $cliente = TblCliente::where('codigo_cli', $codigo_cli)->first();
        $cc_nit = $codigo_cli .'.'. str_pad($sucursal, 2, "0", STR_PAD_LEFT);
        $sucursal = TblCliente::where('cc_nit', $cc_nit)->first();
        return response()->json(compact('cliente', 'sucursal'), 200);
    }

    public function validarVendedorVD($documento_vendedorVD) {
        $vendedor = TblUsuario::where('documento', $documento_vendedorVD)->where('nivel', 'u_ventadirecta')->where('codigo_vendedor', 'NOT LIKE', 'VD%')->where('codigo_vendedor', 'NOT LIKE', 'VI%')->first();

        return response()->json(compact('vendedor'), 200);
    }
}
