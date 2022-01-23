<?php

use App\Http\Controllers\Auth\C_login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\C_request_committee;
use App\Http\Controllers\C_decision_committee;
use App\Models\USERS_TB;

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



//Auth::routes();
/************************************تسجيل الدخول*****************************************/
Route::get('/login', [C_login::class, 'index'])
    ->name('login');
Route::post('/login', [C_login::class, 'checkData'])
    ->name('login');
Route::post('/logout', [C_login::class, 'logout'])
    ->name('logout')->middleware('Auth');

// checkdata
/******************************************نهاية***********************************/

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('Auth');

/* ******************************************** طلب تقديم لجنة و تخزين الطلب ******************************************************** */

//عرض صفحة انشاء طلب
Route::get('/request_committee/create', [C_request_committee::class, 'create'])
    ->name('request_committee.create')->middleware('Auth','Rules:1');

//تخزين بيانات طلب
Route::post('/request_committee/store', [C_request_committee::class, 'storerequest'])
    ->name('request_committee.storerequest')->middleware('Auth','Rules:1|2');

/* *********************************************************** نهاية  *************************************************************** */
/************************************************بداية صفحة تظهر عند الوكيل ******************************************************** */

// عرض صفحة الوكيل للموافقة على الطلب
Route::get('/request_committee/agent/index', [App\Http\Controllers\C_request_committee_agent::class, 'index'])
    ->name('request_committee.agent.formrequest')->middleware('Auth','Rules:3');

//الموافقة او الرفض للطلب
Route::post('/request_committee/agent/status_step', [App\Http\Controllers\C_request_committee_agent::class, 'Post_req_agent'])
    ->name('request_committee.agent.status_step')->middleware('Auth','Rules:3|4');

//عرض تفاصيل الطلب
Route::get('/request_committee/agent/detalis_req', [App\Http\Controllers\C_request_committee_agent::class, 'details_req'])
    ->name('request_committee.agent.detalis_req')->middleware('Auth','Rules:3');
//عرض الطلبات في الجدول
Route::get('/request_committee/agent/GetDataTable', [App\Http\Controllers\C_request_committee_agent::class, 'GetDataTable'])
    ->name('request_committee.agent.GetDataTable')->middleware('Auth','Rules:3');


/**********************************************************نهاية الصفحة************************************************ */
/********************************************************** الشوون الادارية تشكليل اللجنة************************************************ */

//عرض تفاصيل اللجنة
Route::get('/request_committee/decision-to-prepare-a-committee/{id}', [C_decision_committee::class, 'get_request_committee'])
    ->name('request_committee.get_request_committee')->middleware('Auth','Rules:6');

//تعديل اللجنة
Route::post('/request_committee/decision-to-prepare-a-committee', [C_decision_committee::class, 'update_request'])
    ->name('request_committee.update_request')->middleware('Auth','Rules:8');
//db تعديل اللجنة
Route::post('/request_committee/decision-to-prepare-a-committee/update', [C_decision_committee::class, 'update_insert'])
    ->name('request_committee.update_request_db')->middleware('Auth','Rules:8');

// Route::post('/request_committee/delete-decision-to-prepare-a-committee/{id}', [C_decision_committee::class, 'delete_request'])
//     ->name('request_committee.delete_request');

// حذف الادارة المعنية
// Route::post('/request_committee/delete-decision-to-prepare-a-committee', [C_decision_committee::class, 'delete_request'])
//     ->name('request_committee.delete_request');

/********************************************************** الشوون الادارية تشكليل اللجنة نهاية ************************************************ */

// عرض صفحة الطلبات عند الشؤون الادارية
Route::get('/request_committee/affairs/index', [App\Http\Controllers\C_a_affairs::class, 'index'])
    ->name('request_committee.affairs.index')->middleware('Auth','Rules:6');
//عرض الطلبات في الجدول
Route::get('/request_committee/affairs/GetDataTable', [App\Http\Controllers\C_a_affairs::class, 'GetDataTable'])
    ->name('request_committee.affairs.GetDataTable')->middleware('Auth','Rules:6');
//عرض التفاصيل
Route::get('/request_committee/affairs/get_detials_req_affairs', [App\Http\Controllers\C_a_affairs::class, 'get_detials_req_affairs'])
    ->name('request_committee.affairs.get_detials_req_affairs')->middleware('Auth','Rules:6');


/******************************************************نهاية الصفحة******************************************************** */
/*************************************************ادارة معينة********************************/ // */
// صفحة لعرض جميع اللجان المشاركة فيها الادارة
Route::get('/request_committee/department/index', [App\Http\Controllers\C_request_committee_dep::class, 'index'])
    ->name('request_committee.department.index')->middleware('Auth','Rules:11');
//عرض الطلبات في الجدول
Route::get('/request_committee/department/GetDataTable', [App\Http\Controllers\C_request_committee_dep::class, 'GetDataTable'])
    ->name('request_committee.department.GetDataTable')->middleware('Auth','Rules:11');
//عرض التفاصيل
Route::get('/request_committee/department/get_detials_req_dep', [App\Http\Controllers\C_request_committee_dep::class, 'get_detials_req_dep'])
    ->name('request_committee.department.get_detials_req_dep')->middleware('Auth','Rules:11');
// عرض صفحة تشكيل اعضاء اللجان
Route::get('/request_committee/department/nomination/{id}', [App\Http\Controllers\C_request_committee_dep::class, 'nomination'])
    ->name('request_committee.department.nomination')->middleware('Auth','Rules:13');
// حذف  عضوا من الترشيح ادارة معينة
Route::post('/request_committee/department/nomination/delete_user', [App\Http\Controllers\C_request_committee_dep::class, 'delete_user'])
    ->name('request_committee.department.delete_user')->middleware('Auth');
//اضافة عضو الى الترشيح ادارة معينة
Route::post('/request_committee/department/nomination/add_user', [App\Http\Controllers\C_request_committee_dep::class, 'add_user'])
    ->name('request_committee.department.add_user')->middleware('Auth');
//اضافة الاعضاء المرشحين db
Route::post('/request_committee/department/nomination/add_users', [App\Http\Controllers\C_request_committee_dep::class, 'add_users'])
    ->name('request_committee.department.add_users')->middleware('Auth','Rules:15');


/**************************************************نهاية الصفحة ادارة معينة******************************** */
//********************************************************************************************************************************* */


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
Route::get('/', function () {

    //  $USERS_TB = new USERS_TB();
    //return  $USERS_TB = $USERS_TB->login(5);

});
