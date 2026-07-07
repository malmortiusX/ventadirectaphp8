<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TblPedidoSemanal;
use App\Models\TblPedidoSemanalCf;
use App\Models\TblRegPedido;
use App\Models\TblUsuario;
use Carbon\Carbon;
use Session;

class PedidosSemanalesController extends Controller
{
    // Middleware que valida si el usuario está autenticado antes de acceder a cualquier método
    public function __construct()
    {
        $this->middleware('auth.check');
    }

    public function index() {
        $hoy = Carbon::now();
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $semana = Carbon::now()->setISODate($hoy->year, $hoy->weekOfYear + 2)->startOfWeek()->next('thursday');
        $polloS1 = TblPedidoSemanal::where('semana', $semana->weekOfYear)->where('ano', $semana->year)->where('codigo_vendedor', $usuario->codigo_vendedor)->first();
        $polloS2 = TblPedidoSemanal::where('semana', $semana->weekOfYear + 1)->where('ano', $semana->year)->where('codigo_vendedor', $usuario->codigo_vendedor)->first();
        $carnesFrias = TblPedidoSemanalCf::where('semana', $semana->weekOfYear)->where('ano', $semana->year)->where('codigo_vendedor', $usuario->codigo_vendedor)->first();
        return view('pedidosSemanales.index')->with(compact('usuario', 'semana', 'polloS1', 'polloS2', 'carnesFrias'));
    }

    public function show($ano, $semana, $vendedor = null) {
        /*if ($ano > Carbon::now()->year || $semana > Carbon::now()->weekOfYear + 2) {
            return redirect(route('pedidos.semanales.create'));
        }*/
        
        $hoy = Carbon::now();
        //$semanaLimite = Carbon::now()->setISODate($hoy->year, $hoy->weekOfYear + 3)->startOfWeek()->next('thursday');
        $semanaLimite = Carbon::now()->setISODate($hoy->year, $hoy->weekOfYear + 2)->startOfWeek()->next('thursday');
        if ($ano > $semanaLimite->year || ($ano == $semanaLimite->year && $semana > $semanaLimite->weekOfYear)) {
            return abort(404);
        }
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $idMenu = 'pedidos-semanales';
        if ($usuario->nivel == 'u_administrador' && $vendedor) {
            $pedido = TblPedidoSemanal::where('semana', $semana)->where('ano', $ano)->where('codigo_vendedor', $vendedor)->first();
        } else {
            $pedido = TblPedidoSemanal::where('semana', $semana)->where('ano', $ano)->where('codigo_vendedor', $usuario->codigo_vendedor)->first();
        }
        if (!$pedido) {
            //if ($semana == $semanaLimite->weekOfYear - 1) {
            if ($semana == $semanaLimite->weekOfYear) {
                if ($hoy->dayOfWeek < 5 || ($hoy->dayOfWeek == 5 && $hoy->diffInSeconds(Carbon::now()->setTime(12, 0, 59, 0), false) > 0)) {
                    $limite = Carbon::now()->setTime(12, 0, 59, 0);
                    if ($hoy->dayOfWeek < 5) {
                        $limite->next('friday');
                    }
                    //$semana = $semanaLimite->subWeek();
                    $semana = $semanaLimite;
                    return view('pedidosSemanales.nuevo')->with(compact('limite', 'usuario', 'semana'));
                } else {
                    //$mensaje = 'Hola <b class="capitalize">'. mb_strtolower($usuario->nombres). '</b>, el pedido semanal de pollo de la semana ' .($semanaLimite->weekOfYear - 1). ' estuvo disponible hasta ' . ($hoy->dayOfWeek == 5 ? 'hoy' : 'el viernes ' . Carbon::now()->previous('friday')->day). ' a las 12:00 m.';
                    $mensaje = 'Hola <b class="capitalize">'. mb_strtolower($usuario->nombres). '</b>, el pedido semanal de pollo de la semana ' .($semanaLimite->weekOfYear). ' estuvo disponible hasta ' . ($hoy->dayOfWeek == 5 ? 'hoy' : 'el viernes ' . Carbon::now()->previous('friday')->day). ' a las 12:00 m.';
                    return view('error')->with(compact('usuario', 'mensaje', 'idMenu'));
                }
            } elseif ($semana == $semanaLimite->weekOfYear) {
                $limite = Carbon::now()->next('friday')->setTime(12, 0, 59, 0);
                $semana = $semanaLimite;
                return view('pedidosSemanales.nuevo')->with(compact('limite', 'usuario', 'semana'));
            } else {
                return abort(404);
            }
        } else {
            $limite = Carbon::now()->setISODate($pedido->ano, $pedido->semana - 2)->next('friday')->setTime(12, 0, 59, 0);
            if ($pedido->estado) {
                return view('pedidosSemanales.cerrado')->with(compact('usuario', 'pedido', 'limite'));
            } else {
                return view('pedidosSemanales.abierto')->with(compact('usuario', 'pedido', 'limite'));
            }
        }
    }

    public function store(Request $request) {
        $hoy = Carbon::now();
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        if ($usuario->nivel == 'u_administrador' && $vendedor) {
            $pedido = TblPedidoSemanal::where('semana', $request->semana)->where('ano', $request->ano)->where('codigo_vendedor', $request->vendedor)->first();
        } else {
            $pedido = TblPedidoSemanal::where('semana', $request->semana)->where('ano', $request->ano)->where('codigo_vendedor', $usuario->codigo_vendedor)->first();
        }
        if (!$pedido) {
            $pedido = new TblPedidoSemanal();
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
                    $productosAnterior = (array) DB::table('tbl_reg_pedidos AS rgp')
                        ->join('tbl_pedidos AS ped', 'rgp.id_pedido', 'ped.id_pedido')
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
                    DB::table('tbl_reg_pedidos')->insert(json_decode(json_encode($productosAnterior), true));
                }
            }
        }
        return redirect(route('pedidos.semanales.show', ['ano' => $pedido->ano, 'semana' => $pedido->semana]));
    }

    public function close($ano, $semana, $vendedor = null, Request $request) {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        if ($usuario->nivel == 'u_administrador' && $vendedor) {
            $pedido = TblPedidoSemanal::where('semana', $semana)->where('ano', $ano)->where('codigo_vendedor', $vendedor)->first();
        } else {
            $pedido = TblPedidoSemanal::where('semana', $semana)->where('ano', $ano)->where('codigo_vendedor', $usuario->codigo_vendedor)->first();
        }
        $pedido->estado = 1;
        $pedido->save();
        return redirect(route('pedidos.semanales.show', ['ano' => $pedido->ano, 'semana' => $pedido->semana]));
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
            ->whereNotIn('pro.codlinea', $lineascf)
            ->orderBy('pro.nombre')
            ->distinct()
            ->limit(10)
            ->get();
        return response()->json(compact('productos'), 200);
    }

    // Agregar producto al pedido
    public function guardarProducto(Request $request) {
        $registro = TblRegPedido::where('id_pedido', $request->id_pedido)->where('codigo', $request->codigo)->first();
        if (!$registro) {
            $registro = new TblRegPedido();
        }
        $registro->fill($request->all());
        $registro->save();

        $productos = TblPedidoSemanal::find($request->id_pedido)->productos;
        return response()->json(compact('registro', 'productos'), 200);
    }

    public function eliminarProducto(Request $request) {
        $registro = TblRegPedido::where('id_pedido', $request->id_pedido)->where('codigo', $request->codigo)->first();
        $registro->delete();

        $productos = TblPedidoSemanal::find($request->id_pedido)->productos;
        return response()->json(compact('registro', 'productos'), 200);
    }
}
