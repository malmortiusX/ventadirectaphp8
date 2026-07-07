<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TblCliente;
use App\Models\TblClienteVd;
use App\Models\TblPedido;
use App\Models\TblProducto;
use App\Models\TblRegComercial;
use App\Models\TblUsuario;
use App\Models\TblListaPrecio;
use App\Models\TblEmpresa;
use App\Models\TblAbono;
use App\Models\TblPagoWompi;
use Carbon\Carbon;
use Session;

class AjaxController extends Controller
{
    // Middleware que valida si el usuario está autenticado antes de acceder a cualquier método
    public function __construct()
    {
        $this->middleware('auth.check');
    }

    // Buscar pedidos entre fechas
    public function pedidosBuscar($inicio, $fin) {
        $usuario = Session::get('user');
        if ($usuario->nivel == 'u_administrador') {
            $pedidos = DB::table('tbl_comercial AS com')
                ->leftJoin('tbl_cliente AS cli', 'com.id_cliente', 'cli.id_cliente')
                ->leftJoin('tbl_reg_comercial AS rgc', 'com.id_comercial', 'rgc.id_comercial')
                ->leftJoin('tbl_clientes_vd AS cvd', 'com.id_cliente_vd', 'cvd.id_cliente_vd')
                ->leftJoin('tbl_usuario AS usu', 'com.id_usuario', 'usu.id_usuario')
                ->select('com.abono', 'com.id_comercial', 'com.estado', 'com.latitud', 'com.longitud', DB::raw('date(com.fecha_ingreso) AS fecha_ingreso'), 'cli.nombre_cliente', 'usu.codigo_vendedor', DB::raw('CONCAT(cvd.nombres, " ", cvd.apellidos) AS nombre_cliente_vd'), DB::raw('SUM(rgc.total) AS total_pedido'))
                ->whereBetween(DB::raw('date(com.fecha_ingreso)'), [$inicio, $fin])
                ->groupBy('com.id_comercial', 'com.fecha_ingreso', 'com.estado', 'com.latitud', 'com.longitud', 'cli.nombre_cliente', 'cvd.nombres', 'cvd.apellidos', 'usu.codigo_vendedor', 'com.abono')
                ->orderBy('com.fecha_ingreso', 'desc')
                ->get();

            $unidades = DB::table('tbl_comercial AS com')
                ->leftJoin('tbl_reg_comercial AS rgc', 'com.id_comercial', 'rgc.id_comercial')
                ->select('rgc.unidades')
                ->where('com.estado', 1)
                ->where('rgc.total', '<>', 0)
                ->whereBetween(DB::raw('date(com.fecha_cierre)'), [$inicio, $fin])
                ->orderBy('com.fecha_cierre', 'desc')
                ->sum('rgc.unidades');

            $ventas = DB::table('tbl_comercial AS com')
                ->leftJoin('tbl_reg_comercial AS rgc', 'com.id_comercial', 'rgc.id_comercial')
                ->select('rgc.total')
                ->where('com.estado', 1)
                ->where('rgc.total', '<>', 0)
                ->whereBetween(DB::raw('date(com.fecha_cierre)'), [$inicio, $fin])
                ->orderBy('com.fecha_cierre', 'desc')
                ->sum('rgc.total');

            $kilos = DB::table('tbl_comercial AS com')
                ->leftJoin('tbl_reg_comercial AS rgc', 'com.id_comercial', 'rgc.id_comercial')
                ->select('rgc.peso')
                ->where('com.estado', 1)
                ->where('rgc.total', '<>', 0)
                ->whereBetween(DB::raw('date(com.fecha_cierre)'), [$inicio, $fin])
                ->orderBy('com.fecha_cierre', 'desc')
                ->sum('rgc.peso');
            return response()->json(compact('ventas', 'kilos', 'unidades', 'pedidos'), 200);

        } else if ($usuario->nivel == 'u_ventadirecta') {

            $pedidos = DB::table('tbl_comercial AS com')
                ->leftJoin('tbl_cliente AS cli', 'com.id_cliente', 'cli.id_cliente')
                ->leftJoin('tbl_reg_comercial AS rgc', 'com.id_comercial', 'rgc.id_comercial')
                ->leftJoin('tbl_clientes_vd AS cvd', 'com.id_cliente_vd', 'cvd.id_cliente_vd')
                ->select('com.abono', 'com.id_comercial', 'com.estado', 'com.latitud', 'com.longitud', DB::raw('date(com.fecha_ingreso) AS fecha_ingreso'), 'cli.nombre_cliente', 'com.nombre_cliente_vd', DB::raw('SUM(rgc.total) AS total_pedido'))
                ->where('com.id_usuario', $usuario->id_usuario)
                ->whereBetween(DB::raw('date(com.fecha_ingreso)'), [$inicio, $fin])
                ->groupBy('com.id_comercial', 'com.fecha_ingreso', 'com.estado', 'com.latitud', 'com.longitud', 'cli.nombre_cliente', 'com.nombre_cliente_vd', 'com.abono')
                ->orderBy('com.fecha_ingreso', 'desc')
                // ->dd();
                ->get();

            $unidades = DB::table('tbl_comercial AS com')
                ->leftJoin('tbl_reg_comercial AS rgc', 'com.id_comercial', 'rgc.id_comercial')
                ->select('rgc.unidades')
                ->where('com.id_usuario', $usuario->id_usuario)
                ->where('com.estado', '<>', 0)
                ->where('rgc.total', '<>', 0)
                ->whereBetween(DB::raw('date(com.fecha_ingreso)'), [$inicio, $fin])
                ->orderBy('com.fecha_ingreso', 'desc')
                ->sum('rgc.unidades');

            $ventas = DB::table('tbl_comercial AS com')
                ->leftJoin('tbl_reg_comercial AS rgc', 'com.id_comercial', 'rgc.id_comercial')
                ->select('rgc.total')
                ->where('com.id_usuario', $usuario->id_usuario)
                ->where('com.estado', '<>', 0)
                ->where('rgc.total', '<>', 0)
                ->whereBetween(DB::raw('date(com.fecha_ingreso)'), [$inicio, $fin])
                ->orderBy('com.fecha_ingreso', 'desc')
                ->sum('rgc.total');

            $kilos = DB::table('tbl_comercial AS com')
                ->leftJoin('tbl_reg_comercial AS rgc', 'com.id_comercial', 'rgc.id_comercial')
                ->select('rgc.peso')
                ->where('com.id_usuario', $usuario->id_usuario)
                ->where('com.estado', '<>', 0)
                ->where('rgc.total', '<>', 0)
                ->whereBetween(DB::raw('date(com.fecha_ingreso)'), [$inicio, $fin])
                ->orderBy('com.fecha_ingreso', 'desc')
                ->sum('rgc.peso');

            return response()->json(compact('ventas', 'kilos', 'unidades', 'pedidos'), 200);
        } else {

            $pedidos = DB::table('tbl_comercial AS com')
                ->leftJoin('tbl_cliente AS cli', 'com.id_cliente', 'cli.id_cliente')
                ->leftJoin('tbl_reg_comercial AS rgc', 'com.id_comercial', 'rgc.id_comercial')
                ->leftJoin('tbl_clientes_vd AS cvd', 'com.id_cliente_vd', 'cvd.id_cliente_vd')
                ->select('com.abono', 'com.id_comercial', 'com.estado', 'com.latitud', 'com.longitud', DB::raw('date(com.fecha_ingreso) AS fecha_ingreso'), 'cli.nombre_cliente', 'com.nombre_cliente_vd', DB::raw('SUM(rgc.total) AS total_pedido'))
                ->where('com.id_usuario', $usuario->id_usuario)
                ->whereBetween(DB::raw('date(com.fecha_ingreso)'), [$inicio, $fin])
                ->groupBy('com.id_comercial', 'com.fecha_ingreso', 'com.estado', 'com.latitud', 'com.longitud', 'cli.nombre_cliente', 'com.nombre_cliente_vd', 'com.abono')
                ->orderBy('com.fecha_ingreso', 'desc')
                // ->dd();
                ->get();

            $unidades = DB::table('tbl_comercial AS com')
                ->leftJoin('tbl_reg_comercial AS rgc', 'com.id_comercial', 'rgc.id_comercial')
                ->select('rgc.unidades')
                ->where('com.id_usuario', $usuario->id_usuario)
                ->where('com.estado', 1)
                ->where('rgc.total', '<>', 0)
                ->whereBetween(DB::raw('date(com.fecha_ingreso)'), [$inicio, $fin])
                ->orderBy('com.fecha_ingreso', 'desc')
                ->sum('rgc.unidades');

            $ventas = DB::table('tbl_comercial AS com')
                ->leftJoin('tbl_reg_comercial AS rgc', 'com.id_comercial', 'rgc.id_comercial')
                ->select('rgc.total')
                ->where('com.id_usuario', $usuario->id_usuario)
                ->where('com.estado', 1)
                ->where('rgc.total', '<>', 0)
                ->whereBetween(DB::raw('date(com.fecha_ingreso)'), [$inicio, $fin])
                ->orderBy('com.fecha_ingreso', 'desc')
                ->sum('rgc.total');

            $kilos = DB::table('tbl_comercial AS com')
                ->leftJoin('tbl_reg_comercial AS rgc', 'com.id_comercial', 'rgc.id_comercial')
                ->select('rgc.peso')
                ->where('com.id_usuario', $usuario->id_usuario)
                ->where('com.estado', 1)
                ->where('rgc.total', '<>', 0)
                ->whereBetween(DB::raw('date(com.fecha_ingreso)'), [$inicio, $fin])
                ->orderBy('com.fecha_ingreso', 'desc')
                ->sum('rgc.peso');

            return response()->json(compact('ventas', 'kilos', 'unidades', 'pedidos'), 200);

        }
    }

    // Buscar pedidos hechos al PDV entre fechas
    public function misPedidosBuscar($inicio, $fin, $estado) {
        $usuario = Session::get('user');
        // dd($usuario);
        $pedidos = DB::table('tbl_comercial AS com')
            ->leftJoin('tbl_cliente AS cli', 'com.id_cliente', 'cli.id_cliente')
            ->leftJoin('tbl_reg_comercial AS rgc', 'com.id_comercial', 'rgc.id_comercial')
            ->leftJoin('tbl_clientes_vd AS cvd', 'com.id_cliente_vd', 'cvd.id_cliente_vd')
            ->select('com.id_comercial', DB::raw('CONCAT(com.en_ruta, com.despachado) AS estado'), 'com.latitud', 'com.longitud', DB::raw('date(com.fecha_ingreso) AS fecha_ingreso'), 'cli.nombre_cliente', 'com.nombre_cliente_vd', DB::raw('SUM(rgc.total) AS total_pedido'))
            ->where('com.cop', $usuario->cop)
            ->where('com.estado', 1)
            ->when($estado, function($query) use ($estado){
                if($estado == 1){
                    return $query->where('com.en_ruta', 0)
                    ->where('com.despachado', 0);

                }elseif($estado == 2){
                    return $query->where('com.en_ruta', 1)
                    ->where('com.despachado', '!=', 1);
                }else{
                    return $query->where('com.en_ruta', 1)
                    ->where('com.despachado', 1);
                }
            })
            ->whereBetween(DB::raw('date(com.fecha_ingreso)'), [$inicio, $fin])
            ->groupBy('com.id_comercial', 'com.fecha_ingreso', 'com.en_ruta', 'com.despachado', 'com.latitud', 'com.longitud', 'cli.nombre_cliente', 'com.nombre_cliente_vd')
            ->orderBy('com.fecha_ingreso', 'desc')
            // ->dd();
            ->get();

        $unidades = DB::table('tbl_comercial AS com')
            ->leftJoin('tbl_reg_comercial AS rgc', 'com.id_comercial', 'rgc.id_comercial')
            ->select('rgc.unidades')
            ->where('com.cop', $usuario->cop)
            ->where('com.estado', 1)
            ->where('rgc.total', '<>', 0)
            ->whereBetween(DB::raw('date(com.fecha_ingreso)'), [$inicio, $fin])
            ->orderBy('com.fecha_ingreso', 'desc')
            ->sum('rgc.unidades');

        $ventas = DB::table('tbl_comercial AS com')
            ->leftJoin('tbl_reg_comercial AS rgc', 'com.id_comercial', 'rgc.id_comercial')
            ->select('rgc.total')
            ->where('com.cop', $usuario->cop)
            ->where('com.estado', 1)
            ->where('rgc.total', '<>', 0)
            ->whereBetween(DB::raw('date(com.fecha_ingreso)'), [$inicio, $fin])
            ->orderBy('com.fecha_ingreso', 'desc')
            ->sum('rgc.total');

        $kilos = DB::table('tbl_comercial AS com')
            ->leftJoin('tbl_reg_comercial AS rgc', 'com.id_comercial', 'rgc.id_comercial')
            ->select('rgc.peso')
            ->where('com.cop', $usuario->cop)
            ->where('com.estado', 1)
            ->where('rgc.total', '<>', 0)
            ->whereBetween(DB::raw('date(com.fecha_ingreso)'), [$inicio, $fin])
            ->orderBy('com.fecha_ingreso', 'desc')
            ->sum('rgc.peso');
        return response()->json(compact('ventas', 'kilos', 'unidades', 'pedidos'), 200);
    }

    // Buscar pedidos hechos al PDV entre fechas
    public function misPedidosBuscarDashboard() {
        $usuario = Session::get('user');
        $hoy = Carbon::now()->format('Y-m-d');
        // dd($hoy);

        $pedidos = DB::table('tbl_comercial AS com')
            ->select(DB::raw('COUNT(com.id_comercial) AS misPedidos'))
            ->where('com.cop', $usuario->cop)
            ->where('com.estado', 1)
            ->where('com.despachado', 0)
            ->whereBetween(DB::raw('date(com.fecha_ingreso)'), [date('Y-m-d',(strtotime ('-1 day', strtotime ($hoy)))), $hoy])
            // ->dd();
            ->get();

        // dd($pedidos);

        return response()->json(compact('pedidos'), 200);
    }

    // Buscar productos por nombre o por codigo
    public function productosBuscar($busqueda) {
        $usuario = Session::get('user');
        $productos = DB::table('tbl_producto AS pro')
            ->join('tbl_rel_lista_precio AS rlp', 'pro.codigo', 'rlp.codigo_producto')
            ->select('pro.id_producto', 'pro.nombre', 'pro.codigo', 'pro.peso_unidad', 'pro.undmed', 'rlp.precio_unidad_inventario', 'rlp.precio_unidad_empaque')
            ->where('pro.activo', 1)
            ->where('rlp.codigo_lista', $usuario->cliente->lista_precio)
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

    // Buscar productos por nombre o por codigo
    public function pqrProductosBuscar($producto, $cliente) {
        $cliente = TblCliente::firstWhere('cc_nit',$cliente);
        $productos = DB::table('tbl_producto AS pro')
            ->join('tbl_rel_lista_precio AS rlp', 'pro.codigo', 'rlp.codigo_producto')
            ->select('pro.id_producto', 'pro.nombre', 'pro.codigo', 'pro.peso_unidad', 'pro.undmed', 'rlp.precio_unidad_inventario', 'rlp.precio_unidad_empaque')
            ->where('pro.activo', 1)
            ->where('rlp.codigo_lista', $cliente->lista_precio)
            ->where('rlp.precio_unidad_inventario', '<>', 99999)
            ->where('rlp.precio_unidad_empaque', '<>', 99999)
            ->where(function($query) {
                $query->where('rlp.precio_unidad_inventario', '>', 0)
                      ->orWhere('rlp.precio_unidad_empaque', '>', 0);
            })
            ->where(function($query) use ($producto) {
                $query->where('pro.nombre', 'like', '%' . $producto . '%')
                      ->orWhere('pro.codigo', 'like', '%' . $producto . '%');
            })
            ->orderBy('pro.nombre')
            ->distinct()
            ->limit(10)
            ->get();
        return response()->json(compact('productos'), 200);
    }

    // Buscar productos por nombre o por codigo
    public function pedidoBuscarProductos($pedido, $busqueda) {
        $usuario = Session::get('user');
        $pedido = TblPedido::find($pedido);
        if ($usuario->id_usuario == $pedido->id_usuario || $usuario->nivel == 'u_administrador') {
            $lista_precio = $pedido->codigo_lista;
            $productos = TblProducto::from('tbl_producto AS pro')
                ->join('tbl_rel_lista_precio AS rlp', 'pro.codigo', 'rlp.codigo_producto')
                ->leftJoin('tbl_solicitud_descuento AS sol', function ($join) use ($pedido) {
                    $join->on('pro.codigo', '=', 'sol.codigo_producto')
                         ->where('sol.estado', 2)
                         ->where('sol.fecha', $pedido->fecha_entrega)
                         ->where('sol.id_cliente', $pedido->cliente->id_cliente);
                })
                ->leftJoin('tbl_rel_lista_descuento AS rld', function ($join) use ($pedido) {
                    $join->on('pro.codigo', '=', 'rld.codigo_producto')
                         ->where('rld.codigo_lista', $pedido->cliente->lista_descuento);
                })
                ->select('pro.id_producto', 'pro.nombre', 'pro.codigo', 'pro.peso_unidad', 'pro.peso_unidad AS peso', 'pro.undmed', 'pro.porciva', 'rlp.precio_unidad_inventario', 'rlp.precio_unidad_empaque', 'rlp.minimocant', 'rlp.minimoemp', DB::raw('IF(sol.porcentaje <> "NULL", sol.porcentaje, IF(rld.descuento_kg <> "0", rld.descuento_kg, rld.descuento_un)) as porcentaje'))
                ->where('pro.activo', 1)
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
                ->with(['rangos' => function($query) use ($pedido) {
                    $query->where('codigo_lista', $pedido->cliente->lista_descuento);
                }])
                ->get();
            return response()->json(compact('productos'), 200);
        }
        return null;
    }

    // Buscar clientes por documento o por nombre
    public function clientesBuscar($busqueda) {
        $usuario = Session::get('user');
        $empresa = TblEmpresa::firstOrFail();
        if ($empresa->nombre == "Cadasa") {
            $clientes = DB::table('tbl_cliente AS cli')
                ->leftJoin('ciudades AS ciu', 'cli.ciudad', 'ciu.id_ciudad')
                ->join('tbl_lista_precio AS lpr', 'cli.lista_precio', 'lpr.codigo')
                ->where(function($query) use ($busqueda) {
                    $query->where('cli.cc_nit', 'like', '%' . $busqueda . '%')
                    ->orWhere('cli.nombre_cliente', 'like', '%' . $busqueda . '%');
                })
                ->where('inactivo', 0)
                ->where('aprobado_com', 1)
                ->orderBy('cli.nombre_cliente')
                ->distinct()
                ->limit(10)
                ->get();
        } else {
            $clientes = DB::table('tbl_cliente AS cli')
                ->leftJoin('ciudades AS ciu', 'cli.ciudad', 'ciu.id_ciudad')
                ->join('tbl_lista_precio AS lpr', 'cli.lista_precio', 'lpr.codigo')
                ->when($usuario->nivel != 'u_administrador', function ($query) use ($usuario) {
                    return $query->where('cli.codigo_vendedor', $usuario->codigo_vendedor);
                })
                ->where(function($query) use ($busqueda) {
                    $query->where('cli.cc_nit', 'like', '%' . $busqueda . '%')
                    ->orWhere('cli.nombre_cliente', 'like', '%' . $busqueda . '%');
                })
                ->where('inactivo', 0)
                ->where('aprobado_com', 1)
                ->orderBy('cli.nombre_cliente')
                ->distinct()
                ->limit(10)
                ->get();
        }
        return response()->json(compact('clientes'), 200);
    }

    public function clientesVendedorBuscar($vendedor, $busqueda) {
        $usuario = Session::get('user');
        if ($usuario->nivel = 'u_movil_especial'|| $usuario->nivel = 'u_administrador') {
            $clientes = TblCliente::from('tbl_cliente AS cli')
                ->leftJoin('ciudades AS ciu', 'cli.ciudad', 'ciu.id_ciudad')
                ->join('tbl_lista_precio AS lpr', 'cli.lista_precio', 'lpr.codigo')
                ->where(function($query) use ($busqueda) {
                    $query->where('cli.cc_nit', 'like', '%' . $busqueda . '%')
                    ->orWhere('cli.nombre_cliente', 'like', '%' . $busqueda . '%');
                })
                ->where('inactivo', 0)
                ->where('aprobado_com', 1)
                ->orderBy('cli.nombre_cliente')
                ->distinct()
                ->limit(10)
                ->get();
            return response()->json(compact('clientes'), 200);
        } else {
            return response()->json(false, 403);
        }
    }

    // Buscar clientes de venta directa por teléfono o por nombre
    public function clientesVdBuscar($busqueda = null) {
        $usuario = Session::get('user');
        if ($usuario->nivel == 'u_callcenter') {
            $clientesvd = DB::table('tbl_clientes_vd AS cli')
                ->leftJoin('ciudades AS ciu', 'cli.id_ciudad', 'ciu.id_ciudad')
                ->leftJoin('tbl_usuario AS usu', 'cli.id_usuario', 'usu.id_usuario')
                ->selectRaw('cli.id_cliente_vd, cli.nombres, cli.apellidos, cli.cedula, cli.telefono, cli.correo_electronico, cli.direccion, cli.barrio, cli.id_ciudad, ciu.ciudad, usu.nivel, "2" as tipo_cliente')
                ->where(function($query) use ($busqueda) {
                    $query->where('cli.telefono', 'like', '%' . $busqueda . '%')
                    ->orWhere('cli.cedula', 'like', '%' . $busqueda . '%')
                    ->orWhere('cli.correo_electronico', 'like', '%' . $busqueda . '%')
                    ->orWhere(DB::raw("CONCAT(cli.nombres,' ',cli.apellidos)"), 'like', '%' . $busqueda . '%')
                    ->orWhere(DB::raw("CONCAT(cli.apellidos,' ',cli.nombres)"), 'like', '%' . $busqueda . '%');
                })
                ->where('usu.nivel', 'u_callcenter')
                ->whereIn('cli.id_ciudad', [80, 84, 100, 107, 156, 240, 319, 353, 466, 481, 632, 1025])
                ->orderBy('cli.nombres')
                ->distinct()
                ->limit(5);
                // ->get();

            $clientes = DB::table('tbl_cliente AS cli')
                ->leftJoin('ciudades AS ciu', 'cli.ciudad', 'ciu.id_ciudad')
                ->join('tbl_lista_precio AS lpr', 'cli.lista_precio', 'lpr.codigo')
                ->selectRaw('cli.id_cliente as id_cliente_vd, cli.nombre_cliente as nombres , " " as apellidos, cli.cc_nit as cedula, cli.telefono, cli.correo as correo_electronico, cli.direccion, cli.barrio, cli.ciudad as id_ciudad, ciu.ciudad, "u_callcenter" as nivel, "1" as tipo_cliente')
                ->where(function($query) use ($busqueda) {
                    $query->where('cli.cc_nit', 'like', '%' . $busqueda . '%')
                    ->orWhere('cli.nombre_cliente', 'like', '%' . $busqueda . '%');
                })
                ->where('inactivo', 0)
                ->where('aprobado_com', 1)
                ->union($clientesvd)
                ->orderBy('nombres')
                ->distinct()
                ->limit(5)
                ->get();

            return response()->json(compact('clientes'), 200);
        } else {
            $clientes = DB::table('tbl_clientes_vd AS cli')
                ->join('ciudades AS ciu', 'cli.id_ciudad', 'ciu.id_ciudad')
                ->selectRaw('cli.id_cliente_vd, cli.nombres, cli.apellidos, cli.cedula, cli.telefono, cli.correo_electronico, cli.direccion, cli.barrio, cli.id_ciudad, ciu.ciudad, "2" as tipo_cliente')
                ->where('id_usuario', $usuario->id_usuario)
                ->where(function($query) use ($busqueda) {
                    $query->where('cli.telefono', 'like', '%' . $busqueda . '%')
                    ->orWhere(DB::raw("CONCAT(`nombres`, ' ', `apellidos`)"), 'like', '%' . $busqueda . '%')
                    ->orWhere(DB::raw("CONCAT(`apellidos`, ' ', `nombres`)"), 'like', '%' . $busqueda . '%');
                })
                ->orderBy('cli.nombres')
                ->distinct()
                ->limit(10)
                ->get();
            return response()->json(compact('clientes'), 200);
        }
    }

    // Crear clientes de venta directa
    public function guardarClienteVd(Request $request) {
        $usuario = Session::get('user');
        if ($request->id_cliente_vd) {
            $cliente = TblClienteVd::find($request->id_cliente_vd);
        } else {
            if ($request->cedula && trim($request->cedula) != "") {
                $cliente = TblClienteVd::where('cedula', $request->cedula)->where('id_usuario', $usuario->id_usuario)->first();
            } else {
                $cliente = TblClienteVd::where('telefono', $request->telefono)->where('id_usuario', $usuario->id_usuario)->first();
            }
            if (!$cliente) {
                $cliente = new TblClienteVd();
            }
        }
        $cliente->fill($request->all());
        $cliente->id_usuario = $usuario->id_usuario;
        if (!$cliente->cedula) {
            $cliente->cedula = '-';
        }
        $cliente->save();
        $ciudad = mb_convert_case(mb_strtolower($cliente->ciudad->ciudad), MB_CASE_TITLE, "UTF-8");
        $usuario = TblUsuario::find($usuario->id_usuario);
        Session::put('user', $usuario);
        return response()->json(compact('cliente', 'ciudad'), 200);
    }

    // Editar clientes de venta directa
    public function editarClienteVd(Request $request) {
        $usuario = Session::get('user');
        $cliente = TblClienteVd($request->id_cliente_vd);
        $cliente->fill($request->all());
        $cliente->save();
        $ciudad = mb_convert_case(mb_strtolower($cliente->ciudad->ciudad), MB_CASE_TITLE, "UTF-8");
        $usuario = TblUsuario::find($usuario->id_usuario);
        Session::put('user', $usuario);
        return response()->json(compact('cliente', 'ciudad'), 200);
    }

    // Crear pedidos
    public function crearPedido(Request $request) {
        $usuario = Session::get('user');
        $pedido = new TblPedido();
        $pedido->fill($request->all());

        if($usuario->cliente) {
            $pedido->id_cliente = $usuario->cliente->id_cliente;
            $pedido->codigo_lista = $usuario->cliente->lista_precio;
        }
        $pedido->forma_pago = 0;
        $pedido->n_factura = 0;
        $pedido->fecha_ingreso = date("Y-m-d H:i:s");
        $pedido->id_usuario = $usuario->id_usuario;
        $pedido->aprobado = 0;
        $pedido->despachado = 0;
        $pedido->orden_carga = 0;
        $pedido->creado_por = $usuario->id_usuario;
        $pedido->trasmit = 0;
        $pedido->nro_suno = 0;
        $pedido->nombre_m = 0;
        $pedido->direccion_m = 0;
        $pedido->tipo_m = 0;
        $pedido->longitud = 0;
        $pedido->latitud = 0;
        $pedido->precision = 0;
        $pedido->impreso = 0;
        $pedido->orden = 0;
        $pedido->hora_entrega = 0;
        $pedido->estado_pedido = 0;
        $pedido->estado = 0;
        $pedido->fecha_cierre = '1900-01-01';

        if (!$pedido->observacion_pedido) {
            $pedido->observacion_pedido = ' ';
        }

        if($request->tipo_cliente == "2"){
            $clientevd = TblClienteVd::find($request->id_cliente_vd);
            $pedido->nombre_cliente_vd = mb_convert_case($clientevd->nombres .' '. $clientevd->apellidos, MB_CASE_UPPER, 'UTF-8');
            $pedido->cedula_cliente_vd = $clientevd->cedula;
            $pedido->telefono_cliente_vd = $clientevd->telefono;
            $pedido->direccion_cliente_vd = mb_convert_case($clientevd->direccion, MB_CASE_UPPER, 'UTF-8');
            $pedido->barrio_cliente_vd = mb_convert_case('B. '. $clientevd->barrio, MB_CASE_UPPER, 'UTF-8');
            $pedido->ciudad_cliente_vd = $clientevd->ciudad->ciudad;
            $pedido->correo_cliente_vd = $clientevd->correo_electronico;
        } else {
            $clientevd = TblCliente::find($request->id_cliente_vd);
            $pedido->nombre_cliente_vd = mb_convert_case($clientevd->nombre_cliente, MB_CASE_UPPER, 'UTF-8');
            $pedido->cedula_cliente_vd = $clientevd->cc_nit;
            $pedido->telefono_cliente_vd = $clientevd->telefono;
            $pedido->direccion_cliente_vd = mb_convert_case($clientevd->direccion, MB_CASE_UPPER, 'UTF-8');
            $pedido->barrio_cliente_vd = mb_convert_case('B. '. $clientevd->barrio, MB_CASE_UPPER, 'UTF-8');
            $pedido->ciudad_cliente_vd = $clientevd->ciudadCl->ciudad;
            $pedido->correo_cliente_vd = $clientevd->correo;
        }
        $pedido->save();

        return response()->json(compact('pedido'), 200);
    }

    public function guardarProducto(Request $request) {
        $pedido = TblPedido::find($request->id_comercial);
        $producto = TblProducto::find($request->id_producto);
        $registro = new TblRegComercial();

        $registro->modificado = 0;
        $registro->rango_1 = 0;
        $registro->rango_2 = 0;
        $registro->un_despachado = 0;
        $registro->kg_despachado = 0;
        $registro->un_diferencia = 0;
        $registro->kg_diferencia = 0;
        $registro->refrigeracion = 0;
        $registro->descuento = 0;
        $registro->totald = 0;
        $registro->valor_iva = 0;
        $registro->porcentaje_iva = 0;
        $registro->fill($request->all());
        if (!$pedido->cliente->listaPrecio->iva_incluido) {
            $registro->porcentaje_iva = $producto->porciva;
        }
        if (isset($request->obsequio) && $request->obsequio) {
            $registro->descuento = 0;
            $registro->totald = 0;
            $registro->valor_iva = 0;
            $registro->total = 0;
            $registro->obsequio = 1;
        }

        $pedido->valor_total = $request->valor_total;

        $pedido->save();
        $registro->save();

        $productos = $pedido->productos()->leftJoin('tbl_solicitud_descuento AS sol', function ($join) use ($pedido) {
            $join->on('tbl_producto.codigo', '=', 'sol.codigo_producto')
                ->where('sol.estado', 2)
                ->where('sol.fecha', $pedido->fecha_entrega)
                ->where('sol.id_cliente', $pedido->cliente->id_cliente);
        })
        ->leftJoin('tbl_rel_lista_precio AS rlp', function ($join) use ($pedido) {
            $join->on('tbl_producto.codigo', '=', 'rlp.codigo_producto')
                ->where('rlp.codigo_lista', $pedido->cliente->lista_precio);
        })
        ->addSelect('tbl_producto.*', 'sol.porcentaje', 'rlp.*')
        ->with(['rangos' => function($query) use ($pedido) {
            $query->where('codigo_lista', $pedido->cliente->lista_descuento);
        }])
        ->get();
        return response()->json(compact('registro', 'productos'), 200);
    }

    // Buscar pqrs entre fechas
    public function pqrsBuscar($inicio, $fin) {

        $usuario = Session::get('user');

        if ($usuario->nivel == 'u_administrador') {

            $listaPqrs = DB::connection('pqrs')
            ->table('mantis_bug_table AS bt')
            ->distinct()
            ->where('bt.project_id', 4)
            ->whereBetween(DB::raw('DATE( FROM_UNIXTIME( bt.date_submitted ) )'), [$inicio, $fin])
            ->orderBy('bt.date_submitted', 'desc')
            ->limit(100)
            ->get();

            foreach ($listaPqrs as $key => $pqr) {
                $pqr->fields = DB::connection('pqrs')
                    ->table('mantis_custom_field_string_table AS cfst')
                    ->where('cfst.bug_id', $pqr->id)
                    ->Where(function($query) {
                        $query->where('cfst.field_id', 6)
                        ->orWhere('cfst.field_id', 61)
                        ->orWhere('cfst.field_id', 37);
                    })
                    ->get();
            }

            // dd($listaPqrs);
            return response()->json(compact('listaPqrs'), 200);

        } else {

            $listaPqrs = DB::connection('pqrs')
            ->table('mantis_bug_table AS bt')
            ->join('mantis_custom_field_string_table AS cfst', 'cfst.bug_id', 'bt.id')
            ->distinct()
            ->where('bt.project_id', 4)
            ->where('cfst.value', $usuario->codigo_vendedor)
            ->whereBetween(DB::raw('DATE( FROM_UNIXTIME( bt.date_submitted ) )'), [$inicio, $fin])
            ->orderBy('bt.date_submitted', 'desc')
            ->limit(100)
            ->get();

            foreach ($listaPqrs as $key => $pqr) {
                $pqr->fields = DB::connection('pqrs')
                    ->table('mantis_custom_field_string_table AS cfst')
                    ->where('cfst.bug_id', $pqr->id)
                    ->get();
            }

            return response()->json(compact('listaPqrs'), 200);
        }
    }

    public function actualizarProducto(Request $request) {
        if ($request->id_reg_comercial) {
            $registro = TblRegComercial::find($request->id_reg_comercial);
        } else {
            $registro = TblRegComercial::where('id_comercial', $request->id_comercial)->where('id_producto', $request->id_producto)->first();
        }
        $registro->fill($request->all());
        if (isset($request->obsequio) && $request->obsequio) {
            $registro->descuento = 0;
            $registro->totald = 0;
            $registro->valor_iva = 0;
            $registro->total = 0;
            $registro->obsequio = 1;
        }
        $registro->save();

        $pedido = TblPedido::find($request->id_comercial);
        $productos = $pedido->productos()->leftJoin('tbl_solicitud_descuento AS sol', function ($join) use ($pedido) {
                $join->on('tbl_producto.codigo', '=', 'sol.codigo_producto')
                    ->where('sol.estado', 2)
                    ->where('sol.fecha', $pedido->fecha_entrega)
                    ->where('sol.id_cliente', $pedido->cliente->id_cliente);
            })
            ->leftJoin('tbl_rel_lista_precio AS rlp', function ($join) use ($pedido) {
                $join->on('tbl_producto.codigo', '=', 'rlp.codigo_producto')
                    ->where('rlp.codigo_lista', $pedido->cliente->lista_precio);
            })
            ->addSelect('tbl_producto.*', 'sol.porcentaje', 'rlp.*')
            ->with(['rangos' => function($query) use ($pedido) {
                $query->where('codigo_lista', $pedido->cliente->lista_descuento);
            }])
            ->get();
        return response()->json(compact('registro', 'productos'), 200);
    }

    public function eliminarProducto(Request $request) {
        if ($request->id_reg_comercial) {
            $registro = TblRegComercial::find($request->id_reg_comercial);
        } else {
            $registro = TblRegComercial::where('id_comercial', $request->id_comercial)->where('id_producto', $request->id_producto)->first();
        }
        $registro->delete();

        $pedido = TblPedido::find($request->id_comercial);
        $pedido->valor_total = $pedido->valor_total - $request->subtotal;
        $pedido->save();

        $productos = $pedido->productos()->leftJoin('tbl_solicitud_descuento AS sol', function ($join) use ($pedido) {
            $join->on('tbl_producto.codigo', '=', 'sol.codigo_producto')
                ->where('sol.estado', 2)
                ->where('sol.fecha', $pedido->fecha_entrega)
                ->where('sol.id_cliente', $pedido->cliente->id_cliente);
        })
        ->leftJoin('tbl_rel_lista_precio AS rlp', function ($join) use ($pedido) {
            $join->on('tbl_producto.codigo', '=', 'rlp.codigo_producto')
                ->where('rlp.codigo_lista', $pedido->cliente->lista_precio);
        })
        ->addSelect('tbl_producto.*', 'sol.porcentaje', 'rlp.*')
        ->with(['rangos' => function($query) use ($pedido) {
            $query->where('codigo_lista', $pedido->cliente->lista_descuento);
        }])
        ->get();
        return response()->json(compact('registro', 'productos'), 200);
    }

    public function guardarCoordenadas(Request $request) {
        $pedido = TblPedido::find($request->id_comercial);
        $pedido->fill($request->all());
        $pedido->save();
        return response()->json(compact('pedido'), 200);
    }

    public function guardarCoordenadasCliente(Request $request) {
        $cliente = TblCliente::find($request->id_cliente);
        $cliente->fill($request->all());
        $cliente->save();
        return response()->json(compact('cliente'), 200);
    }

    public function clientesProductos($cliente) {
        DB::statement("SET lc_time_names = 'es_ES'");
        $productos = DB::table('tbl_comercial AS com')
            ->join('tbl_reg_comercial AS rgc', 'com.id_comercial', 'rgc.id_comercial')
            ->join('tbl_producto AS pro', 'rgc.id_producto', 'pro.id_producto')
            ->select('pro.codigo', 'pro.nombre', 'pro.undmed', DB::raw('CONCAT(DATE_FORMAT(com.fecha_ingreso, "%d %b - %a")) AS nombre_dia'), DB::raw('SUM(rgc.unidades) AS unidades'), DB::raw('SUM(rgc.peso) AS peso'), DB::raw('SUM(rgc.total) AS total'), DB::raw('SUM(rgc.total) / SUM(rgc.unidades) AS prom_unidades'), DB::raw('SUM(rgc.total) / SUM(rgc.peso) AS prom_peso'))
            ->where('com.id_cliente', $cliente)
            ->where('com.estado', 1)
            ->whereBetween(DB::raw('date(com.fecha_ingreso)'), [date('Y-m-d', strtotime('-1 week')), date('Y-m-d')])
            ->groupBy('pro.codigo', 'pro.nombre', 'pro.undmed', 'nombre_dia')
            ->orderBy(DB::raw('DATE(com.fecha_ingreso)'), 'ASC')
            ->orderBy('pro.codigo', 'ASC')
            ->get();
        //dd($productos, 'si');
        return response()->json(compact('productos'), 200);
    }

    public function centdistVendedor($vendedor) {
        $vendedor = TblUsuario::where('codigo_vendedor', $vendedor)->firstOrFail();
        $centrosDist = $vendedor->centrosDist;
        return response()->json($centrosDist, 200);
    }

    public function guardarAbonoWompi(Request $request) {

        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $pagoWompi = new TblPagoWompi;

        $pagoWompi->valor = $request->valor;
        $pagoWompi->id_usuario = $request->id_usuario;
        $pagoWompi->id_pedido = $request->id_pedido;
        $pagoWompi->fecha_creacion = Carbon::now()->format('Y-m-d H:m:s');
        $pagoWompi->save();

        if ( $usuario->regional != "EJE CAFETERO" ) {
            $llaveIntegridadWompi = "prod_integrity_oJSoj4LYXMfFsn8xEEWfFcCEJubn9toH";
        } else {
            $llaveIntegridadWompi = "prod_integrity_cpYSolmiD4PmPcBqCCj3UGfUk1yl51jY";
        }

        $signature = $pagoWompi->id . $pagoWompi->valor . "00" . "COP" . $llaveIntegridadWompi;

        $signature = hash("sha256", $signature);

        return response()->json(compact('signature', 'pagoWompi'), 200);
    }

    public function actualizaWompi($busqueda, $idWompi)
    {
        $pagoWompi = TblPagoWompi::where('id', $busqueda)->firstOrFail();

        $pagoWompi->id_wompi = $idWompi;
        $pagoWompi->save();

        return response()->json(200);
    }
}
