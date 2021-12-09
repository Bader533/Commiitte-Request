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

}
