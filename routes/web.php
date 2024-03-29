<?php

use App\Http\Controllers\Management\MenuController;
use App\Http\Controllers\Management\MenuParentController;
use App\Http\Controllers\Management\PermissionController;
use App\Http\Controllers\Management\RoleController;
use App\Http\Controllers\TelegramMessageControlle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::middleware('role:super admin|admin')->group(function () {
        Route::get('menus', [MenuController::class, 'index'])->name('menus.index')->middleware('permission:menus-index');
        Route::post('menus', [MenuController::class, 'store'])->name('menus.store')->middleware('permission:menus-store');
        Route::get('menus/{id}/edit', [MenuController::class, 'edit'])->name('menus.edit')->middleware('permission:menus-edit');
        Route::put('menus/{id}', [MenuController::class, 'update'])->name('menus.update')->middleware('permission:menus-update');
        Route::delete('menus/{id}', [MenuController::class, 'destroy'])->name('menus.destroy')->middleware('permission:menus-destroy');
    });

    Route::resource('menu-parents', MenuParentController::class);

    Route::resource('roles', RoleController::class);

    Route::resource('permissions', PermissionController::class);

    Route::get('/send-telegram-message', [TelegramMessageControlle::class, 'sendMessage']);
});
