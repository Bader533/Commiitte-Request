<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDO;

class ROLE_MEMBERS_C_TB extends Model
{
    use HasFactory;

    //حذف ترشيح عضو من ادارة معينة
    public function delete_user($id_user)
    {

        $sql = "begin HANI.Post_committee_delete_dep(:id_user,:result_row); end;";

        return DB::transaction(function ($conn) use ($sql,$id_user) {
            $pdo = $conn->getPdo();

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_user',$id_user, PDO::PARAM_INT);
            $stmt->bindParam(':result_row',$result_row, PDO::PARAM_NULL);
            $stmt->execute();
          //  oci_execute($result_row, OCI_DEFAULT);
           // oci_fetch_all($result_row, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
           // oci_free_cursor($result_row);

            return $result_row;
        });
    }
    // اضافة عضو لترشيح من ادارة معينة
    public function add_user($id_user,$dep_R_C_ID,$text)
    {
        $P_DEPARTMENTS_R_C_ID =$dep_R_C_ID;
        $P_USERS_ID=$id_user;
        $P_TEXT =$text;

        $sql = "begin HANI.Post_committee_users_dep(:P_DEPARTMENTS_R_C_ID,:P_USERS_ID,:P_TEXT); end;";

        return DB::transaction(function ($conn) use ($sql,$P_DEPARTMENTS_R_C_ID,$P_USERS_ID,$P_TEXT) {
            $pdo = $conn->getPdo();

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':P_DEPARTMENTS_R_C_ID',$P_DEPARTMENTS_R_C_ID, PDO::PARAM_INT);
            $stmt->bindParam(':P_USERS_ID',$P_USERS_ID, PDO::PARAM_NULL);
            $stmt->bindParam(':P_TEXT',$P_TEXT, PDO::PARAM_NULL);
            $stmt->execute();

        });
    }
}
