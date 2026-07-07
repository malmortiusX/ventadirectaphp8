<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\TblSondeo;

class ArchivosExternosController extends Controller
{
    public function __invoke($ruta)
    {
        if (!Storage::disk('private')->exists($ruta)) {
            abort(404);
        }

        $token = md5(sha1('Dt7efDSzWQdvuT1NVvGP50VNDEALHPnHRap20lFg8dLVvvO75385YHFZibGw;' . date('Ymd')));
        // return date('Ymd')." - ".$token ;
        if (isset($_GET['token']) && $_GET['token'] == $token) {
            $local_path = config('filesystems.disks.private.root') . DIRECTORY_SEPARATOR . $ruta;
            return response()->file($local_path);
        } else {
            abort(403);
        }

    }
}
