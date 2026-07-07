<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxBackOfficeController extends Controller
{
    public function imprimirPedidos(Request $request) {
        $variables = $request->all();
        return response()->json(compact('variables'), 200);
    }
}
