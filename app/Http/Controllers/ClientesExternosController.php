<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Ciudad;
use App\Models\TblTipoCliente;
use App\Models\TblCliente;
use App\Models\TblClienteVd;
use App\Models\TblUsuario;
use App\Models\TblCentDist;
use App\Models\TblFormularioEmpresarias;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;

use Session;

class ClientesExternosController extends Controller
{
    // Renderiza la vista de crear usuario para el COP
    public function createExternoCop($cop)
    {
        $ciudades = Ciudad::orderBy('ciudad')->get();

        $pdvs = TblUsuario::where('nivel', 'u_comercial')
                    ->where('estado', '0')
                    ->where('canal_ventas', 'PDV')
                    ->get();

        // dd($pdvs[29]);

        $pdv = TblUsuario::where('nivel', 'u_comercial')
                    ->where('codigo_vendedor', $cop)
                    ->first();

        if($cop == '401') {
            $campanaActiva = DB::table('campanas')
            ->select('id', 'nombre')
            ->where('estado', '1')
            ->first();
            // ->get();
        } elseif($cop == '111') {
            $campanaActiva = new \stdClass();
            $campanaActiva->nombre = "CALLCENTER";
        } else {
            $campanaActiva = NULL;
        }
        // dd($cop);

        $tiposCliente = TblTipoCliente::where('id_canal', 5)->orderBy('clase')->get();

        $centroDistribucion = TblCentDist::where('cop', 'like', $cop.'%')->first();

        return view('clientes.pdvnuevoExterno')->with(compact('ciudades', 'tiposCliente', 'cop', 'centroDistribucion', 'pdvs', 'pdv', 'campanaActiva'));
    }

    // Renderiza la vista de crear usuario para el NIT
    public function createExternoNit($nit)
    {
        $ciudades = Ciudad::orderBy('ciudad')->get();
        $cliente = TblCliente::where('cedula', $nit)->first();
        $tiposCliente = TblTipoCliente::where('id_canal', 5)->orderBy('clase')->get();
        // dd($cliente);
        return view('clientes.pdvnuevoExterno')->with(compact('ciudades', 'tiposCliente', 'cliente'));
    }

    // Renderiza la vista de crear empresario
    public function createEmpresario()
    {
        Carbon::setUTF8(true);
        Carbon::setLocale(config('app.locale'));
        setlocale(LC_ALL, 'es_MX', 'es', 'ES', 'es_MX.utf8');
        $fecha = Carbon::now();
        $ciudades = Ciudad::whereNotNull('cop')->whereNotNull('regional')->orderBy('ciudad')->get();
        $tiposCliente = TblTipoCliente::where('id_canal', 5)->orderBy('clase')->get();

        return view('clientes.empresarioNuevo')->with(compact('ciudades', 'tiposCliente', 'fecha'));
    }

    // Renderiza la vista de crear empresario
    public function createEmpresarioContinuacion()
    {
        Carbon::setUTF8(true);
        Carbon::setLocale(config('app.locale'));
        setlocale(LC_ALL, 'es_MX', 'es', 'ES', 'es_MX.utf8');
        $formulario = TblFormularioEmpresarias::where('cedula_empresaria', Session::get('user')->documento)->latest('id')->first();
        $fecha = Carbon::now();
        $ciudades = Ciudad::whereNotNull('cop')->whereNotNull('regional')->orderBy('ciudad')->get();
        $ciudadesTodas = Ciudad::orderBy('ciudad')->get();
        $tiposCliente = TblTipoCliente::where('id_canal', 5)->orderBy('clase')->get();

        return view('clientes.empresarioNuevoContinuacion')->with(compact('ciudades', 'ciudadesTodas', 'tiposCliente', 'fecha', 'formulario'));
    }

    public function storeExterno(Request $request) {

        // dd($request);
        $usuario = TblUsuario::where('codigo_vendedor', $request->cop)->first();

        if($usuario) {
            if ($usuario->crea_clientes != 1 || trim($request->cop) == "") {
                $mensaje = 'Hola <b class="capitalize">'. mb_strtolower($usuario->nombres). '</b>, al parecer te perdiste. No estás autorizado para crear clientes.';
                return view('errorfull')->with(compact('usuario', 'mensaje'));
            }
        }

        $cliente = TblCliente::where('cedula', $request->codigo_cli)->first();
        // dd($cliente);
        if (!$cliente) {
            $cliente = new TblCliente();
            Session::put('cliente_creado', $cliente);
        } else {
            Session::put('cliente_actualizado', $cliente);
        }

        $cliente->fill($request->all());

        // Convierte todos los atributos a mayúscula
        foreach ($cliente->getAttributes() as $el => $val) {
            $cliente->$el = mb_strtoupper($val);
        }

        $cliente->sucursal = '00';
        $cliente->cc_nit = $cliente->codigo_cli .'.'. $cliente->sucursal;
        $cliente->nombre_cliente = mb_strtoupper($request->nombres);

        if($usuario) {
            $cliente->codigo_vendedor = $usuario->codigo_vendedor;
            $cliente->lista_precio = $usuario->lista_precio;
        } else {
            $cliente->codigo_vendedor = "";
            $cliente->lista_precio = "LVD";
        }

        $cliente->fecha_creacion = date('Y-m-d');
        $cliente->id_tipo_cliente = 56;
        $cliente->estado_cliente = 0;
        $cliente->aprobado_com = 1;
        $cliente->inactivo = 0;

        // Variables obligatorias pero que no se como llenar
        $cliente->interno = 0;
        $cliente->ruta = '';
        $cliente->fecha_modificacion = '1970-01-01';
        $cliente->fecha_descuento = '';
        $cliente->latitud = '';
        $cliente->longitud = '';
        $cliente->precision = '';
        $cliente->cedula = $cliente->codigo_cli;
        $cliente->secuencia = 0;
        $cliente->secuencia_entrega = 0;
        $cliente->creado_ced = 0;
        $cliente->co = $request->cop;
        $cliente->tipo_cliente = 6021;

        if($request->firma){
            $image_64 = $request->firma;
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
            $replace = substr($image_64, 0, strpos($image_64, ',')+1);

            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $nombre = $cliente->cc_nit.'.'.$extension;
            Storage::disk('private')->put('/clientes/firmas/' . $nombre, base64_decode($image));
            $cliente->firma = 'clientes/firmas/' . $nombre;
        }
        // dd($cliente);
        $cliente->save();
        try {
            dispatch(new CorreoClienteJob($usuario, $cliente));
            //Mail::to($usuario->correo_jefe)->send(new CorreoCliente($usuario, $cliente));
        } catch (\Throwable $th) {
            //throw $th;
        }

        $cops = array('014', '090', '096', '097', '102', '104', '106', '108', '122', '202', '204', '401', '407', '408', '409', '412', '414', '415', '419', '420', '423', '452', '456', '457', '458', '476', '482', '531', '564', '565', '566', '568', '569', '576', '584', '588', '590', '596', '597', '598', '599', '248', '261');

        if($usuario && in_array($request->cop, $cops)) {
            if($request->campana){
                if($request->campana == 'CALLCENTER') {
                    return redirect(route('clientes.externos.cop', ['cop' => '111']));
                } else {
                    return redirect(route('clientes.externos.cop', ['cop' => '401']));
                }
            } else {
                return redirect(route('clientes.externos.cop', ['cop' => $request->cop]));
            }
        } else {
            return redirect(route('clientes.externos.empresarios'));
        }
    }



    public function storeEmpresario(Request $request) {

        $formulario = new TblFormularioEmpresarias;

        $formulario->fill($request->all());

        $formulario->fecha_creacion = Carbon::now()->format('Y-m-d H:i:s');
        $formulario->save();
        // dd($formulario);

        $usuario_empresaria = TblUsuario::where('documento', $request->cedula_empresaria)->where('nivel', 'u_ventadirecta')->where('codigo_vendedor', 'NOT LIKE', 'VD%')->where('codigo_vendedor', 'NOT LIKE', 'VI%')->first();
        // dd($cliente);
        if (!$usuario_empresaria) {

            $usuario_empresaria = new TblUsuario();
            Session::put('usuario_creado', $usuario_empresaria);

            //ASIGNA EL SIGUIENTE CODIGO DE VENDEDOR
            $numero_siguiente = DB::table('codigos_empresarias')->select('numero_siguiente')->first();
            $usuario_empresaria->codigo_vendedor = "V" . str_pad($numero_siguiente->numero_siguiente, 3, "0", STR_PAD_LEFT);
            $nuevo_numero_siguiente = $numero_siguiente->numero_siguiente + 1;
            $codigo_empresarias = DB::update(
                'UPDATE codigos_empresarias SET numero_siguiente = ? ',
                [$nuevo_numero_siguiente]
            );
            $usuario_empresaria->estado = '0';

            $usuario_empresaria->nombres = $request->nombres_empresaria;
            $usuario_empresaria->apellidos = $request->apellidos_empresaria;
            $usuario_empresaria->descripcion = '';
            $usuario_empresaria->documento = $request->cedula_empresaria;
            $usuario_empresaria->correo = $request->correo_empresaria;
            $usuario_empresaria->telefono = $request->telefono_empresaria;
            $usuario_empresaria->direccion = $request->direccion_empresaria;
            $usuario_empresaria->nivel = 'u_ventadirecta';
            $usuario_empresaria->error_clave = '0';
            $usuario_empresaria->pin = '0000';

            $usuario_empresaria->ultima_actualizacion = Carbon::now()->format('Y-m-d H:i:s');
            $usuario_empresaria->fecha_modificado = Carbon::now()->format('Y-m-d H:i:s');

            //ASIGNA EL COP DE LA CIUDAD
            $cop = DB::table('ciudades')->select('cop')->where('id_ciudad', $request->ciudad_empresaria)->first();
            $usuario_empresaria->cop = $cop->cop;

            $ciudad = DB::table('ciudades')->select('ciudad')->where('id_ciudad', $request->ciudad_empresaria)->first();
            $usuario_empresaria->ciudad = $ciudad->ciudad;

            $regional = DB::table('ciudades')->select('regional')->where('id_ciudad', $request->ciudad_empresaria)->first();
            $usuario_empresaria->regional = $regional->regional;

            $usuario_empresaria->cc_nit_usuario = $request->cc_nit;
            $usuario_empresaria->correo_jefe = 'yolima.jaimes@avicolaelmadrono.com';
            $usuario_empresaria->pedido_minimo = 0;
            $usuario_empresaria->lista_precio = "LVE";
            $usuario_empresaria->cambio_cop = '0';
            $usuario_empresaria->cambia_rutero_varios = '0';
            $usuario_empresaria->color = 'celeste';
            $usuario_empresaria->control_minimo = '0';
            $usuario_empresaria->canalventas = '10';
            $usuario_empresaria->cc_nit_usuario = $request->cedula_empresaria . '.00';
            $usuario_empresaria->login = $usuario_empresaria->codigo_vendedor;
            $usuario_empresaria->clave = md5(sha1($request->cedula_empresaria));
            $usuario_empresaria->pregunta_secreta = $usuario_empresaria->clave;
            $usuario_empresaria->respuesta_secreta = $usuario_empresaria->clave;

            $usuario_empresaria->save();

        } else {
            Session::put('usuario_actualizado', $usuario_empresaria);
        }
        // dd($usuario_empresaria);


        $cliente_empresaria = TblCliente::where('cedula', $request->cedula_empresaria)->first();

        if (!$cliente_empresaria) {

            $cliente_empresaria = new TblCliente();
            Session::put('cliente_creado', $cliente_empresaria);
            $cliente_empresaria->estado_cliente = 0;
            $cliente_empresaria->aprobado_com = 0;
            $cliente_empresaria->inactivo = 0;

            $cliente_empresaria->sucursal = '00';
            $cliente_empresaria->cc_nit = $request->cedula_empresaria .'.'. $cliente_empresaria->sucursal;
            $cliente_empresaria->nombre_cliente = mb_strtoupper($request->nombres_empresaria) . " ". mb_strtoupper($request->apellidos_empresaria);
            $cliente_empresaria->codigo_vendedor = $usuario_empresaria->codigo_vendedor;
            $cliente_empresaria->lista_precio = $usuario_empresaria->lista_precio;
            $cliente_empresaria->fecha_creacion = date('Y-m-d');
            $cliente_empresaria->id_tipo_cliente = 12;
            $cliente_empresaria->barrio = $request->barrio_empresaria;

            // Variables obligatorias pero que no se como llenar
            $cliente_empresaria->interno = 0;
            $cliente_empresaria->ruta = '';
            $cliente_empresaria->fecha_modificacion = Carbon::now()->format('Y-m-d');
            $cliente_empresaria->fecha_descuento = '';
            $cliente_empresaria->latitud = '';
            $cliente_empresaria->longitud = '';
            $cliente_empresaria->precision = '';
            $cliente_empresaria->cedula = $request->cedula_empresaria;
            $cliente_empresaria->secuencia = 0;
            $cliente_empresaria->secuencia_entrega = 0;
            $cliente_empresaria->creado_ced = 0;
            $cliente_empresaria->co = $request->cop;
            $cliente_empresaria->tipo_cliente = 9002;
            $cliente_empresaria->telefono = $request->telefono_empresaria;
            $cliente_empresaria->direccion = $request->direccion_empresaria;
            $cliente_empresaria->ciudad = $request->ciudad_empresaria;
            $cliente_empresaria->correo = $request->correo_empresaria;
            $cliente_empresaria->save();
            // dd($cliente_empresaria);

            $clienteVD_empresaria = new TblClienteVd();
            $clienteVD_empresaria->id_usuario = $usuario_empresaria->id_usuario;
            $clienteVD_empresaria->nombres = $usuario_empresaria->nombres;
            $clienteVD_empresaria->apellidos = $usuario_empresaria->apellidos;
            $clienteVD_empresaria->cedula = $usuario_empresaria->documento;
            $clienteVD_empresaria->telefono = $usuario_empresaria->telefono;
            $clienteVD_empresaria->correo_electronico = $usuario_empresaria->correo;
            $clienteVD_empresaria->direccion = $usuario_empresaria->direccion;
            $clienteVD_empresaria->barrio = $request->barrio_empresaria;
            $clienteVD_empresaria->id_ciudad = $request->ciudad_empresaria;
            $clienteVD_empresaria->save();

        } else {
            Session::put('cliente_actualizado', $cliente_empresaria);
        }

        return redirect(route('clientes.externos.empresarios'));
    }


    public function storeEmpresarioContinuacion(Request $request) {

        // dd($request);

        $formulario = TblFormularioEmpresarias::where('cedula_empresaria', Session::get('user')->documento)->latest('id')->first();

        $formulario->fill($request->all());

        if($request->cedula_empresaria_cara_1){
            $nombre = $formulario->cedula_empresaria . '-cedula_cara_1' . '.' . $request->cedula_empresaria_cara_1->getClientOriginalExtension();;
            Storage::disk('private')->put('/empresarias/cedulas/' . $nombre, \File::get($request->cedula_empresaria_cara_1));
            $formulario->cedula_empresaria_cara_1 = 'empresarias/cedulas/' . $nombre;
        }

        if($request->cedula_empresaria_cara_2){
            $nombre = $formulario->cedula_empresaria . '-cedula_cara_2' . '.' . $request->cedula_empresaria_cara_2->getClientOriginalExtension();;
            Storage::disk('private')->put('/empresarias/cedulas/' . $nombre, \File::get($request->cedula_empresaria_cara_2));
            $formulario->cedula_empresaria_cara_2 = 'empresarias/cedulas/' . $nombre;
        }

        if($request->firma_empresaria){
            $image_64 = $request->firma_empresaria;
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
            $replace = substr($image_64, 0, strpos($image_64, ',')+1);

            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $nombre_archivo = $formulario->cedula_empresaria.'.'.$extension;
            Storage::disk('private')->put('/empresarias/firmas/' . $nombre_archivo, base64_decode($image));
            $formulario->firma_empresaria = 'empresarias/firmas/' . $nombre_archivo;
        }
        $formulario->fecha_modificacion = Carbon::now()->format('Y-m-d H:i:s');
        $formulario->save();
        // dd($formulario);

        $cliente_empresaria = TblCliente::where('codigo_vendedor', Session::get('user')->codigo_vendedor)->first();
        $cliente_empresaria->firma = $formulario->firma_empresaria;
        $cliente_empresaria->save();
        // dd($cliente_empresaria);

        return redirect(route('pedidos.create'));
    }
}
