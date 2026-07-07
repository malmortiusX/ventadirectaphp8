<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TblUsuario;
use Carbon\Carbon;
use Session;

class ProductosController extends Controller
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
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $hoy = Carbon::now();

        if (isset($_GET['perPage'])) {
            Session::put('pagination', $_GET['perPage']);
        } elseif (!Session::has('pagination')) {
            Session::put('pagination', 10);
        }

        $orden = (isset($_GET['orden']) ? (strpos($_GET['orden'], ',') ? substr($_GET['orden'], 0, strpos($_GET['orden'], ',')) : $_GET['orden']) : 'pro.codigo');
        $orden2 = isset($_GET['orden']) && strpos($_GET['orden'], ',') && substr($_GET['orden'], strpos($_GET['orden'], ',') + 1) == 'desc' ? 'desc' : 'asc';
        $fecha_inicial = (isset($_GET['fecha_inicial']) ? $_GET['fecha_inicial'] : Carbon::now()->firstOfMonth()->toDateString());
        $fecha_final = (isset($_GET['fecha_final']) ? $_GET['fecha_final'] : $hoy->toDateString());
        $linea = (isset($_GET['linea']) ? $_GET['linea'] : null);
        $nombre = (isset($_GET['nombre']) ? $_GET['nombre'] : null);

        $productos = DB::table('tbl_producto AS pro')
            ->join('tbl_reg_comercial AS rgc', 'pro.id_producto', 'rgc.id_producto')
            ->join('tbl_comercial AS com', function ($join) use ($fecha_inicial, $fecha_final, $usuario) {
                $join->on('rgc.id_comercial', 'com.id_comercial')
                      ->where('com.estado', 1)
                      ->where('com.id_usuario', $usuario->id_usuario)
                      ->whereDate('com.fecha_entrega', '>=', $fecha_inicial)
                      ->whereDate('com.fecha_entrega', '<=', $fecha_final);
            })
            ->select('pro.codigo', 'pro.nombre', 'pro.codlinea', 'pro.desclinea', DB::raw('SUM(rgc.unidades) AS unidades'), DB::raw('SUM(rgc.peso) AS peso'), DB::raw('SUM(rgc.totald) AS totald'), DB::raw('SUM(rgc.total) AS total'))
            ->when($linea, function ($query) use ($linea) {
                return $query->where('pro.codlinea', $linea);
            })
            ->when($nombre, function ($query) use ($nombre) {
                return $query->whereRaw('UPPER(pro.nombre) LIKE ?', '%' . mb_strtoupper(str_replace(' ', '%', $nombre)) . '%')
                             ->orWhereRaw('UPPER(pro.codigo) LIKE ?', '%' . mb_strtoupper(str_replace(' ', '%', $nombre)) . '%');
            })
            ->groupBy('pro.codigo', 'pro.nombre', 'pro.codlinea', 'pro.desclinea')
            ->orderBy($orden, $orden2)
            ->paginate(Session::get('pagination'));

        $lineas = DB::table('tbl_producto AS pro')
            ->join('tbl_reg_comercial AS rgc', 'pro.id_producto', 'rgc.id_producto')
            ->join('tbl_comercial AS com', function ($join) use ($fecha_inicial, $fecha_final, $usuario) {
                $join->on('rgc.id_comercial', 'com.id_comercial')
                    ->where('com.estado', 1)
                    ->where('com.id_usuario', $usuario->id_usuario)
                    ->whereDate('com.fecha_entrega', '>=', $fecha_inicial)
                    ->whereDate('com.fecha_entrega', '<=', $fecha_final);
            })
            ->select('pro.codlinea', 'pro.desclinea')
            ->distinct()
            ->orderBy('desclinea')
            ->get();
            
        return view('productos.index')->with(compact('usuario', 'hoy', 'lineas', 'productos', 'nombre', 'orden', 'orden2', 'fecha_inicial', 'fecha_final', 'linea'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
}
