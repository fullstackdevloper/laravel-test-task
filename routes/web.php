<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Frontend\FrontendController;


use App\Http\Controllers\HomeController;





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


Route::get('logout', function ()
{
     Auth::logout();
     return redirect('/admin'); 
});




Route::prefix('admin')->group(function ()
{
    Route::get('/', function ()
    {
        return view('admin.login');
    })->middleware(['guest']);
    ;
    Route::get('/forgotPassword', function ()
    {
        return view('admin.forgotPassword');
    })->middleware(['guest']);

  
    Route::group(['middleware' => ['role:Admin' ]], function ()
    {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);


    });
 
});
Route::get('/shop', [FrontendController::class, 'index']);
Route::get('/category/{id}', [FrontendController::class, 'fetchProduct'])->name('category');
Route::get('/product/{id}', [FrontendController::class, 'singleProduct'])->name('singleProduct');

Route::prefix('')->group(function ()
{
    Route::get('register', function ()
    {
        return redirect('/register');
    });
  
    Route::get('{any}', function ()
    {
        return redirect('/admin');
    })->where('any', '.*');
});


Auth::routes([
    'register' => true
]);
