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

Route::group(['middleware' => 'auth'], function () {
	Route::get('/', function () {
		return view('inicio');
	});

	//Actualiza los terminos para los usuarios
	Route::patch('actualizar-usuario/{user_id}', ['as' => 'updateTerminos', 'uses' => 'UserController@updateTerminos']);
	Route::get('auth/logout', 'Auth\AuthController@getLogout');
	Route::controllers([
		'buscar' => 'SearchController', 
		'imprimir' => 'ImprimirController'
	]);
	
	//RUTAS PARA PROFESIONALES SOAP
	Route::group(['prefix' => 'soap'], function(){

		Route::post('bucar-paciente', ['as' => 'buscarPacienteSoap', 'uses' => 'SearchController@pacienteSoap']);
		Route::group(['prefix' => 'paciente'], function(){
			Route::get('agregar', ['as' => 'addPaciente', 'uses' => 'PacientesController@index']);
			Route::post('registrar', ['as' => 'addPacienteSoap', 'uses' => 'PacientesController@addPacienteSoap']);
			Route::get('editar/{id}/{id_categoria?}', ['as' => 'editPacienteSoap', 'uses' => 'PacientesController@editPacienteSoap']);
			Route::patch('actualizar/{id}', ['as' => 'updatePacienteSoap', 'uses' => 'PacientesController@updatePacienteSoap']);
		});

		Route::get('menu-categorias/{id}', ['as' => 'categorias', 'uses' => 'SoapController@menuCategorias']);
		Route::get('categoria/{id_categoria}/{id_paciente}/{id_soap?}', ['as' => 'soapCategory', 'uses' => 'SoapController@soapCategory']);
			
		//Solo aplica para la categoria ambulatoria
		Route::post('agregar-observacion', ['as' => 'add_observacion', 'uses' => 'SoapController@add_observacion']);

		//Rutas para registrar el subjetivo y actualizarlo dentro del SOAP
		Route::post('registrar-subjetivo/{id_categoria}/{id_paciente}', ['as' => 'addSubjetivo', 'uses' => 'SoapController@addSubjetivo']);
		Route::patch('actualizar-subjetivo/{id_categoria}/{id_paciente}/{id_soap}', ['as' => 'updateSubjetivo', 'uses' => 'SoapController@updateSubjetivo']);

		//Ruta para agregar el objetivo al soap
		Route::patch('actualizar-objetivo/{id_categoria}/{id_paciente}/{id_soap}', ['as' => 'updateObjetivo', 'uses' => 'SoapController@updateObjetivo']);
		
		//Rutas para escala edmonton
		Route::get('escala-edmonton/{id_categoria}/{id_paciente}/{id_soap}', ['as' => 'openEscala', 'uses' => 'SoapController@openEscala']);
		Route::post('registrar-escala-edmonton/{id_categoria}/{id_paciente}/{id_soap}', ['as' => 'registrarEscala', 'uses' => 'SoapController@registrarEscala']);
		
		//Registrar Impresion diagnostica
		Route::post('registrar-diagnostico/{id_categoria}/{id_paciente}/{id_soap}/{id_impresion?}', ['as' => 'addDiagnostico', 'uses' => 'SoapController@addDiagnostico']);
		//Registrar los cuidados del paciente
		Route::post('registrar-cuidados/{id_categoria}/{id_paciente}/{id_soap}/{id_cuidado?}', ['as' => 'addCuidados', 'uses' => 'SoapController@addCuidados']);
		//Registrar Nuevo Medicamento (enviado por ajax para mejor usabilidad)
		Route::post('agregar-medicamento', ['as' => 'addMedicamento', 'uses' => 'SoapController@addMedicamento']);
		//Registrar y editar recetas
		Route::post('registrar-receta/{id_categoria}/{id_paciente}/{id_soap}/{id_cuidado}/{id_receta?}', ['as' => 'addReceta', 'uses' => 'SoapController@addReceta']);
		Route::post('editar-receta/{id_categoria}/{id_paciente}/{id_soap}/{id_receta}', ['as' => 'editReceta', 'uses' => 'SoapController@editReceta']);
		//Registra observaciones del soap
		Route::post('registrar-observaciones/{id_categoria}/{id_paciente}/{id_soap}', ['as' => 'addObservaciones', 'uses' => 'SoapController@addObservaciones']);
		//Registra el surco del soap (solo para la categoria DOMICILIARIA)
		Route::get('registrar-surco/{id_paciente}/{id_soap}', ['as' => 'getsurco', 'uses' => 'SoapController@openSurco']);

		Route::get('historial-clinica/{id_categoria}/{id_paciente}/{id_soap?}', ['as' => 'historial', 'uses' => 'SoapController@historial']);
	});

	//RUTAS PARA PROFESIONALES NO SOAP
	Route::post('profesionales/editProfesional', 'ProfesionalesController@editProfesional');
	Route::resource('profesionales', 'ProfesionalesController');
	Route::post('pacientes/editPaciente', 'PacientesController@editPaciente');
	Route::resource('pacientes', 'PacientesController');

	Route::resource('equipo-medico', 'EquipoMedicoController');

	Route::resource('camas', 'CamasController');
	Route::resource('salas', 'SalasController');
	Route::resource('servicios', 'ServiciosMedicosController');
	Route::resource('zona', 'ZonasController');

	Route::get('verAgenda', 'AgendaController@verAgenda');
	Route::post('crearCita', 'AgendaController@crearCita');
	Route::resource('agenda', 'AgendaController');
	Route::resource('rvd', 'RegistroVisitasController');
	Route::resource('surco', 'SurcoController');
	Route::post('surco/paciente', 'SurcoController@create');
	Route::post('surco/respuesta', 'SurcoController@storeRespuesta');
	Route::get('surco/verRespuesta/{id_respuesta}', 'SurcoController@verRespuesta');
	
	Route::resource('atencion_paciente', 'AtencionPacienteController');
	Route::post('atencion_paciente/paciente', 'AtencionPacienteController@create');
	Route::post('atencion_paciente/agregar_respuesta', 'AtencionPacienteController@storeRespuestaInterconsulta');

	Route::resource('interconsulta', 'InterconsultaController');
	Route::post('interconsulta/paciente', 'InterconsultaController@create');

	Route::resource('evolucion', 'EvolucionController');
	Route::post('evolucion/paciente', ['as' => 'buscarPaciente', 'uses' => 'EvolucionController@buscarPaciente']);
	Route::post('evolucion/responsable/{id_paciente}', ['as' => 'responsable', 'uses' => 'EvolucionController@registrarResponsable']);

	Route::resource('rda', 'RegistroDiarioActividadesController');
	Route::post('rda.storedetails', 'RegistroDiarioActividadesController@storeDetails');

	Route::group(['prefix' => 'indicadores'], function(){	
		//Rutass para los Indicadores de Domiciliaria	
		Route::get('domiciliaria/total-visitas', ['as' => 'totalVisitas', 'uses' => 'IndicadoresController@totalVisitas']);
		Route::post('domiciliaria/total-visitas', ['as' => 'filtrarVisitas', 'uses' => 'IndicadoresController@filtrarVisitas']);

		Route::get('domiciliaria/tiempo-promedio-por-visita', ['as' => 'tiempoPromedio', 'uses' => 'IndicadoresController@tiempoPromedio']);
		Route::post('domiciliaria/tiempo-promedio-por-visita', ['as' => 'filtrarTiempoPromedio', 'uses' => 'IndicadoresController@filtrarTiempoPromedio']);

		Route::get('domiciliaria/pacientes-por-diagnostico', ['as' => 'pacienteDiag', 'uses' => 'IndicadoresController@pacienteDiagnostico']);

		Route::get('domiciliaria/actividades-realizadas', ['as' => 'actividadesDom', 'uses' => 'IndicadoresController@actividadesRealizadas']);
		
		Route::get('ambulatoria/actividades-realizadas',  ['as' => 'actividadesAmb', 'uses' => 'IndicadoresController@actividadesRealizadas']);

		Route::get('hospitalaria/indicadores/porcentaje-ocupacion-camas', ['as' => 'porcentaje-ocupacion', 'uses' => 'IndicadoresController@ocupacionCamas']);
	});
	//RUTAS PARA PROFESIONALES NO SOAP

});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');

// Password reset link request routes...
Route::get('password/enviar', 'EnviarPasswordController@getEnviar');
Route::post('password/enviar', 'EnviarPasswordController@postEnviar');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');
