<?php

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

Route::auth();

//EXTRA




Route::get('administrativo/prueba1', 'AdministrativoController@prueba1');
Route::get('administrativo/prueba2', 'AdministrativoController@prueba2');
Route::get('administrativo/prueba3', 'AdministrativoController@prueba3');

Route::get('/contacto', function () {
    return view('contacto.index');
});

//INICIO

Route::get('/prueba', function () {
    return view('avance.avance1.confirmatucuenta');
});

Route::get('/latam', function () {
    return view('empresa.latam');
});


Route::get('/inicio', 'AcademiaConfiguracionController@index');

Route::get('/inicio2', function () {
    return view('inicio.indexx');
});


Route::get('/listo', 'AcademiaConfiguracionController@listo');

Route::get('/pagina', function () {
    return view('pagina_web.index');
});

Route::get('/', function () {
    return view('menu.index');
});

//AGENDAR

Route::get('agendar','AgendarController@index');
Route::post('agendar','AgendarController@store');

//ALUMNO

Route::get('participante/alumno', 'AlumnoController@principal');
Route::get('participante/alumno/inactivos', 'AlumnoController@inactivos');
Route::post('participante/alumno/agregar', 'AlumnoController@store');
Route::get('participante/alumno/agregar', 'AlumnoController@create');
Route::delete('participante/alumno/eliminar/{id}', 'AlumnoController@destroy');
Route::post('participante/alumno/restablecer/{id}', 'AlumnoController@restore');
Route::get('participante/alumno/detalle/{id}', 'AlumnoController@edit');
Route::get('participante/alumno/operaciones/{id}', 'AlumnoController@operar');
Route::get('participante/alumno/deuda/{id}', 'AlumnoController@deuda');
Route::get('participante/alumno/historial/{id}', 'AlumnoController@historial');
Route::post('participante/alumno/sesion/{id}', 'AlumnoController@sesion');
Route::put('participante/alumno/update/identificacion','AlumnoController@updateID');
Route::put('participante/alumno/update/nombre','AlumnoController@updateNombre');
Route::put('participante/alumno/update/fecha_nacimiento','AlumnoController@updateFecha');
Route::put('participante/alumno/update/sexo','AlumnoController@updateSexo');
Route::put('participante/alumno/update/correo','AlumnoController@updateCorreo');
Route::put('participante/alumno/update/telefono','AlumnoController@updateTelefono');
Route::put('participante/alumno/update/direccion','AlumnoController@updateDireccion');
Route::put('participante/alumno/update/ficha','AlumnoController@updateFicha');

//INSTRUCTOR

Route::get('participante/instructor', 'InstructorController@index');
Route::post('participante/instructor/agregar', 'InstructorController@store');
Route::get('participante/instructor/agregar', 'InstructorController@create');
Route::delete('participante/instructor/eliminar/{id}', 'InstructorController@destroy');
Route::get('participante/instructor/detalle/{id}', 'InstructorController@edit');
Route::get('participante/instructor/operaciones/{id}', 'InstructorController@operar');
Route::put('participante/instructor/update/identificacion','InstructorController@updateID');
Route::put('participante/instructor/update/nombre','InstructorController@updateNombre');
Route::put('participante/instructor/update/fecha_nacimiento','InstructorController@updateFecha');
Route::put('participante/instructor/update/sexo','InstructorController@updateSexo');
Route::put('participante/instructor/update/correo','InstructorController@updateCorreo');
Route::put('participante/instructor/update/telefono','InstructorController@updateTelefono');
Route::put('participante/instructor/update/direccion','InstructorController@updateDireccion');
Route::put('participante/instructor/update/ficha','InstructorController@updateFicha');
Route::put('participante/instructor/update/estatus','InstructorController@updateEstatus');

//VISITANTE

Route::get('participante/visitante', 'VisitanteController@index');
Route::post('participante/visitante/agregar', 'VisitanteController@store');
Route::get('participante/visitante/agregar', 'VisitanteController@create');
Route::post('participante/visitante/eliminar/{id}', 'VisitanteController@destroy');
Route::get('participante/visitante/detalle/{id}', 'VisitanteController@edit');
Route::put('participante/visitante/update/identificacion','VisitanteController@updateID');
Route::put('participante/visitante/update/nombre','VisitanteController@updateNombre');
Route::put('participante/visitante/update/fecha_nacimiento','VisitanteController@updateFecha');
Route::put('participante/visitante/update/sexo','VisitanteController@updateSexo');
Route::put('participante/visitante/update/correo','VisitanteController@updateCorreo');
Route::put('participante/visitante/update/telefono','VisitanteController@updateTelefono');
Route::put('participante/visitante/update/direccion','VisitanteController@updateDireccion');
Route::put('participante/visitante/update/como_se_entero','VisitanteController@updateComoSeEntero');
Route::put('participante/visitante/update/especialidad','VisitanteController@updateEspecialidad');

//PROVEEDOR

Route::get('participante/proveedor', 'ProveedorController@principal');
Route::post('participante/proveedor/agregar', 'ProveedorController@store');
Route::get('participante/proveedor/agregar', 'ProveedorController@create');
Route::delete('participante/proveedor/eliminar/{id}', 'ProveedorController@destroy');
Route::get('participante/proveedor/detalle/{id}', 'ProveedorController@edit');
Route::get('participante/proveedor/operaciones/{id}', 'ProveedorController@operar');
Route::put('participante/proveedor/update/nombre','ProveedorController@updateNombre');
Route::put('participante/proveedor/update/fecha_nacimiento','ProveedorController@updateFecha');
Route::put('participante/proveedor/update/sexo','ProveedorController@updateSexo');
Route::put('participante/proveedor/update/correo','ProveedorController@updateCorreo');
Route::put('participante/proveedor/update/telefono','ProveedorController@updateTelefono');
Route::put('participante/proveedor/update/direccion','ProveedorController@updateDireccion');
Route::put('participante/proveedor/update/empresa','ProveedorController@updateEmpresa');

//CLASES GRUPALES

Route::get('agendar/clases-grupales', 'ClaseGrupalController@principal');
Route::post('agendar/clases-grupales/agregar', 'ClaseGrupalController@store');
Route::get('agendar/clases-grupales/agregar', 'ClaseGrupalController@create');
Route::get('agendar/clases-grupales/detalle/{id}', 'ClaseGrupalController@edit');
Route::get('agendar/clases-grupales/operaciones/{id}', 'ClaseGrupalController@operar');
Route::delete('agendar/clases-grupales/eliminar/{id}', 'ClaseGrupalController@destroy');
Route::post('agendar/clases-grupales/inscribir', 'ClaseGrupalController@storeInscripcion');
Route::post('agendar/clases-grupales/alumnos', 'ClaseGrupalController@getAlumnos');
Route::post('agendar/clases-grupales/alumnos/eliminar', 'ClaseGrupalController@eliminarAlumnos');
Route::post('agendar/clases-grupales/agregarhorario', 'ClaseGrupalController@agregarhorario');
Route::post('agendar/clases-grupales/eliminarhorario/{id}', 'ClaseGrupalController@eliminarhorario');
Route::get('agendar/clases-grupales/progreso/{id}', 'ClaseGrupalController@progreso');

Route::put('agendar/clases-grupales/update/nombre', 'ClaseGrupalController@updateNombre');
Route::put('agendar/clases-grupales/update/fecha', 'ClaseGrupalController@updateFecha');
Route::put('agendar/clases-grupales/update/fechacobro', 'ClaseGrupalController@updateFechaCobro');
Route::put('agendar/clases-grupales/update/especialidad', 'ClaseGrupalController@updateEspecialidad');
Route::put('agendar/clases-grupales/update/instructor', 'ClaseGrupalController@updateInstructor');
Route::put('agendar/clases-grupales/update/nivel_baile', 'ClaseGrupalController@updateNivelBaile');
Route::put('agendar/clases-grupales/update/horario', 'ClaseGrupalController@updateHorario');
Route::put('agendar/clases-grupales/update/estudio', 'ClaseGrupalController@updateEstudio');
Route::put('agendar/clases-grupales/update/cupo', 'ClaseGrupalController@updateCupos');
Route::put('agendar/clases-grupales/update/cuporeservacion', 'ClaseGrupalController@updateCuposOnline');
Route::put('agendar/clases-grupales/update/video', 'ClaseGrupalController@updateLink');
Route::put('agendar/clases-grupales/update/imagen', 'ClaseGrupalController@updateImagen');

Route::post('agendar/clases-grupales/update/inscripcion', 'ClaseGrupalController@updateInscripcion');
Route::post('agendar/clases-grupales/update/mensualidad', 'ClaseGrupalController@updateMensualidad');
Route::post('agendar/clases-grupales/update/fecha_pago', 'ClaseGrupalController@updateFechaPago');

Route::get('agendar/clases-grupales/inscribir/{id}', 'ClaseGrupalController@inscribir');
Route::get('agendar/clases-grupales/participantes/{id}', 'ClaseGrupalController@participantes');
Route::delete('agendar/clases-grupales/eliminarinscripcion/{id}', 'ClaseGrupalController@eliminarinscripcion');

//CLASES PERSONALIZADAS

Route::get('agendar/clases-personalizadas', 'ClasePersonalizadaController@index');
Route::get('agendar/clases-personalizadas/agregar', 'ClasePersonalizadaController@create');
Route::post('agendar/clases-personalizadas/agregar', 'ClasePersonalizadaController@store');
Route::get('agendar/clases-personalizadas/detalle/{id}', 'ClasePersonalizadaController@edit');
Route::get('agendar/clases-personalizadas/operaciones/{id}', 'ClasePersonalizadaController@operar');
Route::delete('agendar/clases-personalizadas/eliminar/{id}', 'ClasePersonalizadaController@destroy');

Route::put('agendar/clases-personalizadas/update/nombre', 'ClasePersonalizadaController@updateNombre');
Route::put('agendar/clases-personalizadas/update/fecha', 'ClasePersonalizadaController@updateFecha');
Route::put('agendar/clases-personalizadas/update/especialidad', 'ClasePersonalizadaController@updateEspecialidad');
Route::put('agendar/clases-personalizadas/update/instructor', 'ClasePersonalizadaController@updateInstructor');
Route::put('agendar/clases-personalizadas/update/alumno', 'ClasePersonalizadaController@updateAlumno');
Route::put('agendar/clases-personalizadas/update/horario', 'ClasePersonalizadaController@updateHorario');
Route::put('agendar/clases-personalizadas/update/estudio', 'ClasePersonalizadaController@updateEstudio');
;
Route::put('agendar/clases-personalizadas/update/descripcion', 'ClasePersonalizadaController@updateDescripcion');
Route::put('agendar/clases-personalizadas/update/condiciones', 'ClasePersonalizadaController@updateCondiciones');

//TALLERES

Route::get('agendar/talleres', 'TallerController@index');
Route::post('agendar/talleres/agregar', 'TallerController@store');
Route::get('agendar/talleres/agregar', 'TallerController@create');
Route::get('agendar/talleres/detalle/{id}', 'TallerController@edit');
Route::get('agendar/talleres/operaciones/{id}', 'TallerController@operar');
Route::delete('agendar/talleres/eliminar/{id}', 'TallerController@destroy');
Route::get('agendar/talleres/participantes/{id}', 'TallerController@participantes');
Route::delete('agendar/talleres/eliminarinscripcion/{id}', 'TallerController@eliminarinscripcion');
Route::post('agendar/talleres/inscribir', 'TallerController@storeInscripcion');

Route::put('agendar/talleres/update/nombre', 'TallerController@updateNombre');
Route::put('agendar/talleres/update/costo', 'TallerController@updateCosto');
Route::put('agendar/talleres/update/descripcion', 'TallerController@updateDescripcion');
Route::put('agendar/talleres/update/fecha', 'TallerController@updateFecha');
Route::put('agendar/talleres/update/especialidad', 'TallerController@updateEspecialidad');
Route::put('agendar/talleres/update/instructor', 'TallerController@updateInstructor');
Route::put('agendar/talleres/update/horario', 'TallerController@updateHorario');
Route::put('agendar/talleres/update/estudio', 'TallerController@updateEstudio');
Route::put('agendar/talleres/update/video', 'TallerController@updateLink');
Route::put('agendar/talleres/update/cupo', 'TallerController@updateCupos');
Route::put('agendar/talleres/update/imagen', 'TallerController@updateImagen');

Route::post('agendar/talleres/update/costo_taller', 'TallerController@updateCostoTaller');



//FIESTAS

Route::get('agendar/fiestas', 'FiestaController@index');
Route::post('agendar/fiestas/agregar', 'FiestaController@store');
Route::get('agendar/fiestas/agregar', 'FiestaController@create');
Route::get('agendar/fiestas/detalle/{id}', 'FiestaController@edit');
Route::get('agendar/fiestas/operaciones/{id}', 'FiestaController@operar');
Route::delete('agendar/fiestas/eliminar/{id}', 'FiestaController@destroy');
Route::post('agendar/fiestas/agregarboleto', 'FiestaController@agregarboleto');
Route::post('agendar/fiestas/eliminarboleto/{id}', 'FiestaController@eliminarboleto');
Route::post('agendar/fiestas/agregarhorario', 'FiestaController@agregarhorario');
Route::post('agendar/fiestas/eliminarhorario/{id}', 'FiestaController@eliminarhorario');

Route::put('agendar/fiestas/update/nombre', 'FiestaController@updateNombre');
Route::put('agendar/fiestas/update/descripcion', 'FiestaController@updateDescripcion');
Route::put('agendar/fiestas/update/fecha', 'FiestaController@updateFecha');
Route::put('agendar/fiestas/update/horario', 'FiestaController@updateHorario');
Route::put('agendar/fiestas/update/lugar', 'FiestaController@updateLugar');
Route::put('agendar/fiestas/update/video', 'FiestaController@updateLink');
Route::put('agendar/fiestas/update/condiciones', 'FiestaController@updateCondiciones');
Route::put('agendar/fiestas/update/imagen', 'FiestaController@updateImagen');

//PROMOCIONES

Route::get('especiales/promociones', 'PromocionController@principal');
Route::post('especiales/promociones/agregar', 'PromocionController@store');
Route::get('especiales/promociones/agregar', 'PromocionController@create');
Route::delete('especiales/promociones/eliminar/{id}', 'PromocionController@destroy');
Route::get('especiales/promociones/detalle/{id}', 'PromocionController@edit');
Route::get('especiales/promociones/operaciones/{id}', 'PromocionController@operar');
Route::get('especiales/promociones/codigo', 'PromocionController@codigo');
Route::post('especiales/promociones/generarcodigo', 'PromocionController@GenerarCodigo');
Route::get('especiales/promociones/validar', 'PromocionController@validar');
Route::post('especiales/promociones/validarcodigo', 'PromocionController@ValidarCodigo');

Route::put('especiales/promociones/update/nombre', 'PromocionController@updateNombre');
Route::put('especiales/promociones/update/porcentaje', 'PromocionController@updatePorcentaje');
Route::put('especiales/promociones/update/descripcion', 'PromocionController@updateDescripcion');
Route::put('especiales/promociones/update/fecha', 'PromocionController@updateFecha');
Route::put('especiales/promociones/update/sexo', 'PromocionController@updateSexo');
Route::put('especiales/promociones/update/edad', 'PromocionController@updateEdad');

// //EXAMENES

// Route::get('especiales/examenes', 'ExamenController@principal');
// Route::get('especiales/examenes/agregar', 'ExamenController@create');
// Route::post('especiales/examenes/agregar', 'ExamenController@store');
// Route::get('especiales/examenes/detalle/{id}', 'ExamenController@edit');
// Route::get('especiales/examenes/operaciones/{id}', 'ExamenController@operar');
// Route::delete('especiales/examenes/eliminar/{id}', 'ExamenController@destroy');

// Route::put('especiales/examenes/update/nombre', 'ExamenController@updateNombre');
// Route::put('especiales/examenes/update/descripcion', 'ExamenController@updateDescripcion');
// Route::put('especiales/examenes/update/fecha', 'ExamenController@updateFecha');
// Route::put('especiales/examenes/update/instructor', 'ExamenController@updateInstructor');
// Route::get('especiales/examenes/evaluar/{id}', 'ExamenController@evaluar');

//CAMPAÑAS

Route::get('especiales/campañas', 'CampanaController@index');
Route::get('especiales/campañas/agregar', 'CampanaController@create');
Route::post('especiales/campañas/agregar', 'CampanaController@store');
Route::get('especiales/campañas/detalle/{id}', 'CampanaController@edit');
Route::get('especiales/campañas/operaciones/{id}', 'CampanaController@operar');
Route::delete('especiales/campañas/eliminar/{id}', 'CampanaController@destroy');

Route::put('especiales/campañas/update/nombre', 'CampanaController@updateNombre');
Route::put('especiales/campañas/update/historia', 'CampanaController@updateHistoria');
Route::put('especiales/campañas/update/eslogan', 'CampanaController@updateEslogan');
Route::put('especiales/campañas/update/cantidad', 'CampanaController@updateCantidad');
Route::put('especiales/campañas/update/plazo', 'CampanaController@updatePlazo');
Route::put('especiales/campañas/update/video', 'CampanaController@updateLink');
Route::put('especiales/campañas/update/datos', 'CampanaController@updateDatosBancarios');
Route::post('especiales/campañas/agregarrecompensa', 'CampanaController@agregarrecompensa');
Route::post('especiales/campañas/eliminarrecompensa/{id}', 'CampanaController@eliminarrecompensa');

//REGALOS

Route::get('especiales/regalos/agregar', 'RegaloController@create');
Route::post('especiales/regalos/agregar', 'RegaloController@store');

// ---- CONFIGURACION ----

Route::get('configuracion', function () {
    return view('configuracion.index');

});

// ACADEMIA

Route::get('configuracion/academia','AcademiaConfiguracionController@configuracion');

Route::post('configuracion/academia/primerpaso','AcademiaConfiguracionController@PrimerPaso');

Route::post('configuracion/academia/contacto','AcademiaConfiguracionController@storeContacto');
Route::post('configuracion/academia/especiales','AcademiaConfiguracionController@storeEspeciales');
Route::post('configuracion/academia/administrativo','AcademiaConfiguracionController@storeAdministrativo');
Route::post('configuracion/academia/estudio','AcademiaConfiguracionController@agregarestudio');
Route::post('configuracion/academia/eliminarestudio/{id}','AcademiaConfiguracionController@eliminarestudio');
Route::post('configuracion/academia/nivel','AcademiaConfiguracionController@agregarnivel');
Route::post('configuracion/academia/eliminarnivel/{id}','AcademiaConfiguracionController@eliminarniveles');
Route::post('configuracion/academia/completar','AcademiaConfiguracionController@store');

Route::put('configuracion/academia/update/contacto', 'AcademiaConfiguracionController@updateContacto');
Route::put('configuracion/academia/update/imagen', 'AcademiaConfiguracionController@updateImagen');
Route::put('configuracion/academia/update/redes', 'AcademiaConfiguracionController@updateRedes');
Route::put('configuracion/academia/update/especiales', 'AcademiaConfiguracionController@updateEspeciales');
Route::put('configuracion/academia/update/administrativo', 'AcademiaConfiguracionController@updateAdministrativo');

// PRODUCTOS

Route::get('configuracion/productos','ConfigProductosController@principalproductos');
Route::get('configuracion/productos/agregar','ConfigProductosController@agregarproductos');
Route::post('configuracion/productos/agregar','ConfigProductosController@store');
Route::get('configuracion/productos/detalle/{id}', 'ConfigProductosController@edit');
Route::delete('configuracion/productos/eliminar/{id}', 'ConfigProductosController@destroy');

Route::put('configuracion/productos/update/nombre', 'ConfigProductosController@updateNombre');
Route::put('configuracion/productos/update/costo', 'ConfigProductosController@updateCosto');
Route::put('configuracion/productos/update/descripcion', 'ConfigProductosController@updateDescripcion');
Route::put('configuracion/productos/update/impuesto', 'ConfigProductosController@updateImpuesto');
Route::put('configuracion/productos/update/imagen', 'ConfigProductosController@updateImagen');


// SERVICIOS

Route::get('configuracion/servicios','ConfigServiciosController@principalservicios');
Route::get('configuracion/servicios/agregar','ConfigServiciosController@agregarservicios');
Route::post('configuracion/servicios/agregar','ConfigServiciosController@store');
Route::get('configuracion/servicios/detalle/{id}', 'ConfigServiciosController@edit');
Route::delete('configuracion/servicios/eliminar/{id}', 'ConfigServiciosController@destroy');

Route::put('configuracion/servicios/update/nombre', 'ConfigServiciosController@updateNombre');
Route::put('configuracion/servicios/update/costo', 'ConfigServiciosController@updateCosto');
Route::put('configuracion/servicios/update/descripcion', 'ConfigServiciosController@updateDescripcion');
Route::put('configuracion/servicios/update/opciones', 'ConfigServiciosController@updateOpciones');
Route::put('configuracion/servicios/update/impuesto', 'ConfigServiciosController@updateImpuesto');
Route::put('configuracion/servicios/update/imagen', 'ConfigServiciosController@updateImagen');

// CLASES GRUPALES

Route::get('configuracion/clases-grupales','ConfigClasesGrupalesController@principalclases');
Route::get('configuracion/clases-grupales/agregar','ConfigClasesGrupalesController@agregarclases');
Route::post('configuracion/clases-grupales/agregar','ConfigClasesGrupalesController@store');
Route::get('configuracion/clases-grupales/detalle/{id}', 'ConfigClasesGrupalesController@edit');
Route::delete('configuracion/clases-grupales/eliminar/{id}', 'ConfigClasesGrupalesController@destroy');

Route::put('configuracion/clases-grupales/update/nombre', 'ConfigClasesGrupalesController@updateNombre');
Route::put('configuracion/clases-grupales/update/costoinscripcion', 'ConfigClasesGrupalesController@updateCostoInscripcion');
Route::put('configuracion/clases-grupales/update/costomensualidad', 'ConfigClasesGrupalesController@updateCostoMensualidad');
Route::put('configuracion/clases-grupales/update/descripcion', 'ConfigClasesGrupalesController@updateDescripcion');
Route::put('configuracion/clases-grupales/update/impuesto', 'ConfigClasesGrupalesController@updateImpuesto');

// COREOGRAFIA

Route::get('configuracion/coreografias','CoreografiaController@principal');
Route::get('configuracion/coreografias/agregar','CoreografiaController@create');
Route::post('configuracion/coreografias/agregar','CoreografiaController@store');
Route::get('configuracion/coreografias/detalle/{id}', 'CoreografiaController@edit');
Route::get('configuracion/coreografias/operaciones/{id}', 'CoreografiaController@operar');
Route::get('configuracion/coreografias/participantes/{id}', 'CoreografiaController@participantes');
Route::post('configuracion/coreografias/inscribir', 'CoreografiaController@storeInscripcion');

// --- ADMINISTRATIVO --- 

//PAGOS

Route::get('administrativo/pagos', 'AdministrativoController@principalpagos');
Route::get('administrativo/pagos/generar', 'AdministrativoController@generarpagos');
Route::get('administrativo/pagos/generar/{id}', 'AdministrativoController@generarpagoscondeuda');
Route::delete('administrativo/pagos/eliminardeuda/{id}', 'AdministrativoController@eliminardeuda');
Route::post('administrativo/pagos/agregaritem', 'AdministrativoController@agregaritem');
Route::post('administrativo/pagos/eliminaritem/{id}', 'AdministrativoController@eliminaritem');
Route::post('administrativo/pagos/itemspendientes/{id}', 'AdministrativoController@itemspendientes');
Route::post('administrativo/pagos/proforma', 'AdministrativoController@storeProforma');
Route::post('administrativo/pagos/cancelarpago', 'AdministrativoController@CancelarPago');

Route::post('administrativo/pagos/gestion', 'AdministrativoController@gestion');
Route::get('administrativo/pagos/gestion', 'AdministrativoController@gestionar');
Route::get('administrativo/pagos/gestion/{id}', 'AdministrativoController@gestionardeuda');
Route::post('administrativo/pagos/agregarpago', 'AdministrativoController@agregarpago');
Route::post('administrativo/pagos/eliminarpago/{id}', 'AdministrativoController@eliminarpago');
Route::post('administrativo/pagos/cancelargestion', 'AdministrativoController@CancelarGestion');

Route::post('administrativo/pagos/factura/{id}', 'AdministrativoController@storeFactura');


//ACUERDOS

Route::get('administrativo/acuerdos', 'AdministrativoController@principalacuerdo');
Route::get('administrativo/acuerdos/generar', 'AdministrativoController@acuerdo');
Route::get('administrativo/acuerdos/generar/{id}', 'AdministrativoController@acuerdoconalumno');
Route::post('administrativo/acuerdo/generar', 'AdministrativoController@generar_acuerdo');
Route::post('administrativo/pagos/pendiente/{id}', 'AdministrativoController@pagospendientes');
Route::post('administrativo/acuerdo/guardar', 'AdministrativoController@storeAcuerdo');

//PRESUPUESTOS

Route::get('administrativo/presupuestos', 'AdministrativoController@principalpresupuesto');
Route::get('administrativo/presupuestos/detalle/{id}', 'AdministrativoController@detallepresupuesto');
Route::get('administrativo/presupuestos/generar', 'AdministrativoController@presupuesto');
Route::post('administrativo/presupuestos/generar', 'AdministrativoController@GenerarPresupuesto');
Route::post('administrativo/presupuestos/agregaritem', 'AdministrativoController@agregaritempresupuesto');
Route::post('administrativo/presupuestos/eliminaritem/{id}', 'AdministrativoController@eliminaritempresupuesto');
Route::delete('administrativo/presupuestos/eliminar/{id}', 'AdministrativoController@eliminarpresupuesto');

//FACTURA

Route::get('administrativo/factura/{id}', 'AdministrativoController@getFactura');
Route::post('administrativo/factura/enviar/{id}', 'AdministrativoController@enviarfactura');

// REPORTES

// Route::get('administrativo/reporte', function () {
//     return view('administrativo.reporte');
// });

Route::get('reportes/inscritos', 'ReporteController@Inscritos');
Route::get('reportes/presenciales', 'ReporteController@Presenciales');
Route::get('reportes/contactos', 'ReporteController@Contactos');

/*
|------------------
|GUIA
|------------------
*/

Route::get('participante/alumno/transferir/{id}', function ($id) {
	Session::put('id_alumno', $id);
	return view('guia.transferir')->with('id', Session::get('id_alumno'));
});

Route::get('participante/alumno/enhorabuena/{id}', function ($id) {
	Session::put('id_alumno', $id);
    return view('guia.index');
});

Route::get('agendar/clases-grupales/enhorabuena/{id}', 'ClaseGrupalController@enhorabuena');
Route::get('agendar/clases-personalizadas/enhorabuena/{id}', 'ClaseGrupalController@enhorabuena');
Route::get('agendar/talleres/enhorabuena/{id}', 'ClaseGrupalController@enhorabuena');

Route::get('guia/pay', function () {
    return view('guia.index3');
});
Route::get('validar', function () {
    return view('guia.validar');
});
Route::get('guia/codigo-validado', function () {
    return view('guia.codigo_validado');
});
Route::get('guia/codigo-invalido', function () {
    return view('guia.codigo_invalido');
});

// FOOTER

Route::get('soporte/acuerdo', function () {
    return view('soporte.acuerdo_servicio');
});
Route::get('soporte/politicas', function () {
    return view('soporte.politicas');
});

Route::get('soporte/normas', function () {
    return view('soporte.normas');
});

Route::get('empresa/sobre-la-empresa', function () {
    return view('empresa.index');
});

Route::get('empresa/embajadores', function () {
    return view('empresa.embajadores');
});

//EMBAJADOR

Route::get('/invitar', 'EmbajadorController@index');

Route::post('/invitar', 'EmbajadorController@invitar');

Route::get('invitar/enhorabuena', function () {
    return view('empresa.enhorabuena');
});
Route::post('/embajadores/agregar', 'EmbajadorController@agregarlinea');
Route::post('/embajadores/eliminar/{id}', 'EmbajadorController@eliminarlinea');

// LOGIN

Route::get('/login', 'Auth\AuthController@getLogin');
Route::post('/login', 'Auth\AuthController@postLogin');
Route::get('/logout', 'Auth\AuthController@getLogout');


// RESTABLECIMIENTO DE CONTRASEÑA

Route::get('/restablecer', function () {
    return view('login.contrasena.restablecer');
});

Route::get('/restablecer/confirmar', function () {
    return view('login.contrasena.salvavidas');
});

Route::get('/restablecer/completado', function () {
    return view('login.contrasena.completado');
});

Route::get('/restablecer/fallo', function () {
    return view('login.contrasena.fallo');
});

// FLUJO DE REGISTRO


Route::get('/registro','RegistroController@create');
Route::post('/registro', 'Auth\AuthController@postRegister');

Route::get('/registro/completado', function () {
    return view('flujo_registro.registro_completado');
});

// CORREO

Route::get('/correo','CorreoController@index');
Route::get('/correo/{id}','CorreoController@indexsinselector');
Route::post('/correo/sesion/{id}', 'CorreoController@Sesion');
Route::post('/correo/cumpleaños', 'CorreoController@correoCumpleaños');
Route::post('/correo/ausencia', 'CorreoController@correoAusencia');
Route::post('/correo/cobro', 'CorreoController@correoCobro');
Route::post('/correo/suspension', 'CorreoController@correoSuspension');
Route::post('/correo/adelanto', 'CorreoController@correoAdelanto');

// USUARIO

Route::get('perfil', 'UsuarioController@perfil');
Route::put('perfil/update/imagen', 'UsuarioController@updateImagen');
Route::put('perfil/update/nombre','UsuarioController@updateNombre');
Route::put('perfil/update/sexo','UsuarioController@updateSexo');
Route::put('perfil/update/correo','UsuarioController@updateCorreo');
Route::put('perfil/update/telefono','UsuarioController@updateTelefono');
Route::put('perfil/update/direccion','UsuarioController@updateDireccion');
Route::put('perfil/update/redes','UsuarioController@updateRedes');
Route::put('perfil/update/password','UsuarioController@updatePassword');


// ASISTENCIA

Route::get('asistencia/consulta/clases-grupales/{id}', 'AsistenciaController@consulta_clase_grupales_alumno');
Route::get('asistencia/consulta/clases-grupales', 'AsistenciaController@consulta_clase_grupales');
Route::post('asistencia/agregar', 'AsistenciaController@store');
Route::post('asistencia/agregar/permitir', 'AsistenciaController@storePermitir');
Route::post('asistencia/agregar/instructor', 'AsistenciaController@storeInstructor');
Route::post('asistencia/agregar/instructor/permitir', 'AsistenciaController@storeInstructorPermitir');

Route::get('/asistencia', 'AsistenciaController@principal');

// RESERVACION

Route::post('reservacion/{id}', 'ReservaController@GuardarTipo');
Route::post('reservar', 'ReservaController@store');

Route::get('/reservacion/completado', function () {
    return view('reserva.reserva_completado');
});

Route::get('reservacion/{id}','ReservaController@reserva');


