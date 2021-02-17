<?php
/* nuevo video 5 comentario Michel */
use  App\Http\Controllers\EmpleadosController;

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
});
/*
Route::get('/empleados', function () {
    return view('empleados.index');
});

Route::get('/empleados/create', function () {
    return view('empleados.create');
});
*/

/* nuevo video 5 comentario Michel */
Route::resource('empleados', EmpleadosController::class)->middleware('auth');

Auth::routes(['register'=>false,'reset'=>false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
