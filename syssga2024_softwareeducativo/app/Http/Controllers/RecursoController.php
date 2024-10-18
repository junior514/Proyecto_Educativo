<?php

namespace App\Http\Controllers;

use App\Models\EntregaTarea;
use App\Models\Leccion;
use App\Models\Recurso;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class RecursoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web_docente');
    }

    public function index(Request $request)
    {

        $idGrupo = $request->get('grupo');
        $nroModulo = $request->get('nroModulo');
        
        $grupo = DB::table('grupos as g')->join('cursos as c', 'g.idCurso', 'c.idCurso')
            ->join('docentes as d', 'g.idDocente', 'd.idDocente')
            ->where('idGrupo', $idGrupo)
            ->first();

        $lecciones = Leccion::where('nroModulo', $nroModulo)
            ->where('idGrupo', $idGrupo)
            ->where('tipo', 'TAREA')
            ->orderBy('nombreLeccion')
            ->get();

        return view('docente.recurso_docente.index', compact("grupo", "nroModulo", "lecciones"));
    }

    public function store_leccion(Request $request)
    {
        try {
            //code...
            $leccion = new Leccion();
            $leccion->nombreLeccion = $request->get('nombreLeccion');
            $leccion->nroModulo = $request->get('nroModulo');
            $leccion->idGrupo = $request->get('idGrupo');
            $leccion->save();
            return redirect()->back()->with('success', "¡Satisfactorio¡, Lección $leccion->nombreLeccion agregada.");
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function create_tarea($id)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $hora = date('H:i', strtotime($mytime->toDateTimeString()));
        $leccion = Leccion::findOrfail($id);
        $grupo = DB::table('grupos as g')->join('cursos as c', 'g.idCurso', 'c.idCurso')
            ->join('docentes as d', 'g.idDocente', 'd.idDocente')
            ->where('idGrupo', $leccion->idGrupo)
            ->first();
        $nroModulo = $leccion->nroModulo;
        return view('docente.recurso_docente.tarea_create', compact("leccion", "grupo", "nroModulo", "fecha", "hora"));
    }

    public function store(Request $request)
    {

        if ($request->get('tipo') == "TAREA") {
            $request->validate([
                'titulo' => 'required|string|max:91',
                'descripcion' => 'nullable|string|max:250',
                'fechaInicio' => 'nullable|date',
                'horaInicio' => 'nullable|date_format:H:i',
                'fechaFin' => [
                    'nullable',
                    'date',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value && !$request->horaFin) {
                            $fail('La hora de finalización es requerida si se proporciona una fecha de finalización.');
                        }
                    },
                    'after_or_equal:' . $request->fechaInicio,
                ],
                'horaFin' => [
                    'nullable',
                    'date_format:H:i',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value && !$request->fechaFin) {
                            $fail('La fecha de finalización es requerida si se proporciona una hora de finalización.');
                        }
                    },
                    'after:horaInicio',
                ],
                'tipo' => 'required|string|max:80',
                'idLeccion' => 'required|integer',
            ]);

            // Continúa con la creación del recurso
            // ...
            $tarea = new Recurso();
            $tarea->titulo = $request->get('titulo');
            $tarea->descripcion = $request->get('descripcion');
            $tarea->fechaInicio = $request->get('fechaInicio');
            $tarea->horaInicio = $request->get('horaInicio');
            $tarea->fechaFin = $request->get('fechaFin');
            $tarea->horaFin = $request->get('horaFin');
            $tarea->tipo = $request->get('tipo');
            $tarea->idLeccion = $request->get('idLeccion');
            if ($request->hasFile('archivo')) {
                $file = $request->file('archivo');
                $rules = [
                    'archivo' => 'required|mimes:pdf,doc,docx|max:2048', // Ejemplo: PDF, Word, tamaño máximo de 2MB
                ];
                $this->validate($request, $rules);
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('tareas'), $fileName);

                $tarea->archivo = $fileName;
            }
            $tarea->save();
        }
        $leccion = Leccion::findOrfail($request->get('idLeccion'));
        return Redirect::to("docente/recurso_docente?grupo=$leccion->idGrupo&nroModulo=$leccion->nroModulo")
            ->with(['success' => "¡Satisfactorio!, Tarea: $tarea->titulo agregado."]);
    }

    public function edit($id)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $hora = date('H:i', strtotime($mytime->toDateTimeString()));


        $recurso = Recurso::findOrfail($id);
        $leccion = Leccion::findOrfail($recurso->idLeccion);
        $grupo = DB::table('grupos as g')->join('cursos as c', 'g.idCurso', 'c.idCurso')
            ->join('docentes as d', 'g.idDocente', 'd.idDocente')
            ->where('idGrupo', $leccion->idGrupo)
            ->first();

        return view('docente.recurso_docente.tarea_edit', compact("recurso", "leccion", "grupo"));
    }

    public function update(Request $request, $id)
    {
        $recurso = Recurso::findOrfail($id);
        if ($recurso->tipo == "TAREA") {
            $request->validate([
                'titulo' => 'required|string|max:91',
                'descripcion' => 'nullable|string|max:250',
                'fechaInicio' => 'nullable|date',
                'horaInicio' => 'nullable|date_format:H:i',
                'fechaFin' => [
                    'nullable',
                    'date',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value && !$request->horaFin) {
                            $fail('La hora de finalización es requerida si se proporciona una fecha de finalización.');
                        }
                    },
                    'after_or_equal:' . $request->fechaInicio,
                ],
                'horaFin' => [
                    'nullable',
                    'date_format:H:i',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value && !$request->fechaFin) {
                            $fail('La fecha de finalización es requerida si se proporciona una hora de finalización.');
                        }
                    },
                    'after:horaInicio',
                ],

            ]);


            $recurso->titulo = $request->get('titulo');
            $recurso->descripcion = $request->get('descripcion');
            $recurso->fechaInicio = $request->get('fechaInicio');
            $recurso->horaInicio = $request->get('horaInicio');
            $recurso->fechaFin = $request->get('fechaFin');
            $recurso->horaFin = $request->get('horaFin');
            if ($request->hasFile('archivo')) {
                $file = $request->file('archivo');
                $rules = [
                    'archivo' => 'required|mimes:pdf,doc,docx|max:2048', // Ejemplo: PDF, Word, tamaño máximo de 2MB
                ];
                $this->validate($request, $rules);

                // Eliminar el archivo anterior si existe
                if (!empty($recurso->archivo) && file_exists(public_path('tareas/' . $recurso->archivo))) {
                    unlink(public_path('tareas/' . $recurso->archivo));
                }
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('tareas'), $fileName);

                $recurso->archivo = $fileName;
            }
            $recurso->update();
        }
        $leccion = Leccion::findOrfail($recurso->idLeccion);
        return Redirect::to("docente/recurso_docente?grupo=$leccion->idGrupo&nroModulo=$leccion->nroModulo")
            ->with(['success' => "¡Satisfactorio!, Tarea: $recurso->titulo modificado."]);
    }

    public function tarea_show($id)
    {
        $recurso = Recurso::findOrfail($id);
        $leccion = Leccion::findOrfail($recurso->idLeccion);
        $grupo = DB::table('grupos as g')->join('cursos as c', 'g.idCurso', 'c.idCurso')
            ->join('docentes as d', 'g.idDocente', 'd.idDocente')
            ->where('idGrupo', $leccion->idGrupo)
            ->first();

        $estudiantes = DB::table('modulos as m')
            ->join('grupos as g', 'm.idGrupo', 'g.idGrupo')
            ->join('matriculas as ma', 'm.idMatricula', 'ma.idMatricula')
            ->join('estudiantes as e', 'ma.idEstudiante', 'e.idEstudiante')
            ->where('m.idGrupo', $leccion->idGrupo)
            ->where('m.nroModulo', $leccion->nroModulo)
            ->get();

        $entregados = DB::table('entrega_tareas as e')
            ->join('estudiantes as es', 'e.idEstudiante', 'es.idEstudiante')
            ->where('idRecurso', $id)
            ->whereNull('fechaRevision')
            ->get();

        $evaluados = DB::table('entrega_tareas as e')
            ->join('estudiantes as es', 'e.idEstudiante', 'es.idEstudiante')
            ->where('idRecurso', $id)
            ->whereNotNull('fechaRevision')
            ->get();

        return view('docente.recurso_docente.tarea_show', compact("recurso", "leccion", "grupo", "entregados", "evaluados", "estudiantes"));
    }

    public function tarea_destroy($id)
    {
        DB::beginTransaction(); // Iniciar la transacción

        try {
            $recurso = Recurso::findOrFail($id);

            if (!empty($recurso->archivo) && file_exists(public_path('tareas/' . $recurso->archivo))) {
                unlink(public_path('tareas/' . $recurso->archivo));
            }

            $recurso->delete();

            DB::commit(); // Confirmar la transacción en caso de éxito

            return redirect()->back()->with(['success' => "¡Satisfactorio!, Tarea: $recurso->titulo eliminado."]);
            // Si deseas redireccionar o devolver una respuesta en caso de éxito, puedes hacerlo aquí.
        } catch (\Exception $e) {
            DB::rollback(); // Revertir la transacción en caso de error
            return redirect()->back()->with(['error' => "¡Error!, " . $e->getMessage()]);
            // Si deseas manejar el error de alguna manera, puedes hacerlo aquí.
        }
    }

    public function revisartarea_store (Request $request, $id){
        try {
            $mytime = Carbon::now('America/Lima');
            $fechaHora = $mytime->toDateTimeString();
            //code...
            $entregaTarea = EntregaTarea::findOrfail($id);
            $entregaTarea->fechaRevision = $fechaHora;
            $entregaTarea->nota = $request->get('nota');
            $entregaTarea->comentarioDocente = $request->get('comentarioDocente');
            $entregaTarea->update();
            return redirect()->back()->with('success', "¡Satisfactorio!, Tarea revisada.");
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function revisartarea_update (Request $request, $id){
        try {
            $mytime = Carbon::now('America/Lima');
            $fechaHora = $mytime->toDateTimeString();
            //code...
            $entregaTarea = EntregaTarea::findOrfail($id);
            $entregaTarea->fechaRevision = $fechaHora;
            $entregaTarea->nota = $request->get('nota');
            $entregaTarea->comentarioDocente = $request->get('comentarioDocente');
            $entregaTarea->update();
            return redirect()->back()->with('success', "¡Satisfactorio!, Revisión de tarea modificada.");
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function revisartarea_destroy ($id){
        try {
 
            //code...
            $entregaTarea = EntregaTarea::findOrfail($id);
            $entregaTarea->fechaRevision = null;
            $entregaTarea->nota = null;
            $entregaTarea->comentarioDocente = null;
            $entregaTarea->update();
            return redirect()->back()->with('success', "¡Satisfactorio!, Revisión eliminada.");
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    

    public static function listarRecursos($idLeccion)
    {
        $recursos = Recurso::where('idLeccion', $idLeccion)->where('tipo','TAREA')->get();
        return $recursos;
    }

    public static function verificarEntregaEst($idRecurso, $idEstudiante)
    {
        $registro = EntregaTarea::where('idRecurso', $idRecurso)
            ->where('idEstudiante', $idEstudiante)
            ->first();
        return isset($registro) ? $registro : false;
    }

    
}
