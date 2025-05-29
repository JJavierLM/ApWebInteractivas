<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutosController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\Admin\EmpleadoController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\Auto;
use Livewire\Volt\Volt;

// Página de inicio
Route::get('/', function () {
    $autos = Auto::all();
    return view('inicio', compact('autos'));

})->name('home');

// -----------------------------
// AUTOS
// -----------------------------
Route::get('/autos', [AutosController::class, 'index'])->name('autos.index');
Route::get('/autos/crud', [AutosController::class, 'crud'])->name('autos.crud');
Route::post('/autos', [AutosController::class, 'store'])->name('autos.store');
Route::get('/autos/{id}/edit', [AutosController::class, 'edit'])->name('autos.edit');
Route::put('/autos/{id}', [AutosController::class, 'update'])->name('autos.update');
Route::delete('/autos/{id}', [AutosController::class, 'destroy'])->name('autos.destroy');

// -----------------------------
// USUARIOS
// -----------------------------
Route::resource('usuarios', UsuarioController::class)->except(['create', 'store', 'show']);

// -----------------------------
// CITAS (registro público)
// -----------------------------
Route::get('/citas', [CitasController::class, 'index'])->name('citas.index');
Route::post('/citas', [CitasController::class, 'store'])->name('citas.store');
Route::post('/citas/{id}/enviar-correo', [CitasController::class, 'enviarCorreo'])->name('citas.enviarCorreo');

// -----------------------------
// RUTAS PROTEGIDAS (solo autenticados)
// -----------------------------
Route::middleware(['auth'])->group(function () {
    // Citas privadas
    Route::get('/mis-citas', [CitasController::class, 'citasUsuario'])->name('citas.mis');
    Route::get('/citas/{id}/edit', [CitasController::class, 'edit'])->name('citas.edit');
    Route::put('/citas/{id}', [CitasController::class, 'update'])->name('citas.update');
    Route::delete('/citas/{id}', [CitasController::class, 'destroy'])->name('citas.destroy');

    // Ventas
    Route::get('/ventas', [VentasController::class, 'index'])->name('ventas.index');
    Route::post('/ventas', [VentasController::class, 'store'])->name('ventas.store');
    Route::get('/mis-ventas', [VentasController::class, 'misVentas'])->name('ventas.mis');
    Route::get('/ventas/{id}/edit', [VentasController::class, 'edit'])->name('ventas.edit');
    Route::put('/ventas/{id}', [VentasController::class, 'update'])->name('ventas.update');
    Route::delete('/ventas/{id}', [VentasController::class, 'destroy'])->name('ventas.destroy');
    Route::get('/reporte-ventas', [VentasController::class, 'reportePDF'])->name('ventas.reporte');

    // Empleados (CRUD - solo admin puede registrar, validado en controlador)
    Route::get('/empleados', [EmpleadoController::class, 'index'])->name('empleados.index');
    Route::post('/empleados', [EmpleadoController::class, 'store'])->name('empleados.store');
    Route::get('/empleados/{id}/edit', [EmpleadoController::class, 'edit'])->name('empleados.edit');
    Route::put('/empleados/{id}', [EmpleadoController::class, 'update'])->name('empleados.update');
    Route::delete('/empleados/{id}', [EmpleadoController::class, 'destroy'])->name('empleados.destroy');
});

// -----------------------------
// Registro de empleados (por admin)
// -----------------------------
Route::post('/registro/empleado', [RegisteredUserController::class, 'store'])->name('registro.empleado.store');

// -----------------------------
// Dashboard y ajustes
// -----------------------------
Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
