<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioFormRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PerfilController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $users = DB::table('users as u')
            ->Where('u.id', '=', auth()->user()->id)
            ->first();
            return view('configuracion.mi_perfil.index',["users"=>$users]);

        }
    }

    public function update(UsuarioFormRequest $request,$id)
    {
        try {
            $usuario=User::findOrFail($id);
            $usuario->name=$request->get('name');
            $usuario->telUse=$request->get('telUse');
            $usuario->email=$request->get('email');
            if ($request->get('password') != ''){
                $usuario->password = bcrypt($request->get('password'));
            }
            // if($request->hasFile('imageUsers')){
            //     $file = $request->file('imageUsers');
            //     $filename    = $file->getClientOriginalName();
            //     $image_resize = Image::make($file->getRealPath());
            //     $image_resize->resize(200, 200);
            //     $image_resize->save(public_path('users/' . $filename));
            //     $usuario->imageUsers = $filename;
            // }
            $usuario->update();
            return Redirect::to('configuracion/mi_perfil')->with(['success' => '¡Satisfactorio!, Se ha modificado correctamente.']);
        } catch (Exception $e) {
            return Redirect::to('configuracion/mi_perfil')->with(['error' => 'Ocurrió un error al procesar su petición']);
        }
    }
}
