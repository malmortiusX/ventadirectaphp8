<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MvGuiaTransporte;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\TblCentDist;
use App\Models\TblEmpresa;
use Carbon\Carbon;
use CodeItNow\BarcodeBundle\Utils\QrCode;
use Dompdf\Dompdf;
use PDF;


class GuiasController extends Controller
{
    public function cargarFactura() {

        $factura = (isset($_GET['factura']) ? $_GET['factura'] : null);
        $placa = (isset($_GET['placa']) ? $_GET['placa'] : null);
        $fecha = (isset($_GET['fecha']) ? Carbon::parse($_GET['fecha']) : null);
        $hoy = Carbon::now();

        // $prueba = DB::connection('sqlsrv')
        //         ->table('MVVARIABLE AS rgc')
        //         ->where('CODVAR', 'FILEFAC')
        //         ->where('CODUSUA', 'TCONTRE')
        //         ->first();

        // dd($prueba);

        return view('guias.cargaFactura')->with(compact(
            'factura',
            'placa',
            'fecha'
        ));


    }

    public function cortarFactura(Request $request) {

        function FormatearValor($cadena, $signo){

            $valor = 0;

            for($i = 1; $i <= strlen($cadena); $i++){
                if( substr($cadena, $i, 1) <> "," && substr($cadena, $i, 1) <> "$"){

                    $valor = $valor + substr($cadena, $i, 1);

                }
            }

            $valor = ($signo == "-") ? $valor * -1 : $valor;

            return $valor;
        }

        // Valida si hay archivo adjunto
        if($request->archivo){
            // Crea el nombre, guarda el archivo y guarda la ruta en la BD
            $nombre = Carbon::now()->timestamp .'.'. $request->archivo->getClientOriginalExtension();
            Storage::disk('private')->put('/guias-transporte/facturas/' . $nombre, \File::get($request->archivo));
        }

        $archivo = fopen($request->file('archivo'), 'r');
        $totalLineas = 0;
        $totales = false;
        $pasa = false;


        while (!feof($archivo)) {

            $totalLineas++;
            $buffer = fgets($archivo);

            if(!empty($buffer)){

                if($totalLineas == 3 && substr($buffer, 53, 5) != "NIT.:"){
                    dd('FORMATO NO VALIDO');
                }

            }

            if(trim(substr($buffer, 97, 7)) == "Numero:"){

                $totales = false;
                $cop = trim(substr($buffer, 105, 3));
                $tipoDocumento = "RM";
                $documento = trim(substr($buffer, 105, 10));

            }

            if(substr($buffer, 0, 12) == "|* P A S A *"){

                $pasa = true;

            }

            if(substr($buffer, 0, 16) == "|    TOTAL_BRUTO" && !$pasa){
                $totales = true;
            }

            if(substr($buffer, 0, 13) == "| Cliente   :"){
                $nombreCliente = trim(substr($buffer, 14, 30));
                $fechaPago = trim(substr($buffer, 85, 26));
                $totales = false;
            }

            if(substr($buffer, 0, 13) == "| Nit o C.C.:"){
                $nit = trim(substr($buffer, 14, 17));
                $totales = false;
            }

            if(substr($buffer, 0, 13) == "| Direccion :"){
                $direccion = trim(substr($buffer, 14, 40));
                $codigoVendedor = trim(substr($buffer, 80, 13));
                $nombreVendedor = trim(substr($buffer, 94, 26));
                $totales = false;
            }

            if(substr($buffer, 0, 13) == "| Telefono  :"){
                $telefono = trim(substr($buffer, 14, 18));
                $totales = false;
            }

            if(substr($buffer, 0, 13) == "| Email     :"){
                $email = trim(substr($buffer, 14, 33));
                $ordenCompra = trim(substr($buffer, 69, 12));
                $totales = false;
            }

            if(substr($buffer, 0, 13) == "| Ciudad    :"){
                $ciudad = trim(substr($buffer, 14, 20));
                $totales = false;
            }

            if(substr($buffer, 95, 9) == "| Fecha :"){
                $totales = false;

                switch (substr($buffer, 110, 3)){
                    case 'ENE':
                        $fecha = substr($buffer, 114, 2) . "/" . "01" . "/" . substr($buffer, 105, 4);
                        break;

                    case 'FEB':
                        $fecha = substr($buffer, 114, 2) . "/" . "02" . "/" . substr($buffer, 105, 4);
                        break;

                    case 'MAR':
                        $fecha = substr($buffer, 114, 2) . "/" . "03" . "/" . substr($buffer, 105, 4);
                        break;

                    case 'ABR':
                        $fecha = substr($buffer, 114, 2) . "/" . "04" . "/" . substr($buffer, 105, 4);
                        break;

                    case 'MAY':
                        $fecha = substr($buffer, 114, 2) . "/" . "05" . "/" . substr($buffer, 105, 4);
                        break;

                    case 'JUN':
                        $fecha = substr($buffer, 114, 2) . "/" . "06" . "/" . substr($buffer, 105, 4);
                        break;

                    case 'JUL':
                        $fecha = substr($buffer, 114, 2) . "/" . "07" . "/" . substr($buffer, 105, 4);
                        break;

                    case 'AGO':
                        $fecha = substr($buffer, 114, 2) . "/" . "08" . "/" . substr($buffer, 105, 4);
                        break;

                    case 'SEP':
                        $fecha = substr($buffer, 114, 2) . "/" . "09" . "/" . substr($buffer, 105, 4);
                        break;

                    case 'OCT':
                        $fecha = substr($buffer, 114, 2) . "/" . "10" . "/" . substr($buffer, 105, 4);
                        break;

                    case 'NOV':
                        $fecha = substr($buffer, 114, 2) . "/" . "11" . "/" . substr($buffer, 105, 4);
                        break;

                    case 'DIC':
                        $fecha = substr($buffer, 114, 2) . "/" . "12" . "/" . substr($buffer, 105, 4);
                        break;
                }
            }

            if(substr($buffer, 0, 13) == "| Contacto  :"){
                $totales = false;


                switch (substr($buffer, 122, 3)){
                    case 'ENE':
                        $fechaVencimiento = substr($buffer, 126, 2) . "/" . "01" . "/" . substr($buffer, 117, 4);
                        break;

                    case 'FEB':
                        $fechaVencimiento = substr($buffer, 126, 2) . "/" . "02" . "/" . substr($buffer, 117, 4);
                        break;

                    case 'MAR':
                        $fechaVencimiento = substr($buffer, 126, 2) . "/" . "03" . "/" . substr($buffer, 117, 4);
                        break;

                    case 'ABR':
                        $fechaVencimiento = substr($buffer, 126, 2) . "/" . "04" . "/" . substr($buffer, 117, 4);
                        break;

                    case 'MAY':
                        $fechaVencimiento = substr($buffer, 126, 2) . "/" . "05" . "/" . substr($buffer, 117, 4);
                        break;

                    case 'JUN':
                        $fechaVencimiento = substr($buffer, 126, 2) . "/" . "06" . "/" . substr($buffer, 117, 4);
                        break;

                    case 'JUL':
                        $fechaVencimiento = substr($buffer, 126, 2) . "/" . "07" . "/" . substr($buffer, 117, 4);
                        break;

                    case 'AGO':
                        $fechaVencimiento = substr($buffer, 126, 2) . "/" . "08" . "/" . substr($buffer, 117, 4);
                        break;

                    case 'SEP':
                        $fechaVencimiento = substr($buffer, 126, 2) . "/" . "09" . "/" . substr($buffer, 117, 4);
                        break;

                    case 'OCT':
                        $fechaVencimiento = substr($buffer, 126, 2) . "/" . "10" . "/" . substr($buffer, 117, 4);
                        break;

                    case 'NOV':
                        $fechaVencimiento = substr($buffer, 126, 2) . "/" . "11" . "/" . substr($buffer, 117, 4);
                        break;

                    case 'DIC':
                        $fechaVencimiento = substr($buffer, 114, 2) . "/" . "12" . "/" . substr($buffer, 117, 4);
                        break;
                }

            }

            if(substr($buffer, 0, 1) == "|" && substr($buffer, 136, 1) == "|" && substr($buffer, 94, 1) == "." && substr($buffer, 108, 1) == "." && substr($buffer, 125, 1) == "." && substr($buffer, 132, 1) == "."){
                $totales = false;

                $codigo = trim(substr($buffer, 1, 10));
                $descripcion  = trim(substr($buffer, 23, 30));
                $unidadMedida = trim(substr($buffer, 79, 3));
                $cantidad = FormatearValor(substr($buffer, 65, 12), substr($buffer, 77, 1));
                $cantidadEmpaque = 0;
                $precio = FormatearValor(substr($buffer, 84, 13), substr($buffer, 85, 1));
                $iva = FormatearValor(substr($buffer, 130, 5), "");
                $descuento = FormatearValor(substr($buffer, 98, 13), substr($buffer, 111, 1));
                $total = FormatearValor(substr($buffer, 115, 13), substr($buffer, 128, 1));
                $motivo = trim(substr($buffer, 62, 2));

                $insertar = true;
            }

            if(empty(substr($buffer, 1, 40)) && (substr($buffer, 79, 2) == "KG")){
                $totales = false;

                $cantidad = FormatearValor(substr($buffer, 65, 12), substr($buffer, 77, 1));
                $unidadMedida  = trim(substr($buffer, 79, 3));
                $cantidadEmpaque = 0;
                $precio = 0;
                $iva = 0;
                $descuento = 0;
                $total = 0;
                $insertar = true;
            }

            if(empty(substr($buffer, 1, 40)) && (substr($buffer, 79, 2) == "UN")){
                $totales = false;

                $codigo = "";
                $descripcion = "";

                $cantidad = FormatearValor(substr($buffer, 65, 12), substr($buffer, 77, 1));
                $unidadMedida = trim(substr($buffer, 79, 3));
                $cantidadEmpaque = 0;
                $precio = 0;
                $iva = 0;
                $descuenta = 0;
                $total = 0;
                $insertar = true;
            }

            if(substr($buffer, 0, 16) == "| Valor Letras :"){
                $totales = false;

                $codigo = "";
                $descripcion = "";

                $bruto = 0;
                $descuento = 0;
                $impuestos = 0;
                $retencion = 0;
                $total = 0;

                $letras = trim(substr($buffer, 17, 119));

                $cantidad = 0;
                $precio = 0;
                $iva = 0;
                $descuento = 0;
                $total = 0;
                $insertar = true;
            }

            if(substr($buffer, 0, 14) == "| Observacion:"){
                $totales = false;

                $codigo = "";
                $descripcion = "";

                $bruto = 0;
                $descuento = 0;
                $impuestos = 0;
                $retencion = 0;
                $total = 0;

                $numeroPlanilla = trim(substr($buffer, 17, 7));

                $cantidad = 0;
                $precio = 0;
                $iva = 0;
                $descuento = 0;
                $total = 0;
                $insertar = true;
            }

        }

        $numeroFactura = "167AD-" . $documento . "-" . date("y");
        $cop = TblCentDist::whereRaw('cop LIKE "' .$cop. '%"')->first();
        $empresa = TblEmpresa::first();

        $planilla = DB::connection('sqlsrv')
                ->table('CONTDIST')
                ->where('CONTDIST.NRODCTO', $numeroPlanilla)
                ->where('CONTDIST.TIPODCTO ', 'PC')
                // ->where('CONTDIST.ESTADO', '!=', '1')
                ->first();

        // dd($numeroPlanilla, $planilla);

        $cargue = DB::connection('sqlsrv')
                ->table('DCTO')
                ->selectRaw('MVDCTO.CODLOTE, MVDCTO.CODIGO, MVDCTO.NOMBRE, MVDCTO.UNDBASE, SUM(MVDCTO.CANTIDAD) CANTIDAD, SUM(MVDCTO.CANTEMPAQ) CANTEMPAQ, LOTES.FECPROD, LOTES.FECPROD + PRODUCT.DIASVENC FECVENCE')
                ->join('MVDCTO', function ($join) {
                    $join->on('DCTO.ORIGEN', '=', 'MVDCTO.ORIGEN')
                          ->on('DCTO.NRODCTO', '=', 'MVDCTO.NRODCTO');
                })
                ->join('LOTES', 'LOTES.CODLOTE', '=', 'MVDCTO.CODLOTE')
                ->join('PRODUCT', 'PRODUCT.CODIGO', '=', 'MVDCTO.CODIGO')
                ->where('DCTO.ORIGEN', 'INV')
                ->where('MVDCTO.PRODUCTO ', 1)
                ->where(function ($query) use ($planilla){
                    $query->where('DCTO.DCTOPRV', trim($planilla->NRODCTO))
                          ->orWhere('DCTO.FACTURAPRV ', trim($planilla->NRODCTO));
                })
                ->groupBy('MVDCTO.CODLOTE', 'MVDCTO.CODIGO', 'MVDCTO.NOMBRE', 'MVDCTO.UNDBASE', 'LOTES.FECPROD', 'PRODUCT.DIASVENC')
                ->get();

        // dd($cargue, $planilla);

        $guia = new MvGuiaTransporte();

        $guia->PLACA = "";
        $guia->DIRCLIENTE = $direccion;
        $guia->CIUDAD = $ciudad;
        $guia->PLACA = $planilla->PLACA;
        $guia->CONDUC = $planilla->CONDUC;
        $guia->NOMCOND = $planilla->NOMCOND;
        $guia->NITTRASP = $planilla->NITTRASP;
        $guia->NOMEMPRESA = $planilla->NOMEMPRESA;
        $guia->OBSERVAC = $planilla->OBSERVAC1;


        $qrCode = new QrCode();

        $qrCode->setText('PLACA: ' . trim($guia->PLACA) . ' - CLIENTE: ' . preg_replace("/[^A-Za-z0-9 ]/", '',iconv('UTF-8', 'ASCII//TRANSLIT', trim($guia->NOMCLIENTE))) . ' - NIT: ' . trim($guia->NIT) . ' - DOCUMENTO:' . trim($guia->DCTO) . ' - FECHA:' . Carbon::parse($guia->FECHASAL)->format('d/m/Y'))
            ->setSize(70)
            ->setPadding(0)
            ->setErrorCorrection('high')
            ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
            ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
            ->setImageType(QrCode::IMAGE_TYPE_PNG);

        $hoy = Carbon::now();

        return view('guias.pdf')->with(compact(
            'numeroFactura', 'cop', 'empresa', 'cargue', 'planilla', 'qrCode', 'hoy', 'guia'
        ));

        $factura = (isset($_GET['factura']) ? $_GET['factura'] : null);
        $placa = (isset($_GET['placa']) ? $_GET['placa'] : null);
        $fecha = (isset($_GET['fecha']) ? Carbon::parse($_GET['fecha']) : null);


    }

    public function search() {
        $factura = (isset($_GET['factura']) ? $_GET['factura'] : null);
        $placa = (isset($_GET['placa']) ? $_GET['placa'] : null);
        $fecha = (isset($_GET['fecha']) ? Carbon::parse($_GET['fecha']) : null);
        $hoy = Carbon::now();

        if (!$factura && !$placa && !$fecha) {
            return view('guias.show')->with(compact(
                'factura',
                'placa',
                'fecha'
            ));
        } else {
            if ($factura) {
                $explodeFactura = explode('F', mb_strtoupper($factura));
                if (count($explodeFactura) == 2) {
                    $cop = $explodeFactura[0];
                    $dcto = $explodeFactura[1];
                    $guia = MvGuiaTransporte::select('TIPODCTO', 'NRODCTO', 'COP', 'TDCTO', 'DCTO', 'NIT', 'NOMCLIENTE', 'DIRCLIENTE', 'PLACA', 'FECHASAL', 'CONDUC', 'NOMCOND', 'NITTRASP', 'NOMEMPRESA', 'DESTINO', 'FECHAENT')
                        ->where('COP', $cop)
                        ->where('DCTO', $dcto)
                        ->distinct()
                        ->first();
                    if ($guia) {
                        return redirect(route('guias.pdf', ['factura' => $factura]));
                    } else {
                        $errorFactura = 'La factura no se encuentra en el sistema';
                        return view('guias.show')->with(compact(
                            'factura',
                            'placa',
                            'fecha',
                            'errorFactura'
                        ));
                    }
                } else {
                    if (!$placa && !$fecha)
                        dd('F');
                }
            }

            if ($placa && $fecha) {
                $guias = MvGuiaTransporte::select('TIPODCTO', 'NRODCTO', 'COP', 'TDCTO', 'DCTO', 'NIT', 'NOMCLIENTE', 'DIRCLIENTE', 'PLACA', 'FECHASAL', 'CONDUC', 'NOMCOND', 'NITTRASP', 'NOMEMPRESA', 'DESTINO', 'FECHAENT')
                    ->where('PLACA', $placa)
                    ->whereDate('FECHASAL', $fecha->toDateTimeString())
                    ->distinct()
                    ->get();
                if ($guias->count()) {
                    return view('guias.index')->with(compact(
                        'guias',
                        'placa',
                        'fecha'
                    ));
                    // dd($guias, $fecha->toDateTimeString());
                } else {
                    $errorPlaca = 'No se encuentraron facturas con los datos ingresados';
                    return view('guias.show')->with(compact(
                        'factura',
                        'placa',
                        'fecha',
                        'errorPlaca'
                    ));
                }
            } else {
                dd('F');
            }

        }
    }

    public function pdf($factura) {
        setlocale(LC_ALL, 'en_US.UTF8');
        $hoy = Carbon::now();
        $explodeFactura = explode('F', mb_strtoupper($factura));
        if (count($explodeFactura) == 2) {
            $cop = $explodeFactura[0];
            $dcto = $explodeFactura[1];
            $guia = MvGuiaTransporte::select('TIPODCTO', 'NRODCTO', 'COP', 'TDCTO', 'DCTO', 'NIT', 'NOMCLIENTE', 'DIRCLIENTE', 'PLACA', 'FECHASAL', 'CONDUC', 'NOMCOND', 'NITTRASP', 'NOMEMPRESA', 'DESTINO', 'FECHAENT')
                ->where('COP', $cop)
                ->where('DCTO', $dcto)
                ->distinct()
                ->firstOrFail();
            $guia->ITEMS = MvGuiaTransporte::select('CODIGO', 'NOMBRE', 'CANTIDAD', 'CANTEMPAQ', 'CODLOTE', 'FECPROD', 'FECVENCE', 'NOTA')
                ->where('COP', $cop)
                ->where('DCTO', $dcto)
                ->orderBy('CODIGO')
                ->get();
            $cop = TblCentDist::whereRaw('cop LIKE "' .$guia->COP. '%"')->first();
            $empresa = TblEmpresa::first();
            $qrCode = new QrCode();
            $qrCode->setText('PLACA: ' . trim($guia->PLACA) . ' - CLIENTE: ' . preg_replace("/[^A-Za-z0-9 ]/", '',iconv('UTF-8', 'ASCII//TRANSLIT', trim($guia->NOMCLIENTE))) . ' - NIT: ' . trim($guia->NIT) . ' - DOCUMENTO:' . trim($guia->DCTO) . ' - FECHA:' . Carbon::parse($guia->FECHASAL)->format('d/m/Y'))
                ->setSize(70)
                ->setPadding(0)
                ->setErrorCorrection('high')
                ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
                ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
                ->setImageType(QrCode::IMAGE_TYPE_PNG);

            // return view('guias.pdf')->with(compact('factura', 'guia', 'cop', 'hoy', 'empresa', 'qrCode'));

            $pdf = PDF::loadView('guias.pdf', compact(
                'factura',
                'guia',
                'cop',
                'empresa',
                'qrCode',
                'hoy'
            ));
            return $pdf->setpaper('LETTER')->stream('Factura N° ' . mb_strtoupper($factura) . '.pdf');
        } else {
            abort(404);
        }
    }
}
