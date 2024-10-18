<?php

namespace App\Http\Controllers;

use App\Models\EntregaTarea;
use App\Models\Leccion;
use App\Models\Recurso;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class RecursoEstudianteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web_estudiante');
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
            ->where('tipo','TAREA')
            ->orderBy('nombreLeccion')
            ->get();

        return view('estudiante.recurso_estudiante.index', compact("grupo", "nroModulo", "lecciones"));
    }

    public function entrega_tarea($id){
        $recurso = Recurso::findOrfail($id);
        $leccion = Leccion::findOrfail($recurso->idLeccion);
        $grupo = DB::table('grupos as g')->join('cursos as c', 'g.idCurso', 'c.idCurso')
            ->join('docentes as d', 'g.idDocente', 'd.idDocente')
            ->where('idGrupo', $leccion->idGrupo)
            ->first();

        return view('estudiante.recurso_estudiante.entrega_tarea', compact("recurso", "leccion", "grupo"));
    }

    public function store(Request $request)
    {
        $mytime = Carbon::now('America/Lima');
        $fechaHora = $mytime->toDateTimeString();
        
        $entregaTarea = new EntregaTarea();
        $entregaTarea->fechaEntrega = $fechaHora;
        $entregaTarea->comentarioEstudiante = $request->get('comentarioEstudiante');
        if ($request->hasFile('archivoEntega')) {
            $file = $request->file('archivoEntega');
            $rules = [
                'archivoEntega' => 'required|mimes:pdf,doc,docx|max:2048', // Ejemplo: PDF, Word, tamaño máximo de 2MB
            ];
            $this->validate($request, $rules);
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('entrega_tareas'), $fileName);

            $entregaTarea->archivoEntega = $fileName;
        }
        $entregaTarea->idRecurso = $request->get('idRecurso');
        $entregaTarea->idEstudiante = auth()->user()->idEstudiante;
        $entregaTarea->save();


        $leccion = DB::table('recursos as r')->join('lecciones as l', 'r.idLeccion', 'l.idLeccion')
        ->where('idRecurso', $entregaTarea->idRecurso)
        ->first();
        return Redirect::to("estudiante/recurso_estudiante?grupo=$leccion->idGrupo&nroModulo=$leccion->nroModulo")
            ->with(['success' => "¡Satisfactorio!, Tarea entregada."]);
    }

    public function corregir_tarea ($id){
        $entregaTarea = EntregaTarea::findOrfail($id);
        $recurso = Recurso::findOrfail($entregaTarea->idRecurso);
        $leccion = Leccion::findOrfail($recurso->idLeccion);
        $grupo = DB::table('grupos as g')->join('cursos as c', 'g.idCurso', 'c.idCurso')
            ->join('docentes as d', 'g.idDocente', 'd.idDocente')
            ->where('idGrupo', $leccion->idGrupo)
            ->first();
        return view('estudiante.recurso_estudiante.corregir_tarea', compact("recurso", "leccion", "grupo", "entregaTarea"));
    }

    public function update(Request $request, $id){
        $mytime = Carbon::now('America/Lima');
        $fechaHora = $mytime->toDateTimeString();

        $entregaTarea = EntregaTarea::findOrfail($id);
        $entregaTarea->fechaEntrega = $fechaHora;
        $entregaTarea->comentarioEstudiante = $request->get('comentarioEstudiante');
        if ($request->hasFile('archivoEntega')) {
            $file = $request->file('archivoEntega');
            $rules = [
                'archivoEntega' => 'required|mimes:pdf,doc,docx|max:2048', // Ejemplo: PDF, Word, tamaño máximo de 2MB
            ];
            $this->validate($request, $rules);
            if (!empty($entregaTarea->archivoEntega) && file_exists(public_path('entrega_tareas/' . $entregaTarea->archivoEntega))) {
                unlink(public_path('entrega_tareas/' . $entregaTarea->archivoEntega));
            }
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('entrega_tareas'), $fileName);

            $entregaTarea->archivoEntega = $fileName;
        }
        $entregaTarea->update();

        $leccion = DB::table('recursos as r')->join('lecciones as l', 'r.idLeccion', 'l.idLeccion')
            ->where('idRecurso', $entregaTarea->idRecurso)
            ->first();
        return Redirect::to("estudiante/recurso_estudiante?grupo=$leccion->idGrupo&nroModulo=$leccion->nroModulo")
            ->with(['success' => "¡Satisfactorio!, Tarea Modificada."]);
    }

    public static function isHoraActualEnRango($fechaDesde, $horaDesde, $fechaHasta, $horaHasta) {
        // Obtener la fecha y hora actual
        $fechaHoraActual = Carbon::now('America/Lima');
        
        // Crear objetos Carbon para las fechas y horas de inicio y fin
        $fechaHoraDesde = Carbon::parse("$fechaDesde $horaDesde");
        $fechaHoraHasta = Carbon::parse("$fechaHasta $horaHasta");
        
        // Verificar si la hora actual está dentro del rango
        return $fechaHoraActual->between($fechaHoraDesde, $fechaHoraHasta);
    }

    public static function verificarEntregaTarea($idRecurso){
        $registro = EntregaTarea::where('idRecurso', $idRecurso)
            ->where('idEstudiante', auth()->user()->idEstudiante)
            ->first();
        return isset($registro) ? $registro : false;
    }   
}
