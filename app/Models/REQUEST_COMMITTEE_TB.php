<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDO;

class REQUEST_COMMITTEE_TB extends Model
{
    use HasFactory;
  // public $id_rq,$status,$date_in,$date_to;
//كل طلبات اللجان الوكيل مع البحث
  public function get_req_agent($pageNumber,$id_rq,$status,$date_in,$date_to)
  {

      $sql = "begin
        HANI.Get_search_req_agent(:pageNumber,:id_rq,:date_in,:date_to,:status,:req);
      end;";
      return DB::transaction(function ($conn) use ($sql,$pageNumber,$id_rq,$status,$date_in,$date_to) {
          $pdo = $conn->getPdo();
          $stmt = $pdo->prepare($sql);
        // $p_count;
        //  $pageNumber =1;
          $stmt->bindParam(':id_rq',$id_rq, PDO::PARAM_NULL);
          $stmt->bindParam(':date_in',$date_in, PDO::PARAM_NULL);
          $stmt->bindParam(':date_to',$date_to, PDO::PARAM_NULL);
          $stmt->bindParam(':status',$status, PDO::PARAM_NULL);
          $stmt->bindParam(':pageNumber',$pageNumber, PDO::PARAM_NULL);
          $stmt->bindParam(':req', $req, PDO::PARAM_STMT);
       //   $stmt->bindParam(':p_count', $p_count, PDO::PARAM_NULL);

          $stmt->execute();
          oci_execute($req, OCI_DEFAULT);
          oci_fetch_all($req, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
          oci_free_cursor($req);

          return ['result'=>$array
                ];
      });
  }
//كل الطلبات  اللجان عند الشؤون الادارية مع البحث
public function get_req_affairs($pageNumber,$id_rq,$status,$date_in,$date_to)
{

    $sql = "begin
      HANI.Get_search_req_a_affairs(:pageNumber,:id_rq,:date_in,:date_to,:status,:req);
    end;";
    return DB::transaction(function ($conn) use ($sql,$pageNumber,$id_rq,$status,$date_in,$date_to) {
        $pdo = $conn->getPdo();
        $stmt = $pdo->prepare($sql);
      //  $pageNumber =1;
        $stmt->bindParam(':id_rq',$id_rq, PDO::PARAM_NULL);
        $stmt->bindParam(':date_in',$date_in, PDO::PARAM_NULL);
        $stmt->bindParam(':date_to',$date_to, PDO::PARAM_NULL);
        $stmt->bindParam(':status',$status, PDO::PARAM_NULL);
        $stmt->bindParam(':pageNumber',$pageNumber, PDO::PARAM_NULL);
        $stmt->bindParam(':req', $req, PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($req, OCI_DEFAULT);
        oci_fetch_all($req, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($req);

        return $array;
    });
}
//تغير حالة الطلب موافق او رفض من قبل الوكيل
public function change_status_req_agent()
{

}
}
