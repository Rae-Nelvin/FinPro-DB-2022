<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Staff\StaffController;

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

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::view('/login','dashboard.user.login')->name('login');
Route::view('/register','dashboard.user.register')->name('register');

Route::prefix('user')->name('user.')->group(function(){
    Route::middleware(['guest:web','PreventBackHistory'])->group(function(){
        Route::post('/create',[UserController::class,'create'])->name('create');
        Route::post('/check',[UserController::class,'check'])->name('check');
    });

    Route::middleware(['auth:web','PreventBackHistory'])->group(function(){
        Route::view('/home','dashboard.user.home')->name('home');
        Route::post('/logout',[UserController::class,'logout'])->name('logout');
    });
});

Route::prefix('admin')->name('admin.')->group(function(){
    Route::middleware(['guest:admin','PreventBackHistory'])->group(function(){
        Route::post('/check',[StaffController::class,'check'])->name('check');
    });

    Route::middleware(['auth:admin','PreventBackHistory'])->group(function(){
        Route::view('/home','dashboard.admin.home')->name('home');
        Route::view('/menu','dashboard.admin.menu')->name('menu');
        Route::view('/upload/menu','dashboard.admin.uploads.menu')->name('uploadmenu');
        Route::view('/transaction','dashboard.admin.transaction')->name('transaction');
        Route::post('/uploadmenu',[AdminController::class,'uploadmenu'])->name('uploadmenu');
        Route::post('/logout',[StaffController::class,'logout'])->name('logout');
    });
});

Route::prefix('staff')->name('staff.')->group(function(){
    Route::middleware(['guest:staff','PreventBackHistory'])->group(function(){
        Route::view('/login','dashboard.staff.login')->name('login');
        Route::post('/check',[StaffController::class,'check'])->name('check');
    });

    Route::middleware(['auth:staff','PreventBackHistory'])->group(function(){
        Route::view('/home','dashboard.staff.home')->name('home');
        Route::post('/logout',[StaffController::class,'logout'])->name('logout');
    });
});