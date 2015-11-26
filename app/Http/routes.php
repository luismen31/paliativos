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
		return view('welcome');
	});

	Route::get('auth/logout', 'Auth\AuthController@getLogout');
	Route::post('profesionales/editProfesional', 'ProfesionalesController@editProfesional');
	Route::resource('profesionales', 'ProfesionalesController');

	Route::post('pacientes/editPaciente', 'PacientesController@editPaciente');
	Route::resource('pacientes', 'PacientesController');

	Route::resource('equipo-medico', 'EquipoMedicoController');
	Route::controller('buscar', 'SearchController');

	Route::resource('camas', 'CamasController');
	Route::resource('salas', 'SalasController');
	Route::resource('servicios', 'ServiciosMedicosController');
	Route::resource('zona', 'ZonasController');
	Route::resource('rvd', 'RegistroVisitasController');
	Route::resource('surco', 'SurcoController');
	Route::post('surco/paciente', 'SurcoController@create');

	Route::get('verAgenda', 'AgendaController@verAgenda');
	Route::post('crearCita', 'AgendaController@crearCita');
	Route::resource('agenda', 'AgendaController');
	Route::resource('rda', 'RegistroDiarioActividadesController');
	Route::post('rda.storedetails', 'RegistroDiarioActividadesController@storeDetails');
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');


// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');
