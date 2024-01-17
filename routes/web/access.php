<?php

use App\Enums\RoutesNamesEnum;
use App\Http\Controllers\web\AuthController;
use App\Http\Controllers\web\RoutesController;
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

Route::group(['middleware' => ['auth']], function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::group(['middleware' => ['auth','maintenance']], function () {
    Route::get('/noAccess', [AuthController::class, 'noAccessPage'])->name('noAccess');
    Route::get('/changePassword', [AuthController::class, 'changePasswordPage'])->name('changePassword');
    Route::get('/home', [RoutesController::class, 'showUserPage'])->name(RoutesNamesEnum::USER_ROUTE);

    // Establishment Route with optional 'id' parameter
    Route::middleware('can:admin-access')->group(function () {
        Route::get('/dashboard', [RoutesController::class, 'showAdminPage'])->name(RoutesNamesEnum::ADMIN_ROUTE);
        Route::get('/manageUsers', [RoutesController::class, 'showUsersPage'])->name("users");
    });
    // Establishment Route with optional 'id' parameter
    Route::middleware('can:admin-establishment-access')->group(function () {
        Route::get('/establishment', [
            RoutesController::class, 'showEstablishmentPage'])
            ->name(RoutesNamesEnum::ESTABLISHMENT_ROUTE);
        Route::get('/places-of-consultations', [
            RoutesController::class, 'showPlaceOfConsultationPage'])
            ->name("places-of-consultations");
    });// Define a constraint for the 'id' parameter, if necessary


    // Service Route with optional 'id' parameter
    Route::middleware('can:admin-service-access')->group(function () {
        Route::get('/services', [RoutesController::class, 'showServicePage'])
            ->name(RoutesNamesEnum::SERVICE_ROUTE);
         Route::get('/doctors/{establishmentId?}', [RoutesController::class, 'showDoctorsPage'])
            ->name('doctors');
    });

    // Place of Consultation Route
    Route::middleware('can:admin-place-of-consultation-access')->group(function () {
        Route::get('/consultationsServices', [RoutesController::class, 'showPlaceOfConsultationAdminPage'])
        ->name(RoutesNamesEnum::PLACE_Of_CONSULTATION_ROUTE);
    });

    // Doctor Route
    Route::middleware('can:doctor-access')->group(function () {
        Route::get('/doctor', [RoutesController::class, 'showDoctorPage'])
            ->name(RoutesNamesEnum::DOCTOR_ROUTE);
    });
});
