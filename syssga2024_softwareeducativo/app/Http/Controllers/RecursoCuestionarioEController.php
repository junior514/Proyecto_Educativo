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

class RecursoCuestionarioEController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web_estudiante');
    }
    public function index(Request $request)
    {
        //dump($request->get('grupo'));
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $hora = date('H:i', strtotime($mytime->toDateTimeString()));
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

        return view('estudiante.recurso_estudiante.cuestionario', compact("grupo", "nroModulo", "lecciones","fecha","hora"));
    }

    public static function listarRecursos($idLeccion)
    {
        $recursos = Cuestionario::where('idLeccion', $idLeccion)->get();
        return $recursos;
    }
    public function ingresar_examen($id,$grupo,$nroModulo)
    {
        $examen=Cuestionario::findOrfail($id);
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $fechaHora = $mytime->toDateTimeString();
        $hora = date('H:i', strtotime($mytime->toDateTimeString()));
        $nroModulo = $nroModulo;
        $idEstudiante=auth()->user()->idEstudiante;
        if($examen->preguntasAleatoria==1){
            $preguntas = Pregunta::where('idCuestionario',$id)->orderby('idPregunta','desc')->get();
        }else{
            $preguntas = Pregunta::where('idCuestionario',$id)->get();
        }
        
        $t = EstudianteCuestionario::where('idEstudiante', $idEstudiante)->where('idCuestionario',$id)->first();
        if(strlen($t)>0){
            $idexamen = $t->idEstCuestionario;
            $fechaini = $t->fechaCreacion;
            $ff=$t->fechaCreacion;
            $df=$mytime->diffInMinutes($ff);
            $nota=$t->nota;
            if($df>=$examen->timeDisponible && $t->nota==''){
                $t->nota=0;
                $t->update();
                $nota=0;
            }
            
            //$nota=$t->nota;
            $comentario=$t->comentario;
        }else{
            $estudiantecuestionario=new EstudianteCuestionario();
            $estudiantecuestionario->idEstudiante = $idEstudiante;
            $estudiantecuestionario->idCuestionario = $id;
            $estudiantecuestionario->fechaCreacion=$fechaHora;
            $estudiantecuestionario->save();
            $idexamen = $estudiantecuestionario->idEstCuestionario;
            $fechaini = $fechaHora;
            $nota = $estudiantecuestionario->nota;
            $comentario='';
        }
      
        $resp=EstudianteRespCuestionario::where('idEstCuestionario',$idexamen)->get();
        
        return view('estudiante.recurso_estudiante.ingresar_examen', compact("examen", "nroModulo","fecha","hora","idexamen","fechaini","grupo","preguntas","resp","nota","comentario"));
    }

    public function guardar_cuestionario(Request $request){
        
        $idEstCuestionario=$request->idEstCuestionario;
        $idCuestionario = $request->idCuestionario;
        $grupo = $request->grupo;
        $nroModulo=$request->nroModulo;
        $ex=EstudianteCuestionario::findOrfail($idEstCuestionario);
        $resp = $request->except('idEstCuestionario','idCuestionario','_token','grupo','nroModulo');
        $puntaje=0;
        $mytime = Carbon::now('America/Lima');
        $fechaHora = $mytime->toDateTimeString();
        foreach($resp as $k=>$val){ 
            $preg=Pregunta::findOrfail($k);
            //$puntaje+=$preg->puntajeTD;
            $r = Respuesta::where('idPregunta',$k)->where('respuestaTD',1)->get();
            $cant=count($r);
            $correcto=0;
            foreach($val as $v){
                $new = new EstudianteRespCuestionario();
                $new->idEstCuestionario = $idEstCuestionario;
                $new->idPregunta=$k;
                $new->idRespuesta=$v;
                $new->save();
                $resp = Respuesta::findOrfail($v);
                if($resp->respuestaTD==1){
                    $correcto++;
                }
            }
            if($correcto==$cant){
                $puntaje+=$preg->puntajeTD;
            }
            
            //dump($val);
        }
        $ex->nota=$puntaje;
        $ex->fechaEntrega=$fechaHora;
        $ex->update();
        
        
        return redirect()->route('cuestionario_estudiante.ingresar_examen', ['id' => $idCuestionario,'grupo'=>$grupo,'nromodulo'=>$nroModulo])->with('success', "¡Satisfactorio¡, Examen entregado|Completado.");
    }

    public function act_cuestionario($id,$grupo,$nroModulo,$idestmodulo){


        return redirect()->route('cuestionario_estudiante.ingresar_examen', ['id' => $id,'grupo'=>$grupo,'nromodulo'=>$nroModulo]);
    }


}

?>