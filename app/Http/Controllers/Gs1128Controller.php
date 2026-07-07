<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class Gs1128Controller extends Controller
{
    public function __invoke() {
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
            $cadena = '02' . $ean14 . '3102' . str_pad($peso_c[0], 4, '0', STR_PAD_LEFT) . str_pad($peso_c[1], 2, '0', STR_PAD_RIGHT) . '37'. $unidades . chr(29) . '17' . $f_venc->format('ymd');
            
            $barcode = new BarcodeGenerator();
            $barcode->setText($cadena);
            $barcode->setType(BarcodeGenerator::Gs1128);
            $barcode->setNoLengthLimit(true);
            $barcode->setAllowsUnknownIdentifier(true);
            $barcode->setFontSize(9);
            $barcode->setScale(1);
            return view('etiquetas.gs1128')->with(compact('cadena', 'descripcion', 'referencia', 'unidades', 'lote', 'peso', 'f_venc', 'ean14', 'barcode'));
        } else {
            abort(403);
        }

    }
}
