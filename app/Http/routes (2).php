<?php
use App\ComoNosConociste;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('usuario.index')->with('como_se_entero', ComoNosConociste::all());
// });

Route::get('/', function () {
    return view('usuario.index')->with('como_se_entero', ComoNosConociste::all());
});

Route::get('storage/imagenes/{archivo}', function ($archivo) {
     $public_path = public_path();
     $url = $public_path.'/imagenes/'.$archivo;
     //verificamos si el archivo existe y lo retornamos
     if (Storage::exists($archivo))
     {
       return response()->download($url);
     }
     //si no se encuentra lanzamos un error 404.
     abort(404);
 
});

Route::get('participante/alumno', 'AlumnoController@index');
Route::post('participante/alumno', 'AlumnoController@index');
Route::post('participante/alumno/agregar', 'AlumnoController@store');
Route::post('participante/alumno/eliminar/{id}', 'AlumnoController@destroy');
Route::get('participante/alumno/editar/{id}', 'AlumnoController@edit');
Route::post('participante/alumno/update/imagen', 'AlumnoController@updateImagen');

Route::get('participante/instructor', 'InstructorController@index');
Route::post('participante/instructor/agregar', 'InstructorController@store');
Route::post('participante/instructor/eliminar/{id}', 'InstructorController@destroy');

Route::get('participante/visitante', 'VisitanteController@index');
Route::post('participante/visitante/agregar', 'VisitanteController@store');
Route::post('participante/visitante/eliminar/{id}', 'VisitanteController@destroy');

Route::get('agendar/cursos', 'ClaseGrupalController@index');
Route::post('agendar/cursos/agregar', 'ClaseGrupalController@store');
Route::post('agendar/cursos/eliminar/{id}', 'ClaseGrupalController@destroy');
Route::get('agendar/cursos/inscripcion', 'ClaseGrupalController@inscripcion');

Route::get('agendar/clases_personalizadas', 'ClasePersonalizadaController@index');
Route::post('agendar/clases_personalizadas/agregar', 'ClasePersonalizadaController@store');
Route::post('agendar/clases_personalizadas/eliminar/{id}', 'ClasePersonalizadaController@destroy');

Route::get('agendar/fiestas', 'FiestaController@index');
Route::post('agendar/fiestas/agregar', 'FiestaController@store');
Route::post('agendar/fiestas/eliminar/{id}', 'FiestaController@destroy');

Route::get('agendar/talleres', 'TallerController@index');
Route::post('agendar/talleres/agregar', 'TallerController@store');
Route::post('agendar/talleres/eliminar/{id}', 'TallerController@destroy');

Route::get('agendar/shows', 'ShowController@index');
Route::post('agendar/shows/agregar', 'ShowController@store');
Route::post('agendar/shows/eliminar/{id}', 'ShowController@destroy');

Route::get('especiales/paquetes', 'PaqueteController@index');
Route::post('especiales/paquetes/agregar', 'PaqueteController@store');
Route::post('especiales/paquetes/eliminar/{id}', 'PaqueteController@destroy');

Route::get('especiales/regalos', 'RegaloController@index');
Route::post('especiales/regalos/agregar', 'RegaloController@store');

Route::get('especiales/campañas', 'CampanaController@index');
Route::post('especiales/campañas/agregar', 'CampanaController@store');
Route::post('especiales/campañas/eliminar/{id}', 'PaqueteController@destroy');

Route::get('especiales/promociones', 'PromocionController@index');
Route::post('especiales/promociones/agregar', 'PromocionController@store');
Route::post('especiales/promociones/eliminar/{id}', 'PromocionController@destroy');


Route::post('configuracion/carga-inicial/primer-paso', 'UsuarioController@store');
Route::post('configuracion/carga-inicial/segundo-paso', 'AcademiaController@PrimerPaso');
Route::post('configuracion/carga-inicial/contacto/', 'AcademiaController@SegundoPaso');
Route::post('configuracion/carga-inicial/especiales/', 'AcademiaController@updateContacto');
Route::post('configuracion/carga-inicial/administrativo/', 'AcademiaController@updateEspeciales');
Route::post('configuracion/carga-inicial/eliminar/{id}', 'CargaInicialController@destroy');


Route::get('contacto', 'ContactoController@index');
Route::post('contacto/enviar', 'ContactoController@send');
Route::get('login', 'LoginController@index');

Route::post('login/try', 'LoginController@login');

Route::get('administrativo/primer-paso', 'AdministrativoController@index');
Route::post('administrativo/segundo-paso', 'AdministrativoController@PrimerPaso');
Route::post('administrativo/factura', 'AdministrativoController@factura');

Route::get('/home', 'HomeController@index');
