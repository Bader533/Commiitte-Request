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
//كل طلبات اللجان مع البحث
  public function get_req_agent($id_rq,$status,$date_in,$date_to)
  {
   // $d=strtotime("1-1-2020");

   $date_in = 2020-1-1;
   // $date=date_create("2010-01-01");
   // $date_in =  date_format($date,"Y-mm-dd");
   /*  $this->$status =$status;
     $this->date_in =$date_start;
     $this->date_to =$date_end;
*/
dd($date_in);
        DB::setDateFormat('Y-MM-DD');
      $sql = "begin
        HANI.Get_search_req_agent(:id_rq,:date_in,:date_to,:status,:req);
      end;";
      return DB::transaction(function ($conn) use ($sql,$id_rq,$status,$date_in,$date_to) {
          $pdo = $conn->getPdo();
          $stmt = $pdo->prepare($sql);
        //  $pageNumber =1;
          $stmt->bindParam(':id_rq',$id_rq, PDO::PARAM_NULL);
          $stmt->bindParam(':date_in',$date_in, PDO::PARAM_NULL);
          $stmt->bindParam(':date_to',$date_to, PDO::PARAM_NULL);
          $stmt->bindParam(':status',$status, PDO::PARAM_NULL);
          $stmt->bindParam(':req', $req, PDO::PARAM_STMT);
          $stmt->execute();
          oci_execute($req, OCI_DEFAULT);
          oci_fetch_all($req, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
          oci_free_cursor($req);

          return $array;
      });
  }

   /* public function get($number_req,$status,$date_start,$date_end)
    {
     //  $this->$pageNumber = $pageNumber;
        $sql = "begin
    HANI.Get_req_agent(:pageNumber,:req);
        end;";
        return DB::transaction(function ($conn) use ($sql) {
            $pdo = $conn->getPdo();
            $stmt = $pdo->prepare($sql);
            $pageNumber =1;
            $stmt->bindParam(':pageNumber',$pageNumber, PDO::PARAM_INT);
            $stmt->bindParam(':req', $req, PDO::PARAM_STMT);
            $stmt->execute();
            oci_execute($req, OCI_DEFAULT);
            oci_fetch_all($req, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            oci_free_cursor($req);

            return $array;
        });
    }*/

}
