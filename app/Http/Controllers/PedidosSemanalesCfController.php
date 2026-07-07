<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TblPedidoSemanalCf;
use App\Models\TblRegPedidoCf;
use App\Models\TblUsuario;
use Carbon\Carbon;
use Session;

class PedidosSemanalesCfController extends Controller
{
    // Middleware que valida si el usuario está autenticado antes de acceder a cualquier método
    public function __construct()
    {
        $this->middleware('auth.check');
    }

    public function create() {
        $hoy = Carbon::now();
        $semana = Carbon::now()->setISODate($hoy->year, $hoy->weekOfYear + 2)->startOfWeek()->next('thursday');
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $pedidoSemana = TblPedidoSemanalCf::where('semana', $semana->weekOfYear)->where('ano', $semana->year)->where('codigo_vendedor', $usuario->codigo_vendedor)->first();
        if (!$pedidoSemana) {
            //cambiar todo para el jueves (dia 4)
            if ($hoy->dayOfWeek < 4 || ($hoy->dayOfWeek == 4 && $hoy->diffInSeconds(Carbon::now()->setTime(15, 0, 59, 0), false) > 0)) {
                $limite = Carbon::now()->startOfWeek()->next('thursday')->setTime(15, 0, 59, 0);
                return view('pedidosSemanales.carnesFrias.nuevo')->with(compact('limite', 'usuario', 'semana'));
            } else {
                $mensaje = 'Hola <b class="capitalize">'. mb_strtolower($usuario->nombres). '</b>, el pedido semanal de carnes frías solo está disponible hasta ' . ($hoy->dayOfWeek == 4 ? 'hoy' : 'el jueves'). ' a las 03:00 pm.';
                $idMenu = 'pedidos-semanales';
                return view('error')->with(compact('usuario', 'mensaje', 'idMenu'));
            }
        }
        return redirect(route('pedidos.semanalescf.show', ['ano' => $pedidoSemana->ano, 'semana' => $pedidoSemana->semana]));
    }

    public function store(Request $request) {
        $hoy = Carbon::now();
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $pedido = new TblPedidoSemanalCf();
        $pedido->fill($request->all());
        $pedido->id_usuario = $usuario->id_usuario;
        $pedido->codigo_vendedor = $usuario->codigo_vendedor;
        $pedido->fecha_ingreso = date('Y-m-d');
        $pedido->estado = 0;
        $pedido->save();

        if ($request->productos == 'on') {
            $productosAnterior = [];
            $semana = Carbon::now()->weekOfYear;
            while (count($productosAnterior) == 0 && $semana > (Carbon::now()->weekOfYear - 10)) {
                $productosAnterior = (array) DB::table('tbl_reg_pedidos_cf AS rgp')
                    ->join('tbl_pedidos_cf AS ped', 'rgp.id_pedido', 'ped.id_pedido')
                    ->select('rgp.id_pedido', 'codigo', 'nombre', 'klu', 'ulu', 'kma', 'uma', 'kmi', 'umi', 'kju', 'uju', 'kvi', 'uvi', 'ksa', 'usa', 'kdo', 'udo', 'peso_unidad', 'undmed', 'peso')
                    ->where('ped.semana', $semana)
                    ->where('ped.ano', Carbon::now()->year)
                    ->where('ped.codigo_vendedor', $usuario->codigo_vendedor)
                    ->get()
                    ->toArray();
                $semana--;
            }
            if ($productosAnterior) {
                foreach ($productosAnterior as $producto) {
                    $producto->id_pedido = $pedido->id_pedido;
                }
                DB::table('tbl_reg_pedidos_cf')->insert(json_decode(json_encode($productosAnterior), true));
            }
        }
        return redirect(route('pedidos.semanalescf.show', ['ano' => $pedido->ano, 'semana' => $pedido->semana]));
    }

    public function close($ano, $semana, $vendedor = null, Request $request) {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        if ($usuario->nivel == 'u_administrador' && $vendedor) {
            $pedido = TblPedidoSemanalCf::where('semana', $semana)->where('ano', $ano)->where('codigo_vendedor', $vendedor)->first();
        } else {
            $pedido = TblPedidoSemanalCf::where('semana', $semana)->where('ano', $ano)->where('codigo_vendedor', $usuario->codigo_vendedor)->first();
        }
        $pedido->estado = 1;
        $pedido->save();
        return redirect(route('pedidos.semanalescf.show', ['ano' => $pedido->ano, 'semana' => $pedido->semana]));
    }

    public function show($ano, $semana, $vendedor = null) {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        if ($usuario->nivel == 'u_administrador' && $vendedor) {
            $pedido = TblPedidoSemanalCf::where('semana', $semana)->where('ano', $ano)->where('codigo_vendedor', $vendedor)->first();
        } else {
            $pedido = TblPedidoSemanalCf::where('semana', $semana)->where('ano', $ano)->where('codigo_vendedor', $usuario->codigo_vendedor)->first();
        }
        if ($pedido) {
            $limite = Carbon::now()->setISODate($pedido->ano, $pedido->semana - 1)->next('thursday')->setTime(15, 0, 59, 0);
            if ($pedido->estado) {
                return view('pedidosSemanales.carnesFrias.cerrado')->with(compact('usuario', 'pedido', 'limite'));
            } else {
                return view('pedidosSemanales.carnesFrias.abierto')->with(compact('usuario', 'pedido', 'limite'));
            }
        } else {
            return abort(404);
        }
    }

    // Buscar productos por nombre o por codigo
    public function productos($busqueda) {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $lineascf = DB::table('tbl_lineas_cf')->where('regional', $usuario->regional)->select('codigo')->distinct()->get()->pluck('codigo');
        $productos = DB::table('tbl_producto AS pro')
            ->where('pro.activo', 1)
            ->where('pro.peso_unidad', '<>', 0)
            ->where(function($query) use ($busqueda) {
                $query->where('pro.nombre', 'like', '%' . $busqueda . '%')
                      ->orWhere('pro.codigo', 'like', '%' . $busqueda . '%');
            })
            ->whereIn('pro.codlinea', $lineascf)
            ->orderBy('pro.nombre')
            ->distinct()
            ->limit(10)
            ->get();
        return response()->json(compact('productos'), 200);
    }

    // Agregar producto al pedido
    public function guardarProducto(Request $request) {
        $registro = TblRegPedidoCf::where('id_pedido', $request->id_pedido)->where('codigo', $request->codigo)->first();
        if (!$registro) {
            $registro = new TblRegPedidoCf();
        }
        $registro->fill($request->all());
        $registro->save();

        $productos = TblPedidoSemanalCf::find($request->id_pedido)->productos;
        return response()->json(compact('registro', 'productos'), 200);
    }

    public function eliminarProducto(Request $request) {
        $registro = TblRegPedidoCf::where('id_pedido', $request->id_pedido)->where('codigo', $request->codigo)->first();
        $registro->delete();

        $productos = TblPedidoSemanalCf::find($request->id_pedido)->productos;
        return response()->json(compact('registro', 'productos'), 200);
    }
}
