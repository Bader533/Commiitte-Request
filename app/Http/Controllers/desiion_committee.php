<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;
use PhpParser\Node\Stmt;

class desiion_committee extends Controller
{
    public function decision_committee()
    {
        return view('request_committee.decision-to-prepare-a-committee');
    }

    //عرض بيانات اللجنة
    public function get_request_committee()
    {

        $sql = "begin BADER.get_request_commmittee(:IDreq,:p_request); end;";
        return DB::transaction(function ($conn) use ($sql) {
            $pdo = $conn->getPdo();
            $stmt = $pdo->prepare($sql);
            $IDreq=180;
            $stmt->bindParam(':IDreq', $IDreq, PDO::PARAM_INT);
            $stmt->bindParam(':p_request', $p_request, PDO::PARAM_STMT);
            $stmt->execute();
            oci_execute($p_request, OCI_DEFAULT);
            oci_fetch_all($p_request, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            oci_free_cursor($p_request);

         return $array['id'];
            return view('request_committee.decision-to-prepare-a-committee', [
                 'result' => $array

            ]);
        });
    }


}
