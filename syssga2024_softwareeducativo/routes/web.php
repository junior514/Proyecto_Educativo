<?php

use App\Http\Controllers\AjusteController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\CursoDocenteController;
use App\Http\Controllers\FormaPagoController;
use App\Http\Controllers\GrupoDocenteController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TipoDescuentoController;
use App\Http\Controllers\ExcelCSVController;
use App\Http\Controllers\GrupoEstudianteController;
use App\Http\Controllers\PerfilDocenteController;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\RecursoEstudianteController;
use App\Http\Controllers\RecursoCuestionarioController;
use App\Http\Controllers\RecursoCuestionarioEController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Auth::routes();
Route::put('/login', [LoginController::class, 'logout']);

Route::resource('inicio/docente', DocenteController::class);
Route::resource('inicio/estudiante', EstudianteController::class);
Route::resource('acceso/usuario', UsuarioController::class);
Route::post('acceso/createserie', [UsuarioController::class, 'createserie'])->name('createserie');
Route::post('acceso/deleteserie', [UsuarioController::class, 'deleteserie'])->name('deleteserie');
Route::resource('inicio/grupo', CursoDocenteController::class);

Route::resource('mantenimiento/curso', CursoController::class);
Route::resource('mantenimiento/producto', ProductoController::class);
Route::resource('configuracion/ajustes', AjusteController::class);
Route::resource('configuracion/mi_perfil', PerfilController::class);
Route::resource('configuracion/forma_pago', FormaPagoController::class);
Route::resource('configuracion/tipo_descuento', TipoDescuentoController::class);

// Rutas docente
Route::resource('inicio/grupo_docente', GrupoDocenteController::class);
Route::resource('configuracion/perfil_docente', PerfilDocenteController::class);
Route::resource('docente/recurso_docente', RecursoController::class);
//Route::resource('docente/recurso_docente/cuestionario', RecursoCuestionarioController::class);


// Rutas Estudiante
Route::resource('inicio/grupo_estudiante', GrupoEstudianteController::class);
Route::resource('estudiante/recurso_estudiante', RecursoEstudianteController::class);

// Rutas Extra
Route::get('inicio/docente/{id}/cursos', [DocenteController::class, 'cursos'])->name('cursosDocente');
Route::post('store_curso', [DocenteController::class, 'store_curso'])->name('store_curso');
Route::post('matricula', [EstudianteController::class, 'matricula'])->name('matricula');
Route::get('inicio/estudiante/{id}/index_pago', [EstudianteController::class, 'index_pago'])->name('pagos_curso');
Route::post('pagarProducto', [EstudianteController::class, 'pagarProducto'])->name('pagarProducto');
Route::get('obtenerCorrelativo/{serieComprobante}', [EstudianteController::class, 'obtenerCorrelativo'])->name('obtenerCorrelativo');
Route::get('obtenerSeries/{idTipoDoc}', [EstudianteController::class, 'obtenerSeries'])->name('obtenerSeries');
Route::delete('eliminar_matricula/{id}', [EstudianteController::class, 'eliminar_matricula'])->name('eliminar_matricula');
Route::post('store_pago', [EstudianteController::class, 'store_pago'])->name('store_pago');
Route::post('store_notacredito', [EstudianteController::class, 'store_notacredito'])->name('store_notacredito');
Route::get('inicio/estudiante/{id}/show_pago', [EstudianteController::class, 'show_pago'])->name('show_pago');
Route::get('inicio/estudiante/{id}/create_credito', [EstudianteController::class, 'create_credito'])->name('create_credito');
Route::post('store_credito', [EstudianteController::class, 'store_credito'])->name('store_credito');
Route::post('store_observacion', [EstudianteController::class, 'store_observacion'])->name('store_observacion');
Route::put('update_observacion/{id}', [EstudianteController::class, 'update_observacion'])->name('update_observacion');
Route::delete('destroy_observacion/{id}', [EstudianteController::class, 'destroy_observacion'])->name('destroy_observacion');
Route::get('inicio/grupo/{id}/{id2}/detalle_modulo', [CursoDocenteController::class, 'detalle_modulo'])->name('detalle_modulo');
Route::get('inicio/grupo/{id}/{id2}/asistencia', [CursoDocenteController::class, 'asistencia_index'])->name('adm_asistencia_index');
Route::get('obtenerGrupo', [EstudianteController::class, 'obtenerGrupo'])->name('obtenerGrupo');

// Rutas reportes - Administrador
Route::get('inicio/grupo/{id}/{id2}/asistencia_excel/{id3}/{id4}', [CursoDocenteController::class, 'asistencia_excel'])->name('adm_asistencia.excel');

// Rutas Extra - Docente
Route::get('inicio/grupo_docente/{id}/{id2}/detalle_modulo_docente', [GrupoDocenteController::class, 'detalle_modulo'])->name('detalle_modulo_docente');
Route::put('cargaSubNota/{id}', [GrupoDocenteController::class, 'cargaSubNota'])->name('cargaSubNota');
Route::get('inicio/grupo_docente/{id}/{id2}/asistencia', [GrupoDocenteController::class, 'asistencia_index'])->name('asistencia_index');
Route::get('inicio/grupo_docente/{id}/{id2}/asistencia_create', [GrupoDocenteController::class, 'asistencia_create'])->name('asistencia_create');
Route::post('asistencia_store', [GrupoDocenteController::class, 'asistencia_store'])->name('asistencia_store');
Route::get('inicio/grupo_docente/{id}/asistencia_edit', [GrupoDocenteController::class, 'asistencia_edit'])->name('asistencia_edit');
Route::put('asistencia_update/{id}', [GrupoDocenteController::class, 'asistencia_update'])->name('asistencia_update');
Route::delete('asistencia_destroy/{id}', [GrupoDocenteController::class, 'asistencia_destroy'])->name('asistencia_destroy');
Route::post('store_leccion', [RecursoController::class, 'store_leccion'])->name('store_leccion');
Route::get('inicio/recurso_docente/{id}/create_tarea', [RecursoController::class, 'create_tarea'])->name('create_tarea');
Route::delete('tarea_destroy/{id}', [RecursoController::class, 'tarea_destroy'])->name('tarea_destroy');
Route::get('inicio/recurso_docente/{id}/tarea_show', [RecursoController::class, 'tarea_show'])->name('tarea_show');
Route::put('revisartarea_store/{id}', [RecursoController::class, 'revisartarea_store'])->name('revisartarea_store');
Route::put('revisartarea_update/{id}', [RecursoController::class, 'revisartarea_update'])->name('revisartarea_update');
Route::delete('revisartarea_destroy/{id}', [RecursoController::class, 'revisartarea_destroy'])->name('revisartarea_destroy');

// Rutas extra - Estudiante
Route::get('inicio/grupo_estudiante/{id}/{id2}/detalle_modulo_estudiante', [GrupoEstudianteController::class, 'detalle_modulo'])->name('detalle_modulo_estudiante');
Route::get('inicio/recurso_estudiante/{id}/entrega_tarea', [RecursoEstudianteController::class, 'entrega_tarea'])->name('entrega_tarea');
Route::get('inicio/recurso_estudiante/{id}/corregir_tarea', [RecursoEstudianteController::class, 'corregir_tarea'])->name('corregir_tarea');



// Rutas de Reportes - Docente
Route::get('inicio/grupo_docente/{id}/{id2}/asistencia_excel/{id3}/{id4}', [GrupoDocenteController::class, 'asistencia_excel'])->name('asistencia.excel');



// Rutas Extra Módulo Estudiante
Route::get('inicio/estudiante/{id}/index_modulo', [EstudianteController::class, 'index_modulo'])->name('index_modulo');
Route::post('store_modulo', [EstudianteController::class, 'store_modulo'])->name('store_modulo');
Route::post('update_modulo', [EstudianteController::class, 'update_modulo'])->name('update_modulo');
Route::delete('destroy_modulo/{id}', [EstudianteController::class, 'destroy_modulo'])->name('destroy_modulo');


//Exportar comprobantes
Route::get('export-excel-csv-file/{slug}', [ExcelCSVController::class, 'exportExcelCSV']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//extras ultimo

Route::get('docente/cuestionario/', [RecursoCuestionarioController::class, 'index'])->name('cuestionario_docente.index');
Route::get('estudiante/cuestionario/', [RecursoCuestionarioEController::class, 'index'])->name('cuestionario_estudiante.index');
Route::get('inicio/cuestionario/{id}/cuestionario_show', [RecursoCuestionarioController::class, 'cuestionario_show'])->name('cuestionario_show');
Route::post('storecuestionario_leccion', [RecursoCuestionarioController::class, 'store_leccion'])->name('storecuestionario_leccion');
Route::get('inicio/cuestionario/{id}/create_cuestionario', [RecursoCuestionarioController::class, 'create_cuestionario'])->name('create_cuestionario');
Route::post('store_cuestionario', [RecursoCuestionarioController::class, 'store_cuestionario'])->name('store_cuestionario');
Route::get('inicio/cuestionario/{id}/crear_cuestionario', [RecursoCuestionarioController::class, 'crear_cuestionario'])->name('crear_cuestionario');
Route::get('docente/cuestionario/edit/{id}', [RecursoCuestionarioController::class, 'edit'])->name('cuestionario_docente.edit');
Route::delete('cuestionario_destroy/{id}', [RecursoCuestionarioController::class, 'cuestionario_destroy'])->name('cuestionario_destroy');
Route::post('store_preguntas', [RecursoCuestionarioController::class, 'store_preguntas'])->name('store_preguntas');
Route::delete('destroy_pregunta/{id}', [RecursoCuestionarioController::class, 'destroy_pregunta'])->name('destroy_pregunta');
Route::post('update_cuestionario', [RecursoCuestionarioController::class, 'update_cuestionario'])->name('update_cuestionario');

Route::get('inicio/cuestionario/{id}/editar_pregunta', [RecursoCuestionarioController::class, 'editar_pregunta'])->name('editar_pregunta');
Route::post('update_preguntas', [RecursoCuestionarioController::class, 'update_preguntas'])->name('update_preguntas');

Route::get('estudiante/cuestionario/ingresar_examen/{id}/{grupo}/{nromodulo}', [RecursoCuestionarioEController::class, 'ingresar_examen'])->name('cuestionario_estudiante.ingresar_examen');
Route::post('guardar_cuestionario', [RecursoCuestionarioEController::class, 'guardar_cuestionario'])->name('guardar_cuestionario');

Route::get('act_cuestionario/{id}/{grupo}/{nromodulo}/{idesmodulo}', [RecursoCuestionarioEController::class, 'act_cuestionario'])->name('act_cuestionario');
Route::delete('estudiantecuestionario_destroy/{id}', [RecursoCuestionarioController::class, 'estudiantecuestionario_destroy'])->name('estudiantecuestionario_destroy');
Route::post('act_cuestionarioest', [RecursoCuestionarioController::class, 'act_cuestionarioest'])->name('act_cuestionarioest');
Route::post('edit_leccion', [RecursoCuestionarioController::class, 'edit_leccion'])->name('edit_leccion');
Route::get('inicio/cuestionario/{id}/{grupo}/{nromodulo}/ver_cuestionario', [RecursoCuestionarioController::class, 'ver_cuestionario'])->name('ver_cuestionario');