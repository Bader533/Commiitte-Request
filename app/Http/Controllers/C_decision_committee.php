<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
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
        return DB::transaction(function ($conn) use ($sql, $id) {
            $pdo = $conn->getPdo();
            $stmt = $pdo->prepare($sql);
            $IDreq = $id;
            $stmt->bindParam(':IDreq', $IDreq, PDO::PARAM_INT);
            $stmt->bindParam(':p_request', $p_request, PDO::PARAM_STMT);
            $stmt->execute();
            oci_execute($p_request, OCI_DEFAULT);
            oci_fetch_all($p_request, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            oci_free_cursor($p_request);


            return view('request_committee.decision-to-prepare-a-committee', [
                'result' => $array,
                'dp' => $this->get_department(),
                'request_dep' => $this->get_request(202),
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

    //عرض اقسام الخاصة بالطلب
    public function get_request($id)
    {

        $sql = "begin BADER.get_request_department(:IDreq,:P_request); end;";

        return DB::transaction(function ($conn) use ($sql, $id) {
            $pdo = $conn->getPdo();
            $stmt = $pdo->prepare($sql);
            $IDreq = $id;
            $stmt->bindParam(':IDreq', $IDreq, PDO::PARAM_INT);
            $stmt->bindParam(':p_request', $p_request, PDO::PARAM_STMT);
            $stmt->execute();
            oci_execute($p_request, OCI_DEFAULT);
            oci_fetch_all($p_request, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            oci_free_cursor($p_request);
            return $array;
        });
    }

    //اضافة على بيانات  على الطلب
    public function update_request(REQUEST $request)
    {

        $validator = Validator::make($request->all(), [
            'department' => 'required',
            'numofemployee' => 'required',
            'nature_committe' => 'required',
            'law' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'code' => 400,
                    'message' => $validator->errors()
                ],
                400
            );
        }

        $pdo = DB::getPdo();
        $P_ID = $request->id_request;
        $department = $request->department;
        $numofemployee = $request->numofemployee;
        $naturecommitte = $request->nature_committe;
        $law = $request->law;



        //اضافة طلب تشكيل لجنة
        $stmt = $pdo->prepare("begin BADER.insert_request_committe(:IDreq,:NATURECOMMITTEE,:LAWS,:DEPARTMENTS_ID,:NUMBER_EMPLOYEE); end;");

        $stmt->bindParam(':IDreq', $P_ID, PDO::PARAM_INT);
        $stmt->bindParam(':NATURECOMMITTEE', $naturecommitte, PDO::PARAM_STR);
        $stmt->bindParam(':LAWS', $law, PDO::PARAM_STR);
        $stmt->bindParam(':DEPARTMENTS_ID', $department, PDO::PARAM_INT);
        $stmt->bindParam(':NUMBER_EMPLOYEE', $numofemployee, PDO::PARAM_INT);
        // $stmt->bindParam(':REASON_COMMITTEE', $experience, PDO::PARAM_STR, 225);
        // $stmt->bindParam(':p_cur', $p_cur, PDO::PARAM_INT);
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

    //حذف الادارة المعنية
    public function delete_request(Request $request)
    {


    }

}
