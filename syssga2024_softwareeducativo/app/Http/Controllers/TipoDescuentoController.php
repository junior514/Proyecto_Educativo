<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoDescuentoRequest;
use App\Models\TipoDescuento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoDescuentoController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $paginate = 20;
        $st = $request->get('st');

        $tiposDescuento = DB::table('tipos_descuento')
            ->where('nombreTP', 'LIKE', '%' . $st . '%')
            ->paginate(15);

        return view('configuracion.tipo_descuento.index', compact("tiposDescuento", "st", "paginate"));
    }

    public function create()
    {
        return view('configuracion.tipo_descuento.create');
    }

    public function store(TipoDescuentoRequest $request)
    {
        try {
            $tipoDescuento = new TipoDescuento();
            $tipoDescuento->nombreTP = $request->get('nombreTP');
            $tipoDescuento->valorPorcentaje = $request->get('valorPorcentaje');
            $tipoDescuento->save();
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
        return redirect()->route('tipo_descuento.index')->with('success', '¡Satisfactorio!, Tipo de descuento añadido.');
    }

    public function edit($id)
    {
        $tipoDescuento = TipoDescuento::findOrFail($id);
        return view("configuracion.tipo_descuento.edit", compact("tipoDescuento"));
    }

    public function update(TipoDescuentoRequest $request, $id)
    {
        try {
            $tipoDescuento = TipoDescuento::findOrFail($id);
            $tipoDescuento->nombreTP = $request->get('nombreTP');
            $tipoDescuento->valorPorcentaje = $request->get('valorPorcentaje');
            $tipoDescuento->update();
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
        return redirect()->route('tipo_descuento.index')->with('success', '¡Satisfactorio!, Tipo de descuento modificado.');
    }

    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $docu = TipoDescuento::findOrFail($id);

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
