<?php

namespace App\Http\Controllers;

use App\Http\Requests\CursoRequest;
use App\Models\Curso;
use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;


class CursoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    
    public function index (Request $request){
        $paginate = 20;
        $st = $request->get('st');
        $cursos = DB::table('cursos as c')
            ->where('nomCur', 'LIKE', '%' . $st . '%')
            ->paginate(15);
 
        return view ('mantenimiento.curso.index', compact("cursos",  "st", "paginate"));
    }

    public function store (CursoRequest $request){
        $mytime = Carbon::now('America/Lima');
        try {
            $curso = new Curso();
            $curso->nomCur = $request->get('nomCur');
            $curso->estadoCur = 1;
            $curso->save();
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
        return redirect()->back()->with('success', '¡Satisfactorio!, Curso añadido.');
    }

    public function edit($id)
    {
        $curso = Curso::findOrFail($id);
        return view("mantenimiento.curso.edit", compact("curso"));
    }

    public function update (CursoRequest $request, $id){
    
        try {
            $curso = Curso::findOrfail($id);
            $curso->nomCur = $request->get('nomCur');
            $curso->update();
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
        return Redirect::to('mantenimiento/curso')->with('success', '¡Satisfactorio!, Curso modificado.');
    }

    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $docu   = Curso::findOrFail($id);

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

}
