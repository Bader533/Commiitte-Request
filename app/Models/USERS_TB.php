<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use NunoMaduro\Collision\Adapters\Phpunit\State;
use PDO;

class USERS_TB extends Model
{
    use HasFactory;

    // كل المتخدمين الخاصين بادارة معينة
    public function get_users_dep($P_DEP_R_C_ID)
    {

        $sql = "begin HANI.Get_committee_users_dep(:P_DEP_R_C_ID,:req); end;";

        return DB::transaction(function ($conn) use ($sql, $P_DEP_R_C_ID) {
            $pdo = $conn->getPdo();

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':P_DEP_R_C_ID', $P_DEP_R_C_ID, PDO::PARAM_INT);
            $stmt->bindParam(':req', $req, PDO::PARAM_STMT);
            $stmt->execute();
            oci_execute($req, OCI_DEFAULT);
            oci_fetch_all($req, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            oci_free_cursor($req);

            return $array;
        });
    }
    //كل المستخدمين
    public function get_users_affairs()
    {
        $sql = "begin BADER.get_user_affairs(:req); end;";
        //procedure get_user_affairs(req OUT SYS_REFCURSOR)
        return DB::transaction(function ($conn) use ($sql) {
            $pdo = $conn->getPdo();

            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':req', $req, PDO::PARAM_STMT);
            $stmt->execute();
            oci_execute($req, OCI_DEFAULT);
            oci_fetch_all($req, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            oci_free_cursor($req);

            return $array;
        });
    }
    public function login($P_ID)
    {
        $sql = "begin HANI.Get_user_auth(:P_ID,:USER_INF,:USER_PERM,:CHECK_DATA,:MENU); end;";

        return DB::transaction(function ($conn) use ($sql, $P_ID) {
            $pdo = $conn->getPdo();

            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':USER_INF', $USER_INF, PDO::PARAM_STMT);
            $stmt->bindParam(':USER_PERM', $USER_PERM, PDO::PARAM_STMT);
            $stmt->bindParam(':MENU', $MENU, PDO::PARAM_STMT);

            $stmt->bindParam(':P_ID', $P_ID, PDO::PARAM_INT);
            $stmt->bindParam(':CHECK_DATA', $CHECK_DATA, PDO::PARAM_INT);


            $stmt->execute();
            oci_execute($USER_INF, OCI_DEFAULT);
            oci_execute($USER_PERM, OCI_DEFAULT);
            oci_execute($MENU, OCI_DEFAULT);
            oci_fetch_all($USER_INF, $USER_INF_array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            oci_fetch_all($USER_PERM, $USER_PERM_array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            oci_fetch_all($MENU, $MENU_array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);

            oci_free_cursor($MENU);
            oci_free_cursor($USER_INF);
            oci_free_cursor($USER_PERM);


            return [
                'user_inf' => $USER_INF_array,
                'user_perm' => $USER_PERM_array,
                'check_data'=>$CHECK_DATA,
                'menu'=>$MENU_array,
            ];
        });
    }

    public static function auth()
    {
       return (object) session()->get('user_data')['user_inf'][0];
    }


}
