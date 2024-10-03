<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', function(){
        return redirect('/login');
    });

    Route::get('/login', [App\Http\Controllers\AuthController::class, 'index']);
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function(){
        return redirect('/dashboard');
    });

    Route::get('/dashboard', App\Http\Controllers\DashboardController::class)->name('dashboard.index');

    Route::prefix('master')->group(function() {
        Route::resource('/divisions', \App\Http\Controllers\Master\DivisionController::class, [ 'except' => [ 'show' ] ])
        ->middleware('permission:master.divisions.index|master.divisions.create|master.divisions.edit|master.divisions.destroy');

        Route::resource('/instructions', \App\Http\Controllers\Master\InstructionController::class, [ 'except' => [ 'show' ] ])
        ->middleware('permission:master.instructions.index|master.instructions.create|master.instructions.edit|master.instructions.destroy');
    });

    Route::prefix('master')->group(function() {
        Route::resource('/dispositions', \App\Http\Controllers\Transaction\DispositionController::class)
        ->middleware('permission:transaction.dispositions.index|transaction.dispositions.create|transaction.dispositions.edit|transaction.dispositions.destroy');

    });

    Route::prefix('setting')->group(function(){
        Route::resource('/users', \App\Http\Controllers\Setting\UserController::class, [ 'except' => [ 'show' ] ])
        ->middleware('permission:setting.users.index|setting.users.create|setting.users.edit|setting.users.destroy');

        Route::resource('/roles', \App\Http\Controllers\Setting\RoleController::class, [ 'except' => [ 'show' ] ])
        ->middleware('permission:setting.roles.index|setting.roles.create|setting.roles.edit|setting.roles.destroy');

        Route::resource('/permissions', \App\Http\Controllers\Setting\PermissionController::class, [ 'only' => [ 'index', 'create', 'store' ] ])
        ->middleware('permission:setting.permission.index|setting.permission.create');
    });

    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
});
