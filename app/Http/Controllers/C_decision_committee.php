<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;
use phpDocumentor\Reflection\Types\This;
use PhpParser\Node\Stmt;

class C_decision_committee extends Controller
{
    public function decision_committee()
    {
        return view('request_committee.decision-to-prepare-a-committee');
    }

    //عرض بيانات اللجنة
    public function get_request_committee($id)
    {
        $sql = "begin BADER.get_request_commmittee(:IDreq,:p_request); end;";
        return DB::transaction(function ($conn) use ($sql,$id) {
            $pdo = $conn->getPdo();
            $stmt = $pdo->prepare($sql);
            $IDreq=$id;
            $stmt->bindParam(':IDreq',$IDreq, PDO::PARAM_INT);
            $stmt->bindParam(':p_request',$p_request, PDO::PARAM_STMT);
            $stmt->execute();
            oci_execute($p_request, OCI_DEFAULT);
            oci_fetch_all($p_request, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            oci_free_cursor($p_request);


            return view('request_committee.decision-to-prepare-a-committee', [
                'result' => $array,
                'dp' => $this->get_department()
            ]);
        });
    }

    // عرض الاقسام
    public function get_department()
    {
        $sql = "begin BADER.get_department(:p_department); end;";
        return DB::transaction(function ($conn) use ($sql) {
            $pdo = $conn->getPdo();
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':p_department', $p_department, PDO::PARAM_STMT);
            $stmt->execute();
            oci_execute($p_department, OCI_DEFAULT);
            oci_fetch_all($p_department, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            oci_free_cursor($p_department);
            return $array;
        });
    }

    public function update_request(REQUEST $request)
    {
        $pdo = DB::getPdo();
        $P_ID = 202;
            $department = $request->department;
            $numofemployee = $request->numofemployee;
        $work_day = $request->work_day;
        $experience = $request->experience;

        //اضافة طلب تشكيل لجنة
        $stmt = $pdo->prepare("begin BADER.insert_request_committe(:IDreq,:NATURECOMMITTEE,:LAWS); end;");

        $stmt->bindParam(':IDreq', $P_ID, PDO::PARAM_INT);
        $stmt->bindParam(':NATURECOMMITTEE', $P_ID, PDO::PARAM_INT);
        $stmt->bindParam(':LAWS', $membercount, PDO::PARAM_INT);
        // $stmt->bindParam(':START_DATE', $start_date, PDO::PARAM_STR);
        // $stmt->bindParam(':COMMITTEE_TERM', $work_day, PDO::PARAM_INT);
        // $stmt->bindParam(':REASON_COMMITTEE', $experience, PDO::PARAM_STR, 225);
        // $stmt->bindParam(':p_cur', $p_cur, PDO::PARAM_INT);
        $stmt->execute();
    }


}
