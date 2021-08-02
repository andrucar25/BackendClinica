<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('v1')->group(function () {

    //auth
    Route::prefix('auth')->group(function () {
        //pacientes
        Route::get('pacientes', 'JWTPacienteController@getAuthenticatedPaciente')->middleware('jwt.pacientes');
        Route::post('pacientes', 'JWTPacienteController@authenticate');
        Route::post('pacientes/change-password', 'JWTPacienteController@changePassword')->middleware('jwt.pacientes');
        Route::post('pacientes/register', 'JWTPacienteController@register');
        Route::post('pacientes/logout', 'JWTPacienteController@logout')->middleware('jwt.pacientes');
    });
    //archivoTeleconsulta
    Route::prefix('archivoTeleconsulta')->group(function () {
        Route::get('/', 'ArchivoTeleconsultaController@index')->middleware('jwt.pacientes');
        Route::post('/', 'ArchivoTeleconsultaController@store')->middleware('jwt.pacientes');
        Route::put('{id}', 'ArchivoTeleconsultaController@update');
        Route::delete('{id}', 'ArchivoTeleconsultaController@remove');
        Route::get('medicos', 'ArchivoTeleconsultaController@indexMedico')->middleware('jwt.medicos');
        Route::post('medicos', 'ArchivoTeleconsultaController@store')->middleware('jwt.medicos');
    });
    //chatMedico
    Route::prefix('chatMedico')->group(function () {
        //Route::get('/', 'ChatMedicoController@index');
        Route::get('searchChatPaciente', 'ChatMedicoController@searchChatPaciente');
        Route::post('storeChatPaciente', 'ChatMedicoController@store');
        Route::put('{id}', 'ChatMedicoController@update');
        Route::delete('{id}', 'ChatMedicoController@remove');
    });
    //comentario
    Route::prefix('comentario')->group(function () {
        Route::get('/', 'ComentarioController@showCommentaryMedic');
        //Route::get('showCommentaryMedic', 'ComentarioController@showCommentaryMedic');
        Route::post('storeCommentary', 'ComentarioController@storeCommentary')->middleware('jwt.pacientes');
        Route::put('{id}', 'ComentarioController@update');
        Route::delete('{id}', 'ComentarioController@remove');
    });
    //farmaciaPedido
    Route::prefix('farmaciaPedido')->group(function () {
        Route::get('/', 'FarmaciaPedidoController@index');
        Route::get('{id}', 'FarmaciaPedidoController@show');
        Route::post('/', 'FarmaciaPedidoController@store');
        Route::put('{id}', 'FarmaciaPedidoController@update');
        Route::delete('{id}', 'FarmaciaPedidoController@remove');
    });
     //especialidad
     Route::prefix('especialidad')->group(function () {
        Route::get('/', 'EspecialidadController@index');
        Route::get('{id}', 'EspecialidadController@show');
        Route::post('/', 'EspecialidadController@store');
        Route::put('{id}', 'EspecialidadController@update');
        Route::delete('{id}', 'EspecialidadController@remove');
    });
    //horarioMedico
    Route::prefix('horarioMedico')->group(function () {
        Route::get('/', 'HorarioMedicoController@index');
        Route::get('getDates', 'HorarioMedicoController@getDates');
        Route::get('{id}', 'HorarioMedicoController@show');
        Route::post('/', 'HorarioMedicoController@store');
        Route::put('{id}', 'HorarioMedicoController@update');
        Route::delete('{id}', 'HorarioMedicoController@remove');
    });
    //Laboratorio
    Route::prefix('laboratorio')->group(function () {
        Route::get('/', 'LaboratorioController@index');
        Route::get('labHistory', 'LaboratorioController@showLabHistory')->middleware('jwt.pacientes');
        Route::post('sendSMS', 'LaboratorioController@sendSMS')->middleware('jwt.pacientes');
        Route::post('/', 'LaboratorioController@store')->middleware('jwt.pacientes');;
        Route::put('{id}', 'LaboratorioController@update');
        Route::delete('{id}', 'LaboratorioController@remove');
    });
     //Reclamo
     Route::prefix('reclamo')->group(function () {
        Route::get('/', 'ReclamoController@index');
        //Route::get('{id}', 'ReclamoController@show');
        Route::post('storeSuggestion', 'ReclamoController@store')->middleware('jwt.pacientes');
        Route::put('{id}', 'ReclamoController@update');
        Route::delete('{id}', 'ReclamoController@remove');
    });
      //Teleconsulta
      Route::prefix('teleconsulta')->group(function () {
        Route::get('/', 'TeleconsultaController@index');
        Route::get('pendingTeleconsultation', 'TeleconsultaController@showPacientePending')->middleware('jwt.pacientes');
        Route::get('historyTeleconsultation', 'TeleconsultaController@showPacienteHistory')->middleware('jwt.pacientes');
        Route::get('historyTeleconsultationMedic', 'TeleconsultaController@showPacienteHistoryMedic');
        Route::get('pendingMedicTeleconsultation', 'TeleconsultaController@showMedicPending')->middleware('jwt.medicos');
        Route::get('showMedicHistory', 'TeleconsultaController@showMedicHistory')->middleware('jwt.medicos');
        Route::post('storeTeleconsultation', 'TeleconsultaController@store')->middleware('jwt.pacientes');
        Route::post('storeRecipe', 'TeleconsultaController@storeRecipe')->middleware('jwt.medicos');
        Route::post('storeUrl', 'TeleconsultaController@storeUrl')->middleware('jwt.medicos');
        Route::post('endTeleconsultation', 'TeleconsultaController@endTeleconsultation')->middleware('jwt.medicos');
        Route::put('{id}', 'TeleconsultaController@update');
        Route::delete('{id}', 'TeleconsultaController@remove');
    });

    //Medico
    Route::prefix('medico')->group(function () {
        Route::get('/', 'MedicoController@index');
        Route::post('/', 'MedicoController@store');
     
    });
    //auth
    Route::prefix('auth')->group(function () {
        //medicos
        Route::get('medicos', 'JWTMedicoController@getAuthenticatedMedico')->middleware('jwt.medicos');
        Route::post('medicos', 'JWTMedicoController@authenticate');
        Route::post('medicos/change-password', 'JWTMedicoController@changePassword')->middleware('jwt.medicos');
        Route::post('medicos/register', 'JWTMedicoController@register');
        Route::post('medicos/logout', 'JWTMedicoController@logout')->middleware('jwt.medicos');
    });

    Route::prefix('pagos')->group(function () {
        Route::post('/', 'PaymentController@orderCharge');     
        Route::post('orderChargeChat', 'PaymentController@orderChargeChat');   
    });
    

});

