<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Ruta raíz redirige a tiendas si está autenticado, si no a login
Route::get('/', function () {
    return Auth::check() ? redirect()->route('stores.index') : redirect()->route('login');
});

// Rutas protegidas que requieren autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/tiendas', function () {
        return view('stores.index');
    })->name('stores.index');
    
    Route::get('/urls', function () {
        return view('url-index');
    })->name('urls.index');

    Route::get('/usuarios', function () {
        return view('users.index');
    })->name('users.index');
    
});

// Ruta de login (solo accesible si no está autenticado)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('auth.index');
    })->name('login');
});

// Ruta de logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');
