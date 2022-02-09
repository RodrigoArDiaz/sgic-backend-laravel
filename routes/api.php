<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthUsuariosController;
use App\Http\Controllers\AuthCatedrasController;
use App\Http\Controllers\Controller;
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
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

 /*
    Route::post('login', [AuthController::class, 'login']);

    Route::post('logout', [AuthController::class, 'logout']);
    
    Route::post('refresh', [AuthController::class, 'refresh']);
    
    Route::post('me', [AuthController::class, 'me']);
    
    Route::post('register', [AuthController::class, 'register']);

*/
/*
    Route::post('login2', [AuthUsuariosController::class, 'login']);

    Route::post('logout2', [AuthUsuariosController::class, 'logout']);
    
    Route::post('refresh2', [AuthUsuariosController::class, 'refresh']);
    
    Route::post('me2', [AuthUsuariosController::class, 'me']);
    
    Route::post('register2', [AuthUsuariosController::class, 'register']);



});
*/


Route::post('buscarcatedras', [AuthCatedrasController::class, 'BuscarCatedras']);
Route::post('borrarcatedra', [AuthCatedrasController::class, 'BorrarCatedra']);

Route::post('altacatedra', [AuthCatedrasController::class, 'AltaCatedra']);
Route::post('bajacatedra', [AuthCatedrasController::class, 'BajaCatedra']);

Route::post('consultarnomcat', [AuthCatedrasController::class, 'verifycat']);

Route::post('modificarcatedra', [AuthCatedrasController::class, 'ModificarCatedra']);

Route::post('consultarmail', [AuthUsuariosController::class, 'verifymail']);

Route::post('consultarlib', [AuthUsuariosController::class, 'verifylib']);
Route::post('consultardni', [AuthUsuariosController::class, 'verifydni']);
Route::post('consultarus', [AuthUsuariosController::class, 'verifyus']);

Route::post('acceso', [AuthUsuariosController::class, 'login']);

Route::post('registro', [AuthUsuariosController::class, 'registro']);

Route::post('reenviarlink', [AuthUsuariosController::class, 'ReenviarLinkActivacion']);
Route::post('restpass', [AuthUsuariosController::class, 'restablecerContrasena']);

Route::get('activarcuenta/{codigo}', [AuthUsuariosController::class, 'ActivarCuenta']);

Route::post('cambiarpass', [AuthUsuariosController::class, 'CambiarPass']);


//Route::post('envmail', [AuthUsuariosController::class, 'EnviarMail']);






Route::group(['middleware' => ['plogdoc']], function(){

    Route::post('acceso/docentes', [AuthUsuariosController::class, 'login']);

});

Route::group(['middleware' => ['plogalum']], function(){

    Route::post('acceso/alumnos', [AuthUsuariosController::class, 'login']);

});

Route::group(['middleware' => ['plogsuper']], function(){

    Route::post('acceso/super', [AuthUsuariosController::class, 'login']);

});



// acceso a las rutas de acuerdo al tipo
Route::group(['middleware' => ['auth:sanctum','palumno']], function(){

    Route::post('me2', [AuthUsuariosController::class, 'me']);
});

// acceso a rutas de acuerdo al tipo
Route::group(['middleware' => ['auth:sanctum','psuperadmin']], function(){

        
        // Route::post('me', [AuthUsuariosController::class, 'me']);
    Route::post('resultado', [Controller::class, 'resultado']);

});



Route::group(['middleware' => ['auth:sanctum','pdocente']], function(){

        
    Route::post('me3', [AuthUsuariosController::class, 'me']);
Route::post('resultado', [Controller::class, 'resultado']);

});

//logout
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('logout', [AuthUsuariosController::class, 'logout']);
    
    Route::post('modus', [AuthUsuariosController::class, 'ModificarUsuario']);

});


Route::post('me', [AuthUsuariosController::class, 'me']);
