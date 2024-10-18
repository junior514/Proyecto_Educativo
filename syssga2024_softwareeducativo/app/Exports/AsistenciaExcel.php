<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AsistenciaExcel implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $id, $id2, $id3, $id4;
    public function __construct($id, $id2, $id3, $id4)
    {
        $this->id = $id;
        $this->id2 = $id2;
        $this->id3 = $id3;
        $this->id4 = $id4;
    }

    public function view(): View
    {
        $idGrupo = $this->id;
        $nroModulo = $this->id2;
        $st = $this->id3;
        $st2 = $this->id4;

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
        
        return view('inicio.grupo_docente.asistencia_excel', compact("grupo", "registros", "estudiantes", "nroModulo", "st", "st2"));
    }
}
