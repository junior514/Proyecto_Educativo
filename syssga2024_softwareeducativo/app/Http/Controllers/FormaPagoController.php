<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormaPagoRequest;
use App\Models\FormaPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormaPagoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $paginate = 20;
        $st = $request->get('st');

        $formasPago = DB::table('formas_pago')
            ->where('nombreFP', 'LIKE', '%' . $st . '%')
            ->paginate(15);

        return view('configuracion.forma_pago.index', compact("formasPago", "st", "paginate"));
    }

    public function create()
    {
        return view('configuracion.forma_pago.create');
    }

    public function store(FormaPagoRequest $request)
    {
        try {
            $formaPago = new FormaPago();
            $formaPago->nombreFP = $request->get('nombreFP');
            $formaPago->save();
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
        return redirect()->route('forma_pago.index')->with('success', '¡Satisfactorio!, Forma de pago añadida.');
    }

    public function edit($id)
    {
        $formaPago = FormaPago::findOrFail($id);
        return view("configuracion.forma_pago.edit", compact("formaPago"));
    }

    public function update(FormaPagoRequest $request, $id)
    {
        try {
            $formaPago = FormaPago::findOrFail($id);
            $formaPago->nombreFP = $request->get('nombreFP');
            $formaPago->update();
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
        return redirect()->route('forma_pago.index')->with('success', '¡Satisfactorio!, Forma de pago modificada.');
    }

    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $docu = FormaPago::findOrFail($id);

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
                    'message' => '¡Error!, Este información tiene enlazado uno o mas registros.',
                ]);
            }
        }
    }
}
