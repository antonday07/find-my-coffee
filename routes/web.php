<?php

use App\Http\Controllers\Web\AppController;
use App\Http\Controllers\Web\AuthenticationController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [AppController::class, 'getApp'])->middleware('auth');

Route::get('/login', [AppController::class, 'getLogin'])->middleware('guest')->name('login');
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login/{social}', [AuthenticationController::class, 'getSocialRedirect'])->middleware('guest');
Route::get('/login/{social}/callback', [AuthenticationController::class, 'getSocialCallback'])->middleware('guest');
