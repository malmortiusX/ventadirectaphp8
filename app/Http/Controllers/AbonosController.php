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

class AbonosController extends Controller
{
    // Middleware que valida si el usuario está autenticado antes de acceder a cualquier método
    public function __construct()
    {
        $this->middleware('auth.check');
    }

    //Lista todos los pedidos del usuario
    public function index()
    {
        //$usuario = TblUsuario::find(727);
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $hoy = Carbon::now();
        return view('abonos.index')->with(compact('usuario', 'hoy'));
    }

    // Renderiza la vista de crear pedido
    public function create($valor = "0")
    {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);

        return view('abonos.nuevo')->with(compact('usuario', 'valor'));
    }

    // Renderiza la vista de crear pedido
    public function recepcion()
    {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);

        $idRecepcion = $_GET['id'];
        // dd($idRecepcion);

        return view('abonos.recepcion')->with(compact('usuario', 'idRecepcion'));
    }
}
