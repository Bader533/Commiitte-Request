<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class C_request_committee_agent extends Controller
{
    //الموافقة على الطلب من قبل الوكيل
    public function Post_req_agent()
    {
        $pdo = DB::getPdo();
        $STATUS_TB_ID = 2;
        $REQUEST_COMMITTEE_TB = 2;
        $USERS_TB_ID = 2;
        $NAME = 'الوكيل يوافق على الطلب';
        $stmt = $pdo->prepare("begin HANI.Post_req_agent(:STATUS_TB_ID,:REQUEST_COMMITTEE_TB,:USERS_TB_ID,:NAME); end;");
        $stmt->bindParam(':STATUS_TB_ID', $STATUS_TB_ID, PDO::PARAM_INT);
        $stmt->bindParam(':REQUEST_COMMITTEE_TB', $REQUEST_COMMITTEE_TB, PDO::PARAM_STMT);
        $stmt->bindParam(':USERS_TB_ID', $USERS_TB_ID, PDO::PARAM_INT);
        $stmt->bindParam(':NAME', $NAME, PDO::PARAM_STR, 200);
        $stmt->execute();

        
    }
    //عرض جميع الطلبات للوكيل
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
}
