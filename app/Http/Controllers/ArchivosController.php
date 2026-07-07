<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArchivosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.check');
    }

    public function __invoke($ruta)
    {
        if (!Storage::disk('private')->exists($ruta)) {
            abort(404);
        }

        $local_path = config('filesystems.disks.private.root') . DIRECTORY_SEPARATOR . $ruta;
        return response()->file($local_path);
    }
}
