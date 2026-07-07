<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Ciudad;
use App\Models\TblCliente;
use App\Models\TblClienteVd;
use App\Models\TblEmpresa;
use App\Models\TblListaPrecio;
use App\Models\TblPedido;
use App\Models\TblProducto;
use App\Models\TblRegComercial;
use App\Models\TblUsuario;
use App\Models\TblFormularioEmpresarias;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\PedidoEnRuta;

class PedidosController extends Controller
{
    // Middleware que valida si el usuario está autenticado antes de acceder a cualquier método
    public function __construct()
    {
        $this->middleware('auth.check');
    }

    //Lista todos los pedidos del usuario
    public function index()
    {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $hoy = Carbon::now();
        return view('pedidos.index')->with(compact('usuario', 'hoy'));
    }

    // Renderiza la vista de crear pedido
    public function create()
    {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $empresa = TblEmpresa::first();
        $ciudades = Ciudad::all();
        $orden = TblPedido::where('id_usuario', $usuario->id_usuario)->whereDate('fecha_ingreso', date('Y-m-d'))->max('orden');
        switch ($usuario->nivel) {
            case 'u_ventadirecta':
                if (!$usuario->cliente) {
                    return redirect(route('dashboard'));
                }
                $formulario = TblFormularioEmpresarias::where('cedula_empresaria', Session::get('user')->documento)->latest('id')->first();
                if (!$formulario->firma_empresaria) {
                    return redirect(route('clientes.externos.empresarios.continuacion'));
                }
                $cliente = $usuario->cliente;
                $clienteVd = $usuario->clientesvd->where('id_usuario', $usuario->id_usuario)->where('cedula', $usuario->documento)->first();
                // dd($clientesvd);
                // $ciudades = Ciudad::whereIn('id_ciudad', [80, 107, 240, 319, 353, 466, 481, 632, 1025])->get();
                // $ciudades = Ciudad::whereIn('id_ciudad', [7, 62, 82, 84, 143, 156, 199, 207, 257, 269, 284, 490, 492, 507, 508, 534, 569, 638, 715, 765, 768, 770, 773, 790, 800, 825, 836, 864, 880, 903, 937, 960, 961, 1029, 80, 107, 240, 319, 353, 466, 481, 629, 632, 1025])->get();
                $ciudades = Ciudad::where('cop', '<>', '' )->get();
                return view('pedidos.ventadirecta.nuevo')->with(compact('usuario', 'cliente', 'ciudades', 'empresa', 'clienteVd'));
                break;

            case 'u_movil':
                $limite = Carbon::now()->diffInSeconds(Carbon::create($usuario->limite_mismo_dia), false);
                $hoy = Carbon::now()->format('H:i:s');
                return view('pedidos.movil.nuevo')->with(compact('usuario', 'ciudades', 'limite', 'orden', 'empresa', 'hoy'));
                break;

            case 'u_movil_especial':
                $limite = Carbon::now()->diffInSeconds(Carbon::create($usuario->limite_mismo_dia), false);
                $vendedores = TblUsuario::whereNotNull('codigo_vendedor')
                    ->whereIn('nivel', ['u_movil', 'u_comercial', 'u_ventadirecta', 'u_movil_especial'])
                    ->where('estado', 0)
                    ->where('regional', $usuario->regional)
                    ->orderBy('codigo_vendedor', 'asc')
                    ->get();
                return view('pedidos.movil.nuevo')->with(compact('usuario', 'vendedores', 'ciudades', 'limite', 'orden', 'empresa'));
                break;

            case 'u_comercial':
                $limite = Carbon::now()->diffInSeconds(Carbon::create($usuario->limite_mismo_dia), false);
                return view('pedidos.movil.nuevo')->with(compact('usuario', 'ciudades', 'limite', 'empresa'));
                break;

            case 'u_callcenter':
                $cliente = $usuario->cliente;
                $clientesvd = $usuario->clientesvd->take(10);
                if($empresa == 'San Marino') {
                    $ciudades = Ciudad::whereIn('id_ciudad', [257, 629])->get();
                } else {
                    $ciudades = Ciudad::whereIn('id_ciudad', [80, 84, 100, 107, 156, 240, 319, 353, 466, 481, 632, 1025])->get();
                }
                return view('pedidos.ventadirecta.nuevo')->with(compact('usuario', 'cliente', 'ciudades', 'empresa'));
                break;

            case 'u_administrador':
                $limite = Carbon::now()->diffInSeconds(Carbon::create($usuario->limite_mismo_dia), false);
                $vendedores = TblUsuario::whereNotNull('codigo_vendedor')
                    ->where('estado', 0)
                    ->orderBy('codigo_vendedor', 'asc')
                    ->get();
                return view('pedidos.movil.nuevo')->with(compact('usuario', 'vendedores', 'ciudades', 'limite', 'orden', 'empresa'));
                break;

            default:
                $limite = Carbon::now()->diffInSeconds(Carbon::create($usuario->limite_mismo_dia), false);
                return view('pedidos.movil.nuevo')->with(compact('usuario', 'cliente', 'ciudades', 'limite', 'empresa'));
                break;
        }
    }

    // Renderiza la vista de crear pedido
    public function createLlamada()
    {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $empresa = TblEmpresa::first();
        $ciudades = Ciudad::whereIn('id_ciudad', [80, 84, 100, 107, 156, 240, 319, 353, 466, 481, 632, 1025])->get();

        $regLlamada = DB::table('tbl_reg_llamadas AS rlla')
                        ->select('*')
                        ->where('rlla.id_usuario', Session::get('user')->id_usuario)
                        ->orderBy('rlla.id_reg_llamada', 'DESC')
                        ->first();

        if ( $regLlamada->id_cliente_vd == 0 ) {

            $cliente = TblCliente::find($regLlamada->id_cliente);

            $clienteVd = '';

        } else {

        $cliente = $usuario->cliente;

        $clienteVd = DB::table('tbl_reg_llamadas AS rlla')
                        ->leftJoin('tbl_clientes_vd AS cli', 'cli.id_cliente_vd', 'rlla.id_cliente_vd')
                        ->leftJoin('ciudades AS ciu', 'cli.id_ciudad', 'ciu.id_ciudad')
                        ->selectRaw('cli.id_cliente_vd, cli.nombres, cli.apellidos, cli.cedula, cli.telefono, cli.correo_electronico, cli.direccion, cli.barrio, cli.id_ciudad, ciu.ciudad')
                        ->where('rlla.id_usuario', Session::get('user')->id_usuario)
                        ->orderBy('rlla.id_reg_llamada', 'DESC')
                        ->first();
                            // dd($clienteVd->ciudad);

        }

        return view('pedidos.ventadirecta.nuevo')->with(compact('usuario', 'empresa', 'ciudades', 'cliente', 'clienteVd'));

    }

    // Guarda el pedido
    public function store(Request $request)
    {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $cliente = TblCliente::find($request->id_cliente);
        $empresa = TblEmpresa::first();

        $pedido = new TblPedido();
        $pedido->fill($request->all());

        if ($usuario->nivel == 'u_callcenter') {
            $pedido->id_cliente = $usuario->cliente->id_cliente;
            $pedido->codigo_lista = $usuario->cliente->lista_precio;

            $clientevd = TblClienteVd::find($request->id_cliente);

            $pedido->id_cliente_vd = $request->id_cliente;
            $pedido->nombre_cliente_vd = mb_convert_case($clientevd->nombres .' '. $clientevd->apellidos, MB_CASE_UPPER, 'UTF-8');
            $pedido->cedula_cliente_vd = $clientevd->cedula;
            $pedido->telefono_cliente_vd = $clientevd->telefono;
            $pedido->direccion_cliente_vd = mb_convert_case($clientevd->direccion .' B. '. $clientevd->barrio, MB_CASE_UPPER, 'UTF-8');
            $pedido->ciudad_cliente_vd = $clientevd->ciudad->ciudad;
        } else {
            $pedido->codigo_lista = $cliente->lista_precio;
        }

        if (!$pedido->observacion_pedido) {
            $pedido->observacion_pedido = ' ';
        }

        if (isset($request->codigo_vendedor)) {
            $vendedor = TblUsuario::where('codigo_vendedor', $request->codigo_vendedor)->firstOrFail();
            $pedido->id_usuario = $vendedor->id_usuario;
        } else {
            $pedido->id_usuario = $usuario->id_usuario;
        }

        $pedido->forma_pago = 0;
        $pedido->n_factura = 0;
        $pedido->fecha_ingreso = date("Y-m-d H:i:s");
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
        $pedido->hora_entrega = 0;
        $pedido->estado_pedido = 0;
        $pedido->estado = 0;
        $pedido->fecha_cierre = '1900-01-01';
        if (!$pedido->orden) {
            $pedido->orden = 0;
        }
        $pedido->save();
        if ($empresa->nombre != 'Italcol') {
            if ($request->productos == 'on') {
                $ultimoPedido = $cliente->pedidos->where('estado', 1)->sortByDesc('id_comercial')->first();
                if ($ultimoPedido) {
                    foreach ($ultimoPedido->productos as $producto) {
                        $productoLista = $cliente->listaPrecio->productos->find($producto->id_producto);
                        if ($productoLista && (($productoLista->pivot->precio_unidad_empaque > 0 && $productoLista->pivot->precio_unidad_empaque != 99999) || ($productoLista->pivot->precio_unidad_inventario > 0 && $productoLista->pivot->precio_unidad_inventario != 99999))) {
                            $registro = new TblRegComercial();
                            $registro->id_comercial = $pedido->id_comercial;
                            $registro->id_producto = $producto->id_producto;
                            $registro->unidades = $producto->pivot->unidades;
                            $registro->peso = $producto->pivot->peso;
                            $registro->valor_un = $productoLista->pivot->precio_unidad_empaque;
                            $registro->valor_kg = $productoLista->pivot->precio_unidad_inventario;
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
                            if ($registro->valor_kg > 0 && $registro->valor_un > 0 && $registro->valor_kg != 99999 && $registro->valor_un != 99999) {
                                if ($producto->pivot->venta_por == 'UN') {
                                    $registro->venta_por = 'UN';
                                    $registro->total = $registro->valor_un * $registro->unidades;
                                } else {
                                    $registro->venta_por = 'KG';
                                    $registro->total = $registro->valor_kg * $registro->peso;
                                }
                            } elseif ($registro->valor_kg > 0 && $registro->valor_kg != 99999) {
                                $registro->venta_por = 'KG';
                                $registro->total = $registro->valor_kg * $registro->peso;
                            } else {
                                $registro->venta_por = 'UN';
                                $registro->total = $registro->valor_un * $registro->unidades;
                            }
                            $registro->save();
                        }
                    }
                }
            }
        }

        if (!$cliente->verificado) {

            return view('pedidos.validarCliente')->with(compact('usuario', 'cliente', 'pedido'));

        } else {

            return redirect(route('pedidos.show', ['id' => $pedido->id_comercial]));

        }
        

    }

    // Detallado de pedido
    public function validaCliente($pedido, Request $request)
    {

        if ($request->opcion == 'validado') {
            $pedido = TblPedido::find($pedido);
            $cliente = TblCliente::find($pedido->id_cliente);
            $cliente->verificado = 1;
            $cliente->save();
        }

        return redirect(route('pedidos.show', ['id' => $pedido]));
    }

    // Detallado de pedido
    public function show($id)
    {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $pedido = TblPedido::find($id);
        $ciudades = Ciudad::all();
        $tope = DB::table('tbl_comercial AS com')
            ->join('tbl_reg_comercial AS rgc', 'com.id_comercial', 'rgc.id_comercial')
            ->select(DB::raw('SUM(rgc.total) AS total'))
            ->whereYear('com.fecha_entrega', date('Y'))
            ->where('com.id_cliente', $pedido->cliente->id_cliente)
            ->where('com.estado', 1)
            ->first();
        if ($pedido && ($usuario->id_usuario == $pedido->id_usuario || $usuario->cop == $pedido->cop || $usuario->nivel == 'u_administrador' || $usuario->nivel == 'u_movil_especial')) {
            if ($pedido->estado) {
                $entrega = Carbon::create($pedido->fecha_entrega);
                return view('pedidos.ver')->with(compact('usuario', 'pedido', 'entrega'));
            } else {
                switch ($pedido->vendedor->nivel) {
                    case 'u_ventadirecta':
                        if ($usuario->nivel == 'u_movil_especial' || $usuario->nivel == 'u_administrador') {
                            $cliente = $pedido->cliente;
                            $limite = Carbon::now()->diffInSeconds(Carbon::create($usuario->limite_mismo_dia), false);
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
                            // dd($productos);
                            return view('pedidos.movil.abierto')->with(compact('usuario', 'cliente', 'ciudades', 'pedido', 'limite', 'productos', 'tope'));
                            break;
                        }
                        if ($usuario->cliente->listaPrecio->fecha_desactivacion > Carbon::now()) {
                            $cliente = $usuario->cliente;
                            $clientesvd = $usuario->clientesvd->take(10);
                            $ciudades = Ciudad::whereIn('id_ciudad', [80, 107, 240, 319, 353, 466, 481, 632, 1025])->get();
                            return view('pedidos.ventadirecta.abierto')->with(compact('usuario', 'cliente', 'ciudades', 'clientesvd', 'pedido', 'tope'));
                            break;
                        } else {
                            $mensaje = 'Hola <b class="capitalize">'. mb_strtolower($usuario->nombres). '</b>, la carga de pedidos de esta campaña estuvo disponible disponible hasta el día ' . $usuario->cliente->listaPrecio->fecha_desactivacion . '.';
                            $idMenu = 'pedidos-create';
                            return view('error')->with(compact('usuario', 'mensaje', 'idMenu'));
                        }

                    case 'u_movil':
                        $cliente = $pedido->cliente;
                        $limite = Carbon::now()->diffInSeconds(Carbon::create($usuario->limite_mismo_dia), false);
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
                        // dd($productos);
                        return view('pedidos.movil.abierto')->with(compact('usuario', 'cliente', 'ciudades', 'pedido', 'limite', 'productos', 'tope'));
                        break;

                    case 'u_comercial':
                        $cliente = $pedido->cliente;
                        $limite = Carbon::now()->diffInSeconds(Carbon::create($usuario->limite_mismo_dia), false);
                        $productos = $pedido->productos()->leftJoin('tbl_solicitud_descuento AS sol', function ($join) use ($pedido) {
                                $join->on('tbl_producto.codigo', '=', 'sol.codigo_producto')
                                    ->where('sol.estado', 2)
                                    ->where('sol.fecha', $pedido->fecha_entrega)
                                    ->where('sol.id_cliente', $pedido->cliente->id_cliente);
                            })
                            ->addSelect('tbl_producto.*', 'sol.porcentaje')
                            ->with(['rangos' => function($query) use ($pedido) {
                                $query->where('codigo_lista', $pedido->cliente->lista_descuento);
                            }])
                            ->get();
                        return view('pedidos.movil.abierto')->with(compact('usuario', 'cliente', 'ciudades', 'pedido', 'limite', 'productos', 'tope'));
                        break;

                    case 'u_callcenter':
                        $cliente = $usuario->clientes->first();
                        $clientesvd = $usuario->clientesvd->take(10);
                        $ciudades = Ciudad::whereIn('id_ciudad', [80, 107, 240, 319, 353, 466, 481, 632, 1025])->get();
                        return view('pedidos.ventadirecta.abierto')->with(compact('usuario', 'cliente', 'ciudades', 'clientesvd', 'pedido', 'tope'));
                        break;

                    default:
                        $cliente = $pedido->cliente;
                        $limite = Carbon::now()->diffInSeconds(Carbon::create($usuario->limite_mismo_dia), false);
                        $productos = $pedido->productos()->leftJoin('tbl_solicitud_descuento AS sol', function ($join) use ($pedido) {
                                $join->on('tbl_producto.codigo', '=', 'sol.codigo_producto')
                                    ->where('sol.estado', 2)
                                    ->where('sol.fecha', $pedido->fecha_entrega)
                                    ->where('sol.id_cliente', $pedido->cliente->id_cliente);
                            })
                            ->addSelect('tbl_producto.*', 'sol.porcentaje')
                            ->with(['rangos' => function($query) use ($pedido) {
                                $query->where('codigo_lista', $pedido->cliente->lista_descuento);
                            }])
                            ->get();
                        return view('pedidos.movil.abierto')->with(compact('usuario', 'cliente', 'ciudades', 'pedido', 'limite', 'productos', 'tope'));
                        break;
                }
            }
        } else {
            return abort('403');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $hoy = Carbon::now();
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $pedido = TblPedido::find($id);
        $tope = DB::table('tbl_comercial AS com')
            ->join('tbl_reg_comercial AS rgc', 'com.id_comercial', 'rgc.id_comercial')
            ->select(DB::raw('SUM(rgc.total) AS total'))
            ->whereYear('com.fecha_entrega', date('Y'))
            ->where('com.id_cliente', $pedido->cliente->id_cliente)
            ->where('com.estado', 1)
            ->first();
        if ($pedido->cliente->tope && $pedido->cliente->valor_facturado + $pedido->productos->sum('pivot.total') > $pedido->cliente->tope) {
            $titulo = 'Tope Anual Alcanzado';
            $mensaje = 'El pedido no se puede cerrar porque el cliente ' . $pedido->cliente->nombre_cliente . ' supera el tope anual establecido ($ ' . number_format($pedido->cliente->tope, TblEmpresa::first()->decimales, ',', '.') . ') con este pedido.';
            $fecha = Carbon::now();
            Session::put('error_tope', compact('titulo', 'mensaje', 'fecha'));
            return back();
        }
        if ($usuario->nivel == 'u_movil' && $pedido->productos->sum('pivot.total') < $usuario->pedido_minimo && $pedido->centroDist->controla_tope == '1') {
            $titulo = 'Tope Mínimo No Alcanzado';
            $mensaje = 'El pedido no se puede cerrar porque el total ($' . number_format($pedido->productos->sum('pivot.total'), TblEmpresa::first()->decimales, ',', '.') . ') no supera el tope mínimo establecido ($' . number_format($usuario->pedido_minimo, TblEmpresa::first()->decimales, ',', '.') . ').';
            $fecha = Carbon::now();
            Session::put('error_pedido_minmo', compact('titulo', 'mensaje', 'fecha'));
            return back();
        }
        if ($usuario->nivel == 'u_movil' && $usuario->pedidos_mismo_dia && Carbon::now()->diffInSeconds(Carbon::create($usuario->limite_mismo_dia), false) < 0) {
            $titulo = 'Hora de Cierre Alcanzada';
            $mensaje = 'Solo puedes cerrar pedidos hasta las ' . $usuario->limite_mismo_dia . '.';
            $fecha = Carbon::now();
            Session::put('error_hora_cierre', compact('titulo', 'mensaje', 'fecha'));
            return back();
        }
        $pedido->fill($request->all());

        if (($usuario->nivel == 'u_ventadirecta' || $usuario->nivel == 'u_callcenter') && $usuario->cliente) {
            $cliente = $usuario->cliente;
            $pedido->codigo_lista = $cliente->lista_precio;
            // dd($request, $pedido);

            if($request->tipo_cliente == "2"){
                $clientevd = TblClienteVd::find($request->id_cliente_vd);
                $pedido->nombre_cliente_vd = mb_convert_case($clientevd->nombres .' '. $clientevd->apellidos, MB_CASE_UPPER, 'UTF-8');
                $pedido->cedula_cliente_vd = $clientevd->cedula;
                $pedido->telefono_cliente_vd = $clientevd->telefono;
                $pedido->direccion_cliente_vd = mb_convert_case($clientevd->direccion .' B. '. $clientevd->barrio, MB_CASE_UPPER, 'UTF-8');
                $pedido->ciudad_cliente_vd = $clientevd->ciudad->ciudad;
            } else {
                $clientevd = TblCliente::find($request->id_cliente_vd);
                $pedido->nombre_cliente_vd = mb_convert_case($clientevd->nombre_cliente, MB_CASE_UPPER, 'UTF-8');
                $pedido->cedula_cliente_vd = $clientevd->cc_nit;
                $pedido->telefono_cliente_vd = $clientevd->telefono;
                $pedido->direccion_cliente_vd = mb_convert_case($clientevd->direccion .' B. '. $clientevd->barrio, MB_CASE_UPPER, 'UTF-8');
                $pedido->ciudad_cliente_vd = $clientevd->ciudadCl->ciudad;
            }

        }

        if (!$pedido->observacion_pedido) {
            $pedido->observacion_pedido = '';
        }

        if (!$pedido->orden_compra) {
            $pedido->orden_compra = '';
        }

        $pedido->estado = 1;

        if ($usuario->nivel == 'u_ventadirecta') {
            $pedido->estado = 2;
        }

        $pedido->fecha_cierre = $hoy->format('Y-m-d H:i:s');
        $pedido->en_ruta = (int) $pedido->cliente->{substr($hoy->dayName, 0, 2)};

        $pedido->save();
        DB::table('tbl_no_compra')
            ->where('id_cliente', $pedido->cliente->id_cliente)
            ->where('id_usuario', $usuario->id_usuario)
            ->whereDate('fecha_no_compra', date('Y-m-d', strtotime($pedido->fecha_ingreso)))
            ->delete();
        return redirect(route('pedidos.show', ['id' => $id]));
    }

    public function pdf($id) {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $pedido = TblPedido::find($id);
        if (($usuario->id_usuario == $pedido->id_usuario || $usuario->cop == $pedido->cop || $usuario->nivel == 'u_administrador') && $pedido->estado != 0 ) {
            return view('pedidos.pdf')->with(compact('usuario', 'pedido'));
        } else {
            return abort('403');
        }
    }

    public function multiPdf(Request $request) {

        $pedidos = TblPedido::find(explode(",", $request->pedidos));
        // dd($pedidos);

        $usuario = TblUsuario::find(Session::get('user')->id_usuario);

        if ($usuario->nivel == 'u_administrador' || $usuario->nivel == 'u_comercial') {
            return view('pedidos.multiPdf')->with(compact('usuario', 'pedidos'));
        } else {
            return abort('403');
        }

        return response()->json('success', 200);
    }

    public function cambiarFechaEntrega($pedido, $fecha_entrega) {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $pedido = TblPedido::find($pedido);

        // Traigo los productos que tienen solicitudes aprobadas para la fecha anterior
        $productos = $pedido->productos()->join('tbl_solicitud_descuento AS sol', function ($join) use ($pedido) {
            $join->on('tbl_producto.codigo', '=', 'sol.codigo_producto')
                 ->where('sol.estado', 2)
                 ->where('sol.fecha', $pedido->fecha_entrega)
                 ->where('sol.id_cliente', $pedido->cliente->id_cliente);
        })->addSelect('tbl_producto.*', 'sol.porcentaje')->get();

        // Les quito el descuento
        foreach ($productos as $index => $producto) {
            $nuevaData = [
                'total' => ($producto->pivot->venta_por == 'UN' || $producto->pivot->venta_por == 'UN ') ? $producto->pivot->unidades * $producto->pivot->valor_un : $producto->pivot->peso * $producto->pivot->valor_kg,
                'totald' => 0,
                'descuento' => 0
            ];
            DB::table('tbl_reg_comercial')->where('id_reg_comercial', $producto->pivot->id_reg_comercial)->update($nuevaData);
        }

        $pedido->fecha_entrega = $fecha_entrega;
        $pedido->save();

        // Traigo los productos que tienen solicitudes aprobadas para la nueva fecha
        $productos = $pedido->productos()->join('tbl_solicitud_descuento AS sol', function ($join) use ($pedido) {
            $join->on('tbl_producto.codigo', '=', 'sol.codigo_producto')
                 ->where('sol.estado', 2)
                 ->where('sol.fecha', $pedido->fecha_entrega)
                 ->where('sol.id_cliente', $pedido->cliente->id_cliente);
        })->addSelect('tbl_producto.*', 'sol.porcentaje')->get();

        // Aplico el descuento a los que lo tienen
        foreach ($productos as $index => $producto) {
            $totald = $producto->pivot->total * $producto->porcentaje / 100;
            $nuevaData = [
                'total' => $producto->pivot->total - $totald,
                'totald' => $totald,
                'descuento' => ($producto->pivot->venta_por == 'UN' || $producto->pivot->venta_por == 'UN ') ? ($producto->pivot->valor_un * $producto->porcentaje / 100) : ($producto->pivot->valor_kg * $producto->porcentaje / 100)
            ];
            DB::table('tbl_reg_comercial')->where('id_reg_comercial', $producto->pivot->id_reg_comercial)->update($nuevaData);
        }

        $productos = $pedido->productos()->leftJoin('tbl_solicitud_descuento AS sol', function ($join) use ($pedido) {
            $join->on('tbl_producto.codigo', '=', 'sol.codigo_producto')
                 ->where('sol.estado', 2)
                 ->where('sol.fecha', $pedido->fecha_entrega)
                 ->where('sol.id_cliente', $pedido->cliente->id_cliente);
        })->addSelect('tbl_producto.*', 'sol.porcentaje')->get();

        return response()->json(compact('productos'), 200);
    }

    //Lista todos los pedidos del usuario
    public function misPedidos()
    {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $hoy = Carbon::now();
        return view('pedidos.misPedidos')->with(compact('usuario', 'hoy'));
    }

    //Pone el pedido en ruta
    public function enRuta($id)
    {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $pedido = TblPedido::find($id);
        $entrega = Carbon::create($pedido->fecha_entrega);

        $pedido->en_ruta = 1;
        $pedido->save();

        return view('pedidos.ver')->with(compact('usuario', 'pedido', 'entrega'));
    }

    //Pone el pedido en despchado
    public function despachado($id)
    {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $pedido = TblPedido::find($id);
        $entrega = Carbon::create($pedido->fecha_entrega);

        $pedido->en_ruta = 1;
        $pedido->despachado = 1;
        $pedido->save();

        return view('pedidos.ver')->with(compact('usuario', 'pedido', 'entrega'));
    }

    //Pone el pedido en ruta multi para la tabla en el index
    public function enRutaMulti(Request $request)
    {
        $pedidos = json_decode($request->pedidos);

        foreach ($pedidos as $idpedido)
        {
            $pedido = TblPedido::find($idpedido);
            $pedido->en_ruta = 1;
            $pedido->save();
        }

        return response()->json('success', 200);
    }

    //Pone el pedido entregado multi para la tabla en el index
    public function entregadosMulti(Request $request)
    {
        $pedidos = json_decode($request->pedidos);

        foreach ($pedidos as $idpedido)
        {
            $pedido = TblPedido::find($idpedido);
            $pedido->en_ruta = 1;
            $pedido->despachado = 1;
            $pedido->save();
        }

        return response()->json('success', 200);
    }
}
