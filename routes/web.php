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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//عرض صفحة انشاء طلب
Route::get('/request_committee/create', [App\Http\Controllers\C_request_committee::class, 'create'])
->name('request_committee.create');
// عرض صفحة الوكيل للموافقة على الطلب
Route::get('/request_committee/form_request', [App\Http\Controllers\C_request_committee::class, 'formrequest'])
->name('request_committee.formrequest');
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
    //$d = new \App\Test();


//  return  $id = DB::connection('oracle')->table('USERS_TB')->get()->Count();

// تستخدم لارجاع CURSOR
/*$procedureName = 'HANI.Get_req_agent';
$bindings = [
    'P_PARENT_FORM_ID'=> 10001,
];
$result = DB::connection('oracle')->executeProcedure($procedureName, $bindings);
dd($result);
*/


// تستخدم لارجاع اي متغير رقم او نص

  $pdo = DB::connection('oracle')->getPdo();
$P_ID = 1;

$stmt = $pdo->prepare("begin HANI.Get_req_agent(:pageNumber,:req); end;");
$stmt->bindParam(':pageNumber',$P_ID, PDO::PARAM_INT);
$stmt->bindParam(':req', $req, PDO::PARAM_STMT);
$stmt->execute();
dd($stmt);
/******************************************************** */
$pdo = DB::getPdo();
$id = 10;

$stmt = $pdo->prepare("begin HANI.Get_test(:id, :id2); end;");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->bindParam(':id2', $id2, PDO::PARAM_INT);
$stmt->execute();

return $id2;


/*
// الاستخدام العادي الاوامر على الجدول مباشر
$id = DB::connection('oracle')->table('ALLOW_OFFICES_TB')->get()->Count();
*/

return 1;
   // return view('welcome');

});
