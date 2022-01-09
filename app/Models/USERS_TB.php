<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDO;

class USERS_TB extends Model
{
    use HasFactory;

    // كل المتخدمين الخاصين بادارة معينة
    public function get_users_dep($P_DEPARTMENTS_TB_ID,$P_DEP_R_C_ID)
    {

        $sql = "begin HANI.Get_committee_users_dep(:P_DEPARTMENTS_TB_ID,:P_DEP_R_C_ID,:req); end;";

        return DB::transaction(function ($conn) use ($sql,$P_DEPARTMENTS_TB_ID,$P_DEP_R_C_ID) {
            $pdo = $conn->getPdo();

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':P_DEPARTMENTS_TB_ID',$P_DEPARTMENTS_TB_ID, PDO::PARAM_INT);
            $stmt->bindParam(':P_DEP_R_C_ID',$P_DEP_R_C_ID, PDO::PARAM_INT);
            $stmt->bindParam(':req',$req, PDO::PARAM_STMT);
            $stmt->execute();
            oci_execute($req, OCI_DEFAULT);
            oci_fetch_all($req, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            oci_free_cursor($req);

            return $array;
        });
    }
}
