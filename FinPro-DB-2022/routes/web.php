<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\CartController;

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
})->name('/');

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
        Route::get('/home',[UserController::class,'home'])->name('home');
        Route::post('/addtocart',[CartController::class,'addtocart'])->name('addtocart');
        Route::get('/portofolio/{id}',[userController::class,'portofolio'])->name('portofolio');
        Route::get('/remove_cartitem/{id}',[CartController::class,'remove_cartitem'])->name('remove_cartitem');
        Route::get('/cart',[CartController::class,'cart'])->name('cart');
        Route::get('/checkout',[CartController::class,'checkout'])->name('checkout');
        Route::post('/payment',[CartController::class,'payment'])->name('payment');
        Route::post('/checkPayment',[CartController::class,'checkPayment'])->name('checkPayment');
        Route::get('/deliveryApprove/{id}',[CartController::class,'deliveryApprove'])->name('deliveryApprove');
        Route::get('/logout',[UserController::class,'logout'])->name('logout');
        Route::get('/transaction',[UserController::class,'transaction'])->name('transaction');
    });
});

Route::prefix('admin')->name('admin.')->group(function(){
    Route::middleware(['guest:admin','PreventBackHistory'])->group(function(){
        Route::post('/check',[StaffController::class,'check'])->name('check');
    });

    Route::middleware(['auth:admin','PreventBackHistory'])->group(function(){
        Route::view('/home','dashboard.admin.home')->name('home');
        Route::get('/menu',[AdminController::class,'menu'])->name('menu');
        Route::view('/upload/menu','dashboard.admin.uploads.menu')->name('uploadmenu');
        Route::get('/transaction',[AdminController::class,'transaction'])->name('transaction');
        Route::get('/staff',[AdminController::class,'staff'])->name('staff');
        Route::view('/upload/staff','dashboard.admin.uploads.staff')->name('uploadstaff');
        Route::get('/edit/staff/{id}',[AdminController::class,'editstaff'])->name('editstaff');
        Route::get('/edit/menu/{id}',[AdminController::class,'editmenu'])->name('editmenu');
        Route::post('/upload_menu',[AdminController::class,'upload_menu'])->name('upload_menu');
        Route::post('/uploadstaff',[AdminController::class,'upload_staff'])->name('upload_staff');
        Route::post('/edit_staff',[AdminController::class,'edit_staff'])->name('edit_staff');
        Route::post('/edit_menu',[AdminController::class,'edit_menu'])->name('edit_menu');
        Route::get('/delete/menu/{id}',[AdminController::class,'delete_menu'])->name('delete_menu');
        Route::get('/delete/staff/{id}',[AdminController::class,'delete_staff'])->name('delete_staff');
        Route::get('/logout',[StaffController::class,'logout'])->name('logout');
    });
});

Route::prefix('staff')->name('staff.')->group(function(){
    Route::middleware(['guest:staff','PreventBackHistory'])->group(function(){
        Route::view('/login','dashboard.staff.login')->name('login');
        Route::post('/check',[StaffController::class,'check'])->name('check');
    });

    Route::middleware(['auth:staff','PreventBackHistory'])->group(function(){
        Route::view('/home','dashboard.staff.home')->name('home');
        Route::get('/cashier',[StaffController::class,'cashier'])->name('cashier');
        Route::get('/cashier/approve/{id}',[StaffController::class,'cashierApprove'])->name('cashierApprove');
        Route::get('/chef/approve/{id}',[StaffController::class,'chefApprove'])->name('chefApprove');
        Route::get('/delivery/approve/{id}',[StaffController::class,'deliveryApprove'])->name('deliveryApprove');
        Route::get('/chef',[StaffController::class,'chef'])->name('chef');
        Route::get('/delivery',[StaffController::class,'delivery'])->name('delivery');
        Route::post('/download-file', [StaffController::class, 'download'])->name('download-file');
        Route::get('/menuDetails/{id}',[StaffController::class, 'menuDetails'])->name('menuDetails');
        Route::get('/logout',[AdminController::class,'logout'])->name('logout');
    });
});