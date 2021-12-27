<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDO;

class STEPS_TB extends Model
{
    use HasFactory;

//تغير حالة الطلب موافق او رفض من قبل الوكيل
public function change_status_req_agent($id_req,$P_STATUS_TB_ID)
{
    $pdo = DB::getPdo();
    $P_REQUEST_COMMITTEE_TB = $id_req;
    //  $USERS_TB_ID = 2;
    // $NAME = 'الوكيل يوافق على الطلب';
    $stmt = $pdo->prepare("begin HANI.Post_req_agent(:P_STATUS_TB_ID,:P_REQUEST_COMMITTEE_TB); end;");
    $stmt->bindParam(':P_STATUS_TB_ID', $P_STATUS_TB_ID, PDO::PARAM_INT);
    $stmt->bindParam(':P_REQUEST_COMMITTEE_TB', $P_REQUEST_COMMITTEE_TB, PDO::PARAM_INT);
    $stmt->execute();
}
//عرض تفاصيل الطلب عند الشؤون الادارية
public function get_detials_req_affairs($id_req)
{
    $sql = "begin
    HANI.Get_committee_details_affairs(:id_rq,:req);
          end;";
     $id_rq = $id_req;
    return DB::transaction(function ($conn) use ($sql,$id_rq) {
        $pdo = $conn->getPdo();

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_rq', $id_rq, PDO::PARAM_INT);
        $stmt->bindParam(':req', $req, PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($req, OCI_DEFAULT);
        oci_fetch_all($req, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($req);

        return $array;
    });
}
//عرض تفاصيل الطلب عند ادارة معينة
public function get_detials_req_dep($id_req)
{
    $sql = "begin
    HANI.Get_committee_details_dep(:id_rq,:req);
          end;";
     $id_rq = $id_req;
    return DB::transaction(function ($conn) use ($sql,$id_rq) {
        $pdo = $conn->getPdo();

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_rq', $id_rq, PDO::PARAM_INT);
        $stmt->bindParam(':req', $req, PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($req, OCI_DEFAULT);
        oci_fetch_all($req, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($req);

        return $array;
    });
}


}
