<?php

namespace App\Http\Controllers;

use App\Models\USERS_TB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use PDO;

use function PHPUnit\Framework\isEmpty;

class C_request_committee extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //-----------
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('request_committee.create');
    }

    public function storerequest(REQUEST $request)
    {
        $messages=$this->messages();

        $validator = Validator::make($request->all(), [
            'membercount' => 'required',
            'start_date' => 'required',
            'work_day' => 'required',
            'experience' => 'required',
        ],$messages);

        if ($validator->fails()) {
            return response()->json(
                ['code' => 400,
                 'message' => $validator->errors()],
                400
            );
        }

        $pdo = DB::getPdo();
        $P_ID =USERS_TB::auth()->ID;

        $membercount = $request->membercount;
        $start_date = $request->start_date;
        $work_day = $request->work_day;
        $experience = $request->experience;

        //اضافة طلب تشكيل لجنة
        $stmt = $pdo->prepare("begin BADER.insert_committee(:USERS_TB_ID,:USER_CHAIMAN_ID,:NUMBER_COMMITTEE_MEMBER,
                                                            :START_DATE,:COMMITTEE_TERM,:REASON_COMMITTEE,:p_cur); end;");

        $stmt->bindParam(':USERS_TB_ID', $P_ID, PDO::PARAM_INT);
        $stmt->bindParam(':USER_CHAIMAN_ID', $P_ID, PDO::PARAM_INT);
        $stmt->bindParam(':NUMBER_COMMITTEE_MEMBER', $membercount, PDO::PARAM_INT);
        $stmt->bindParam(':START_DATE', $start_date, PDO::PARAM_STR);
        $stmt->bindParam(':COMMITTEE_TERM', $work_day, PDO::PARAM_INT);
        $stmt->bindParam(':REASON_COMMITTEE', $experience, PDO::PARAM_STR, 225);
        $stmt->bindParam(':p_cur', $p_cur, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt)
            return response()->json([
                'status' => true,
                'msg' => 'تم الحفظ بنجاح',

            ]);

        else
            return response()->json([
                'status' => false,
                'msg' => 'فشل الحفظ برجاء المحاوله مجددا',
            ]);
    }


    public function messages()
    {

        return [

            'membercount.required' => 'عدد افراد اللجنة مطلوبة',
            'start_date.required' => 'تاريخ البدء مطلوبة',
            'work_day.required' => 'عدد ايام عمل اللجنة مطلوبة',
            'experience.required' => 'سبب انعقاد اللجنة مطلوبة',

        ];
    }





    //******************************************************************************** */


    public function final_report_for_the_adoption()
    {

        return view('request_committee.final-report for-the-adoption-of-the-committee-data');
    }

    public function view_committee_details()
    {
        return view('request_committee.view-committee-details');
    }

    public function composition_of_committee_members()
    {
        return view('request_committee.composition-of-committee-members');
    }

    public function committee_formation_requests()
    {
        return view('request_committee.committee-formation-requests');
    }

    public function notification()
    {
        return view('request_committee.notification');
    }
}
