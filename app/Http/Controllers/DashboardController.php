<?php

namespace App\Http\Controllers;

use Session;
use App\Models\TblCliente;
use App\Models\TblPedido;
use App\Models\TblUsuario;
use App\Models\TblAviso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // Middleware que valida si el usuario está autenticado antes de acceder a cualquier método
    public function __construct()
    {
        $this->middleware('auth.check');
    }

    // Define que vista renderizar y con que información
    public function __invoke()
    {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        DB::statement("SET lc_time_names = 'es_ES'");

        $pedidosSemana = DB::table('tbl_comercial AS com')
            ->leftJoin('tbl_reg_comercial AS rgc', 'com.id_comercial', 'rgc.id_comercial')
            ->select(DB::raw('SUM(rgc.total) AS total_ventas'), DB::raw('DAYNAME(com.fecha_ingreso) AS nombre_dia'))
            ->when($usuario->nivel != 'u_administrador', function ($query) use ($usuario) {
                return $query->where('com.id_usuario', $usuario->id_usuario);
            })
            ->where('com.estado', 1)
            ->whereDate('com.fecha_cierre', '>', date('Y-m-d', strtotime('last sunday')))
            ->groupBy('nombre_dia', DB::raw('DAYNAME(com.fecha_ingreso)'))
            ->orderBy(DB::raw('DAYNAME(com.fecha_ingreso)'), 'ASC')
            ->get();

        $lineaSemana = DB::table('tbl_comercial AS com')
            ->join('tbl_reg_comercial AS rgc', 'com.id_comercial', 'rgc.id_comercial')
            ->join('tbl_producto', 'rgc.id_producto', 'tbl_producto.id_producto')
            ->select(DB::raw('SUM(rgc.total) as y, tbl_producto.desclinea as name'))
            ->when($usuario->nivel != 'u_administrador', function ($query) use ($usuario) {
                return $query->where('com.id_usuario', $usuario->id_usuario);
            })
            ->where('com.estado', 1)
            ->where('rgc.total', '<>', 0)
            ->whereDate('com.fecha_cierre', '>', date('Y-m-d', strtotime('last sunday')))
            ->groupBy('tbl_producto.desclinea')
            ->get();

        $kilosSemana = DB::table('tbl_reg_comercial AS rgc')
            ->leftJoin('tbl_comercial AS com', 'rgc.id_comercial', 'com.id_comercial')
            ->leftJoin('tbl_producto AS pro', 'rgc.id_producto', 'pro.id_producto')
            ->select('pro.desclinea AS name', DB::raw('SUM(rgc.peso) AS y'))
            ->when($usuario->nivel != 'u_administrador', function ($query) use ($usuario) {
                return $query->where('com.id_usuario', $usuario->id_usuario);
            })
            ->where('com.estado', 1)
            ->whereDate('com.fecha_cierre', '>', date('Y-m-d', strtotime('last sunday')))
            ->where('rgc.peso', '>', 0)
            ->where('rgc.total', '<>', 0)
            ->groupBy('pro.desclinea')
            ->get();

        $mensaje = null;
        $mostrarMensaje = false;

        if (isset($_GET['cliente']) && isset($_GET['hora'])) {
            if (Carbon::now()->diffInSeconds(Carbon::parse($_GET['hora'])) < 10) {
                $mostrarMensaje = true;
                $cliente = TblCliente::find($_GET['cliente']);
                $mensaje = 'El cliente ' .$cliente->nombre_cliente. ' se ha creado satisfactoriamente.';
            }
        }

        switch ($usuario->nivel) {
            case 'u_ventadirecta':
                $hoy = Carbon::now()->format('Y-m-d');
                $pedidos = $usuario->pedidos()->take(10)->get();
                $avisos = $usuario->avisos->where('fecha_inicial', '<=', $hoy)->where('fecha_inicial', '>=', $hoy)->where('nivel', $usuario->nivel);
                $total_pedidos = TblPedido::selectRaw('sum(valor_total) as total_pedidos')
                                    ->where('id_usuario', $usuario->id_usuario)
                                    ->where('estado', '2')
                                    ->groupBy('id_usuario')
                                    ->get();

                return view('dashboard.ventadirecta')->with(compact('usuario', 'pedidos', 'pedidosSemana', 'lineaSemana', 'kilosSemana', 'avisos', 'total_pedidos'));
                break;

            case 'u_administrador':
                $pedidos = TblPedido::where('estado', 1)->orderBy('fecha_ingreso', 'desc')->take(10)->get();
                return view('dashboard.admin')->with(compact('usuario', 'pedidos', 'pedidosSemana', 'lineaSemana', 'kilosSemana', 'mensaje', 'mostrarMensaje'));
                break;

            default:
                $pedidos = $usuario->pedidos()->take(10)->get();
                return view('dashboard.movil')->with(compact('usuario', 'pedidos', 'pedidosSemana', 'lineaSemana', 'kilosSemana', 'mensaje', 'mostrarMensaje'));
                break;
        }
    }
}
