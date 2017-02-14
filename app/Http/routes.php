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

Route::get('error', 'AcademiaConfiguracionController@error');

Route::get('/confirmacion/{token}', [
    'uses' => 'RegistroController@confirmacion',
    'as'   => 'confirmacion'
]);

Route::get('todos-con-robert', 'CampanaController@todos_con_robert');

Route::auth();

// FLUJO DE REGISTRO

Route::get('/registro','RegistroController@registrar');
Route::post('/registro', 'RegistroController@postRegister');
Route::get('/registro/completado', 'RegistroController@completado');

// ACTIVAR CUENTA

Route::get('/activar','RegistroController@activar');
Route::post('/activar', 'CorreoController@correoActivacion');
Route::get('/activar/completado', 'RegistroController@activarcompletado');

// RESTABLECIMIENTO DE CONTRASEÑA

Route::get('/restablecer', 'LoginController@restablecer');
Route::get('/restablecer/confirmar', 'LoginController@restablecerconfirmar');
Route::get('/restablecer/fallo', 'LoginController@restablecerfallo');
Route::get('/restablecer/completado', 'LoginController@restablecercompletado');

// LOGIN

Route::get('/login', 'LoginController@getLogin');
Route::post('/login', 'LoginController@postLogin');

// RESERVACION


Route::get('agendar/reservaciones/actividades/{id}','ReservaController@principal');
Route::post('agendar/reservaciones/agregar','ReservaController@guardar_reservacion_visitante');
Route::get('reservacion/{id}','ReservaController@reserva');
Route::post('reservacion/{id}', 'ReservaController@GuardarTipo');
Route::post('reservar', 'ReservaController@store');
Route::post('reservarconusuario', 'ReservaController@storeconusuario');
Route::get('agendar/reservacion/completado', 'ReservaController@completado');


//EMPRESA

Route::get('empresa/sobre-la-empresa', 'EmpresaController@index');

//EMBAJADOR

Route::get('empresa/embajadores', 'EmbajadorController@principal');
Route::post('/embajadores/agregar', 'EmbajadorController@agregarlinea');
Route::post('/embajadores/eliminar/{id}', 'EmbajadorController@eliminarlinea');


// REGALO USUARIO

Route::get('especiales/regalos/disponibles/{id}', 'RegaloController@indexconacademia');
Route::get('especiales/regalos', 'RegaloController@index');
Route::get('especiales/regalos/progreso/{id}', 'RegaloController@progreso');
Route::get('especiales/regalos/enviar/{id}', 'RegaloController@CrearRegaloUsuario');
Route::post('especiales/regalos/enviar', 'RegaloController@EnviarRegaloUsuario');

// CLASES PERSONALIZADAS USUARIO

Route::get('agendar/clases-personalizadas/disponibles/{id}', 'ClasePersonalizadaController@indexconacademia');
Route::get('agendar/clases-personalizadas', 'ClasePersonalizadaController@index');
Route::get('agendar/clases-personalizadas/progreso/{id}', 'ConfigClasePersonalizadaController@progreso');
Route::get('agendar/clases-personalizadas/agregar/{id}', 'ClasePersonalizadaController@reservacion');

// CLASES GRUPALES USUARIO

Route::get('agendar/clases-grupales/disponibles/{id}', 'ClaseGrupalController@indexconacademia');
Route::get('agendar/clases-grupales/progreso/{id}', 'ClaseGrupalController@progreso');

// PROGRESO

Route::post('agendar/clases-grupales/inscribirse', 'ClaseGrupalController@storeInscripcionVistaAlumno');
Route::post('agendar/talleres/inscribirse', 'TallerController@storeInscripcionVistaAlumno');
Route::get('agendar/talleres/progreso/{id}', 'TallerController@progreso');

// CAMPAÑAS

Route::get('especiales/campañas/progreso/{id}', 'CampanaController@progreso');

Route::post('especiales/campañas/contribuir', 'CampanaController@storePatrocinador');
Route::post('especiales/campañas/contribuir/contribucion', 'CampanaController@storeTransferencia');
Route::get('especiales/campañas/contribuir/campaña/{id}', 'CampanaController@contribuirCampana');
Route::get('especiales/campañas/contribuir/recompensa/{id}', 'CampanaController@contribuirRecompensa');
Route::post('especiales/campañas/contribuir/participante-externo', 'CampanaController@contribuirExterno');
Route::get('especiales/campañas/contribuir/participante-externo', 'CampanaController@procesarExterno');
Route::get('especiales/campañas/contribuir/mercadopago', 'CampanaController@procesarExterno');

Route::post('especiales/campañas/contribuir/mercadopago', 'CampanaController@storeMercadopago');

Route::get('especiales/campañas/contribuir/enhorabuena/{id}', 'CampanaController@enhorabuena');

Route::get('especiales/campañas/invitar/{id}', 'CampanaController@principalinvitar');
Route::post('especiales/campañas/invitar/agregar', 'CampanaController@agregarlinea');
Route::post('especiales/campañas/invitar/eliminar/{id}', 'CampanaController@eliminarlinea');
Route::post('especiales/campañas/invitar', 'CampanaController@invitar');	
Route::get('especiales/campañas/invitacion/enhorabuena/{id}', 'CampanaController@enhorabuena_invitacion');
Route::get('especiales/campañas/invitacion/enhorabuena', 'CampanaController@enhorabuena_invitacion_sinid');

Route::group(['middleware' => ['auth','verified'] ], function () {

		Route::get('notificacion', 'NotificacionController@consulta');

		Route::get('/logout', 'Auth\AuthController@getLogout');

		// DESDE AQUI NECESITAN ESTAR AUTENTICADO


		/*------------------------------------------------------
		//MIDDLEWARE ADMINISTRADOR
		//RUTAS QUE SOLAMENTE PODRA TENER ACCESO EL ROL ADMIN
		------------------------------------------------------*/
		Route::group(['middleware' => ['admin']], function() {
			
			//EXAMENES

			Route::get('especiales/examenes', 'ExamenController@principal');
			Route::get('especiales/examenes/agregar', 'ExamenController@create');
			Route::post('especiales/examenes/agregar', 'ExamenController@store');
			Route::get('especiales/examenes/detalle/{id}', 'ExamenController@edit');
			Route::get('especiales/examenes/operaciones/{id}', 'ExamenController@operar');
			Route::delete('especiales/examenes/eliminar/{id}', 'ExamenController@destroy');
			
			Route::put('especiales/examenes/update/nombre', 'ExamenController@updateNombre');
			Route::put('especiales/examenes/update/descripcion', 'ExamenController@updateDescripcion');
			Route::put('especiales/examenes/update/fecha', 'ExamenController@updateFecha');
			Route::put('especiales/examenes/update/proxima_fecha', 'ExamenController@updateProximaFecha');
			Route::put('especiales/examenes/update/instructor', 'ExamenController@updateInstructor');
			Route::put('especiales/examenes/update/generos', 'ExamenController@updateGeneros');
			Route::put('especiales/examenes/update/tipos_de_evaluacion', 'ExamenController@updateTipos');
			Route::put('especiales/examenes/update/items', 'ExamenController@updateItem');
			Route::get('especiales/examenes/evaluar/{id}', 'ExamenController@evaluar');
			Route::post('especiales/examenes/agregar_item','ExamenController@agregar_item');
			Route::post('especiales/examenes/eliminar_item/{id}','ExamenController@eliminar_item');
			Route::post('especiales/examenes/actualizar_item','ExamenController@actualizar_item');
			Route::post('especiales/examenes/eliminar_item_fijo/{id}','ExamenController@eliminar_item_fijo');

			//EVALUACION (SERIAN LOS RESULTADOS DE LOS EXAMENES)
			Route::get('especiales/evaluaciones', 'EvaluacionController@index');
			Route::get('especiales/evaluaciones/{id}', 'EvaluacionController@evaluaciones');
			Route::post('especiales/evaluaciones/agregar', 'EvaluacionController@store');			

			// ---- CONFIGURACION ----

			Route::get('configuracion', 'AcademiaConfiguracionController@principal');

			// SUCURSAL

			Route::get('configuracion/administradores','AdministradorController@principal');
			Route::get('configuracion/administradores/agregar','AdministradorController@create');
			Route::post('configuracion/administradores/agregar','AdministradorController@store');

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
			Route::post('configuracion/academia/update/especiales', 'AcademiaConfiguracionController@updateEspeciales');
			Route::put('configuracion/academia/update/administrativo', 'AcademiaConfiguracionController@updateAdministrativo');
			Route::put('configuracion/academia/update/referido', 'AcademiaConfiguracionController@updateReferido');

			// PRODUCTOS

			Route::get('configuracion/productos','ConfigProductosController@principalproductos');
			Route::get('configuracion/productos/agregar','ConfigProductosController@agregarproductos');
			Route::post('configuracion/productos/agregar','ConfigProductosController@store');
			Route::get('configuracion/productos/detalle/{id}', 'ConfigProductosController@edit');
			Route::delete('configuracion/productos/eliminar/{id}', 'ConfigProductosController@destroy');

			Route::put('configuracion/productos/update/nombre', 'ConfigProductosController@updateNombre');
			Route::put('configuracion/productos/update/costo', 'ConfigProductosController@updateCosto');
			Route::put('configuracion/productos/update/cantidad', 'ConfigProductosController@updateCantidad');
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
			Route::put('configuracion/clases-grupales/update/condiciones', 'ConfigClasesGrupalesController@updateCondiciones');
			Route::put('configuracion/clases-grupales/update/imagen', 'ConfigClasesGrupalesController@updateImagen');
			Route::put('configuracion/clases-grupales/update/inasistencias','ConfigClasesGrupalesController@updateAsistencias');
			Route::put('configuracion/clases-grupales/update/avanzado','ConfigClasesGrupalesController@updateAvanzado');

			//CLASES PERSONALIZADAS

			Route::get('configuracion/clases-personalizadas', 'ConfigClasePersonalizadaController@index');
			Route::get('configuracion/clases-personalizadas/agregar', 'ConfigClasePersonalizadaController@create');
			Route::post('configuracion/clases-personalizadas/agregar', 'ConfigClasePersonalizadaController@store');
			Route::get('configuracion/clases-personalizadas/detalle/{id}', 'ConfigClasePersonalizadaController@edit');
			Route::get('configuracion/clases-personalizadas/operaciones/{id}', 'ConfigClasePersonalizadaController@operar');
			Route::delete('configuracion/clases-personalizadas/eliminar/{id}', 'ConfigClasePersonalizadaController@destroy');
			Route::post('configuracion/clases-personalizadas/cancelar/{id}', 'ConfigClasePersonalizadaController@cancelar');
			Route::post('configuracion/clases-personalizadas/cancelarpermitir/{id}', 'ConfigClasePersonalizadaController@cancelarpermitir');

			Route::put('configuracion/clases-personalizadas/update/nombre', 'ConfigClasePersonalizadaController@updateNombre');
			Route::put('configuracion/clases-personalizadas/update/costo', 'ConfigClasePersonalizadaController@updateCosto');
			Route::put('configuracion/clases-personalizadas/update/imagen', 'ConfigClasePersonalizadaController@updateImagen');
			Route::put('configuracion/clases-personalizadas/update/descripcion', 'ConfigClasePersonalizadaController@updateDescripcion');
			Route::put('configuracion/clases-personalizadas/update/etiqueta', 'ConfigClasePersonalizadaController@updateEtiqueta');
			Route::put('configuracion/clases-personalizadas/update/tiempo_expiracion', 'ConfigClasePersonalizadaController@updateExpiracion');

			Route::post('configuracion/clases-personalizadas/configurar', 'ConfigClasePersonalizadaController@configuracion');
			Route::get('configuracion/clases-personalizadas/participantes/{id}', 'ConfigClasePersonalizadaController@participantes');


			// COREOGRAFIA

			Route::get('configuracion/coreografias','CoreografiaController@principal');
			Route::get('configuracion/coreografias/agregar','CoreografiaController@create');
			Route::post('configuracion/coreografias/agregar','CoreografiaController@store');
			Route::get('configuracion/coreografias/detalle/{id}', 'CoreografiaController@edit');
			Route::get('configuracion/coreografias/operaciones/{id}', 'CoreografiaController@operar');
			Route::get('configuracion/coreografias/participantes/{id}', 'CoreografiaController@participantes');
			Route::post('configuracion/coreografias/inscribir', 'CoreografiaController@storeInscripcion');

			

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
			Route::post('administrativo/pagos/agregarcliente', 'AdministrativoController@AgregarCliente');

			//PAGO CON MERCADOPAGO
			Route::post('administrativo/pagos/facturamercadopago', 'AdministrativoController@storeMercadopago');

			Route::get('administrativo/pagar/{id}', 'AdministrativoController@pagar');

			//ACUERDOS

			Route::get('administrativo/acuerdos', 'AdministrativoController@principalacuerdo');
			Route::get('administrativo/acuerdos/detalle/{id}', 'AdministrativoController@detalleacuerdo');
			Route::get('administrativo/acuerdos/generar', 'AdministrativoController@acuerdo');
			Route::get('administrativo/acuerdos/generar/{id}', 'AdministrativoController@acuerdoconalumno');
			Route::post('administrativo/acuerdo/generar', 'AdministrativoController@generar_acuerdo');
			Route::post('administrativo/pagos/pendiente/{id}', 'AdministrativoController@pagospendientes');
			Route::post('administrativo/acuerdo/guardar', 'AdministrativoController@storeAcuerdo');
			Route::delete('administrativo/acuerdo/eliminar/{id}', 'AdministrativoController@eliminaracuerdo');
			Route::post('administrativo/acuerdo/actualizar', 'AdministrativoController@updateAcuerdo');

			//PRESUPUESTOS

			Route::get('administrativo/presupuestos', 'AdministrativoController@principalpresupuesto');
			Route::get('administrativo/presupuestos/detalle/{id}', 'AdministrativoController@detallepresupuesto');
			Route::get('administrativo/presupuestos/generar', 'AdministrativoController@presupuesto');
			Route::post('administrativo/presupuestos/generar', 'AdministrativoController@GenerarPresupuesto');
			Route::post('administrativo/presupuestos/agregaritem', 'AdministrativoController@agregaritempresupuesto');
			Route::post('administrativo/presupuestos/eliminaritem/{id}', 'AdministrativoController@eliminaritempresupuesto');
			Route::delete('administrativo/presupuestos/eliminar/{id}', 'AdministrativoController@eliminarpresupuesto');

			//FACTURA

			Route::post('administrativo/factura/enviar/{id}', 'AdministrativoController@enviarfactura');

			// REPORTES

			// Route::get('administrativo/reporte', function () {
			//     return view('administrativo.reporte');
			// });

			Route::get('reportes/inscritos', 'ReporteController@Inscritos');
			Route::post('reportes/inscritos', 'ReporteController@InscritosFiltros');
			Route::get('reportes/diagnosticos', 'ReporteController@Diagnosticos');
			Route::post('reportes/diagnosticos', 'ReporteController@DiagnosticosFiltros');
			Route::get('reportes/presenciales', 'ReporteController@Presenciales');
			Route::post('reportes/presenciales', 'ReporteController@PresencialesFiltros');
			Route::get('reportes/contactos', 'ReporteController@Contactos');
			Route::get('reportes/promotores', 'ReporteController@Promotores');
			Route::post('reportes/promotores', 'ReporteController@PromotoresFiltros');
			Route::get('reportes/asistencias', 'ReporteController@asistencias');
			Route::get('reportes/estatus_alumnos','ReporteController@estatus_alumnos');
			Route::post('reportes/estatus_alumnos/filtrar','ReporteController@filtrar_estatus_alumnos');
			Route::post('reportes/asistencias/filtrar', 'ReporteController@filtrarAsistencias');
			Route::get('reportes/chart', 'ReporteController@charts');
			Route::get('reportes/administrativo', 'ReporteController@Administrativo');
			Route::post('reportes/administrativo', 'ReporteController@AdministrativoFiltros');
		
		});	//END MIDDLEWARE ADMIN
		/*----------------------------------------------------------
		//MIDDELEWARE RECEPCIONISTA
		//SOLO RUTAS A LAS QUE TENDRA ACCESO EL ROL RECEPCIONISTA
		-----------------------------------------------------------*/
		Route::group(['middleware' => 'recepcionista'], function() {

			Route::get('/listo', 'AcademiaConfiguracionController@listo');

			//ALUMNO

			Route::get('participante/alumno', 'AlumnoController@principal');
			Route::get('participante/alumno/inactivos', 'AlumnoController@inactivos');
			Route::post('participante/alumno/agregar', 'AlumnoController@store');
			Route::get('participante/alumno/agregar', 'AlumnoController@create');
			Route::get('participante/alumno/agregar/{id}', 'AlumnoController@agregarvisitante');
			Route::delete('participante/alumno/eliminar/{id}', 'AlumnoController@destroy');
			Route::delete('participante/alumno/eliminar_permanentemente/{id}', 'AlumnoController@eliminar_permanentemente');
			Route::post('participante/alumno/restablecer/{id}', 'AlumnoController@restore');
			Route::get('participante/alumno/detalle/{id}', 'AlumnoController@edit');
			Route::get('participante/alumno/perfil-evaluativo/{id}', 'AlumnoController@perfil_evaluativo');
			Route::get('participante/alumno/operaciones/{id}', 'AlumnoController@operar');
			Route::get('participante/alumno/deuda/{id}', 'AlumnoController@deuda');
			Route::get('participante/alumno/historial/{id}', 'AlumnoController@historial');
			Route::post('participante/alumno/sesion/{id}', 'AlumnoController@sesion');
			Route::put('participante/alumno/update/promotor','AlumnoController@updatePromotor');
			Route::put('participante/alumno/update/identificacion','AlumnoController@updateID');
			Route::put('participante/alumno/update/nombre','AlumnoController@updateNombre');
			Route::put('participante/alumno/update/fecha_nacimiento','AlumnoController@updateFecha');
			Route::put('participante/alumno/update/sexo','AlumnoController@updateSexo');
			Route::put('participante/alumno/update/correo','AlumnoController@updateCorreo');
			Route::put('participante/alumno/update/telefono','AlumnoController@updateTelefono');
			Route::put('participante/alumno/update/direccion','AlumnoController@updateDireccion');
			Route::put('participante/alumno/update/ficha','AlumnoController@updateFicha');
			Route::put('participante/alumno/update/rol','AlumnoController@updateRol');
			Route::post('participante/alumno/update/mensualidad', 'AlumnoController@updateCostoMensualidad');
			Route::post('participante/alumno/update/entrega', 'AlumnoController@updateEntrega');

			Route::get('participante/alumno/evaluaciones/{id}', 'EvaluacionController@evaluaciones_alumno');

			//INSTRUCTOR

			Route::get('participante/instructor', 'InstructorController@index');
			Route::post('participante/instructor/agregar', 'InstructorController@store');
			Route::get('participante/instructor/agregar', 'InstructorController@create');
			Route::delete('participante/instructor/eliminar/{id}', 'InstructorController@destroy');
			Route::get('participante/instructor/detalle/{id}', 'InstructorController@edit');
			Route::get('participante/instructor/experiencia/{id}', 'InstructorController@perfil_evaluativo');
			Route::post('participante/instructor/experiencia', 'InstructorController@storeExperiencia');
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
			Route::put('participante/instructor/update/redes', 'InstructorController@updateRedes');
			Route::put('participante/instructor/update/avanzado','InstructorController@updateAvanzado');
			Route::put('participante/instructor/update/imagen','InstructorController@updateImagen');

			Route::get('participante/instructor/pagos/{id}', 'InstructorController@principalpagos');
			Route::post('participante/instructor/agregarpago', 'InstructorController@agregarpago');
			Route::delete('participante/instructor/eliminarpago/{id}', 'InstructorController@eliminarpago');
			Route::post('participante/instructor/pagar', 'InstructorController@pagar');


			//VISITANTE

			Route::get('participante/visitante', 'VisitanteController@index');
			Route::post('participante/visitante/agregar', 'VisitanteController@store');
			Route::get('participante/visitante/agregar', 'VisitanteController@create');
			Route::post('participante/visitante/eliminar/{id}', 'VisitanteController@destroy');
			Route::get('participante/visitante/detalle/{id}', 'VisitanteController@edit');
			Route::get('participante/visitante/operaciones/{id}', 'VisitanteController@operar');
			Route::put('participante/visitante/update/identificacion','VisitanteController@updateID');
			Route::put('participante/visitante/update/nombre','VisitanteController@updateNombre');
			Route::put('participante/visitante/update/fecha_nacimiento','VisitanteController@updateFecha');
			Route::put('participante/visitante/update/sexo','VisitanteController@updateSexo');
			Route::put('participante/visitante/update/correo','VisitanteController@updateCorreo');
			Route::put('participante/visitante/update/telefono','VisitanteController@updateTelefono');
			Route::put('participante/visitante/update/direccion','VisitanteController@updateDireccion');
			Route::put('participante/visitante/update/como_se_entero','VisitanteController@updateComoSeEntero');
			Route::put('participante/visitante/update/especialidad','VisitanteController@updateEspecialidad');
			Route::put('participante/visitante/update/promotor','VisitanteController@updatePromotor');
			Route::put('participante/visitante/update/dias','VisitanteController@updateDiasDeClase');

			Route::get('participante/visitante/impresion/{id}', 'VisitanteController@impresion');
			Route::post('participante/visitante/impresion', 'VisitanteController@storeImpresion');
			Route::post('participante/visitante/enviar', 'VisitanteController@enviar');


			Route::get('participante/visitante/llamadas/{id}', 'VisitanteController@indexLlamada');
			Route::get('participante/visitante/llamadas/agregar/{id}', 'VisitanteController@createLlamada');
			Route::post('participante/visitante/llamadas/agregar', 'VisitanteController@storeLlamada');

			//FAMILIA

			Route::get('participante/familia', 'FamiliaController@principal');
			Route::post('participante/familia/agregar', 'FamiliaController@store');
			Route::get('participante/familia/agregar', 'FamiliaController@create');
			Route::post('participante/familia/agregarparticipante', 'FamiliaController@agregarparticipante');
			Route::post('participante/familia/eliminarparticipante/{id}', 'FamiliaController@eliminarparticipante');
			Route::post('participante/familia/agregarparticipantefijo', 'FamiliaController@agregarparticipantefijo');
			Route::delete('participante/familia/eliminar/{id}', 'FamiliaController@destroy');
			Route::get('participante/familia/detalle/{id}', 'FamiliaController@edit');
			Route::get('participante/familia/operaciones/{id}', 'FamiliaController@operar');
			Route::get('participante/familia/participantes/{id}', 'FamiliaController@participantes');

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
			Route::put('agendar/clases-grupales/update/etiqueta', 'ClaseGrupalController@updateEtiqueta');
			Route::put('agendar/clases-grupales/update/mostrar', 'ClaseGrupalController@updateMostrar');
			Route::put('agendar/clases-grupales/update/cantidad', 'ClaseGrupalController@updateCantidad');

			Route::post('agendar/clases-grupales/update/inscripcion', 'ClaseGrupalController@updateInscripcion');
			Route::post('agendar/clases-grupales/update/mensualidad', 'ClaseGrupalController@updateMensualidad');
			Route::post('agendar/clases-grupales/update/fecha_pago', 'ClaseGrupalController@updateFechaPago');

			Route::get('agendar/clases-grupales/inscribir/{id}', 'ClaseGrupalController@inscribir');
			Route::get('agendar/clases-grupales/participantes/{id}', 'ClaseGrupalController@participantes');
			Route::post('agendar/clases-grupales/eliminarinscripcion/{id}', 'ClaseGrupalController@eliminarinscripcion');
			Route::post('agendar/clases-grupales/eliminar_reserva/{id}', 'ClaseGrupalController@eliminar_reserva');
			Route::post('agendar/clases-grupales/editarinscripcion', 'ClaseGrupalController@editarinscripcion');

			Route::post('agendar/clases-grupales/trasladar', 'ClaseGrupalController@Trasladar');

			Route::post('agendar/clases-grupales/cancelar', 'ClaseGrupalController@cancelarClase');

			Route::get('agendar/clases-grupales/nivelaciones/{id}', 'ClaseGrupalController@nivelaciones');
			Route::post('agendar/clases-grupales/nivelaciones/agregar', 'ClaseGrupalController@storeNivelaciones');


			//MULTIHORARIO CLASES GRUPALES

			Route::get('agendar/clases-grupales/multihorario/{id}', 'MultihorarioClaseGrupalController@principal');
			Route::post('agendar/clases-grupales/multihorario/agregarhorario', 'MultihorarioClaseGrupalController@agregar');
			Route::post('agendar/clases-grupales/multihorario/eliminarhorario/{id}', 'MultihorarioClaseGrupalController@eliminar');
			Route::post('agendar/clases-grupales/multihorario/cancelarhorarios', 'MultihorarioClaseGrupalController@CancelarHorarios');
			Route::post('agendar/clases-grupales/multihorario/guardarhorarios', 'MultihorarioClaseGrupalController@GuardarHorarios');
			Route::get('agendar/clases-grupales/multihorario/detalle/{id}', 'MultihorarioClaseGrupalController@edit');
			Route::put('agendar/clases-grupales/multihorario/update/especialidad', 'MultihorarioClaseGrupalController@updateEspecialidad');
			Route::put('agendar/clases-grupales/multihorario/update/instructor', 'MultihorarioClaseGrupalController@updateInstructor');
			Route::put('agendar/clases-grupales/multihorario/update/dia', 'MultihorarioClaseGrupalController@updateDia');
			Route::put('agendar/clases-grupales/multihorario/update/horario', 'MultihorarioClaseGrupalController@updateHorario');
			Route::put('agendar/clases-grupales/multihorario/update/estudio', 'MultihorarioClaseGrupalController@updateEstudio');
			Route::put('agendar/clases-grupales/multihorario/update/etiqueta', 'MultihorarioClaseGrupalController@updateEtiqueta');

			//CLASES PERSONALIZADAS

			Route::post('agendar/clases-personalizadas/inscribir', 'ClasePersonalizadaController@storeInscripcion');
			Route::get('agendar/clases-personalizadas/detalle/{id}', 'ClasePersonalizadaController@edit');
			Route::get('agendar/clases-personalizadas/operaciones/{id}', 'ClasePersonalizadaController@operar');
			Route::delete('agendar/clases-personalizadas/eliminar/{id}', 'ClasePersonalizadaController@destroy');

			Route::put('agendar/clases-personalizadas/update/alumno', 'ClasePersonalizadaController@updateAlumno');
			Route::put('agendar/clases-personalizadas/update/nombre', 'ClasePersonalizadaController@updateNombre');
			Route::put('agendar/clases-personalizadas/update/fecha', 'ClasePersonalizadaController@updateFecha');
			Route::put('agendar/clases-personalizadas/update/especialidad', 'ClasePersonalizadaController@updateEspecialidad');
			Route::put('agendar/clases-personalizadas/update/instructor', 'ClasePersonalizadaController@updateInstructor');
			Route::put('agendar/clases-personalizadas/update/horario', 'ClasePersonalizadaController@updateHorario');

			//MULTIHORARIO CLASES GRUPALES

			Route::get('agendar/clases-personalizadas/multihorario/{id}', 'MultihorarioClasePersonalizadaController@principal');
			Route::post('agendar/clases-personalizadas/multihorario/agregarhorario', 'MultihorarioClasePersonalizadaController@agregar');
			Route::post('agendar/clases-personalizadas/multihorario/eliminarhorario/{id}', 'MultihorarioClasePersonalizadaController@eliminar');
			Route::post('agendar/clases-personalizadas/multihorario/cancelarhorarios', 'MultihorarioClasePersonalizadaController@CancelarHorarios');
			Route::post('agendar/clases-personalizadas/multihorario/guardarhorarios', 'MultihorarioClasePersonalizadaController@GuardarHorarios');
			Route::get('agendar/clases-personalizadas/multihorario/detalle/{id}', 'MultihorarioClasePersonalizadaController@edit');
			Route::put('agendar/clases-personalizadas/multihorario/update/especialidad', 'MultihorarioClasePersonalizadaController@updateEspecialidad');
			Route::put('agendar/clases-personalizadas/multihorario/update/instructor', 'MultihorarioClasePersonalizadaController@updateInstructor');
			Route::put('agendar/clases-personalizadas/multihorario/update/dia', 'MultihorarioClasePersonalizadaController@updateDia');
			Route::put('agendar/clases-personalizadas/multihorario/update/horario', 'MultihorarioClasePersonalizadaController@updateHorario');
			Route::put('agendar/clases-personalizadas/multihorario/update/estudio', 'MultihorarioClasePersonalizadaController@updateEstudio');
			Route::put('agendar/clases-personalizadas/multihorario/update/etiqueta', 'MultihorarioClasePersonalizadaController@updateEtiqueta');


			//TALLERES

			Route::post('agendar/talleres/agregar', 'TallerController@store');
			Route::get('agendar/talleres/agregar', 'TallerController@create');
			Route::get('agendar/talleres/detalle/{id}', 'TallerController@edit');
			Route::get('agendar/talleres/operaciones/{id}', 'TallerController@operar');
			Route::delete('agendar/talleres/eliminar/{id}', 'TallerController@destroy');
			Route::get('agendar/talleres/participantes/{id}', 'TallerController@participantes');
			Route::post('agendar/talleres/eliminarinscripcion/{id}', 'TallerController@eliminarinscripcion');
			Route::post('agendar/talleres/inscribir', 'TallerController@storeInscripcion')
			;

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
			Route::put('agendar/talleres/update/cuporeservacion', 'TallerController@updateCuposOnline');
			Route::put('agendar/talleres/update/imagen', 'TallerController@updateImagen');
			Route::put('agendar/talleres/update/etiqueta', 'TallerController@updateEtiqueta');
			Route::put('agendar/talleres/update/condiciones', 'TallerController@updateCondiciones');

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
			Route::put('agendar/fiestas/update/etiqueta', 'FiestaController@updateEtiqueta');

			//CITAS

			Route::get('agendar/citas', 'CitaController@principal');
			Route::get('agendar/citas/calendario', 'CitaController@calendario');
			Route::post('agendar/citas/agregar', 'CitaController@store');
			Route::get('agendar/citas/agregar', 'CitaController@create');
			Route::get('agendar/citas/detalle/{id}', 'CitaController@edit');
			Route::get('agendar/clases-grupales/operaciones/{id}', 'ClaseGrupalController@operar');
			Route::delete('agendar/citas/eliminar/{id}', 'CitaController@destroy');

			Route::put('agendar/citas/update/fecha', 'CitaController@updateFecha');
			Route::put('agendar/citas/update/tipo', 'CitaController@updateTipo');
			Route::put('agendar/citas/update/alumno', 'CitaController@updateAlumno');
			Route::put('agendar/citas/update/instructor', 'CitaController@updateInstructor');
			Route::put('agendar/citas/update/horario', 'CitaController@updateHorario');
			Route::put('agendar/citas/update/etiqueta', 'CitaController@updateEtiqueta');

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

			//CAMPAÑAS

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
			Route::put('especiales/campañas/update/imagen', 'CampanaController@updateImagen');
			Route::put('especiales/campañas/update/presentacion', 'CampanaController@updatePresentacion');
			Route::put('especiales/campañas/update/imagen_presentacion', 'CampanaController@updateImagenPresentacion');
			Route::put('especiales/campañas/update/condiciones', 'CampanaController@updateCondiciones');
			Route::put('especiales/campañas/update/datos', 'CampanaController@updateDatosBancarios');
			Route::post('especiales/campañas/agregarrecompensa', 'CampanaController@agregarrecompensa');
			Route::post('especiales/campañas/eliminarrecompensa/{id}', 'CampanaController@eliminarrecompensa');
		    Route::post('especiales/campañas/agregarrecompensafija', 'CampanaController@agregarrecompensafija');
		    Route::post('especiales/campañas/eliminarrecompensafija/{id}', 'CampanaController@eliminarrecompensafija');
		    Route::post('especiales/campañas/agregardatos', 'CampanaController@agregardatos');
			Route::post('especiales/campañas/eliminardatos/{id}', 'CampanaController@eliminardatos');
			Route::post('especiales/campañas/agregardatosfijos', 'CampanaController@agregardatosfijos');
		    Route::post('especiales/campañas/eliminardatosfijos/{id}', 'CampanaController@eliminardatosfijos');

		    //PATROCINADORES

			Route::get('especiales/campañas/patrocinadores/{id}', 'CampanaController@principalpatrocinadores');
			Route::get('especiales/campañas/patrocinadores/detalle/{id}', 'CampanaController@detallepatrocinador');
			Route::put('especiales/campañas/patrocinadores/update/nombre', 'CampanaController@updateNombrePatrocinador');
			Route::put('especiales/campañas/patrocinadores/update/monto', 'CampanaController@updateMontoPatrocinador');
			Route::delete('especiales/campañas/patrocinadores/eliminar/{id}', 'CampanaController@eliminarpatrocinador');
			Route::post('especiales/campañas/patrocinadores/enviar/{id}', 'CampanaController@ReenviarCorreoPatrocinador');


			//CONTRIBUCIONES

			Route::get('especiales/campañas/contribuciones/{id}', 'CampanaController@principalcontribuciones');
			Route::post('especiales/campañas/contribuciones/confirmar/{id}', 'CampanaController@confirmarcontribucion');
			Route::delete('especiales/campañas/contribuciones/eliminar/{id}', 'CampanaController@eliminarcontribucion');

			//REGALOS

		    Route::get('especiales/regalos/detalle/{id}', 'RegaloController@edit');
			Route::get('especiales/regalos/operaciones/{id}', 'RegaloController@operar');
			Route::delete('especiales/regalos/eliminar/{id}', 'RegaloController@destroy');
			Route::get('especiales/regalos/agregar', 'RegaloController@create');
			Route::post('especiales/regalos/agregar', 'RegaloController@store');

			Route::put('especiales/regalos/update/nombre', 'RegaloController@updateNombre');
			Route::put('especiales/regalos/update/costo', 'RegaloController@updateCosto');
			Route::put('especiales/regalos/update/descripcion', 'RegaloController@updateDescripcion');
			Route::put('especiales/regalos/update/imagen', 'RegaloController@updateImagen');

			// ---- CONFIGURACION ----

			// --- ADMINISTRATIVO --- 

			// VALIDAR

			Route::get('validar', 'ValidacionController@principal');
			Route::post('validar', 'ValidacionController@validar');
			Route::get('validar/exitoso', 'ValidacionController@exitoso');
			Route::get('validar/invalido', 'ValidacionController@invalido');

			/*
			|------------------
			|GUIA
			|------------------
			*/

			Route::get('participante/alumno/transferir/{id}', 'AlumnoController@transferir');
			Route::get('participante/alumno/enhorabuena/{id}', 'AlumnoController@enhorabuena');

			Route::get('agendar/clases-grupales/enhorabuena/{id}', 'ClaseGrupalController@enhorabuena');
			Route::get('agendar/clases-personalizadas/enhorabuena/{id}', 'ClaseGrupalController@enhorabuena');
			Route::get('agendar/talleres/enhorabuena/{id}', 'ClaseGrupalController@enhorabuena');


			Route::get('guia/pay', function () {
			    return view('guia.index3');
			});

			// FOOTER

			Route::get('soporte/acuerdo', 'EmpresaController@acuerdos');
			Route::get('soporte/politicas', 'EmpresaController@politicas');
			Route::get('soporte/normas', 'EmpresaController@normas');

			// CORREO

			Route::get('/correo/help', 'CorreoController@indexayuda');

			Route::get('/correo','CorreoController@index');
			Route::get('/correo/{id}','CorreoController@indexsinselector');
			Route::post('/correo/sesion/{id}', 'CorreoController@Sesion');
			Route::post('/correo/cumpleaños', 'CorreoController@correoCumpleaños');
			Route::post('/correo/ausencia', 'CorreoController@correoAusencia');
			Route::post('/correo/cobro', 'CorreoController@correoCobro');
			Route::post('/correo/suspension', 'CorreoController@correoSuspension');
			Route::post('/correo/adelanto', 'CorreoController@correoAdelanto');
			Route::post('/correo/ayuda', 'CorreoController@correoAyuda');
			Route::post('/correo/informacion', 'CorreoController@correoInformacion');
			Route::post('/correo/personalizado', 'CorreoController@correoPersonalizado');
			Route::post('/correo/personalizadovisitante', 'CorreoController@correoPersonalizadoVisitante');


			// ASISTENCIA

			Route::get('/asistencia/generar', 'AsistenciaController@generarAsistencia');
			Route::post('asistencia/consulta/clases-grupales', 'AsistenciaController@consulta_clase_grupales_alumno');
			Route::post('asistencia/consulta/clases-personalizadas', 'AsistenciaController@consulta_clase_personalizadas_alumno');
			Route::post('asistencia/consulta/citas', 'AsistenciaController@consulta_citas_alumno');
			Route::get('asistencia/consulta/clases-grupales', 'AsistenciaController@consulta_clase_grupales');
			Route::post('asistencia/agregar', 'AsistenciaController@store');
			Route::post('asistencia/agregar/permitir', 'AsistenciaController@storePermitir');
			Route::post('asistencia/agregar/instructor', 'AsistenciaController@storeInstructor');
			Route::post('asistencia/agregar/instructor/permitir', 'AsistenciaController@storeInstructorPermitir');


		    //PRIVILEGIOS
		    //Roles
		    Route::get('privilegios/roles', 'RolesController@index');
		    Route::post('privilegios/roles/agregar', 'RolesController@store');
		    Route::get('privilegios/roles/agregar', 'RolesController@create');

		    //Permisos
		    Route::get('privilegios/permisos', 'PermisosController@index');
		    Route::post('privilegios/permisos/agregar', 'PermisosController@store');
		    Route::get('privilegios/permisos/agregar', 'PermisosController@create');

		    //Asignar
		    //Route::get('privilegios/permisos/asignar/{id}', 'PermisosController@createAsignar');
		    Route::post('privilegios/permisos/asignar', 'PermisosController@asignar');

			// });

			//Route::get('/inicio', 'AcademiaConfiguracionController@index');

			//SMS

			Route::get('sms', 'SmsController@send');
			Route::get('mercadopago', 'MercadopagoController@mercadopago');

			//STAFF


			Route::get('staff', 'StaffController@principal');
			Route::post('staff/agregar', 'StaffController@store');
			Route::post('staff/agregarhorario', 'StaffController@agregar_horario');
			Route::post('staff/eliminarhorario/{id}', 'StaffController@eliminar_horario');
			Route::post('staff/agregarhorariofijo', 'StaffController@agregar_horario_fijo');
			Route::post('staff/eliminarhorariofijo/{id}', 'StaffController@eliminar_horario_fijo');
			Route::get('staff/agregar', 'StaffController@create');
			Route::delete('staff/eliminar/{id}', 'StaffController@destroy');
			Route::get('staff/detalle/{id}', 'StaffController@edit');
			Route::get('staff/operaciones/{id}', 'StaffController@operar');
			Route::put('staff/update/identificacion','StaffController@updateID');
			Route::put('staff/update/nombre','StaffController@updateNombre');
			Route::put('staff/update/fecha_nacimiento','StaffController@updateFecha');
			Route::put('staff/update/sexo','StaffController@updateSexo');
			Route::put('staff/update/telefono','StaffController@updateTelefono');
			Route::put('staff/update/direccion','StaffController@updateDireccion');
			Route::put('staff/update/cargo','StaffController@updateCargo');
			Route::put('staff/update/horario','StaffController@updateHorario');

			//INCIDENCIAS

			Route::get('incidencias/generar/{id}', 'IncidenciaController@createconid');
			Route::get('incidencias/generar', 'IncidenciaController@create');
			Route::post('incidencias/generar', 'IncidenciaController@store');
			Route::get('incidencias/detalle/{id}', 'SugerenciaController@planilla');

			//BUSCADOR

			Route::get('perfil/{id}', 'BuscadorController@perfil');
			Route::get('buscador', 'BuscadorController@index');
			Route::post('buscador', 'BuscadorController@buscarAlumno');

		});// EN MIDDLEWARE RECEPCIONISTA
		/*--------------------------------------------------------
		MIDDLEWARE ALUMNO
		//SOLO RUTAS A LAS QUE TENDRA ACCESO EL PERFIL ALUMNO
		--------------------------------------------------------*/
		Route::group(['middleware' => ['alumno']], function() {

			//SUGERENCIAS

			Route::get('sugerencias/generar', 'SugerenciaController@create');
			Route::post('sugerencias/generar', 'SugerenciaController@store');
			Route::get('sugerencias/detalle/{id}', 'SugerenciaController@planilla');

		    // PRINCIPAL
		    
			Route::get('/inicio', 'AcademiaConfiguracionController@index');
			Route::post('/inicio/condiciones', 'UsuarioController@aceptar_condiciones');
			Route::get('/', 'AcademiaConfiguracionController@menu');
			
			//AGENDAR

			Route::get('agendar','AgendarController@index');
			Route::post('agendar','AgendarController@store');
			Route::post('guardar-fecha','AgendarController@guardarFecha');

			//CLASES PERSONALIZADAS

			Route::get('agendar/clases-personalizadas/agregar', 'ClasePersonalizadaController@create');
			Route::post('agendar/clases-personalizadas/reservar', 'ClasePersonalizadaController@reservar');
			Route::get('agendar/clases-personalizadas/completado', 'ClasePersonalizadaController@completado');
			Route::get('agendar/clases-personalizadas/{id}', 'ClasePersonalizadaController@progreso');
			Route::post('agendar/clases-personalizadas/{id}', 'ClasePersonalizadaController@aceptarcondiciones');

			//REGALO

			Route::post('especiales/regalos/verificar', 'RegaloController@verify');
			Route::post('especiales/regalos/verificar/{id}', 'RegaloController@verificarconalumno');


			// NORMATIVAS

			Route::get('/normativas', 'UsuarioController@documentos');
			Route::get('/normativas/generales', 'UsuarioController@generales');
			Route::get('/normativas/clases-grupales', 'UsuarioController@clases_grupales');
			Route::get('/normativas/clases-personalizadas', 'UsuarioController@clases_personalizadas');

			// --- ADMINISTRATIVO --- 

			Route::get('administrativo', 'AdministrativoController@index');
			Route::get('administrativo/factura/{id}', 'AdministrativoController@getFactura');

			// ASISTENCIA
			Route::get('/asistencia', 'AsistenciaController@principal');
			
		
			//PERFIL USUARIO
			Route::get('perfil', 'UsuarioController@perfil');
			Route::get('perfil-evaluativo', 'UsuarioController@perfil_evaluativo');
			Route::post('perfil-evaluativo', 'UsuarioController@store');			
			Route::put('perfil/update/imagen', 'UsuarioController@updateImagen');
			Route::put('perfil/update/nombre','UsuarioController@updateNombre');
			Route::put('perfil/update/sexo','UsuarioController@updateSexo');
			Route::put('perfil/update/correo','UsuarioController@updateCorreo');
			Route::put('perfil/update/telefono','UsuarioController@updateTelefono');
			Route::put('perfil/update/direccion','UsuarioController@updateDireccion');
			Route::put('perfil/update/redes','UsuarioController@updateRedes');
			Route::put('perfil/update/password','UsuarioController@updatePassword');

			//CAMPAÑAS
			Route::get('especiales/campañas', 'CampanaController@index');


			//INSTRUCTORES
			
			Route::get('instructores', 'InstructorController@index');
			Route::post('instructores/sesion', 'InstructorController@sesion');
			Route::get('instructores/detalle/{id}', 'InstructorController@progreso');

			//CLASES GRUPALES 
			
			Route::get('agendar/clases-grupales', 'ClaseGrupalController@principal');

			//TALLERES
			
			Route::get('agendar/talleres', 'TallerController@index');

			//EVALUACIONES
			
			Route::get('evaluaciones', 'EvaluacionController@evaluaciones_vista_alumno');
			Route::get('evaluaciones/detalle/{id}','EvaluacionController@getDetalle');
			Route::get('especiales/evaluaciones/detalle/{id}','EvaluacionController@getDetalle');

			//NOTIFICACIONES
			
			Route::get('notificaciones', 'NotificacionController@principal');
			Route::post('notificaciones', 'NotificacionController@responderNotificacion');
			Route::post('notificacion_revisado', 'NotificacionController@revisarNotificacion');
			Route::post('notificacion_eliminadas', 'NotificacionController@eliminarNotificaciones');
			Route::post('notificacion_nueva', 'NotificacionController@nuevaNotificaion');

			//PROGRESO TU CLASE DE BAILE
			
			Route::get('progreso','ProgresoController@index');
			Route::get('progreso/{id}','ProgresoController@progreso');
			Route::get('programacion/{id}','ProgresoController@programacion');

			//EMBAJADOR

			Route::get('/invitar', 'EmbajadorController@index');
			Route::post('/invitar', 'EmbajadorController@invitar');	
			Route::get('/invitar/enhorabuena', 'EmbajadorController@enhorabuena');		

		});//END MIDDLEWARE ALUMNO

});