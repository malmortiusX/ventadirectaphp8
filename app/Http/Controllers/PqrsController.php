<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TblCliente;
use App\Models\TblUsuario;
use Carbon\Carbon;
use Session;
class PqrsController extends Controller
{
    // Middleware que valida si el usuario está autenticado antes de acceder a cualquier método
    public function __construct()
    {
        $this->middleware('auth.check');
    }

    public function index() {

        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        $hoy = Carbon::now();

        return view('pqrs.index')->with(compact('hoy', 'usuario'));
    }

    public function create($cliente = null) {
        $usuario = TblUsuario::find(Session::get('user')->id_usuario);
        if ($cliente) {
            $cliente = TblCliente::find($cliente);
        }
        $categorias = DB::connection('pqrs')->table('mantis_category_table')->where('project_id', 4)->where('status', 0)->get();
        $opciones = DB::connection('pqrs')
            ->table('mantis_custom_field_project_table AS cfpt')
            ->join('mantis_custom_field_table AS cft', 'cfpt.field_id', 'cft.id')
            ->where('cfpt.project_id', 4)
            ->where('display_report', 1)
            ->orderBy('cfpt.sequence')
            ->get();
        foreach ($opciones as $opcion) {
            if ($opcion->type == 3) {
                $opcion->possible_values = explode(' | ', $opcion->possible_values);
            }
        }
        $prioridades = [
            ['id' => 10, 'text' => 'Ninguna' ],
            ['id' => 20, 'text' => 'Baja' ],
            ['id' => 30, 'text' => 'Normal' ],
            ['id' => 40, 'text' => 'Alta' ],
            ['id' => 50, 'text' => 'Urgente' ],
            ['id' => 60, 'text' => 'Inmediata' ],
        ];
        $types = ['text', 'number', '', 'select', 'email', '', '', '', 'date'];
        return view('pqrs.nuevo')->with(compact('categorias', 'opciones', 'usuario', 'prioridades', 'types', 'cliente'));
    }

    public function store(Request $request) {
        // dd($request);
        $configuracion = [];
        $now = Carbon::now()->timestamp;
        $bug_text_id = DB::connection('pqrs')->table('mantis_bug_text_table')->insertGetId(
            ['description' => $request->summary, 'steps_to_reproduce' => '', 'additional_information' => '']
        );
        $bug_id = DB::connection('pqrs')->table('mantis_bug_table')->insertGetId([
            'project_id' => 4,
            'reporter_id' => 1,
            'handler_id' => 0,
            'duplicate_id' => 0,
            'priority' => 1,
            'severity' => 50,
            'reproducibility' => 70,
            'status' => 10,
            'resolution' => 10,
            'projection' => 10,
            'eta' => 10,
            'bug_text_id' => $bug_text_id,
            'os' => '',
            'os_build' => '',
            'platform' => '',
            'version' => '',
            'fixed_in_version' => '',
            'build' => '',
            'profile_id' => 0,
            'view_state' => 50,
            'summary' => $request->summary,
            'sponsorship_total' => 0,
            'sticky' => 0,
            'target_version' => '',
            'category_id' => $request->category_id,
            'date_submitted' => $now,
            'due_date' => 1,
            'last_updated' => $now,
        ]);
        foreach($request->all() as $key => $item) {
            if (strpos($key, 'custom_field_') === 0) {
                $field = str_replace('custom_field_', '', $key);
                if ($field == 21 || $field == 29) {
                    array_push($configuracion, ['field_id' => $field, 'bug_id' => $bug_id, 'value' => Carbon::create($item)->timestamp]);
                } elseif (!$item) {
                    array_push($configuracion, ['field_id' => $field, 'bug_id' => $bug_id, 'value' => '']);
                } else {
                    array_push($configuracion, ['field_id' => $field, 'bug_id' => $bug_id, 'value' => $item]);
                }
            }
        }
        DB::connection('pqrs')->table('mantis_custom_field_string_table')->insert($configuracion);
        Session::put('pqrs', [$bug_id, $request->custom_field_6]);
        return redirect(route('pqrs.index'));
    }

    // Detallado de pqr
    public function show($id){

        $usuario = Session::get('user');

        $pqr = DB::connection('pqrs')
        ->table('mantis_bug_table AS bt')
        ->where('bt.id', $id)
        ->orderBy('bt.date_submitted', 'desc')
        ->first();

        $pqrCampos = DB::connection('pqrs')
        ->table('mantis_custom_field_string_table AS cfst')
        ->join('mantis_custom_field_table AS cft', 'cfst.field_id', 'cft.id')
        ->where('cfst.bug_id', $id)
        ->orderBy('cfst.field_id', 'desc')
        ->get();

        $pqrAdjuntos = DB::connection('pqrs')
        ->table('mantis_bug_file_table')
        ->where('bug_id', $id)
        ->get();

        $pqrDescripcion = DB::connection('pqrs')
        ->table('mantis_bug_text_table')
        ->where('id', $pqr->bug_text_id)
        ->first();

        // dd($pqrDescripcion);
        return view('pqrs.ver')->with(compact('pqr', 'pqrCampos', 'pqrAdjuntos', 'pqrDescripcion', 'usuario'));

    }
}
