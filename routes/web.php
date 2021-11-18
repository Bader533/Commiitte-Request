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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/request_committee/create', [App\Http\Controllers\C_request_committee::class, 'create'])
->name('request_committee.create')->middleware('auth');

Route::get('/request_committee/form request', [App\Http\Controllers\C_request_committee::class, 'formrequest'])
->name('request_committee.formrequest')->middleware('auth');

Route::get('/request_committee/form request affairs', [App\Http\Controllers\C_request_committee::class, 'formrequestaffairs'])
->name('request_committee.formrequestaffairs')->middleware('auth');

Route::get('/request_committee/committee members', [App\Http\Controllers\C_request_committee::class, 'committee_members'])
->name('request_committee.committeemembers')->middleware('auth');

