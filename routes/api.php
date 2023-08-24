<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\Api\TeamController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*
*
* API routes for user
*
*/
Route::name('auth.')->group(function () {
    Route::post('login', [UserController::class, 'login'])->name('login');
    Route::post('register', [UserController::class, 'register'])->name('register');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [UserController::class, 'logout'])->name('logout');
        Route::get('user', [UserController::class, 'fetch'])->name('user');
    });
});


/*
*
* API routes for company
*
*/
Route::prefix('company')->name('company.')->middleware('auth:sanctum')->group(function () {
    Route::get('', [CompanyController::class, 'fetch'])->name('fetch');
    Route::post('', [CompanyController::class, 'createCompany'])->name('create');
    Route::post('update/{id}', [CompanyController::class, 'updateCompany'])->name('update');
});


/*
*
* API routes for team
*
*/
Route::prefix('team')->name('team.')->middleware('auth:sanctum')->group(function () {
    Route::post('', [TeamController::class, 'createTeam'])->name('create');
    Route::get('', [TeamController::class, 'fetch'])->name('fetch');
    Route::post('update/{id}', [TeamController::class, 'updateTeam'])->name('update');
    Route::delete('{id}', [TeamController::class, 'deleteTeam'])->name('delete');
});
