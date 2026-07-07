<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TblUsuario;
use Carbon\Carbon;
use Session;

class EncuestaController extends Controller
{
    // Middleware que valida si el usuario está autenticado antes de acceder a cualquier método
    public function __construct()
    {
        $this->middleware('auth.check');
    }

    //Lista la vista encuesta
    public function show()
    {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $hoy = Carbon::now();
        return view('encuesta.index')->with(compact('usuario', 'hoy'));
    }
}
