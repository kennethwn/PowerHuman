<?php

use App\Http\Controllers\UserController;
use Database\Factories\UserFactory;
use GuzzleHttp\Psr7\Request;
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

//Route::get('/user/{id}', [UserController::class, 'index']);

//Route::get('/user/name/{name?}', [UserController::class, 'findNameByCurrentUser']);

Route::get('/user/{name?}', function (string $name = 'John') {
    return $name;
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
