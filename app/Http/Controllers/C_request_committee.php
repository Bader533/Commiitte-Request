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
//الموافقة على الطلب من قبل الوكيل
    public function Post_req_agent()
    {
        $pdo = DB::getPdo();
        $ID = 10;
        $STATUS_TB_ID=2;
        $REQUEST_COMMITTEE_TB=2;
        $USERS_TB_ID=2;
        $NAME='الوكيل يوافق على الطلب';
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



    public function formrequest()
    {
        $sql = "begin
            HANI.Get_req_agent(:pageNumber,:req);
        end;";
        return DB::transaction(function ($conn) use ($sql) {
            $pdo = $conn->getPdo();
            $stmt = $pdo->prepare($sql);
            $pageNumber = 1;

            $stmt->bindParam(':pageNumber', $pageNumber, PDO::PARAM_INT);
            $stmt->bindParam(':req', $req, PDO::PARAM_STMT);

            $stmt->execute();

            oci_execute($req, OCI_DEFAULT);
            oci_fetch_all($req, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            oci_free_cursor($req);

            return view('request_committee.formrequest', [
                'result' => $array
            ]);
        });
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
