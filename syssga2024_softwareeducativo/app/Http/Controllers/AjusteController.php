<?php

namespace App\Http\Controllers;

use App\Http\Requests\AjusteRequest;
use App\Http\Requests\EmpresaFormRequest;
use App\Models\Ajuste;
use App\Models\Empresa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as Image;

class AjusteController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $empresa = Ajuste::first();
            return view('configuracion.ajustes.index', ["empresa" => $empresa]);
        }
    }

    public function update(AjusteRequest $request, $id)
    {
        try {
            $empresa = Ajuste::findOrFail($id);
            $empresa->nombre = $request->get('nombre');
            $empresa->direccion = $request->get('direccion');
            $empresa->telefono = $request->get('telefono');
            $empresa->ruc = $request->get('ruc');
            $empresa->correo = $request->get('correo');

            if ($request->hasFile('logo')) {
                if (!empty($empresa->logo) && file_exists(public_path('empresa/' . $empresa->logo))) {
                    unlink(public_path('empresa/' . $empresa->logo));
                }
                $file = $request->file('logo');
                $filename  = $file->getClientOriginalName();
                $image_resize = Image::make($file->getRealPath());
                $image_resize->resize(200, 200);
                $image_resize->save(public_path('empresa/' . $filename));
                $empresa->logo = $filename;
            }
            $empresa->update();
            return Redirect::to('configuracion/ajustes')->with(['success' => '¡Satisfactorio!, Se ha modificado correctamente.']);
        } catch (Exception $e) {
            return Redirect::to('configuracion/ajustes')->with(['error' => $e->getMessage()]);
        }
    }
}
