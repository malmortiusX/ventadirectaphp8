<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TblSolicitudDescuento;
use App\Models\TblUsuario;
use Carbon\Carbon;
use Session;

class SolicitudesSDescuentoController extends Controller
{
    // Middleware que valida si el usuario está autenticado antes de acceder a cualquier método
    public function __construct()
    {
        $this->middleware('auth.check');
    }

    // Renderiza la vista de crear una solicitud
    public function index() {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $estado = (isset($_GET['estado']) ? $_GET['estado'] : '5');
        $cliente = (isset($_GET['cliente']) ? $_GET['cliente'] : null);
        $fechaDescuento = (isset($_GET['fecha_descuento']) ? $_GET['fecha_descuento'] : '');
        if ($usuario->bloquear_descuento != 0) {
            $mensaje = 'Hola <b class="capitalize">'. mb_strtolower($usuario->nombres). '</b>, al parecer te perdiste. No estás autorizado para solicitar descuentos.';
            return view('error')->with(compact('usuario', 'mensaje'));
        }
        if (isset($_GET['perPage'])) {
            Session::put('pagination', $_GET['perPage']);
        }
        $hoy = Carbon::now();
        $solicitudes = DB::table('tbl_solicitud_descuento AS sdc')
            ->leftJoin('tbl_producto AS pro', 'sdc.codigo_producto', 'pro.codigo')
            ->leftJoin('tbl_cliente AS cli', 'sdc.id_cliente', 'cli.id_cliente')
            ->leftJoin('tbl_usuario AS usu', 'sdc.usuario_solicita', 'usu.id_usuario')
            ->select('sdc.id_solicitud_descuento', 'sdc.porcentaje', 'sdc.porcentaje', 'sdc.kilos', 'sdc.unidades', 'sdc.fecha', 'sdc.fecha_creacion', 'sdc.estado', 'sdc.codigo_producto', 'pro.nombre AS nombre_producto', 'sdc.id_cliente', 'cli.nombre_cliente', 'sdc.usuario_solicita', DB::raw('CONCAT(usu.nombres, " ", usu.apellidos) AS nombre_usuario_solicita'))
            ->when($usuario->nivel != 'u_administrador', function ($query) use ($usuario) {
                return $query->where('sdc.usuario_solicita', $usuario->id_usuario);
            })
            ->when($estado != '' && $estado < 4, function ($query) use ($estado) {
                return $query->where('sdc.estado', $estado);
            })
            ->when($fechaDescuento != '', function ($query) use ($fechaDescuento) {
                return $query->whereDate('sdc.fecha', $fechaDescuento);
            })
            ->when($cliente != '', function ($query) use ($cliente) {
                return $query->where('sdc.id_cliente', $cliente);
            })
            ->orderBy('sdc.fecha_creacion', 'DESC')
            ->paginate(Session::get('pagination'));

        $clientes = DB::table('tbl_solicitud_descuento AS sdc')
            ->leftJoin('tbl_cliente AS cli', 'sdc.id_cliente', 'cli.id_cliente')
            ->select('sdc.id_cliente', 'cli.cc_nit', 'cli.nombre_cliente')
            ->when($usuario->nivel != 'u_administrador', function ($query) use ($usuario) {
                return $query->where('sdc.usuario_solicita', $usuario->id_usuario);
            })
            ->when($estado != '' && $estado < 4, function ($query) use ($estado) {
                return $query->where('sdc.estado', $estado);
            })
            ->when($fechaDescuento != '', function ($query) use ($fechaDescuento) {
                return $query->whereDate('sdc.fecha', $fechaDescuento);
            })
            ->orderBy('cli.cc_nit', 'DESC')
            ->distinct()
            ->get();

        return view('descuentos.index')->with(compact('usuario', 'hoy', 'solicitudes', 'estado', 'fechaDescuento', 'cliente', 'clientes'));
    }

    // Renderiza la vista de crear una solicitud
    public function create() {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        if ($usuario->bloquear_descuento != 0) {
            $mensaje = 'Hola <b class="capitalize">'. mb_strtolower($usuario->nombres). '</b>, al parecer te perdiste. No estás autorizado para solicitar descuentos.';
            return view('error')->with(compact('usuario', 'mensaje'));
        }
        $hoy = Carbon::now();
        return view('descuentos.nuevo')->with(compact('usuario', 'hoy'));
    }

    public function store(Request $request) {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        if ($usuario->bloquear_descuento != 0) {
            $mensaje = 'Hola <b class="capitalize">'. mb_strtolower($usuario->nombres). '</b>, al parecer te perdiste. No estás autorizado para solicitar descuentos.';
            return view('error')->with(compact('usuario', 'mensaje'));
        }
        $validacionSolicitud = TblSolicitudDescuento::where('fecha', $request->fecha)->where('id_cliente', $request->id_cliente)->where('codigo_producto', $request->codigo_producto)->where('estado', '<>', 3)->first();
        if ($validacionSolicitud) {
            $msjEstado = '';
            switch ($validacionSolicitud->estado) {
                case 1:
                    $msjEstado = 'REVISADA';
                    break;

                case 2:
                    $msjEstado = 'APROBADA';
                    break;

                default:
                    $msjEstado = 'PENDIENTE';
                    break;
            }
            $titulo = 'Solicitud Duplicada';
            $mensaje = 'Ya existe una solicitud ' .$msjEstado. ' para el cliente ' .trim($validacionSolicitud->cliente->nombre_cliente). ' con el producto ' .trim($validacionSolicitud->producto->nombre). ' para aplicar el día ' .date('d/m/Y', strtotime($validacionSolicitud->fecha)). '.';
            $fecha = Carbon::now();
            Session::put('error_solicitud', compact('titulo', 'mensaje', 'fecha'));
            return redirect(route('descuentos.index', ['cliente' => $validacionSolicitud->id_cliente]));
        } else {
            $solicitud = new TblSolicitudDescuento();
            $solicitud->fill($request->all());
            $solicitud->usuario_solicita = $usuario->id_usuario;
            $solicitud->fecha_creacion = date('Y-m-d H:i:s');
            $solicitud->save();
            return redirect(route('descuentos.index'));
        }
    }

    public function obtenerProductosListaPrecio($lista_precio, $busqueda) {
        $productos = DB::table('tbl_producto AS pro')
            ->join('tbl_rel_lista_precio AS rlp', 'pro.codigo', 'rlp.codigo_producto')
            ->select('pro.id_producto', 'pro.nombre', 'pro.codigo', 'pro.peso_unidad', 'pro.undmed', 'rlp.precio_unidad_inventario', 'rlp.precio_unidad_empaque')
            ->where('rlp.codigo_lista', $lista_precio)
            ->where('rlp.precio_unidad_inventario', '<>', 99999)
            ->where('rlp.precio_unidad_empaque', '<>', 99999)
            ->where(function($query) {
                $query->where('rlp.precio_unidad_inventario', '>', 0)
                      ->orWhere('rlp.precio_unidad_empaque', '>', 0);
            })
            ->where(function($query) use ($busqueda) {
                $query->where('pro.nombre', 'like', '%' . $busqueda . '%')
                      ->orWhere('pro.codigo', 'like', '%' . $busqueda . '%');
            })
            ->orderBy('pro.nombre')
            ->distinct()
            ->limit(10)
            ->get();
        return response()->json(compact('productos'), 200);
    }
}
