<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    // $pdo = DB::getPdo();
    // $P_ID = 111;
    // $P_DATE = '08/11/21';

    // $P_ster = "bader";
    // ID,USERS_TB_ID,USER_CHAIMAN_ID,NUMBER_COMMITTEE_MEMBER,START_DATE,COMMITTEE_TERM,REASON_COMMITTEE
    // $stmt = $pdo->prepare("begin BADER.insert_committee(:ID,:USERS_TB_ID,:USER_CHAIMAN_ID,:NUMBER_COMMITTEE_MEMBER,:START_DATE,:COMMITTEE_TERM,:REASON_COMMITTEE); end;");
    // $stmt->bindParam(':ID', $P_ID, PDO::PARAM_INT);
    // $stmt->bindParam(':USERS_TB_ID', $P_ID, PDO::PARAM_INT);
    // $stmt->bindParam(':USER_CHAIMAN_ID', $P_ID, PDO::PARAM_INT);
    // $stmt->bindParam(':NUMBER_COMMITTEE_MEMBER', $P_ID, PDO::PARAM_INT);

    // $stmt->bindParam(':START_DATE', $P_DATE, PDO::PARAM_STR);


    // $stmt->bindParam(':COMMITTEE_TERM', $P_ID, PDO::PARAM_INT);
    // $stmt->bindParam(':REASON_COMMITTEE', $P_ster, PDO::PARAM_STR, 225);
    // $stmt->execute();

    // dd($stmt);

    // return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/* ******************************************** request_committee ******************************************************** */

//عرض صفحة انشاء طلب
Route::get('/request_committee/create', [App\Http\Controllers\C_request_committee::class, 'create'])
    ->name('request_committee.create');

//تخزين بيانات طلب
Route::post('/request_committee/store', [App\Http\Controllers\C_request_committee::class, 'storerequest'])
    ->name('request_committee.storerequest');

/* *********************************************************************************************************************** */


/************************************************بداية صفحة تظهر عند الوكيل ******************************************************** */

// عرض صفحة الوكيل للموافقة على الطلب
Route::get('/request_committee/form_request', [App\Http\Controllers\C_request_committee_agent::class, 'formrequest'])
    ->name('request_committee.formrequest');
//الموافقة او الرفض للطلب
Route::post('/request_committee/form_request/status_step', [App\Http\Controllers\C_request_committee_agent::class, 'Post_req_agent'])
->name('request_committee.request_committee_agent');
 //عرض تفاصيل الطلب
 Route::get('/request_committee/form_request/detalis_req', [App\Http\Controllers\C_request_committee_agent::class, 'details_req'])
    ->name('request_committee.formrequest.detalis_req');
//كل الطلبات
Route::get('/request_committee/form_request/req_all_json', [App\Http\Controllers\C_request_committee_agent::class, 'req_all_json'])
->name('request_committee.formrequest.req_all_json');

Route::get('/request_committee/GetDataTable', [App\Http\Controllers\C_request_committee_agent::class, 'GetDataTable'])
;


/**********************************************************نهاية الصفحة************************************************ */

// عرض صفحة الطلبات عند الشؤون الادارية
Route::get('/request_committee/form_request_affairs', [App\Http\Controllers\C_request_committee::class, 'formrequestaffairs'])
    ->name('request_committee.formrequestaffairs');
// عرض صفحة تشكيل اعضاء اللجان
Route::get('/request_committee/committee_members', [App\Http\Controllers\C_request_committee::class, 'committee_members'])
    ->name('request_committee.committeemembers');
//الشؤون الادارية -عند الضعط على زر اعداد قرار تشكيل لجنة
Route::get('/request_committee/decision to prepare a committee', [App\Http\Controllers\C_request_committee::class, 'decision_committee'])
    ->name('request_committee.decision_committee');
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
Route::get('/test', function () {

});
