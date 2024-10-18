<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Http\Requests\ProductoRequest;

class ProductoController extends Controller
{
     public function __construct(){
        $this->middleware('auth');
    }

    
    public function index (Request $request){
        $paginate = 20;
        $st = $request->get('st');
 
        $productos = DB::table('productos as p')
            ->where('nombreProducto', 'LIKE', '%' . $st . '%')
            ->paginate(15);
 
        return view ('mantenimiento.producto.index', compact("productos",  "st", "paginate"));
    }

    public function store (ProductoRequest $request){
        $mytime = Carbon::now('America/Lima');
        try {
            $producto = new Producto();
            $producto->nombreProducto = $request->get('nombreProducto');
            $producto->precio = $request->get('precio');
            $producto->save();
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
        return redirect()->back()->with('success', '¡Satisfactorio!, Producto añadido.');
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view("mantenimiento.producto.edit", compact("producto"));
    }

    public function update (ProductoRequest $request, $id){
    
        try {
            $producto = Producto::findOrfail($id);
            $producto->nombreProducto = $request->get('nombreProducto');
            $producto->precio = $request->get('precio');
            $producto->update();
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
        return Redirect::to('mantenimiento/producto')->with('success', '¡Satisfactorio!, Producto modificado.');
    }

    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $docu = Producto::findOrFail($id);

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
