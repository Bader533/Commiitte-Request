<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class C_request_committee extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ///-----------
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

        // dd($request->start_date,$request->work_day,$request->membercount);
        // dd($request->membercount);

        $pdo = DB::getPdo();
        $P_ID = 111;
        $membercount = $request->membercount;
        $start_date = $request->start_date;
        $work_day =$request->work_day;
        $experience =$request->experience;

        $stmt = $pdo->prepare("begin BADER.insert_committee(:ID,:USERS_TB_ID,:USER_CHAIMAN_ID,:NUMBER_COMMITTEE_MEMBER,:START_DATE,:COMMITTEE_TERM,:REASON_COMMITTEE); end;");
        $stmt->bindParam(':ID', $P_ID, PDO::PARAM_INT);
        $stmt->bindParam(':USERS_TB_ID', $P_ID, PDO::PARAM_INT);
        $stmt->bindParam(':USER_CHAIMAN_ID', $P_ID, PDO::PARAM_INT);
        $stmt->bindParam(':NUMBER_COMMITTEE_MEMBER', $membercount, PDO::PARAM_INT);
        $stmt->bindParam(':START_DATE', $start_date, PDO::PARAM_STR);
        $stmt->bindParam(':COMMITTEE_TERM', $work_day, PDO::PARAM_INT);
        $stmt->bindParam(':REASON_COMMITTEE', $experience, PDO::PARAM_STR, 225);
        $stmt->execute();

        dd($stmt);

    }

    public function formrequestaffairs()
    {

        return view('request_committee.formrequest-affairs');
    }

    public function committee_members()
    {

        return view('request_committee.committee-members');
    }

    public function decision_committee()
    {
        return view('request_committee.decision-to-prepare-a-committee');
    }

    public function decision_to_form_committees()
    {

        return view('request_committee.decision-to-form-committees-at-the-relevant-departments');
    }

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
