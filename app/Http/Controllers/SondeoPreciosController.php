<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\TblCanalVentas;
use App\Models\TblListaPrecio;
use App\Models\TblMarca;
use App\Models\TblProducto;
use App\Models\TblSondeo;
use App\Models\TblUsuario;
use Carbon\Carbon;
use Session;

class SondeoPreciosController extends Controller
{
    // Middleware que valida si el usuario está autenticado antes de acceder a cualquier método
    public function __construct()
    {
        $this->middleware('auth.check');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hoy = Carbon::now();
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $orden = (isset($_GET['orden']) ? substr($_GET['orden'], 0, strpos($_GET['orden'], '|')) : 'fecha_sondeo');
        $sort = (isset($_GET['orden']) ? substr($_GET['orden'], strpos($_GET['orden'], '|') + 1) : 'desc');
        $marca = (isset($_GET['marca']) ? $_GET['marca'] : null);
        $canal = (isset($_GET['canal']) ? $_GET['canal'] : null);
        $producto = (isset($_GET['producto']) ? $_GET['producto'] : null);
        $fecha_final = (isset($_GET['fecha_final']) ? $_GET['fecha_final'] : $hoy->toDateString());
        $fecha_inicial = (isset($_GET['fecha_inicial']) ? $_GET['fecha_inicial'] : Carbon::now()->firstOfMonth()->toDateString());

        if (isset($_GET['perPage'])) {
            Session::put('pagination', $_GET['perPage']);
        } elseif (!Session::has('pagination')) {
            Session::put('pagination', 10);
        }

        $marcas = TblMarca::all()->sortBy('nombre');
        $canales = TblCanalVentas::all()->sortBy('nombre');
        if ($usuario->nivel == 'u_administrador' || $usuario->nivel == 'u_supervisor') {
            $sondeos = TblSondeo::leftJoin('tbl_producto AS pro', 'codigo_producto', 'pro.codigo')
                ->when($marca, function ($query) use ($marca) {
                    return $query->where('id_marca', $marca);
                })
                ->when($canal, function ($query) use ($canal) {
                    return $query->where('id_canal', $canal);
                })
                ->when($producto, function ($query) use ($producto) {
                    return $query->whereRaw('UPPER(pro.nombre) LIKE ?', '%' . mb_strtoupper(str_replace(' ', '%', $producto)) . '%')
                                ->orWhereRaw('UPPER(pro.codigo) LIKE ?', '%' . mb_strtoupper(str_replace(' ', '%', $producto)) . '%');
                })
                ->whereDate('fecha_sondeo', '>=', $fecha_inicial)
                ->whereDate('fecha_sondeo', '<=', $fecha_final)
                ->orderBy($orden, $sort)
                ->paginate(Session::get('pagination'));
        } else {
            $sondeos = $usuario->sondeos()
                ->leftJoin('tbl_producto AS pro', 'codigo_producto', 'pro.codigo')
                ->when($marca, function ($query) use ($marca) {
                    return $query->where('id_marca', $marca);
                })
                ->when($canal, function ($query) use ($canal) {
                    return $query->where('id_canal', $canal);
                })
                ->when($producto, function ($query) use ($producto) {
                    return $query->whereRaw('UPPER(pro.nombre) LIKE ?', '%' . mb_strtoupper(str_replace(' ', '%', $producto)) . '%')
                                ->orWhereRaw('UPPER(pro.codigo) LIKE ?', '%' . mb_strtoupper(str_replace(' ', '%', $producto)) . '%');
                })
                ->whereDate('fecha_sondeo', '>=', $fecha_inicial)
                ->whereDate('fecha_sondeo', '<=', $fecha_final)
                ->orderBy($orden, $sort)
                ->paginate(Session::get('pagination'));
        }
        return view('sondeos.index')->with(compact('usuario', 'sondeos', 'marcas', 'canales', 'orden', 'sort', 'marca', 'canal', 'producto', 'fecha_inicial', 'fecha_final', 'hoy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $canales = TblCanalVentas::all()->sortBy('nombre');
        $marcas = TblMarca::all()->sortBy('nombre');
        $listas = TblListaPrecio::where('lista_sondeo', 1)->addSelect(DB::Raw('TRIM(nombre) AS lista_precio, TRIM(codigo) AS codigo'))->orderBy(DB::Raw('TRIM(codigo)'))->distinct()->get();
        return view('sondeos.nuevo')->with(compact('usuario', 'canales', 'marcas', 'listas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $sondeo = new TblSondeo();

        try {
            // Inicia la tansacción
            DB::beginTransaction();
            $sondeo->fill($request->all());
            $sondeo->id_usuario = $usuario->id_usuario;
            $sondeo->regional = $usuario->regional;
            $sondeo->ciudad = $usuario->ciudad;
            $sondeo->fecha_sondeo = date('Y-m-d H:i:s');
            $sondeo->imagen = null;
            $sondeo->save();

            // Valida si hay imágen adjunta
            if($request->imagen){
                $extension = $request->imagen->getClientOriginalExtension();
                // Crea el nombre, guarda la imágen y guarda la ruta en la BD
                $nombre = $sondeo->id_sondeo .'-'. $sondeo->codigo_producto .'.'. $extension;
                Storage::disk('private')->put('/sondeos/' . $nombre, \File::get($request->imagen));
                $sondeo->imagen = 'sondeos/' . $nombre;
                $sondeo->save();
            }

            Session::put('sondeo-id_canal', $sondeo->id_canal);
            Session::put('sondeo-id_marca', $sondeo->id_marca);
            Session::put('sondeo-lista_precio', $sondeo->lista_precio);
            $producto = $sondeo->producto;
            $data = json_encode(compact('sondeo', 'producto'));
            Session::put('sondeo_creado', $data);
            DB::commit();
            return redirect()->route('sondeos.index');
        } catch (\Exception $exc) {
            // En caso de fallar reversa los cambios realizados en la BD
            DB::rollback();
            report($exc);
            dd($exc);
            $success = false;
            return back()->withErrors(['msg', 'Hubo un error inesperado']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function obtenerProductos($busqueda) {
        $productos = TblProducto::where('sondear', 1)
            ->where('activo', 1)
            ->where(function($query) use ($busqueda) {
                $query->where('nombre', 'like', '%' . $busqueda . '%')
                      ->orWhere('codigo', 'like', '%' . $busqueda . '%');
            })
            ->orderBy(DB::Raw('TRIM(nombre)'), 'asc')
            ->distinct()
            ->limit(10)
            ->get();
        return response()->json(compact('productos'), 200);
    }

    // Buscar precio de producto segun lista de precio para el sondeo
    public function obtenerPrecioProducto($producto, $listaprecio) {
        $lista_precio = TblListaPrecio::findOrFail($listaprecio);

        foreach ($lista_precio->productos as $rel_lista_precio) {
            if($rel_lista_precio->codigo == $producto){
                $precio_unidad_inventario = $rel_lista_precio->pivot->precio_unidad_inventario;
                $precio_unidad_empaque = $rel_lista_precio->pivot->precio_unidad_empaque;
            }
        }
        return response()->json(compact('precio_unidad_inventario', 'precio_unidad_empaque'), 200);
    }
}
