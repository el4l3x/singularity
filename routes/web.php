<?php

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\FranquiciaController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VisitaController;
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
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resources([
        'logs' => LogController::class,
        'franquicias' => FranquiciaController::class,
        'usuarios' => UsuarioController::class,
        'roles' => RoleController::class,
        'personas' => PersonaController::class,
        'empresas' => EmpresaController::class,
        'productos' => ProductoController::class,
        'servicios' => ServicioController::class,
        'etiquetas' => TagController::class,
    ]);

    Route::resource('franquicias.visitas', VisitaController::class)->shallow();
});
