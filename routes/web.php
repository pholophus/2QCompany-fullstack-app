<?php

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
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('welcome');
    
// });

// Route::resource('companies', CompanyController::class);
// Route::get('/companies/{company}/delete', [CompanyController::class, 'delete'])->name('companies.delete');

Route::redirect('/', '/companies');

Route::middleware(['auth'])->group(function () {

    // Companies resource routes
    Route::resource('companies', CompanyController::class);

    // Additional route for delete
    Route::get('/companies/{company}/delete', [CompanyController::class, 'delete'])->name('companies.delete');

});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
