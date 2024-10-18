<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class UsuarioController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $paginate = 8;
        $searchText = trim($request->get('searchText'));
        if ($request) {
            $usuario = User::where('name', 'LIKE', '%' . $searchText . '%')
                ->orderBy('name')
                ->paginate($paginate);
            $tipo = ["USUARIO", 'SECRETARIA', 'LABORATORIO', 'ADMINISTRADOR'];
            return view('acceso.usuario.index', compact("usuario", "tipo", "searchText", "paginate"));
        }
    }
    public function create()
    {
        return view('acceso.usuario.create');
    }
    public function store(UsuarioFormRequest $request)
    {
        try {
            //code...
            $usuario = new User();
            $usuario->nroDoc=$request->get('nroDoc');
            $usuario->name=$request->get('name');
            // $usuario->tipUse=$request->get('tipUse');
            $usuario->tipUse= 'ADMINISTRADOR';
            $usuario->telUse=$request->get('telUse');
            $usuario->email=$request->get('email');
            $usuario->estUse = 'ACTIVO';
            if ($request->get('password') != ''){
                $usuario->password = bcrypt($request->get('password'));
            }
            $usuario->save();
            return Redirect::to('acceso/usuario')->with(['success' => '¡Satisfactorio!, ' . $usuario->name . ' agregado.']);
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }

    public function createserie(Request $request)
    {
        DB::table('series_doc')
            ->insert([
                'users_id' => $request->id,
                'idTipoDoc' => $request->tipo_doc,
                'nombre' => $request->serie,
            ])
        ;

        return redirect()->back()->with(['success' => '¡Satisfactorio!, Serie agregada.']);
    }

    public function deleteserie(Request $request)
    {
        DB::table('series_doc')
            ->where('idSerieDoc', '=', $request->id)
            ->delete()
        ;

        return redirect()->back()->with(['success' => '¡Satisfactorio!, Serie eliminada.']);
    }

    public function edit($id)
    {
        $tipo = ["USUARIO", 'SECRETARIA', 'LABORATORIO', 'ADMINISTRADOR'];

        $series = DB::table('series_doc')
            ->join('tipos_doc', 'tipos_doc.idTipoDoc', '=', 'series_doc.idTipoDoc')
            ->select('series_doc.*', 'tipos_doc.nombre as tipo_doc')
            ->where('users_id', '=', $id)
            ->get();
        
        $tipos_doc = DB::table('tipos_doc')
            ->get();
        
        $usuario = User::findOrFail($id);

        return view("acceso.usuario.edit", compact("usuario", "tipo", "series", "tipos_doc"));
    }
    public function update(UsuarioFormRequest $request, $id)
    {
        try {
            $usuario=User::findOrFail($id);
            $usuario->nroDoc=$request->get('nroDoc');
            $usuario->name=$request->get('name');
            // $usuario->tipUse=$request->get('tipUse');
            $usuario->telUse=$request->get('telUse');
            $usuario->email=$request->get('email');
            if ($request->get('password') != ''){
                $usuario->password = bcrypt($request->get('password'));
            }
            $usuario->update();
            return Redirect::to('acceso/usuario')->with(['success' => '¡Satisfactorio!, ' . $usuario->name . ' modificado.']);
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $n_id = substr($id, 1);

        $vuser = DB::table('users')
            ->where('id', $n_id)
            ->first();
        if (isset($vuser->estUse)) {
            if ($vuser->estUse == 'ACTIVO') {
                $status = "INACTIVO";
            } else {
                $status = "ACTIVO";
            }
        }

        $users = User::findOrFail($n_id);
        $users->estUse = $status;
        $users->update();
        return Redirect::to('acceso/usuario')->with(['success' => '¡Satisfactorio!, Estado de ' . $users->name . ' modificado.']);
    }

    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $docu   = User::findOrFail($id);
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
