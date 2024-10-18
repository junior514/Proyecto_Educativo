<?php

namespace App\Http\Controllers;

use App\Exports\AsistenciaExcel;
use App\Models\Asistencia;
use App\Models\Curso;
use App\Models\DetalleAsistencia;
use App\Models\Modulo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;

class GrupoDocenteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web_docente');
    }

    public function index(Request $request)
    {
        $st = $request->get('st');
        $paginate = 15;
        $grupos = DB::table('grupos as g')
            ->join('cursos as c', 'g.idCurso', 'c.idCurso')
            ->join('docentes as d', 'g.idDocente', 'd.idDocente')
            ->where('g.idDocente', auth()->guard('web_docente')->user()->idDocente)
            ->Where(function ($q)  use ($st) {
                $q->orwhere('nombreGrupo', 'LIKE', '%' . $st . '%')
                    ->orWhere('nomCur', 'LIKE', '%' . $st . '%');
            })
            ->paginate($paginate);
        $cursos = Curso::orderBy('nomCur')->get();
        return view('inicio.grupo_docente.index', compact("grupos", "cursos", "st", "paginate"));
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
        return view('inicio.grupo_docente.show', compact("grupo", "modulos"));
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

        return view('inicio.grupo_docente.detalle_modulo_docente', compact("grupo", "estudiantes", "nroModulo"));
    }

    public function cargaSubNota(Request $request, $id)
    {
        $nro_nota = $request->get('nota');

        $subNota1 = $request->get('subNota1');
        $subNota2 = $request->get('subNota2');
        $subNota3 = $request->get('subNota3');
        $arreglo = array(
            "subNota1" => $subNota1,
            "subNota2" => $subNota2,
            "subNota3" => $subNota3,
        );
        $json = json_encode($arreglo);

        try {
            $modulo = Modulo::findOrfail($id);
            if ($nro_nota == 'Nota 1') {
                $modulo->nota1 = $json;
            } elseif ($nro_nota == 'Nota 2') {
                $modulo->nota2 = $json;
            } else {
                $modulo->nota3 = $json;
            }
            $modulo->update();
            return redirect()->back()->with('success', '¡Satisfactorio!, Subnotas registrada.');
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public static function promedioSubNota($jsonString)
    {
        // Decodificar el JSON en un array asociativo
        $array = json_decode($jsonString, true);

        // Verificar si la decodificación fue exitosa
        if ($array !== null) {
            // Ahora, $array contiene los datos en formato de array asociativo
            // print_r($array);
            return number_format((($array['subNota1'] + $array['subNota2'] + $array['subNota3']) / 3), 2);
        } else {
            return 0;
        }
    }

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

        return view('inicio.grupo_docente.asistencia_index', compact("registros", "estudiantes", "st", "st2", "grupo", "nroModulo"));
    }

    public function asistencia_create($idGrupo, $nroModulo)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();

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
        $estados = ['ASISTENCIA', 'TARDANZA', 'FALTA', 'JUSTIFICACIÓN'];
        return view('inicio.grupo_docente.asistencia_create', compact("estudiantes", "grupo", "nroModulo", "estados", "fecha"));
    }

    public function asistencia_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|unique:asistencias,fecha,' . null . ',idAsistencia,idGrupo,' . $request->get('idGrupo') . ',nroModulo,' . $request->get('nroModulo'),

        ], [
            'fecha.unique' => 'Ya tiene registrado una asistencia para esta fecha.',
        ]);

        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->messages() as $field => $messages) {
                foreach ($messages as $message) {
                    $errors[] = ['field' => $field, 'message' => $message];
                }
            }
            return new JsonResponse(['success' => false, 'errors' => $errors], 422);
        }

        DB::beginTransaction();
        try {
            $asistencia = new Asistencia();
            $asistencia->idGrupo = $request->get('idGrupo');
            $asistencia->nroModulo = $request->get('nroModulo');
            $asistencia->fecha = $request->get('fecha');
            $asistencia->observacion = $request->get('observacion');
            $asistencia->save();

            $idEstudiante = $request->get('idEstudiante');
            $estado = $request->get('estado');
            $observacion = $request->get('observacionD');
            for ($i = 0; $i < count($idEstudiante); $i++) {
                $asistencia_estudiante_det = new DetalleAsistencia();
                $asistencia_estudiante_det->idEstudiante = $idEstudiante[$i];
                $asistencia_estudiante_det->estado = $estado[$i];
                $asistencia_estudiante_det->observacion = $observacion[$i];
                $asistencia_estudiante_det->idAsistencia = $asistencia->idAsistencia;
                $asistencia_estudiante_det->save();
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
        return response()->json(['success' => true, 'redireccionar' => route('asistencia_index', [$asistencia->idGrupo, $asistencia->nroModulo])]);
    }


    public static function obtenerAsistencia($idEstudiante, $idAsistencia)
    {
        $registro = DetalleAsistencia::where('idEstudiante', $idEstudiante)
            ->where('idAsistencia', $idAsistencia)
            ->first();
        return isset($registro) ? $registro : "";
    }

    public function asistencia_edit($id)
    {
        $asistencia = Asistencia::findOrfail($id);
        $grupo = DB::table('grupos as g')->join('cursos as c', 'g.idCurso', 'c.idCurso')
            ->join('docentes as d', 'g.idDocente', 'd.idDocente')
            ->where('idGrupo', $asistencia->idGrupo)
            ->first();

        $estudiantes = DB::table('modulos as m')
            ->join('grupos as g', 'm.idGrupo', 'g.idGrupo')
            ->join('matriculas as ma', 'm.idMatricula', 'ma.idMatricula')
            ->join('estudiantes as e', 'ma.idEstudiante', 'e.idEstudiante')
            ->where('m.idGrupo', $asistencia->idGrupo)
            ->where('m.nroModulo', $asistencia->nroModulo)
            ->get();

        $estados = ['ASISTENCIA', 'TARDANZA', 'FALTA', 'JUSTIFICACIÓN'];
        return view('inicio.grupo_docente.asistencia_edit', compact("estudiantes", "asistencia", "grupo", "estados"));
    }

    public function asistencia_update(Request $request, $id)
    {
        $asistencia = Asistencia::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'fecha' => 'required|unique:asistencias,fecha,' . $id . ',idAsistencia,idGrupo,' . $asistencia->idGrupo . ',nroModulo,' . $asistencia->nroModulo,

        ], [
            'fecha.unique' => 'Ya tiene registrado una asistencia para esta fecha.',
        ]);

        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->messages() as $field => $messages) {
                foreach ($messages as $message) {
                    $errors[] = ['field' => $field, 'message' => $message];
                }
            }
            return new JsonResponse(['success' => false, 'errors' => $errors], 422);
        }

        DB::beginTransaction();
        try {


            $asistencia->fecha = $request->get('fecha');
            $asistencia->observacion = $request->get('observacion');
            $asistencia->update();
            $estudiantes = $request->input('estudiantes');

            foreach ($estudiantes as $estudiante) {
                if ($estudiante['idDetalleAsistencia'] == -1) {
                    $detalle_asistencia = new DetalleAsistencia();
                    $detalle_asistencia->idEstudiante = $estudiante['idEstudiante'];
                    $detalle_asistencia->estado = $estudiante['estado'];
                    $detalle_asistencia->observacion = $estudiante['observacion'];
                    $detalle_asistencia->idAsistencia = $asistencia->idAsistencia;
                    $detalle_asistencia->save();
                } else {
                    $detalle_asistencia = DetalleAsistencia::findOrFail($estudiante['idDetalleAsistencia']);
                    $detalle_asistencia->estado = $estudiante['estado'];
                    $detalle_asistencia->observacion = $estudiante['observacion'];
                    $detalle_asistencia->update();
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }

        return response()->json(['success' => true, 'redireccionar' => route('asistencia_index', [$asistencia->idGrupo, $asistencia->nroModulo])]);
    }

    public function asistencia_destroy(Request $request, $id)
    {
        DB::beginTransaction(); // Iniciar una transacción

        try {
            // Eliminar los detalles de asistencia primero
            DetalleAsistencia::where('idAsistencia', $id)->delete();

            // Luego, eliminar la asistencia principal
            $asistencia = Asistencia::findOrFail($id);
            $asistencia->delete();

            // Confirmar la transacción si todo se ejecuta correctamente
            DB::commit();

            return redirect()->back()->with('success', "¡Satisfactorio!, Asistencia de la fecha $asistencia->fecha eliminada.");
        } catch (\Exception $e) {
            // En caso de error, revertir la transacción
            DB::rollBack();

            return redirect()->back()->with('error', "Error al eliminar la asistencia: " . $e->getMessage());
        }
    }

    public function asistencia_excel($id, $id2, $id3, $id4)
    {
        return Excel::download(new AsistenciaExcel($id, $id2, $id3, $id4), 'Asistencia Excel.xlsx');
    }
}
