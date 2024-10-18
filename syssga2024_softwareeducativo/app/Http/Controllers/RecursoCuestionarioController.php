<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\Leccion;
use App\Models\Cuestionario;
use App\Models\EstudianteCuestionario;
use App\Models\EstudianteRespCuestionario;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class RecursoCuestionarioController extends Controller
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
            ->where('tipo', 'EXAMEN')
            ->orderBy('nombreLeccion')
            ->get();

        return view('docente.recurso_docente.cuestionario', compact("grupo", "nroModulo", "lecciones"));
    }

    public static function listarRecursos($idLeccion)
    {
        $recursos = Cuestionario::where('idLeccion', $idLeccion)->get();
        return $recursos;
    }

    public function cuestionario_show($id)
    {
        $recurso = Cuestionario::findOrfail($id);
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

    public function store_leccion(Request $request)
    {
        try {
            //code...
            $leccion = new Leccion();
            $leccion->nombreLeccion = $request->get('nombreLeccion');
            $leccion->nroModulo = $request->get('nroModulo');
            $leccion->idGrupo = $request->get('idGrupo');
            $leccion->tipo = 'EXAMEN';
            $leccion->save();
            return redirect()->back()->with('success', "¡Satisfactorio¡, Lección $leccion->nombreLeccion agregada.");
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function create_cuestionario($id)
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
        return view('docente.recurso_docente.cuestionario_create', compact("leccion", "grupo", "nroModulo", "fecha", "hora"));
    }
    public function store_cuestionario(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:250',
            'tipo' => 'required|string|max:80',
            'restringir_fecha'=>'required|boolean',
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
            'timeDisponible'=>'required|integer',
            'intentoDisponible'=>'required|integer',
            'preguntaPagina'=>'required|integer',
            'revisarPreguntas'=>'required|boolean',
            'verResultados'=>'required|boolean',
            'preguntasAleatoria'=>'required|boolean',
            'idLeccion' => 'required|integer',
        ]);
        $leccion=Leccion::findorFail($request->idLeccion);
        if($request->tipo=='EXAMEN FINAL'){
            $v=Leccion::join('cuestionarios','cuestionarios.idLeccion','=','lecciones.idLeccion')->where('lecciones.idGrupo',$leccion->idGrupo)->where('lecciones.tipo','EXAMEN')->where('cuestionarios.tipo','EXAMEN FINAL')->first();
            $mes='Ya existe un Examen Final en este curso';
        }else if($request->tipo=='EXAMEN RECUPERACION'){
            $v=Leccion::join('cuestionarios','cuestionarios.idLeccion','=','lecciones.idLeccion')->where('lecciones.idGrupo',$leccion->idGrupo)->where('lecciones.tipo','EXAMEN')->where('cuestionarios.tipo','EXAMEN RECUPERACION')->first();
            $mes='Ya existe un Examen de Recuperación en este curso';
        }
        
       //dump(strlen($v)) ;
        if(strlen($v)>0){
            return redirect()->back()->with(['error' => $mes]);
        }else{
            $tarea = new Cuestionario();
            $tarea->titulo = $request->get('titulo');
            $tarea->descripcion = $request->get('descripcion');
            $tarea->fechaInicio = $request->get('fechaInicio');
            $tarea->horaInicio = $request->get('horaInicio');
            $tarea->fechaFin = $request->get('fechaFin');
            $tarea->horaFin = $request->get('horaFin');
            $tarea->tipo = $request->get('tipo');
            $tarea->restringir_fecha = $request->get('restringir_fecha');
            $tarea->timeDisponible = $request->get('timeDisponible');
            $tarea->intentoDisponible = $request->get('intentoDisponible');
            $tarea->preguntaPagina = $request->get('preguntaPagina');
            $tarea->revisarPreguntas = $request->get('revisarPreguntas');
            $tarea->verResultados = $request->get('verResultados');
            $tarea->preguntasAleatoria = $request->get('preguntasAleatoria');
            $tarea->idLeccion = $request->get('idLeccion');
            $tarea->save();
            $idCuestionario=$tarea->idCuestionario;
            return redirect()->route('crear_cuestionario', ['id' => $idCuestionario]);
        }

        //dump($request->get('preguntasAleatoria'));
        

    }

    public function crear_cuestionario($id)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $hora = date('H:i', strtotime($mytime->toDateTimeString()));
        $cuestionario = Cuestionario::findOrfail($id);
        $leccion = Leccion::findOrfail($cuestionario->idLeccion);
        $grupo = DB::table('grupos as g')->join('cursos as c', 'g.idCurso', 'c.idCurso')
            ->join('docentes as d', 'g.idDocente', 'd.idDocente')
            ->where('idGrupo', $leccion->idGrupo)
            ->first();
        $nroModulo = $leccion->nroModulo;
        $respuesta=EstudianteCuestionario::where('idCuestionario',$id)
                    ->join('estudiantes as es', 'estudiante_cuestionarios.idEstudiante', 'es.idEstudiante')
                    ->get();
        //dump($respuestas);
        return view('docente.recurso_docente.cuestionario_crear', compact("cuestionario","leccion", "grupo", "nroModulo","respuesta"));
    }

    public function cuestionario_destroy($id)
    {
        DB::beginTransaction(); // Iniciar la transacción

        try {
            $recurso = Cuestionario::findOrFail($id);

            $recurso->delete();

            DB::commit(); // Confirmar la transacción en caso de éxito

            return redirect()->back()->with(['success' => "¡Satisfactorio!, Examen: $recurso->titulo eliminado."]);
            // Si deseas redireccionar o devolver una respuesta en caso de éxito, puedes hacerlo aquí.
        } catch (\Exception $e) {
            DB::rollback(); // Revertir la transacción en caso de error
            return redirect()->back()->with(['error' => "¡Error!, " . $e->getMessage()]);
            // Si deseas manejar el error de alguna manera, puedes hacerlo aquí.
        }
    }

    public function store_preguntas(Request $request){
        $request->validate([
            'preguntaEnunciadoTD' => 'required|string',
            'puntajeTD'=>'required|integer',
            'tipoPreg' => 'required|string',
            'idCuestionario'=>'required|integer',
        ]);
        $idCuestionario=$request->get('idCuestionario');
        $pregunta = new Pregunta();
        $pregunta->preguntaEnunciadoTD = $request->get('preguntaEnunciadoTD');
        $pregunta->puntajeTD = $request->get('puntajeTD');
        $pregunta->tipoPreg = $request->get('tipoPreg');
        $pregunta->idCuestionario = $request->get('idCuestionario');
        $pregunta->save();
        $idPregunta=$pregunta->idPregunta;
        $respuestaTD=$request->get('respuestaTD');
        $opcionRespTD= $request->get('opcionRespTD');
        foreach($request->get('enumerarTD') as $key =>$r){
            
            $op=$opcionRespTD[$key];
            $en=$r;
            if(isset($respuestaTD[$key])){
                $res=$respuestaTD[$key];
            }

            $respuesta=new Respuesta();
            $respuesta->enumerarTD=$en;
            $respuesta->opcionRespTD=$op;
            $respuesta->idPregunta =$idPregunta;
            $respuesta->save();
           
        }
        foreach($request->get('respuestaTD') as $b){
            $res=Respuesta::where('idPregunta',$idPregunta)->where('enumerarTD',$b)->first();
            //dump($res['idRespuesta']);
            if($res){
                $v=1;
                $rr=Respuesta::findOrfail($res['idRespuesta']);
                $rr->respuestaTD=$v;
                $rr->update();
            }
            
            
        }
        return redirect()->route('crear_cuestionario', ['id' => $idCuestionario])->with('success', "¡Satisfactorio¡, Pregunta agregada.");
        //return redirect()->back()->with('success', "¡Satisfactorio¡, Pregunta agregada.");
        

    }
    public static function listarPreguntas($idCuestionario)
    {
        $preguntas = Pregunta::where('idCuestionario', $idCuestionario)->get();
        return $preguntas;
    }

    public function destroy_pregunta($id)
    {
        DB::beginTransaction(); // Iniciar la transacción

        try {
            $recurso = Pregunta::findOrFail($id);
            $idCuestionario=$recurso->idCuestionario;
            $recurso->delete();

            DB::commit(); // Confirmar la transacción en caso de éxito
            return redirect()->route('crear_cuestionario', ['id' => $idCuestionario])->with('success', "¡Satisfactorio¡, Pregunta eliminada.");
            //return redirect()->back()->with(['success' => "¡Satisfactorio!, Pregunta eliminada."]);
            // Si deseas redireccionar o devolver una respuesta en caso de éxito, puedes hacerlo aquí.
        } catch (\Exception $e) {
            DB::rollback(); // Revertir la transacción en caso de error
            return redirect()->back()->with(['error' => "¡Error!, " . $e->getMessage()]);
            // Si deseas manejar el error de alguna manera, puedes hacerlo aquí.
        }
    }

    public function editar_pregunta($id)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $hora = date('H:i', strtotime($mytime->toDateTimeString()));


        $pregunta = Pregunta::findOrfail($id);
        $respuesta = Respuesta::where('idPregunta',$id)->get();
        $cuestionario=Cuestionario::findOrfail($pregunta->idCuestionario);
       

        return view('docente.recurso_docente.pregunta_edit', compact("pregunta", "respuesta","cuestionario"));
    }

    public function update_preguntas(Request $request){
        $request->validate([
            'preguntaEnunciadoTD' => 'required|string',
            'puntajeTD'=>'required|integer',
            'tipoPreg' => 'required|string',
            'idCuestionario'=>'required|integer',
        ]);
        $idCuestionario=$request->idCuestionario;
        $pregunta = Pregunta::findOrfail($request->idPregunta);
        $pregunta->preguntaEnunciadoTD = $request->get('preguntaEnunciadoTD');
        $pregunta->puntajeTD = $request->get('puntajeTD');
        $pregunta->update();
        $modulos = Respuesta::where('idPregunta', $request->idPregunta)->delete();
        $idPregunta=$request->idPregunta;
        $respuestaTD=$request->get('respuestaTD');
        $opcionRespTD= $request->get('opcionRespTD');
       /* dump($request->enumerarTD);
        dump($opcionRespTD);
        dump($respuestaTD);*/
        foreach($request->get('enumerarTD') as $key =>$r){
            
            $op=$opcionRespTD[$key];
            $en=$r;
            if(isset($respuestaTD[$key])){
                $res=$respuestaTD[$key];
            }

            $respuesta=new Respuesta();
            $respuesta->enumerarTD=$en;
            $respuesta->opcionRespTD=$op;
            $respuesta->idPregunta =$idPregunta;
            $respuesta->save();
           
        }
        foreach($request->get('respuestaTD') as $b){
            $res=Respuesta::where('idPregunta',$idPregunta)->where('enumerarTD',$b)->first();
            //dump($res['idRespuesta']);
            if($res){
                $v=1;
                $rr=Respuesta::findOrfail($res['idRespuesta']);
                $rr->respuestaTD=$v;
                $rr->update();
            }
            
            
        }
        return redirect()->route('crear_cuestionario', ['id' => $idCuestionario])->with('success', "¡Satisfactorio¡, Pregunta modificada.");
        

    }
    public static function listarRespuestas($idPregunta)
    {
        $respuestas = Respuesta::where('idPregunta', $idPregunta)->get();
        return $respuestas;
    }

    public static function listarRespuestasEst($idCuestionario)
    {
        $respuestasCues = EstudianteCuestionario::where('idCuestionario', $idCuestionario)->get();
        return $respuestasCues;
    }


    public function edit($id)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $hora = date('H:i', strtotime($mytime->toDateTimeString()));


        $cuestionario = Cuestionario::findOrfail($id);
        $leccion = Leccion::findOrfail($cuestionario->idLeccion);
        $grupo = DB::table('grupos as g')->join('cursos as c', 'g.idCurso', 'c.idCurso')
            ->join('docentes as d', 'g.idDocente', 'd.idDocente')
            ->where('idGrupo', $leccion->idGrupo)
            ->first();
        $nroModulo = $leccion->nroModulo;
        return view('docente.recurso_docente.cuestionario_edit', compact("cuestionario", "leccion", "grupo","nroModulo"));
    }

    public function update_cuestionario(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:250',
            'tipo' => 'required|string|max:80',
            'restringir_fecha'=>'required|boolean',
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
            'timeDisponible'=>'required|integer',
            'intentoDisponible'=>'required|integer',
            'preguntaPagina'=>'required|integer',
            'revisarPreguntas'=>'required|boolean',
            'verResultados'=>'required|boolean',
            'preguntasAleatoria'=>'required|boolean',
            'idLeccion' => 'required|integer',
            'idCuestionario' => 'required|integer',
        ]);

        //dump($request->get('preguntasAleatoria'));
        $idCuestionario=$request->idCuestionario;
        $tarea = Cuestionario::findOrfail($idCuestionario);
        $tarea->titulo = $request->get('titulo');
        $tarea->descripcion = $request->get('descripcion');
        $tarea->fechaInicio = $request->get('fechaInicio');
        $tarea->horaInicio = $request->get('horaInicio');
        $tarea->fechaFin = $request->get('fechaFin');
        $tarea->horaFin = $request->get('horaFin');
        $tarea->tipo = $request->get('tipo');
        $tarea->restringir_fecha = $request->get('restringir_fecha');
        $tarea->timeDisponible = $request->get('timeDisponible');
        $tarea->intentoDisponible = $request->get('intentoDisponible');
        $tarea->preguntaPagina = $request->get('preguntaPagina');
        $tarea->revisarPreguntas = $request->get('revisarPreguntas');
        $tarea->verResultados = $request->get('verResultados');
        $tarea->preguntasAleatoria = $request->get('preguntasAleatoria');
        $tarea->idLeccion = $request->get('idLeccion');
        $tarea->update();
        
        return redirect()->route('crear_cuestionario', ['id' => $idCuestionario]);

    }

    public function estudiantecuestionario_destroy($id)
    {
        DB::beginTransaction(); // Iniciar la transacción

        try {
            $resp=EstudianteRespCuestionario::where('idEstCuestionario',$id)->delete();
            $recurso = EstudianteCuestionario::findOrFail($id);
            $idCuestionario=$recurso->idCuestionario;
            $recurso->delete();

            DB::commit(); // Confirmar la transacción en caso de éxito
            return redirect()->route('crear_cuestionario', ['id' => $idCuestionario])->with('success', "¡Satisfactorio¡, Registro eliminado.");
            //return redirect()->back()->with(['success' => "¡Satisfactorio!, Registro eliminado."]);
            // Si deseas redireccionar o devolver una respuesta en caso de éxito, puedes hacerlo aquí.
        } catch (\Exception $e) {
            DB::rollback(); // Revertir la transacción en caso de error
            return redirect()->back()->with(['error' => "¡Error!, " . $e->getMessage()]);
            // Si deseas manejar el error de alguna manera, puedes hacerlo aquí.
        }
    }

    public function act_cuestionarioest(Request $request)
    {
        $request->validate([
            'nota'=>'required',
            'idEstCuestionario'=>'required|integer',
        ]);
        $idCuestionario=$request->idCuestionario;
        $est=EstudianteCuestionario::findOrfail($request->idEstCuestionario);
        $est->nota=$request->nota;
        $est->comentario=$request->comentario;
        $est->update();
        return redirect()->route('crear_cuestionario', ['id' => $idCuestionario])->with('success', "¡Satisfactorio¡, Operación completada.");

    }

    public function edit_leccion(Request $request){
        $request->validate([
            'nombreLeccion'=>'required|string',
            'idLeccion'=>'required|integer',
        ]);
        $l=Leccion::findOrfail($request->idLeccion);
        $l->nombreLeccion=$request->nombreLeccion;
        $l->update();
        return redirect()->back()->with('success', "¡Satisfactorio¡, Lección $l->nombreLeccion modificada.");
    }

    public function ver_cuestionario($id,$grupo,$nromodulo){
        $examen=Cuestionario::findOrfail($id);
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $fechaHora = $mytime->toDateTimeString();
        $hora = date('H:i', strtotime($mytime->toDateTimeString()));
        $nroModulo = $nromodulo;
        $fechaini = $fechaHora;
        if($examen->preguntasAleatoria==1){
            $preguntas = Pregunta::where('idCuestionario',$id)->orderby('idPregunta','desc')->get();
        }else{
            $preguntas = Pregunta::where('idCuestionario',$id)->get();
        }
        return view('docente.recurso_docente.cuestionario_ver', compact("examen", "grupo", "nroModulo", "fecha", "hora","fechaini","preguntas")); 
    }
   
}
