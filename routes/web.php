<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
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
    return view('admin');
})->name('wellcome');



// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/login', function () {
//     return view('login');
// })->name('login');

// Route::get('/admin', function () {
//     return view('admin');
// });

// Route::get('/answer', function () {
//     return view('answer');
// });

// Route::get('passwordreset/{id}', [AuthController::class, 'resetpasswordview'])->name('resetpasswordview');
// Route::post('updatepassword', [AuthController::class, 'reset'])->name('resetpassword');

// Route::get('/downloadpdf/{id}',[PdfController::class,'downloadpdf']);
