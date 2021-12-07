<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\C_request_committee;
use App\Http\Controllers\C_decision_committee;


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



Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

/* ******************************************** طلب تقديم لجنة و تخزين الطلب ******************************************************** */

//عرض صفحة انشاء طلب
Route::get('/request_committee/create', [C_request_committee::class, 'create'])
    ->name('request_committee.create');

//تخزين بيانات طلب
Route::post('/request_committee/store', [C_request_committee::class, 'storerequest'])
    ->name('request_committee.storerequest');

/* *********************************************************** نهاية  *************************************************************** */


/************************************************بداية صفحة تظهر عند الوكيل ******************************************************** */

// عرض صفحة الوكيل للموافقة على الطلب
Route::get('/request_committee/agent/index', [App\Http\Controllers\C_request_committee_agent::class, 'index'])
    ->name('request_committee.agent.formrequest');

//الموافقة او الرفض للطلب
Route::post('/request_committee/agent/status_step', [App\Http\Controllers\C_request_committee_agent::class, 'Post_req_agent'])
    ->name('request_committee.agent.status_step');

//عرض تفاصيل الطلب
Route::get('/request_committee/agent/detalis_req', [App\Http\Controllers\C_request_committee_agent::class, 'details_req'])
    ->name('request_committee.agent.detalis_req');
//عرض الطلبات في الجدول
Route::get('/request_committee/agent/GetDataTable', [App\Http\Controllers\C_request_committee_agent::class, 'GetDataTable'])
    ->name('request_committee.agent.GetDataTable');


/**********************************************************نهاية الصفحة************************************************ */

/********************************************************** الشوون الادارية تشكليل اللجنة************************************************ */

//الشؤون الادارية -عند الضعط على زر اعداد قرار تشكيل لجنة
/*Route::get('/request_committee/decision-to-prepare-a-committee/{id}', [C_decision_committee::class, 'decision_committee'])
    ->name('request_committee.decision_committee');
*/
Route::get('/request_committee/decision-to-prepare-a-committee/{id}', [C_decision_committee::class, 'get_request_committee'])
    ->name('request_committee.get_request_committee');

// Route::get('/request_committee/decision-to-prepare-a-committee', [C_decision_committee::class, 'get_department'])
//     ->name('request_committee.get_department');

/********************************************************** الشوون الادارية تشكليل اللجنة نهاية ************************************************ */

// عرض صفحة الطلبات عند الشؤون الادارية
Route::get('/request_committee/affairs/index', [App\Http\Controllers\C_a_affairs::class, 'index'])
    ->name('request_committee.affairs.index');
Route::get('/request_committee/affairs/GetDataTable', [App\Http\Controllers\C_a_affairs::class, 'GetDataTable'])
    ->name('request_committee.affairs.GetDataTable');

/******************************************************نهاية الصفحة******************************************************** */
// عرض صفحة تشكيل اعضاء اللجان
Route::get('/request_committee/committee_members', [App\Http\Controllers\C_request_committee::class, 'committee_members'])
    ->name('request_committee.committeemembers');

// صفحة لعرض جميع اللجان المشاركة فيها الادارة
Route::get('/request_committee/decision to form committees at the relevant departments', [App\Http\Controllers\C_request_committee::class, 'decision_to_form_committees'])
    ->name('request_committee.decision_to_form_committees');
//صفحة لعرض التقرير النهائي لبيانات اللجان
Route::get('/request_committee/final report for the adoption of the committees data', [App\Http\Controllers\C_request_committee::class, 'final_report_for_the_adoption'])
    ->name('request_committee.final_report_for_the_adoption');
//صفحة لعرض تفاصيل اللجنة
Route::get('/request_committee/View committee details', [App\Http\Controllers\C_request_committee::class, 'view_committee_details'])
    ->name('request_committee.view_committee_details');
//صفحة لعرض اعضاء اللجنة و القونين يمكن من خلالها اعتماد اللجنة و رفعها للوكيل
Route::get('/request_committee/composition of committee members', [App\Http\Controllers\C_request_committee::class, 'composition_of_committee_members'])
    ->name('request_committee.composition_of_committee_members');
//صفحة لعرض كافة تفاصيل وبيانات اللجنةواعضائهاوالنصوصوالقوانين
Route::get('/request_committee/committee formation requests', [App\Http\Controllers\C_request_committee::class, 'committee_formation_requests'])
    ->name('request_committee.committee_formation_requests');
//صفحة لعرض جميع الاشعارات في النظام
Route::get('/request_committee/notification', [App\Http\Controllers\C_request_committee::class, 'notification'])
    ->name('request_committee.notification');


///test
/*Route::get('/test', function () {

});*/
