<?php


use App\Http\Controllers\web\AuthController;
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
Route::get('/',[AuthController::class, 'index'])->name('homePage')->middleware("maintenance");
Route::get('/maintenanceMode', [AuthController::class, 'maintenanceModePage'])->name('maintenanceMode');

Route::group(['middleware'=>'guest'],  function(){
    Route::get('/login',[AuthController::class, 'showLoginPage'])->name('loginPage');
});
Route::group(['middleware'=>['guest','maintenance']],  function(){
    Route::get('/register',[AuthController::class, 'showRegisterPage'])->name('registerPage');
    Route::get('/forgetPassword',[AuthController::class, 'showForgetPasswordPage'])->name('forgetPasswordPage');

});



