<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CompanyController;
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
Route::post('login', [UserController::class, 'login']);

Route::post('register', [UserController::class, 'register']);

Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::get('user', [UserController::class, 'fetch'])->middleware('auth:sanctum');


/*
*
* API routes for company
*
*/
Route::get('/company', [CompanyController::class, 'all']);
