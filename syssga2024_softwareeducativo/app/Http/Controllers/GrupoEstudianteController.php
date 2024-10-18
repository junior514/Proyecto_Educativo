<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GrupoEstudianteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web_estudiante');
    }

    public function index(Request $request)
    {
        $st = $request->get('st');
        $paginate = 15;
        $grupos = DB::table('modulos as m')
            ->join('grupos as g', 'm.idGrupo', 'g.idGrupo')
            ->join('cursos as c', 'g.idCurso', 'c.idCurso')
            ->join('docentes as d', 'g.idDocente', 'd.idDocente')
            ->join('matriculas as ma', 'm.idMatricula', 'ma.idMatricula')
            ->where('idEstudiante', auth()->guard('web_estudiante')->user()->idEstudiante)
            ->groupBy('m.idGrupo', 'nombreGrupo')
            ->select('m.idGrupo', 'nombreGrupo') // Aquí corregido
            ->paginate($paginate);
        // $cursos = Curso::orderBy('nomCur')->get();
        return view('inicio.grupo_estudiante.index', compact("grupos", "st", "paginate"));
    }

    public function show($id)
    {
        $grupo = DB::table('grupos as g')->join('cursos as c', 'g.idCurso', 'c.idCurso')
            ->join('docentes as d', 'g.idDocente', 'd.idDocente')
            ->where('idGrupo', $id)
            ->first();

        $modulos = DB::table('modulos as m')->join('grupos as g', 'm.idGrupo', 'g.idGrupo')
            ->where('m.idGrupo', $id)
            ->select('nroModulo', DB::raw('COUNT(nroModulo) as cantidadAlumnos'))
            ->groupBy('nroModulo')
            ->get();
        return view('inicio.grupo_estudiante.show', compact("grupo", "modulos"));
    }

    public function detalle_modulo($idGrupo, $nroModulo)
    {
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

        return view('inicio.grupo_estudiante.detalle_modulo_estudiante', compact("grupo", "estudiantes", "nroModulo"));
    }


}
