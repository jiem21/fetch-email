<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\UserController;
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
// users
// Route::get('/', [ UserController::class, 'index' ]);
// Route::post('/user/register', [ UserController::class, 'register' ]);
// Route::get('/user/delete/{id}', [ UserController::class, 'delete' ]);

// emails
Route::get('/', [ EmailController::class, 'index' ]);
Route::get('/fetch-emails', [ EmailController::class, 'save_mails' ]);
