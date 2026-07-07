<?php

namespace App\Http\Controllers;

use Session;
use App\Models\TblUsuario;
use App\Models\TblCliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RuteroController extends Controller
{
    // Middleware que valida si el usuario está autenticado antes de acceder a cualquier método
    public function __construct()
    {
        $this->middleware('auth.check');
    }

    // Define que vista renderizar y con que información
    public function index() {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $motivos = DB::table('tbl_no_compra_motivos')
            ->where('nivel_usuario', $usuario->nivel)
            ->orderBy('motivo')
            // ->dd();
            ->get();
        $pqrs = Session::get('pqrs');
        if ($pqrs) {
            Session::forget('pqrs');
        }
        $hoy = Carbon::now()->format('H:i:s');
        return view('rutero')->with(compact('usuario', 'motivos', 'pqrs', 'hoy'));
    }

    public function clientes($fecha) {
        $fechaConsulta = Carbon::parse($fecha);
        $diaConsulta = $fechaConsulta->dayName;
        $mesConsulta = $fechaConsulta->monthName;
        $dias = ['lu', 'ma', 'mi', 'ju', 'vi', 'sa', 'do'];
        $dia = $dias[date('N', strtotime($fecha)) - 1];
        $semana = 's' . $fechaConsulta->weekOfMonth;
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);

        if($usuario->nivel == 'u_callcenter') {

            $clientes = DB::table('tbl_clientes_vd AS cli')
                ->leftJoin('tbl_comercial AS com', function ($join) use ($fecha) {
                    $join->on('cli.id_cliente_vd', 'com.id_cliente_vd')
                        ->where('com.estado', 1)
                        ->whereDate('com.fecha_ingreso', $fecha);
                })
                ->leftJoin('tbl_no_compra AS noc', function ($join) use ($fecha) {
                    $join->on('cli.id_cliente_vd', 'noc.id_cliente_vd')
                        ->whereDate('noc.fecha_no_compra', $fecha);
                })
                ->leftJoin('ciudades AS ciu', 'cli.id_ciudad', 'ciu.id_ciudad')
                ->leftJoin('tbl_usuario AS usu', 'noc.creado_por', 'usu.id_usuario')
                ->select('cli.id_cliente_vd', 'cli.cedula AS cc_nit',  DB::raw('CONCAT(TRIM(cli.nombres), " ", TRIM(cli.apellidos)) AS nombre_cliente'), DB::raw('CASE WHEN cli.sec_' . $dia . ' > 0 THEN cli.sec_' . $dia . ' ELSE 999 END AS secuencia'), DB::raw('TRIM(cli.telefono) AS telefono'), DB::raw('TRIM(cli.direccion) AS direccion'), 'ciu.ciudad', DB::raw('(cli.s1 + cli.s2 + cli.s3 + cli.s4) AS frecuencia'), 'noc.id_no_compra', 'noc.motivo AS motivo_no_compra', DB::raw('CONCAT(usu.nombres," ",usu.apellidos) AS creador_no_compra'), DB::raw('COUNT(com.id_comercial) AS pedidos'))
                // ->where('cli.inactivo', 0)
                ->where($dia, 1)
                ->where($semana, 1)
                ->groupBy('cli.id_cliente_vd', 'cli.cedula', 'nombre_cliente', 'cli.sec_' . $dia, 'cli.telefono', 'cli.direccion', 'ciu.ciudad', 'cli.s1', 'cli.s2', 'cli.s3', 'cli.s4', 'noc.id_no_compra', 'noc.motivo', 'usu.nombres', 'usu.apellidos')
                ->orderBy('secuencia' , 'ASC')
                ->orderBy('cli.cedula', 'ASC')
                ->distinct()
                ->get();
                // dd($clientes);
        } else {

            $clientes = DB::table('tbl_cliente AS cli')
                ->leftJoin('tbl_comercial AS com', function ($join) use ($fecha) {
                    $join->on('cli.id_cliente', 'com.id_cliente')
                        ->where('com.estado', 1)
                        ->whereDate('com.fecha_ingreso', $fecha);
                })
                ->leftJoin('tbl_no_compra AS noc', function ($join) use ($fecha) {
                    $join->on('cli.id_cliente', 'noc.id_cliente')
                        ->whereDate('noc.fecha_no_compra', $fecha);
                })
                ->leftJoin('ciudades AS ciu', 'cli.ciudad', 'ciu.id_ciudad')
                ->leftJoin('tbl_usuario AS usu', 'noc.creado_por', 'usu.id_usuario')
                ->select('cli.id_cliente', 'cli.cc_nit', 'cli.sucursal',  DB::raw('TRIM(cli.nombre_cliente) AS nombre_cliente'), 'cli.codigo_vendedor', DB::raw('CASE WHEN cli.sec_' . $dia . ' > 0 THEN cli.sec_' . $dia . ' ELSE 999 END AS secuencia'), DB::raw('TRIM(cli.telefono) AS telefono'), DB::raw('TRIM(cli.direccion) AS direccion'), 'ciu.ciudad', 'cli.latitud', 'cli.longitud', 'cli.precision', DB::raw('(cli.s1 + cli.s2 + cli.s3 + cli.s4) AS frecuencia'), 'noc.id_no_compra', 'noc.motivo AS motivo_no_compra', DB::raw('CONCAT(usu.nombres," ",usu.apellidos) AS creador_no_compra'), DB::raw('COUNT(com.id_comercial) AS pedidos'), 'cli.telefono')
                ->where('cli.codigo_vendedor', $usuario->codigo_vendedor)
                ->where('cli.inactivo', 0)
                ->where($dia, 1)
                ->where($semana, 1)
                ->groupBy('cli.id_cliente', 'cli.cc_nit', 'cli.sucursal', 'cli.nombre_cliente', 'cli.codigo_vendedor', 'cli.sec_' . $dia, 'cli.telefono', 'cli.direccion', 'ciu.ciudad', 'cli.latitud', 'cli.longitud', 'cli.precision', 'cli.s1', 'cli.s2', 'cli.s3', 'cli.s4', 'noc.id_no_compra', 'noc.motivo', 'usu.nombres', 'usu.apellidos')
                ->orderBy('secuencia' , 'ASC')
                ->orderBy('cli.cc_nit', 'ASC')
                ->distinct()
                ->get();
        }
        return response()->json(compact('clientes', 'fechaConsulta', 'dia', 'semana', 'diaConsulta', 'mesConsulta'), 200);
    }

    public function pedidosCliente($fecha, $cliente) {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $pedidos = DB::table('tbl_comercial AS com')
            ->join('tbl_cliente AS cli', 'com.id_cliente', 'cli.id_cliente')
            ->leftJoin('tbl_reg_comercial AS rgc', 'com.id_comercial', 'rgc.id_comercial')
            ->select('com.id_comercial', 'com.estado', DB::raw('SUM(rgc.total) AS total_pedido'))
            ->whereDate('com.fecha_ingreso', $fecha)
            ->where('com.id_cliente', $cliente)
            ->where('cli.codigo_vendedor', $usuario->codigo_vendedor)
            ->groupBy('com.id_comercial', 'com.estado')
            // ->dd();
            ->get();
        // dd($pedidos, 'si');
        return response()->json(compact('pedidos'), 200);
    }

    public function registrarNoCompra(Request $request) {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $cliente = TblCliente::find($request->cliente);
        // return $cliente;
        if ($request->cliente_vd) {
            $cliente_vd = $request->cliente_vd;
        } else {
            $cliente_vd = NULL;
        }

        if ($cliente_vd) {
            $validacion = DB::table('tbl_no_compra')
                ->where('id_usuario', $usuario->id_usuario)
                ->where('id_cliente_vd', $cliente_vd)
                ->whereDate('fecha_no_compra', date('Y-m-d'))
                ->first();
        } else {
            $validacion = DB::table('tbl_no_compra')
                ->where('id_usuario', $usuario->id_usuario)
                ->where('id_cliente', $cliente->id_cliente)
                ->whereDate('fecha_no_compra', date('Y-m-d'))
                ->first();
        }

        if ($validacion) {
            $mensaje = 'El cliente ' . $cliente->nombre_cliente . ' ya tiene una no compra registrada el día de hoy.';
            return response()->json(compact('cliente', 'mensaje', 'validacion'), 500);
        }

        $fecha = date('Y-m-d H:i:s');
        DB::table('tbl_no_compra')->insert([
            'id_cliente' => $cliente->id_cliente,
            'fecha_no_compra' => $fecha,
            'id_usuario' => $usuario->id_usuario,
            'codigo_lista' => $cliente->lista_precio,
            'creado_por' => $usuario->id_usuario,
            'motivo' => $request->motivo,
            'nombre_cli' => '',
            'direccion_cli' => '',
            'tipo_cli' => '',
            'longitud_cli' => '',
            'latitud_cli' => '',
            'precision_cli' => '',
            'id_cliente_vd' => $cliente_vd
        ]);
        $noCompra = DB::getPdo()->lastInsertId();
        $motivo = $request->motivo;

        if ($cliente_vd) {
            return response()->json(compact('cliente', 'noCompra', 'motivo', 'cliente_vd'), 200);
        } else {
            return response()->json(compact('cliente', 'noCompra', 'motivo'), 200);
        }
    }

    public function regLlamada($cliente, $clienteVd) {
        $usuario = Session::get('user')->id_usuario;
        $hoy = Carbon::now()->format('Y-m-d H:m:s');

        DB::table('tbl_reg_llamadas')->insert([
            'id_usuario' => $usuario,
            'id_cliente' => $cliente,
            'id_cliente_vd' => $clienteVd
        ]);

    }
}
