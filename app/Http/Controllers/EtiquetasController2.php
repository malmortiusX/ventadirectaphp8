<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class EtiquetasController2 extends Controller
{
    public function gs1128() {
        $token = $_GET['token'];
        $descripcion = $_GET['descripcion'];
        $referencia = $_GET['referencia'];
        $unidades = $_GET['unidades'];
        $lote = $_GET['lote'];
        $peso = $_GET['peso'];
        $f_venc = $_GET['f_venc'];
        $ean14 = $_GET['ean14'];

        //if ($token == md5('123456')) {
        if ($token == '123456') {
            $peso_c = explode(".", $peso);
            if (strlen($peso_c[0]) > 4) {
                abort(404);
            }
            if (strlen($peso_c[1]) > 2) {
                $peso_c[1] = substr($peso_c[1], 0, 2);
            }
            $f_venc = date_create_from_format('d/m/Y', $f_venc);

            // $cadena = '02' . $ean14 . '3102' . str_pad($peso_c[0], 4, '0', STR_PAD_LEFT) . str_pad($peso_c[1], 2, '0', STR_PAD_RIGHT) . '37'. $unidades . chr(29) . '17' . $f_venc->format('ymd');

            $cadena = '02' . $ean14 . '37'. $unidades . chr(29) . '3102' . str_pad($peso_c[0], 4, '0', STR_PAD_LEFT) . str_pad($peso_c[1], 2, '0', STR_PAD_RIGHT) . '17' . $f_venc->format('ymd') . '10' . $lote;


            $barcode = new BarcodeGenerator();
            $barcode->setText($cadena);
            $barcode->setType(BarcodeGenerator::Gs1128);
            $barcode->setNoLengthLimit(true);
            $barcode->setAllowsUnknownIdentifier(true);
            $barcode->setFontSize(9);
            $barcode->setScale(1);
            $code = $barcode->generate();
            return view('etiquetas2.gs1128')->with(compact('cadena', 'descripcion', 'referencia', 'unidades', 'lote', 'peso', 'f_venc', 'ean14', 'barcode'));
        } else {
            abort(403);
        }
    }

    public function ean14() {
        $token = $_GET['token'];
        $referencia = $_GET['referencia'];
        $descripcion = $_GET['descripcion'];
        $prefijo = $_GET['prefijo'];
        $peso = $_GET['peso'];

        //if ($token == md5('123456')) {
        if ($token == '123456') {
            $peso_c = explode(".", $peso);
            if (strlen($peso_c[0]) > 2) {
                abort(404);
            }
            if (strlen($peso_c[1]) > 3) {
                $peso_c[1] = substr($peso_c[1], 0, 3);
            }

            $cadenaValidar = $prefijo . str_pad($peso_c[0], 2, '0', STR_PAD_LEFT) . str_pad($peso_c[1], 3, '0', STR_PAD_RIGHT);
            $sumatoria = 0;
            $digitoVerificacion = 0;

            for ($i = strlen($cadenaValidar); $i > 0; $i--) {
                $caracter = substr($cadenaValidar, $i-1, 1);
                if($i % 2 == 0) {
                    $sumatoria = $sumatoria + ($caracter * 1);
                } else {
                    $sumatoria = $sumatoria + ($caracter * 3);
                }
            }

            if($sumatoria % 10 == 0) {
                $digitoVerificacion = 0;
            } else {
                $digitoVerificacion = 10 - ($sumatoria % 10);
            }

            $cadena = '01' . $cadenaValidar . $digitoVerificacion;

            $barcode = new BarcodeGenerator();
            $barcode->setText($cadena);
            $barcode->setType(BarcodeGenerator::Gs1128);
            $barcode->setScale(2);
            return view('etiquetas.ean14')->with(compact('cadena', 'descripcion', 'referencia', 'peso', 'prefijo', 'barcode'));
        } else {
            abort(403);
        }
    }
}
