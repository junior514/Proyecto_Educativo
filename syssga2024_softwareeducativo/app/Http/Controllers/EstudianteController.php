<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstudianteRequest;
use App\Http\Requests\MatriculaRequest;
use App\Http\Requests\ModuloRequest;
use App\Models\ConceptoCredito;
use App\Models\Credito;
use App\Models\Estudiante;
use App\Models\Matricula;
use App\Models\CuotaPagar;
use App\Models\FormaPago;
use App\Models\Pago;
use App\Models\Modulo;
use App\Models\ObservacionCredito;
use App\Models\Producto;
use App\Models\Comprobante;
use App\Models\DetalleAsistencia;
use App\Models\TipoDescuento;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use GuzzleHttp\Promise\Create;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Datetime;
use Storage;

use function PHPUnit\Framework\returnSelf;

class EstudianteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $paginate = 30;
        $searchText = trim($request->get('searchText'));
        if ($request) {
            $estudiante = DB::table('estudiantes as e')
                ->where('nomEst', 'LIKE', '%' . $searchText . '%')
                ->orwhere('nroDoc', 'LIKE', '%' . $searchText . '%')
                ->orderBy('nomEst')
                ->paginate($paginate);

            $tipo_documento = ["6" => "RUC", "1" => "DNI", "-" => "VARIOS", "4" => "CARNET DE EXTRANJERÍA", "7" => "PASAPORTE"];
            // ->get();

            return view('inicio.estudiante.index', compact("estudiante", "tipo_documento", "paginate", "searchText"));
        }
    }

    public function store(EstudianteRequest $request)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        try {
            $estudiante = new Estudiante();
            $estudiante->nroDoc =  $request->get('nroDoc');
            $estudiante->nomEst =  $request->get('nomEst');
            $estudiante->telEst =  $request->get('telEst');
            $estudiante->dirEst =  $request->get('dirEst');
            $estudiante->email =  $request->get('email');
            $estudiante->generoEst =  $request->get('generoEst');
            $estudiante->f_nacimiento =  $request->get('f_nacimiento');
            $estudiante->fecCre = $fecha;
            $estudiante->tipoDoc =  $request->get('tipoDoc');
            $estudiante->password =  bcrypt($request->get('nroDoc'));
            if ($request->hasFile('fotoEst')) {
                $file = $request->file('fotoEst');
                $filename    = $file->getClientOriginalName();
                $image_resize = Image::make($file->getRealPath());
                // $image_resize->resize(200, 200);
                $image_resize->save(public_path('/estudiante/' . $filename));
                $estudiante->fotoEst = $filename;
            }
            $estudiante->save();
            return redirect()->back()->with(['success' => '¡Satisfactorio!, ' . $estudiante->nomEst . ' agregado.']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $tipo_documento =  ["6" => "RUC", "1" => "DNI", "-" => "VARIOS", "4" => "CARNET DE EXTRANJERÍA", "7" => "PASAPORTE"];
        return view("inicio.estudiante.edit", ["estudiante" => Estudiante::findOrFail($id), "tipo_documento" => $tipo_documento]);
    }

    public function update(EstudianteRequest $request, $id)
    {
        try {
            $estudiante = Estudiante::findOrFail($id);
            $estudiante->nroDoc =  $request->get('nroDoc');
            $estudiante->nomEst = $request->get('nomEst');
            $estudiante->telEst = $request->get('telEst');
            $estudiante->dirEst = $request->get('dirEst');
            $estudiante->email = $request->get('email');
            $estudiante->generoEst = $request->get('generoEst');
            $estudiante->f_nacimiento = $request->get('f_nacimiento');
            $estudiante->tipoDoc =  $request->get('tipoDoc');
            if ($request->get('password') != '') {
                $estudiante->password = bcrypt($request->get('password'));
            }
            if ($request->hasFile('fotoEst')) {
                if (!empty($estudiante->fotoEst) && file_exists(public_path('/estudiante/' . $estudiante->fotoEst))) {
                    unlink(public_path('/estudiante/' . $estudiante->fotoEst));
                }
                $file = $request->file('fotoEst');
                $filename    = $file->getClientOriginalName();
                $image_resize = Image::make($file->getRealPath());
                $image_resize->save(public_path('/estudiante/' . $filename));
                $estudiante->fotoEst = $filename;
            }
            $estudiante->update();
            return Redirect::to('inicio/estudiante')->with(['success' => '¡Satisfactorio!, ' . $estudiante->nomEst . ' modificado.']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $estudiante = Estudiante::findOrFail($id);
        $cursos = DB::table('cursos as c')->orderBy('nomCur')->get();
        $matriculas = DB::table('matriculas as m')->join('cursos as c', 'm.idCurso', 'c.idCurso')

            ->where('idEstudiante', $id)->get();
        return view("inicio.estudiante.show", compact("estudiante", "cursos", "matriculas", "fecha"));
    }

    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {

                $curso = Estudiante::findOrFail($id);
                if ($curso->delete()) {
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
                    'message' => '¡Error!, ' . 'Asegurese que el estudiante no registre matriculas.',
                ]);
            }
        }
    }

    public function matricula(MatriculaRequest $request)
    {
        $mytime = Carbon::now('America/Lima');
        $fechaHora = $mytime->toDateTimeString();
        try {
            DB::beginTransaction(); // Comenzar la transacción

            // Creamos la matricula
            $matricula = new Matricula();
            $matricula->idCurso = $request->get('idCurso');
            $matricula->idEstudiante = $request->get('idEstudiante');
            $matricula->fecMat = $fechaHora;
            $matricula->id = auth()->user()->id;
            $matricula->save();

            for ($i = 1; $i <= 12; $i++) {
                $modulo = new Modulo();
                $modulo->nroModulo = $i;
                $modulo->idMatricula = $matricula->idMatricula;
                $modulo->idGrupo = $request->get('idGrupo');
                $modulo->save();
            }
            DB::commit(); // Confirmar la transacción

        } catch (\Exception $e) {
            DB::rollBack(); // Deshacer la transacción en caso de error
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
        return redirect()->back()->with(['success' => '¡Satisfactorio!, ' . 'se agregó una matricula' . '.']);
    }

    public static function valEliminarMatricula($id)
    {
        $credito = DB::table('creditos')
            ->where('idMatricula', $id)
            ->count();

        $asistencia = DetalleAsistencia::where('idEstudiante', $id)
            ->count();

        // $modulo = DB::table('modulos')
        //     ->where('idMatricula', $id)
        //     ->count();

        return $credito == 0 && $asistencia == 0 ? true : false;
    }

    public function eliminar_matricula(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $modulos = Modulo::where('idMatricula', $id)->delete();

            $matricula = Matricula::findOrFail($id);
            $matricula->delete();
            DB::commit();
            return redirect()->back()->with(['success' => '¡Satisfactorio!, se eliminó la matricula.']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }

    public function index_pago($id)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();

        $matricula = DB::table('matriculas as m')->join('cursos as c', 'm.idCurso', 'c.idCurso')
            ->join('estudiantes as e', 'm.idEstudiante', 'e.idEstudiante')
            ->where('idMatricula', $id)->first();

        $creditos = Credito::where('idMatricula', $id)->get();
        $pagos = DB::table('pagos as p')
            ->leftJoin('creditos as c', 'p.idCredito', '=', 'c.idCredito')
            ->leftJoin('comprobantes as com', 'com.idPago', '=', 'p.idPago')
            ->where('c.idMatricula', $id)
            ->orderByDesc('p.idPago')
            ->select('p.*', 'c.*', 'com.tipoDoc', 'com.serieComprobante', 'com.numComprobante', 'com.sunat_pdf', 'com.sunat_estado')
            ->where('com.tipoDoc', '!=', '07')
            ->get();
        
        $tipos_doc = DB::table('tipos_doc')
            ->where('idTipoDoc', '!=', '07')
            ->get();
        $tipos_docCredito = DB::table('tipos_doc')
            ->where('idTipoDoc', '=', '07')
            ->get();

        $productos = Producto::orderBy('nombreProducto')->get();
        $tiposDescuento = TipoDescuento::orderBy('nombreTP')->get();
        $formasPago = FormaPago::orderBy('nombreFP')->get();
        return view('inicio.estudiante.pago_index', compact("matricula", "creditos", "pagos", "productos", "tiposDescuento", "formasPago", "fecha", "tipos_doc", "tipos_docCredito"));
    }

    public function pagarProducto(Request $request)
    {   
        if($request->idTipoDoc != '00'){
            $factura = $this->armar_json($request);
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('ROTUX_API_TOKEN'),
            ])->post(env('ROTUX_API_URL').'/invoices/send', $factura);
    
            // Verifica si la solicitud fue exitosa (código de respuesta 200)
            if ($response->successful()) {
                
                $data = $response->json(); // Obtiene la respuesta JSON
    
                if($data['success'] == false){
                    return redirect()->back()->with(['error' => '¡Error!, ' . $data['error']['message']]);
                }
    
                $zip = base64_decode($data['cdrZip']);
                $filename_zip = 'CDR/'.$factura['company']['ruc'].'-'.$factura['serie'] . '-' . $factura['correlativo'] . '.zip';
                Storage::disk('public')->put($filename_zip, $zip);
    
                $xml = $data['xml'];
                $filename_xml = 'XML/'.$factura['company']['ruc'].'-'.$factura['serie'] . '-' . $factura['correlativo'] . '.xml';
                Storage::disk('public')->put($filename_xml, $xml);    
                
                $mytime = Carbon::now('America/Lima');
                $fecha = $mytime->toDateString();
                try {
                    DB::beginTransaction(); // Iniciar la transacción
    
                    //credito
                    $credito = new Credito();
                    $credito->fechaCre = $fecha;
                    $credito->valorCre = $request->get('valorPago');
                    $credito->pagoAnticipado = $request->get('valorPago');
                    $credito->fechaPrimCuota = $fecha;
                    $credito->periodoCuotas = 'NINGUNO';
                    $credito->nroCuotas = 1;
                    $credito->idMatricula = $request->get('idMatricula');
                    $credito->save();
    
                    // CuotaAPagar
                    $cuotaPagar = new CuotaPagar();
                    $cuotaPagar->fechAPagar = $fecha;
                    $cuotaPagar->montoAPagar = $request->get('valorPago');
                    $cuotaPagar->idCredito = $credito->idCredito;
                    $cuotaPagar->save();
    
                    // Concepto
                    $idProducto = $request->get('idProducto') != null ? $request->get('idProducto') : []; //Validamos que exista el array de productos
                    $valorUnidad = $request->get('valorUnidad');
                    $cantidad = $request->get('cantidad');
                    $descuento  = $request->get('descuento');
                    $valorDescontado  = $request->get('valorDescontado');
                    $valorTotal  = $request->get('valorTotal');
    
                    $cont = 0;
                    while ($cont < count($idProducto)) {
                        $con_credito = new ConceptoCredito();
                        $con_credito->valorUnidad = $valorUnidad[$cont];
                        $con_credito->cantidad = $cantidad[$cont];
                        $con_credito->porcenDescuento = $descuento[$cont];
                        $con_credito->valorDescontado = $valorDescontado[$cont];
                        $con_credito->valorTotal = $valorTotal[$cont];
                        $con_credito->idProducto = $idProducto[$cont];
                        $con_credito->idCredito  = $credito->idCredito;
                        $con_credito->save();
                        $cont++;
                    }
    
                    // Pagos
                    $pago = new Pago();
                    $pago->fechaPago = $fecha;
                    $pago->fechaAsiento = $fecha;
                    $pago->detallePago = $request->get('detallePago');
                    $pago->valorPago = $request->get('valorPago');
                    $pago->idFormaPago = $request->get('idFormaPago');
                    $pago->idCredito = $credito->idCredito;
                    $pago->save();
    
                    //Registrar respuesta de comprobante
                    $comprobante = new Comprobante();
                    $comprobante->idMatricula = $request->idMatricula;
                    $comprobante->idPago = $pago->idPago;
                    $comprobante->tipoDoc = $factura['tipoDoc'];
                    $comprobante->tipoOperacion = $factura['tipoOperacion'];
                    $comprobante->serieComprobante = $factura['serie'];
                    $comprobante->numComprobante = $factura['correlativo'];
                    $comprobante->fechaHora = new \DateTime();
                    $comprobante->tipoPago = $factura['formaPago']['tipo'];
                    $comprobante->monedaPago = $factura['tipoMoneda'];
                    $comprobante->totalComprobante = $request->valorPago;
                    $comprobante->igv = $request->valorPago - ($request->valorPago / 1.18);
                    $comprobante->sunat_estado = 1;
                    $comprobante->sunat_descripcion = $data['cdrResponse']['description'];
                    $comprobante->sunat_cdr = $filename_zip;
                    $comprobante->sunat_xml = $filename_xml;
                    $comprobante->sunat_pdf = $data['ruta_pdf'];
                    $comprobante->save();
    
                    DB::commit(); // Confirmar la transacción
    
                    return redirect()->back()->with('success', '¡Satisfactorio!, Pago agregado.');
                } catch (\Exception $e) {
                    DB::rollBack(); // Revertir la transacción en caso de excepción
                    return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
                }
            } else {
                // Manejo de errores si la solicitud no fue exitosa
                return redirect()->back()->with(['error' => '¡Error!, No se pudo enviar el comprobante.']);
            }
        }else{
                $mytime = Carbon::now('America/Lima');
                $fecha = $mytime->toDateString();
                try {
                    DB::beginTransaction(); // Iniciar la transacción
    
                    //credito
                    $credito = new Credito();
                    $credito->fechaCre = $fecha;
                    $credito->valorCre = $request->get('valorPago');
                    $credito->pagoAnticipado = $request->get('valorPago');
                    $credito->fechaPrimCuota = $fecha;
                    $credito->periodoCuotas = 'NINGUNO';
                    $credito->nroCuotas = 1;
                    $credito->idMatricula = $request->get('idMatricula');
                    $credito->save();
    
                    // CuotaAPagar
                    $cuotaPagar = new CuotaPagar();
                    $cuotaPagar->fechAPagar = $fecha;
                    $cuotaPagar->montoAPagar = $request->get('valorPago');
                    $cuotaPagar->idCredito = $credito->idCredito;
                    $cuotaPagar->save();
    
                    // Concepto
                    $idProducto = $request->get('idProducto') != null ? $request->get('idProducto') : []; //Validamos que exista el array de productos
                    $valorUnidad = $request->get('valorUnidad');
                    $cantidad = $request->get('cantidad');
                    $descuento  = $request->get('descuento');
                    $valorDescontado  = $request->get('valorDescontado');
                    $valorTotal  = $request->get('valorTotal');
    
                    $cont = 0;
                    while ($cont < count($idProducto)) {
                        $con_credito = new ConceptoCredito();
                        $con_credito->valorUnidad = $valorUnidad[$cont];
                        $con_credito->cantidad = $cantidad[$cont];
                        $con_credito->porcenDescuento = $descuento[$cont];
                        $con_credito->valorDescontado = $valorDescontado[$cont];
                        $con_credito->valorTotal = $valorTotal[$cont];
                        $con_credito->idProducto = $idProducto[$cont];
                        $con_credito->idCredito  = $credito->idCredito;
                        $con_credito->save();
                        $cont++;
                    }
    
                    // Pagos
                    $pago = new Pago();
                    $pago->fechaPago = $fecha;
                    $pago->fechaAsiento = $fecha;
                    $pago->detallePago = $request->get('detallePago');
                    $pago->valorPago = $request->get('valorPago');
                    $pago->idFormaPago = $request->get('idFormaPago');
                    $pago->idCredito = $credito->idCredito;
                    $pago->save();
    
                    DB::commit(); // Confirmar la transacción
    
                    return redirect()->back()->with('success', '¡Satisfactorio!, Pago agregado.');
                } catch (\Exception $e) {
                    DB::rollBack(); // Revertir la transacción en caso de excepción
                    return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
                }
        }
    }
    //obtener correlativo
    public function obtenerCorrelativo($serieComprobante)
    {
        $ultimoNumero = DB::table('comprobantes')
        ->where('serieComprobante', $serieComprobante)
        ->max('numComprobante');
    
        if (is_null($ultimoNumero)) {
            $ultimoNumero = 1;
        } else {
            $ultimoNumero += 1;
        }
        
        return response()->json(['ultimoNumero' => $ultimoNumero]);
        
    }

    //obtener serie
    public function obtenerSeries($idTipoDoc)
    {
        //obtener usuario logueado
        $id = auth()->user()->id;

        $series = DB::table('series_doc')
            ->where('idTipoDoc', $idTipoDoc)
            ->where('users_id', $id)
            ->get();
    
        return response()->json([
            'series' => $series,
        ]);
    }

    //armamos el JSON para enviar el comprobante
    function armar_json($request)
    {
        $ajustes = DB::table('ajustes')->first();
        $estudiante = DB::table('matriculas')
            ->join('estudiantes', 'estudiantes.idEstudiante', '=', 'matriculas.idEstudiante')
            ->select('estudiantes.*')
            ->where('matriculas.idMatricula', $request->idMatricula)
            ->first();

        // Concepto
        $idProducto = $request->get('idProducto') != null ? $request->get('idProducto') : []; //Validamos que exista el array de productos
        $valorUnidad = $request->get('valorUnidad');
        $cantidad = $request->get('cantidad');
        $descuento  = $request->get('descuento');
        $valorDescontado  = $request->get('valorDescontado');
        $valorTotal  = $request->get('valorTotal');

        $factura = [
            "paperFormat" => "TICKET", // A4, A5, TICKET
            "ublVersion" => "2.1",
            "tipoDoc" => $request->idTipoDoc,
            "tipoOperacion" => "0101",
            "serie" => $request->idSerieDoc,
            "correlativo" => $request->correlativo,
            "fechaEmision" => Carbon::now()->toIso8601String(),
            "formaPago" => [
                "moneda" => "PEN",
                "tipo" => "Contado"
            ],
            "tipoMoneda" => "PEN",
            "company" => [
                "ruc" => $ajustes->ruc,
                "razonSocial" => $ajustes->nombre,
                "nombreComercial" => $ajustes->nombre,
                "address" => [
                    "ubigueo" => "150101",
                    "departamento" => "LIMA",
                    "provincia" => "LIMA",
                    "distrito" => "LIMA",
                    "urbanizacion" => "-",
                    "direccion" => $ajustes->direccion,
                    "codLocal" => "0000"
                ]
            ],
            "client" => [
                "tipoDoc" => $estudiante->tipoDoc,
                "numDoc" => $estudiante->nroDoc,
                "rznSocial" => $estudiante->nomEst
            ],
            "details" => [],
            "observaciones" => $request->detallePago
        ];   

        // Llenar el array de "details" con los datos de los productos
        for ($cont = 0; $cont < count($idProducto); $cont++) {

            $totalGeneral = $valorUnidad[$cont] * $cantidad[$cont] - $valorDescontado[$cont];
            $igv = $totalGeneral - ($totalGeneral / 1.18);
            $mtoBase = $totalGeneral - $igv;
            $mtoValor = $totalGeneral - $igv;
            $mtoValorUnit = $mtoValor / $cantidad[$cont];

            $producto = [
                "tipAfeIgv" => 10,
                "codProducto" => $idProducto[$cont],
                "unidad" => "NIU",
                "descripcion" => DB::table('productos')->where('idProducto', $idProducto[$cont])->first()->nombreProducto,
                "cantidad" => $cantidad[$cont],
                "mtoValorUnitario" => round($mtoValorUnit,2),
                "mtoValorVenta" => round($mtoValor,2),
                "mtoBaseIgv" => round($mtoBase,2),
                "porcentajeIgv" => 18,
                "igv" => round($igv,2),
                "totalImpuestos" => round($igv,2),
                "mtoPrecioUnitario" => $valorUnidad[$cont] - $valorDescontado[$cont] / $cantidad[$cont],
            ];

            $factura["details"][] = $producto;
        }
          
        return $factura;
    }

    //armar el JSON para enviar el comprobante - credito
    function armar_jsonCredito($request)
    {
        $credito = DB::table('creditos as c')
            ->leftJoin('matriculas as m', 'm.idMatricula', '=', 'c.idMatricula')
            ->leftJoin('concepto_creditos as cc', 'cc.idCredito', '=', 'c.idCredito')
            ->where('c.idCredito', '=', $request->idCredito)
            ->first();

        $ajustes = DB::table('ajustes')->first();
        $estudiante = DB::table('matriculas')
            ->join('estudiantes', 'estudiantes.idEstudiante', '=', 'matriculas.idEstudiante')
            ->select('estudiantes.*')
            ->where('matriculas.idMatricula', $credito->idMatricula)
            ->first();
        
            $factura = [
                "paperFormat" => "TICKET", // A4, A5, TICKET
                "idMatricula" => $credito->idMatricula, // solo para el controlador
                "ublVersion" => "2.1",
                "tipoDoc" => $request->idTipoDoc,
                "tipoOperacion" => "0101",
                "serie" => $request->idSerieDoc,
                "correlativo" => $request->correlativo,
                "fechaEmision" => Carbon::now()->toIso8601String(),
                "formaPago" => [
                    "moneda" => "PEN",
                    "tipo" => "Contado"
                ],
                "tipoMoneda" => "PEN",
                "company" => [
                    "ruc" => $ajustes->ruc,
                    "razonSocial" => $ajustes->nombre,
                    "nombreComercial" => $ajustes->nombre,
                    "address" => [
                        "ubigueo" => "150101",
                        "departamento" => "LIMA",
                        "provincia" => "LIMA",
                        "distrito" => "LIMA",
                        "urbanizacion" => "-",
                        "direccion" => $ajustes->direccion,
                        "codLocal" => "0000"
                    ]
                ],
                "client" => [
                    "tipoDoc" => $estudiante->tipoDoc,
                    "numDoc" => $estudiante->nroDoc,
                    "rznSocial" => $estudiante->nomEst
                ],
                "details" => [],
                "observaciones" => $request->detallePago,
            ];  

            $igv = $request->valorPagoC - ($request->valorPagoC / 1.18);
            $mtoBase = $request->valorPagoC - $igv;
            $mtoValor = $request->valorPagoC - $igv;
            $mtoValorUnit = $mtoValor / 1;


            $producto = [
                "tipAfeIgv" => 10,
                "codProducto" => $credito->idProducto,
                "unidad" => "NIU",
                "descripcion" => DB::table('productos')->where('idProducto', $credito->idProducto)->first()->nombreProducto,
                "cantidad" => 1,
                "mtoValorUnitario" => round($mtoValorUnit,2),
                "mtoValorVenta" => round($mtoValor,2),
                "mtoBaseIgv" => round($mtoBase,2),
                "porcentajeIgv" => 18,
                "igv" => round($igv,2),
                "totalImpuestos" => round($igv,2),
                "mtoPrecioUnitario" => $request->valorPagoC,
            ];

            $factura["details"][] = $producto;

            return $factura;
    }

    public function store_pago(Request $request)
    {
        if($request->idTipoDoc != '00'){
            // Realizamos la validaciones
            $totalPagar = Credito::findOrfail($request->get('idCredito'))->valorCre;
            $pagado = self::obtenerPagado($request->get('idCredito'));
            $porPagar = $totalPagar - $pagado;
            // aqui validación request para que no permitar pagar mas del total a pagar
            $rules = [
                'valorPagoC' => 'numeric|max:' . $porPagar,
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $factura = $this->armar_jsonCredito($request);
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('ROTUX_API_TOKEN'),
            ])->post(env('ROTUX_API_URL').'/invoices/send', $factura);

            if ($response->successful()) {
                $data = $response->json(); // Obtiene la respuesta JSON
    
                if($data['success'] == false){
                    return redirect()->back()->with(['error' => '¡Error!, ' . $data['error']['message']]);
                }
    
                $zip = base64_decode($data['cdrZip']);
                $filename_zip = 'CDR/'.$factura['company']['ruc'].'-'.$factura['serie'] . '-' . $factura['correlativo'] . '.zip';
                Storage::disk('public')->put($filename_zip, $zip);
    
                $xml = $data['xml'];
                $filename_xml = 'XML/'.$factura['company']['ruc'].'-'.$factura['serie'] . '-' . $factura['correlativo'] . '.xml';
                Storage::disk('public')->put($filename_xml, $xml);   

                try {

                    $pago = new Pago();
                    $pago->fechaPago = $request->get('fechaPago');
                    $pago->fechaAsiento = $request->get('fechaAsiento');
                    $pago->valorPago = $request->get('valorPagoC');
                    $pago->detallePago = $request->get('detallePago');
                    $pago->idFormaPago  = $request->get('idFormaPago');
                    $pago->idCredito = $request->get('idCredito');
                    $pago->save();

                    //Registrar respuesta de comprobante
                    $comprobante = new Comprobante();
                    $comprobante->idMatricula = $factura['idMatricula'];
                    $comprobante->idPago = $pago->idPago;
                    $comprobante->tipoDoc = $factura['tipoDoc'];
                    $comprobante->tipoOperacion = $factura['tipoOperacion'];
                    $comprobante->serieComprobante = $factura['serie'];
                    $comprobante->numComprobante = $factura['correlativo'];
                    $comprobante->fechaHora = new \DateTime();
                    $comprobante->tipoPago = $factura['formaPago']['tipo'];
                    $comprobante->monedaPago = $factura['tipoMoneda'];
                    $comprobante->totalComprobante = $request->valorPagoC;
                    $comprobante->igv = $request->valorPagoC - ($request->valorPagoC / 1.18);
                    $comprobante->sunat_estado = 1;
                    $comprobante->sunat_descripcion = $data['cdrResponse']['description'];
                    $comprobante->sunat_cdr = $filename_zip;
                    $comprobante->sunat_xml = $filename_xml;
                    $comprobante->sunat_pdf = $data['ruta_pdf'];
                    $comprobante->save();

                    return redirect()->back()->with(['success' => '¡Satisfactorio!, se añadió nuevo pago.']);
                } catch (\Exception $e) {
                    return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
                }
            }else{
                return redirect()->back()->with(['error' => '¡Error!, No se pudo enviar el comprobante.']);
            }
        }else{
            // Realizamos la validaciones
            $totalPagar = Credito::findOrfail($request->get('idCredito'))->valorCre;
            $pagado = self::obtenerPagado($request->get('idCredito'));
            $porPagar = $totalPagar - $pagado;
            // aqui validación request para que no permitar pagar mas del total a pagar
            $rules = [
                'valorPagoC' => 'numeric|max:' . $porPagar,
                // Agregar más reglas según tus necesidades
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {
                $pago = new Pago();
                $pago->fechaPago = $request->get('fechaPago');
                $pago->fechaAsiento = $request->get('fechaAsiento');
                $pago->valorPago = $request->get('valorPagoC');
                $pago->detallePago = $request->get('detallePago');
                $pago->idFormaPago  = $request->get('idFormaPago');
                $pago->idCredito = $request->get('idCredito');
                $pago->save();
                return redirect()->back()->with(['success' => '¡Satisfactorio!, se añadió nuevo pago.']);
            } catch (\Exception $e) {
                return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
            }
        }
    }

    public function show_pago($id)
    {
        $user = auth()->user();

        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $formasPago = FormaPago::orderBy('nombreFP')->get();
        $credito = DB::table('creditos as cr')
            ->join('matriculas as m', 'cr.idMatricula', 'm.idMatricula')
            ->join('cursos as c', 'm.idCurso', 'c.idCurso')
            ->join('estudiantes as e', 'm.idEstudiante', 'e.idEstudiante')
            ->where('cr.idCredito', $id)
            ->first();

        $credito_detalle = DB::table('concepto_creditos as cc')->join('productos as p', 'cc.idProducto', 'p.idProducto')
            ->where('idCredito', $id)
            ->get();

        $tipos_doc = DB::table('tipos_doc')
            ->where('idTipoDoc', '!=', '07')
            ->get();

        $tipos_docCredito = DB::table('tipos_doc')
            ->where('idTipoDoc', '=', '07')
            ->get();

        $cuotaPagar = DB::table('cuotas_a_pagar as cp')
            ->join('creditos as cr', 'cp.idCredito', 'cr.idCredito')
            ->join('matriculas as m', 'cr.idMatricula', 'm.idMatricula')
            ->join('cursos as c', 'm.idCurso', 'c.idCurso')
            ->join('estudiantes as e', 'm.idEstudiante', 'e.idEstudiante')
            ->where('cp.idCredito', $id)->get();

        $observaciones = DB::table('observaciones_creditos as oc')
            ->join('users as u', 'oc.id', 'u.id')
            ->where('idCredito', $id)
            ->get();

        $pagos = DB::table('pagos as p')
            ->leftJoin('creditos as c', 'c.idCredito', '=', 'p.idCredito')
            ->leftJoin('comprobantes as com', 'com.idPago', '=', 'p.idPago')
            ->where('p.idCredito', '=', $id)
            ->where('com.tipoDoc', '!=', '07')
            ->get();


        return view('inicio.estudiante.pago_show', compact("credito", "credito_detalle", "pagos", "cuotaPagar", "fecha", "formasPago", "observaciones", "tipos_doc", "tipos_docCredito"));
    }

    function armar_jsonAnulacion($request)
    {
        //formato --> https://github.com/antonywyatt/api-facturacion-examples/blob/main/notes.json
        $ajustes = DB::table('ajustes')->first();
        $estudiante = DB::table('matriculas as m')
            ->select('e.*', 'm.idMatricula')
            ->join('estudiantes as e', 'e.idEstudiante', '=', 'm.idEstudiante')
            ->join('creditos as c', 'c.idMatricula', '=', 'm.idMatricula')
            ->join('pagos as p', 'p.idCredito', '=', 'c.idCredito')
            ->where('p.idPago', '=', $request->idPago)
            ->first();
        
        $detalles = DB::table('productos as p')
            ->select('p.nombreProducto', 'cc.*')
            ->join('concepto_creditos as cc', 'cc.idProducto', '=', 'p.idProducto')
            ->join('creditos as c', 'c.idCredito', '=', 'cc.idCredito')
            ->join('pagos as pa', 'pa.idCredito', '=', 'c.idCredito')
            ->where('pa.idPago', '=', $request->idPago)
            ->get();

        $notacredito = [
                "ublVersion" => "2.1",
                "idMatricula" => $estudiante->idMatricula, // solo para el controlador
                "tipoDoc" => $request->idTipoDoc,
                "serie" => $request->idSerieDoc,
                "correlativo" => $request->correlativo,
                "fechaEmision" => Carbon::now()->toIso8601String(),
                "tipDocAfectado" => $request->tipDocAfectado,
                "numDocfectado" => $request->numDocfectado, //serie y correlativo del comprobante que se anula
                "codMotivo" => "01",
                "desMotivo" => $request->detallePago,
                "formaPago" => [
                    "moneda" => "PEN",
                    "tipo" => "Contado"
                ],
                "tipoMoneda" => "PEN",
                "company" => [
                    "ruc" => $ajustes->ruc,
                    "razonSocial" => $ajustes->nombre,
                    "nombreComercial" => $ajustes->nombre,
                    "address" => [
                        "ubigueo" => "150101",
                        "departamento" => "LIMA",
                        "provincia" => "LIMA",
                        "distrito" => "LIMA",
                        "urbanizacion" => "-",
                        "direccion" => $ajustes->direccion,
                        "codLocal" => "0000"
                    ]
                ],
                "client" => [
                    "tipoDoc" => $estudiante->tipoDoc,
                    "numDoc" => $estudiante->nroDoc,
                    "rznSocial" => $estudiante->nomEst
                ],
                "details" => [],
                "observaciones" => $request->detallePago
        ];
        
        // Llenar el array de "details" con los datos de los productos
        foreach ($detalles as $detalle) {

            $totalGeneral = $detalle->valorUnidad * $detalle->cantidad - $detalle->valorDescontado;
            $igv = $totalGeneral - ($totalGeneral / 1.18);
            $mtoBase = $totalGeneral - $igv;
            $mtoValor = $totalGeneral - $igv;
            $mtoValorUnit = $mtoValor / $detalle->cantidad;

            $producto = [
                "tipAfeIgv" => 10,
                "codProducto" => $detalle->idProducto,
                "unidad" => "NIU",
                "descripcion" => DB::table('productos')->where('idProducto', $detalle->idProducto)->first()->nombreProducto,
                "cantidad" => $detalle->cantidad,
                "mtoValorUnitario" => round($mtoValorUnit,2),
                "mtoValorVenta" => round($mtoValor,2),
                "mtoBaseIgv" => round($mtoBase,2),
                "porcentajeIgv" => 18,
                "igv" => round($igv,2),
                "totalImpuestos" => round($igv,2),
                "mtoPrecioUnitario" => $detalle->valorUnidad - $detalle->valorDescontado / $detalle->cantidad,
            ];

            $notacredito["details"][] = $producto;
        }
        
        return $notacredito;
    }

    public function store_notacredito(Request $request)
    {
        $notacredito = $this->armar_jsonAnulacion($request);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('ROTUX_API_TOKEN'),
        ])->post(env('ROTUX_API_URL').'/notes/send', $notacredito);

        if ($response->successful()) {
            $data = $response->json(); // Obtiene la respuesta JSON
            if($data['success'] == false){
                return redirect()->back()->with(['error' => '¡Error!, ' . $data['error']['message']]);
            }
            $zip = base64_decode($data['cdrZip']);
            $filename_zip = 'CDR/'.$notacredito['company']['ruc'].'-'.$notacredito['serie'] . '-' . $notacredito['correlativo'] . '.zip';
            Storage::disk('public')->put($filename_zip, $zip);
    
            $xml = $data['xml'];
            $filename_xml = 'XML/'.$notacredito['company']['ruc'].'-'.$notacredito['serie'] . '-' . $notacredito['correlativo'] . '.xml';
            Storage::disk('public')->put($filename_xml, $xml); 

            try {

                DB::table('pagos')
                    ->where('idPago', $request->idPago)
                    ->update([
                        'estado' => 0,
                        'detallePago' => $request->detallePago.' | Anulado con Nota de Crédito: '.$notacredito['serie'] . '-' . $notacredito['correlativo'],
                    ]);

                DB::table('comprobantes')
                    ->where('idPago', $request->idPago)
                    ->update([
                        'sunat_estado' => 2,
                        'doc_relacionado' => $notacredito['serie'] . '-' . $notacredito['correlativo'],
                    ]);
                
                //Registrar respuesta de comprobante
                $comprobante = new Comprobante();
                $comprobante->idMatricula = $notacredito['idMatricula'];
                $comprobante->idPago = $request->idPago;
                $comprobante->tipoDoc = $notacredito['tipoDoc'];
                $comprobante->tipoOperacion = '0000';
                $comprobante->serieComprobante = $notacredito['serie'];
                $comprobante->numComprobante = $notacredito['correlativo'];
                $comprobante->fechaHora = new \DateTime();
                $comprobante->tipoPago = $notacredito['formaPago']['tipo'];
                $comprobante->monedaPago = $notacredito['tipoMoneda'];
                //sumar details de notacredito
                $total = 0;
                $igv = 0;
                foreach ($notacredito['details'] as $detalle) {
                    $total += $detalle['mtoValorVenta'];
                    $igv += $detalle['igv'];
                }
                $comprobante->totalComprobante = $total + $igv;
                $comprobante->igv = $igv;
                $comprobante->sunat_estado = 1;
                $comprobante->sunat_descripcion = $data['cdrResponse']['description'];
                $comprobante->sunat_cdr = $filename_zip;
                $comprobante->sunat_xml = $filename_xml;
                $comprobante->sunat_pdf = $data['ruta_pdf'];
                $comprobante->doc_relacionado = $notacredito['tipDocAfectado'].'-'.$notacredito['numDocfectado'];
                $comprobante->save();

                return redirect()->back()->with(['success' => '¡Satisfactorio!, se anuló el pago.']);
            } catch (\Exception $e) {
                return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
            }
        }else{
            return redirect()->back()->with(['error' => '¡Error!, No se pudo enviar el comprobante.']);
        }
    }

    public static function obtenerPagado($idCredito)
    {
        $registro = Pago::where('idCredito', $idCredito)
            ->select(DB::raw('SUM(valorPago) as importe'))
            ->first();
        return isset($registro->importe) ? $registro->importe : 0;
    }

    public static function obtenerSaldo($idCredito)
    {
        $pago = Pago::where('idCredito', $idCredito)
            ->select(DB::raw('SUM(valorPago) as importe'))
            ->first();
        $pago = isset($pago->importe) ? $pago->importe : 0;
        $credito = Credito::findOrfail($idCredito);
        $saldo = $credito->valorCre - $pago;
        return $saldo;
    }

    public static function obtenerEstadoCredito($id)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $cuotaPagar = DB::table('cuotas_a_pagar as cp')
            ->join('creditos as cr', 'cp.idCredito', 'cr.idCredito')
            ->join('matriculas as m', 'cr.idMatricula', 'm.idMatricula')
            ->join('cursos as c', 'm.idCurso', 'c.idCurso')
            ->join('estudiantes as e', 'm.idEstudiante', 'e.idEstudiante')
            ->where('cp.idCredito', $id)->get();
        $obtenerPagado = self::obtenerPagado($id);
 
        foreach ($cuotaPagar as $cuota) {
            if ($obtenerPagado < $cuota->montoAPagar && $cuota->fechAPagar < $fecha) {
                return 'Mora';
            }
            $obtenerPagado -= $cuota->montoAPagar;
        }
        return 'Al día';
    }

    public function create_credito($id)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();

        $matricula = DB::table('matriculas as m')->join('cursos as c', 'm.idCurso', 'c.idCurso')
            ->join('estudiantes as e', 'm.idEstudiante', 'e.idEstudiante')
            ->where('idMatricula', $id)->first();

        $productos = Producto::orderBy('nombreProducto')->get();
        $tiposDescuento = TipoDescuento::orderBy('nombreTP')->get();
        $formasPago = FormaPago::orderBy('nombreFP')->get();
        $periodoCuotas = ['Mensual', 'Quincenal', 'Semanal'];

        $nroPagare  = DB::select("SHOW TABLE STATUS LIKE 'creditos'")[0]->Auto_increment;

        return view('inicio.estudiante.credito_create', compact("matricula", "productos", "tiposDescuento", "formasPago", "periodoCuotas", "fecha", "nroPagare"));
    }

    public function store_credito(Request $request)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        try {
            DB::beginTransaction(); // Iniciar la transacción

            //credito
            $credito = new Credito();
            $credito->fechaCre = $fecha;
            $credito->valorCre = $request->get('valorPago');
            $credito->pagoAnticipado = $request->get('pagoAnticipado');
            $credito->fechaPrimCuota = $request->get('fechaPrimCuota');
            $credito->periodoCuotas = $request->get('periodoCuotas');
            $credito->nroCuotas = $request->get('nroCuotas');
            $credito->idMatricula = $request->get('idMatricula');
            $credito->save();

            // CuotaAPagar
            $fechAPagar = $request->get('fechAPagar') != null ? $request->get('fechAPagar') : [];
            $montoAPagar = $request->get('montoAPagar');

            $i = 0;
            while ($i < count($fechAPagar)) {
                $cuotaPagar = new CuotaPagar();
                $cuotaPagar->fechAPagar = $fechAPagar[$i];
                $cuotaPagar->montoAPagar = $montoAPagar[$i];
                $cuotaPagar->idCredito = $credito->idCredito;
                $cuotaPagar->save();
                $i++;
            }

            // Concepto
            $idProducto = $request->get('idProducto') != null ? $request->get('idProducto') : []; //Validamos que exista el array de productos
            $valorUnidad = $request->get('valorUnidad');
            $cantidad = $request->get('cantidad');
            $descuento  = $request->get('descuento');
            $valorDescontado  = $request->get('valorDescontado');
            $valorTotal  = $request->get('valorTotal');

            $cont = 0;
            while ($cont < count($idProducto)) {
                $con_credito = new ConceptoCredito();
                $con_credito->valorUnidad = $valorUnidad[$cont];
                $con_credito->cantidad = $cantidad[$cont];
                $con_credito->porcenDescuento = $descuento[$cont];
                $con_credito->valorDescontado = $valorDescontado[$cont];
                $con_credito->valorTotal = $valorTotal[$cont];
                $con_credito->idProducto = $idProducto[$cont];
                $con_credito->idCredito  = $credito->idCredito;
                $con_credito->save();
                $cont++;
            }
            DB::commit(); // Confirmar la transacción

            return redirect()->route('pagos_curso', $credito->idMatricula)->with('success', '¡Satisfactorio!, Crédito N° ' . $credito->idCredito .  ', agregado.');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }


    public function index_modulo($id)
    {
        $matricula =  DB::table('matriculas as m')->join('cursos as c', 'm.idCurso', 'c.idCurso')
            ->join('estudiantes as e', 'm.idEstudiante', 'e.idEstudiante')
            ->where('idMatricula', $id)->first();

        $modulos = DB::table('modulos as mo')
            ->join('matriculas as m', 'mo.idMatricula', 'm.idMatricula')
            ->join('cursos as c', 'm.idCurso', 'c.idCurso')
            ->join('grupos as g', 'mo.idGrupo', 'g.idGrupo')
            ->join('docentes as d', 'g.idDocente', 'd.idDocente')
            ->join('estudiantes as e', 'm.idEstudiante', 'e.idEstudiante')
            ->where('m.idMatricula', $id)->get();
        $grupos = DB::table('grupos as g')->join('docentes as d', 'g.idDocente', 'd.idDocente')
            ->join('cursos as c', 'g.idCurso', 'c.idCurso')
            ->where('g.idCurso', $matricula->idCurso)
            ->get();


        return view('inicio.estudiante.modulo_index', compact("matricula", "modulos", "grupos"));
    }

    public function store_modulo(ModuloRequest $request)
    {
        try {
            $modulo = new Modulo();
            $modulo->nroModulo = $request->get('nroModulo');
            $modulo->idMatricula = $request->get('idMatricula');
            $modulo->idGrupo = $request->get('idGrupo');
            $modulo->save();
            return redirect()->back()->with(['success' => '¡Satisfactorio!, se añadió nuevo módulo.']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }

    public function update_modulo(ModuloRequest $request)
    {
        try {
            $modulo = Modulo::findOrfail($request->get('idModulo'));
            $modulo->nroModulo = $request->get('nroModulo');
            $modulo->idGrupo = $request->get('idGrupo');
            $modulo->update();
            return redirect()->back()->with(['success' => '¡Satisfactorio!, se modificó los datos del módulo.']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }

    public function destroy_modulo($id)
    {
        try {
            $modulo = Modulo::findOrfail($id);
            if ($modulo->delete()) {
                return redirect()->back()->with(['success' => '¡Satisfactorio!, se eliminó el módulo.']);
            } else {
                return redirect()->back()->with(['error' => '¡Error!, No se pudo eliminar el registro.']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }

    public function store_observacion(Request $request)
    {
        try {
            $observacion = new ObservacionCredito();
            $observacion->fechaObs = $request->get('fechaObs');
            $observacion->detalleObs = $request->get('detalleObs');
            $observacion->idCredito = $request->get('idCredito');
            $observacion->id = auth()->user()->id;
            $observacion->save();
            return redirect()->back()->with('success', '¡Satisfactorio!, Observación agregada.');
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update_observacion(Request $request, $id)
    {
        try {
            $observacion = ObservacionCredito::findOrfail($id);
            $observacion->fechaObs = $request->get('fechaObs');
            $observacion->detalleObs = $request->get('detalleObs');
            $observacion->save();
            return redirect()->back()->with('success', '¡Satisfactorio!, Observación modificada.');
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function destroy_observacion(Request $request, $id)
    {
        try {
            //code...
            $observacion = ObservacionCredito::findOrfail($id);
            if ($observacion->delete()) {
                return redirect()->back()->with('success', '¡Satisfactorio!, Observación eliminada.');
            } else {
                return redirect()->back()->with('error', 'No se pudo eliminar la observación.');
            }
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function obtenerGrupo (Request $request){
        $idCurso = $request->get('idCurso');
        $grupos = DB::table('grupos as g')->join('docentes as d', 'g.idDocente', 'd.idDocente')
            ->join('cursos as c', 'g.idCurso', 'c.idCurso')
            ->where('g.idCurso', $idCurso)
            ->pluck('g.nombreGrupo', 'g.idGrupo');

            $selectGrupos = '<select id="idGrupo" name="idGrupo" class="form-control form-control-sm" data-live-search="true" required>';
            $selectGrupos .= '<option value="">Selecciona un Grupo</option>';
        
            foreach ($grupos as $id => $nombre) {
                $selectGrupos .= '<option value="' . $id . '">' . $nombre . '</option>';
            }
        
            $selectGrupos .= '</select>';
        
            return response()->json(['selectGrupos' => $selectGrupos]);
    }
}
