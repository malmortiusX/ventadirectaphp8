<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TblUsuario;
use App\Models\TblFacturaAnulada;
use Session;

class FacturasAnuladasController extends Controller
{
    // Middleware que valida si el usuario está autenticado antes de acceder a cualquier método
    public function __construct()
    {
        $this->middleware('auth.check');
    }

    // Define que vista renderizar y con que información
    public function index()
    {
        \Log::info('INDEX', ['session_id' => session()->getId(), 'success' => session('success')]);
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);

        if ($usuario->nivel == 'u_administrador') {
            $tiposDevolucion = [
                'Error en peso de producto',
                'Error en unidades',
                'Error en código',
                'Error en precio',
                'Por merma',
                'Entrega fuera de tiempo',
                'Otros conceptos'
            ];

            // var_dump(Session::get('user'));
            // exit;
            // if(Session::has('success')) {
            //     Session::forget('success');
            //     return view('registro-facturas-anuladas.index')->with(compact('usuario', 'tiposDevolucion', 'successMessage'));
            // }

            return view('registro-facturas-anuladas.index')->with(compact('usuario', 'tiposDevolucion'));
        } else {
            abort(403);
        }
    }

    public function store(Request $request)
    {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
 
        if ($usuario->nivel == 'u_administrador' || $usuario->nivel == 'u_comercial') {
            // Validar los datos del formulario
            $request->validate([
                'nit' => 'required|string|max:20',
                'nombre_cliente' => 'required|string|max:150',
                'direccion_cliente' => 'required|string|max:200',
                'telefono_cliente' => 'required|string|max:20',
                'centro_operacion' => 'required|string|max:100',
                'tipo_documento' => 'required|string|max:50',
                'numero_documento' => 'required|string|max:30',
                'fecha' => 'required|date',
                'valor' => 'required|numeric',
                'tipo_devolucion' => 'required|string|max:50',
                'observacion' => 'required|string|max:1000',
            ]);
 
            // Guardar la información en la base de datos
            $facturaAnulada = new TblFacturaAnulada();
            $facturaAnulada->nit = $request->input('nit');
            $facturaAnulada->nombre_cliente = $request->input('nombre_cliente');
            $facturaAnulada->direccion_cliente = $request->input('direccion_cliente');
            $facturaAnulada->telefono_cliente = $request->input('telefono_cliente');
            $facturaAnulada->centro_operacion = $request->input('centro_operacion');
            $facturaAnulada->tipo_documento = $request->input('tipo_documento');
            $facturaAnulada->numero_documento = $request->input('numero_documento');
            $facturaAnulada->fecha = $request->input('fecha');
            $facturaAnulada->valor = $request->input('valor');
            $facturaAnulada->tipo_devolucion = $request->input('tipo_devolucion');
            $facturaAnulada->observacion = $request->input('observacion');
            $facturaAnulada->id_usuario_registro = $usuario->id_usuario;
            $facturaAnulada->save();

            \Log::info('STORE', ['session_id' => session()->getId(), 'success_set' => true]);
 
            return redirect()->route('registro-facturas-anuladas.index')->with('success', 'Factura anulada registrada correctamente.');
        } else {
            abort(403);
        }
    }
}
