<?php

namespace App\Http\Controllers;

use App\Exports\AsistenciaExcel;
use App\Http\Requests\GrupoRequest;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class CursoDocenteController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    
    public function index (Request $request){
        $paginate = 20;
        $st = $request->get('st');
        $st2 = empty($request->get('st2')) ? -1 : $request->get('st2');
   
        $grupos = DB::table('grupos as g')
            ->join('cursos as c', 'g.idCurso', 'c.idCurso')
            ->join('docentes as d', 'g.idDocente', 'd.idDocente')
            ->where('nomCur', 'LIKE', '%' . $st . '%')
            ->where('g.idDocente', $st2 == -1 ? '!=' : '=', $st2)
            ->paginate(15);

        $docentes = Docente::orderBy('nomDoc')->get();
        $cursos = Curso::orderBy('nomCur')->get();
        return view ('inicio.grupo.index', compact("grupos", "cursos", "docentes", "st", "st2", "paginate"));
    }

    public function store (GrupoRequest $request){
        $mytime = Carbon::now('America/Lima');
        try {
            $grupo = new Grupo();
            $grupo->idCurso = $request->get('idCurso');
            $grupo->idDocente = $request->get('idDocente');
            $grupo->nombreGrupo = $request->get('nombreGrupo');
            $grupo->save();
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
        return redirect()->back()->with('success', '¡Satisfactorio!, Grupo añadido.');
    }

    public function edit($id)
    {
        $docentes = Docente::orderBy('nomDoc')->get();
        $cursos = Curso::orderBy('nomCur')->get();
        $grupo = Grupo::findOrFail($id);
        return view("inicio.grupo.edit", compact("grupo", "docentes", "cursos"));
    }

    public function update (GrupoRequest $request, $id){
    
        try {
            $grupo = Grupo::findOrfail($id);
            $grupo->idCurso = $request->get('idCurso');
            $grupo->idDocente = $request->get('idDocente');
            $grupo->nombreGrupo = $request->get('nombreGrupo');
            $grupo->update();
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
        return Redirect::to('inicio/grupo')->with('success', '¡Satisfactorio!, Grupo modificado.');
    }

    public function show($id){
        $grupo = DB::table('grupos as g')->join('cursos as c', 'g.idCurso', 'c.idCurso')
            ->join('docentes as d', 'g.idDocente', 'd.idDocente')
            ->where('idGrupo', $id)
            ->first();

        $modulos = DB::table('modulos as m')->join('grupos as g', 'm.idGrupo', 'g.idGrupo')
            ->where('m.idGrupo', $id)
            ->select('nroModulo', DB::raw('COUNT(nroModulo) as cantidadAlumnos'))
            ->groupBy('nroModulo')
            ->get();
        return view('inicio.grupo.show', compact("grupo", "modulos"));
    }

    public function detalle_modulo($idGrupo, $nroModulo){
        $grupo = DB::table('grupos as g')->join('cursos as c', 'g.idCurso', 'c.idCurso')
            ->join('docentes as d', 'g.idDocente', 'd.idDocente')
            ->where('idGrupo', $idGrupo)
            ->first();

        $estudiantes = DB::table('modulos as m')
            ->join('grupos as g', 'm.idGrupo', 'g.idGrupo')
            ->join('matriculas as ma', 'm.idMatricula', 'ma.idMatricula')
            ->join('estudiantes as e', 'ma.idEstudiante', 'e.idEstudiante')
            ->where('m.idGrupo', $idGrupo)
            ->where('m.nroModulo', $nroModulo)
            ->get();

        return view('inicio.grupo.detalle_modulo', compact("grupo", "estudiantes", "nroModulo"));
    }

    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $docu   = Grupo::findOrFail($id);

                if ($docu->delete()) {
                    return response()->json([
                        'success' => true,
                        'message' => '¡Satisfactorio!, Registro eliminado con éxito.',
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => '¡Error!, No se pudo eliminar.',
                    ]);
                }
            }
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => '¡Error!, Este registro tiene enlazado uno o mas registros.',
                ]);
            }
        }
    }

    // Asistencia

    public function asistencia_index(Request $request, $idGrupo, $nroModulo)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();

        $st = empty($request->get('st')) ? date('Y-m-01', strtotime($fecha)) : $request->get('st');
        $st2 = empty($request->get('st2')) ? date('Y-m-t', strtotime($fecha)) : $request->get('st2');

        $grupo = DB::table('grupos as g')->join('cursos as c', 'g.idCurso', 'c.idCurso')
            ->join('docentes as d', 'g.idDocente', 'd.idDocente')
            ->where('idGrupo', $idGrupo)
            ->first();
        $registros = DB::table('asistencias as a')
            ->where('idGrupo', $idGrupo)
            ->where('nroModulo', $nroModulo)
            ->whereBetween('fecha', [$st, $st2])
            ->orderBy('fecha')
            ->get();

        $estudiantes = DB::table('modulos as m')
            ->join('grupos as g', 'm.idGrupo', 'g.idGrupo')
            ->join('matriculas as ma', 'm.idMatricula', 'ma.idMatricula')
            ->join('estudiantes as e', 'ma.idEstudiante', 'e.idEstudiante')
            ->where('m.idGrupo', $idGrupo)
            ->where('m.nroModulo', $nroModulo)
            ->get();

        return view('inicio.grupo.asistencia_index', compact("registros", "estudiantes", "st", "st2", "grupo", "nroModulo"));
    }

    public function asistencia_excel($id, $id2, $id3, $id4)
    {
        return Excel::download(new AsistenciaExcel($id, $id2, $id3, $id4), 'Asistencia Excel.xlsx');
    }

}
