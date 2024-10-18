<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocenteRequest;
use Illuminate\Http\Request;
use App\Models\Docente;
use App\Models\Curso;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class DocenteController extends Controller
{
     public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $paginate = 20;
        $searchText = trim($request->get('searchText'));
        if ($request) {
            $docentes = Docente::where('nomDoc', 'LIKE', '%' . $searchText . '%')
                ->orwhere('nroDoc', 'LIKE', '%' . $searchText . '%')
                ->orderBy('nomDoc')
                ->paginate($paginate);
            return view('inicio.docente.index', compact("docentes", "searchText", "paginate"));
        }
    }

     public function store(DocenteRequest $request)
    {
        try {
            //code...
            $docente = new Docente();
            $docente->nroDoc =  $request->get('nroDoc');
            $docente->nomDoc =  $request->get('nomDoc');
            $docente->telDoc =  $request->get('telDoc');
            $docente->dirDoc =  $request->get('dirDoc');
            $docente->espDoc =  $request->get('espDoc');
            $docente->email =  $request->get('email');
            $docente->password =  bcrypt($request->get('nroDoc'));
            $docente->save();
            
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
        return Redirect::to('inicio/docente')->with(['success' => '¡Satisfactorio!, ' . $docente->nomDoc . ' agregado.']);
    }

    public function edit($id)
    {

        return view("inicio.docente.edit", ["docente" => Docente::findOrFail($id)]);
    }

    public function update(DocenteRequest $request, $id)
    {
        try {
            $docente = Docente::findOrFail($id);
            $docente->nroDoc =  $request->get('nroDoc');
            $docente->nomDoc =  $request->get('nomDoc');
            $docente->telDoc =  $request->get('telDoc');
            $docente->dirDoc =  $request->get('dirDoc');
            $docente->espDoc =  $request->get('espDoc');
            $docente->email =  $request->get('email');
            if ($request->get('password') != ''){
                $docente->password = bcrypt($request->get('password'));
            }
            $docente->update();
            return Redirect::to('inicio/docente')->with(['success' => '¡Satisfactorio!, ' . $docente->nomDoc . ' modificado.']);
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $docu   = Docente::findOrFail($id);

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


    public function store_curso (Request $request){
        $mytime = Carbon::now('America/Lima');
        try {
            $curso = new Curso();
            $curso->nomCur = $request->get('nomCur');
            $curso->fechCreacionCur = $mytime->toDateTimeString();
            $curso->idDocente = $request->get('idDocente');
            $curso->save();
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
        return redirect()->back()->with('success', '¡Satisfactorio!, Curso añadido.');
    }
}
