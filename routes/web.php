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

//عند الضعط على رز اعداد قرار تشكيل الجنة
Route::get('/request_committee/decision to prepare a committee', [App\Http\Controllers\C_request_committee::class, 'decision_committee'])
->name('request_committee.decision_committee')->middleware('auth');

Route::get('/request_committee/decision to form committees at the relevant departments', [App\Http\Controllers\C_request_committee::class, 'decision_to_form_committees'])
->name('request_committee.decision_to_form_committees')->middleware('auth');

Route::get('/request_committee/final report for the adoption of the committees data', [App\Http\Controllers\C_request_committee::class, 'final_report_for_the_adoption'])
->name('request_committee.final_report_for_the_adoption')->middleware('auth');

Route::get('/request_committee/View committee details', [App\Http\Controllers\C_request_committee::class, 'view_committee_details'])
->name('request_committee.view_committee_details')->middleware('auth');

Route::get('/request_committee/composition of committee members', [App\Http\Controllers\C_request_committee::class, 'composition_of_committee_members'])
->name('request_committee.composition_of_committee_members')->middleware('auth');


Route::get('/request_committee/committee formation requests', [App\Http\Controllers\C_request_committee::class, 'committee_formation_requests'])
->name('request_committee.committee_formation_requests')->middleware('auth');
