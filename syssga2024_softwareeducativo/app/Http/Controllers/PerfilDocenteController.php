<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocenteRequest;
use App\Models\Docente;
use Illuminate\Http\Request;

class PerfilDocenteController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:web_docente');
    }

    public function index(Request $request)
    {
        if ($request) {
            $users = Docente::findOrfail(auth()->user()->idDocente);
            return view('configuracion.perfil_docente.index',["users"=>$users]);

        }
    }

    public function update(DocenteRequest $request,$id)
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
            return redirect()->back()->with(['success' => '¡Satisfactorio!, ' . $docente->nomDoc . ' modificado.']);
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }
}
