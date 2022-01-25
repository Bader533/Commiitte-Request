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
    public function get_req_agent($id_rq, $status, $date_in, $date_to, $PageIndex, $PageSize)
    {
        /* id_rq NUMBER,date_in DATE,date_to DATE,status NUMBER,req out SYS_REFCURSOR,
      p_count out NUMBER,PageSize NUMBER DEFAULT 10,PageIndex  NUMBER DEFAULT 0 */
        // $PageSize =10;
        // $PageIndex=0;

        $sql = "begin
        HANI.Get_search_req_agent(:id_rq,:date_in,:date_to,:status,:req,:p_count,:PageSize,:PageIndex);
      end;";
        return DB::transaction(function ($conn) use ($sql, $id_rq, $status, $date_in, $date_to, $PageIndex, $PageSize) {
            $pdo = $conn->getPdo();
            $stmt = $pdo->prepare($sql);
            //  $PageSize =2;
            //  $PageIndex=1;
            //$pageNumber =1;
            $stmt->bindParam(':id_rq', $id_rq, PDO::PARAM_NULL);
            $stmt->bindParam(':date_in', $date_in, PDO::PARAM_NULL);
            $stmt->bindParam(':date_to', $date_to, PDO::PARAM_NULL);
            $stmt->bindParam(':status', $status, PDO::PARAM_NULL);
            $stmt->bindParam(':req', $req, PDO::PARAM_STMT);
            $stmt->bindParam(':p_count', $p_count, PDO::PARAM_NULL, 12);
            $stmt->bindParam(':PageSize', $PageSize, PDO::PARAM_INT);
            $stmt->bindParam(':PageIndex', $PageIndex, PDO::PARAM_INT);

            $stmt->execute();
            oci_execute($req, OCI_DEFAULT);
            oci_fetch_all($req, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            oci_free_cursor($req);

            return [
                'result' => $array,
                'p_count' => $p_count,
            ];
        });
    }
    //كل الطلبات  اللجان عند الشؤون الادارية مع البحث
    public function get_req_affairs($id_rq, $status, $date_in, $date_to, $PageIndex, $PageSize)
    {

        $sql = "begin
      HANI.Get_search_req_a_affairs(:id_rq,:date_in,:date_to,:status,:req,:p_count,:PageSize,:PageIndex);
    end;";
        return DB::transaction(function ($conn) use ($sql, $id_rq, $status, $date_in, $date_to, $PageIndex, $PageSize) {
            $pdo = $conn->getPdo();
            $stmt = $pdo->prepare($sql);
            //  $pageNumber =1;
            $stmt->bindParam(':id_rq', $id_rq, PDO::PARAM_NULL);
            $stmt->bindParam(':date_in', $date_in, PDO::PARAM_NULL);
            $stmt->bindParam(':date_to', $date_to, PDO::PARAM_NULL);
            $stmt->bindParam(':status', $status, PDO::PARAM_NULL);
            $stmt->bindParam(':req', $req, PDO::PARAM_STMT);
            $stmt->bindParam(':p_count', $p_count, PDO::PARAM_NULL, 12);
            $stmt->bindParam(':PageSize', $PageSize, PDO::PARAM_INT);
            $stmt->bindParam(':PageIndex', $PageIndex, PDO::PARAM_INT);
            $stmt->execute();
            oci_execute($req, OCI_DEFAULT);
            oci_fetch_all($req, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            oci_free_cursor($req);

            return [
                'result' => $array,
                'p_count' => $p_count,
            ];
        });
    }
    // كل طلبات اللجان عند ادارة معينة
    public function get_req_dep($id_rq, $status, $date_in, $date_to, $PageIndex, $PageSize ,$P_USER_DEP)
    {
        $sql = "begin
        HANI.Get_search_req_department(:id_rq,:date_in,:date_to,:status,:req,:p_count,:PageSize,:PageIndex,:P_USER_DEP );
        end;";
        return DB::transaction(function ($conn) use ($sql, $id_rq, $status, $date_in, $date_to, $PageIndex, $PageSize,$P_USER_DEP) {
            $pdo = $conn->getPdo();
            $stmt = $pdo->prepare($sql);
            //  $pageNumber =1;
            $stmt->bindParam(':id_rq', $id_rq, PDO::PARAM_NULL);
            $stmt->bindParam(':date_in', $date_in, PDO::PARAM_NULL);
            $stmt->bindParam(':date_to', $date_to, PDO::PARAM_NULL);
            $stmt->bindParam(':status', $status, PDO::PARAM_NULL);
            $stmt->bindParam(':req', $req, PDO::PARAM_STMT);
            $stmt->bindParam(':p_count', $p_count, PDO::PARAM_NULL, 12);
            $stmt->bindParam(':PageSize', $PageSize, PDO::PARAM_INT);
            $stmt->bindParam(':PageIndex', $PageIndex, PDO::PARAM_INT);
            $stmt->bindParam(':P_USER_DEP', $P_USER_DEP, PDO::PARAM_INT);

            $stmt->execute();
            oci_execute($req, OCI_DEFAULT);
            oci_fetch_all($req, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            oci_free_cursor($req);

            return [
                'result' => $array,
                'p_count' => $p_count,
            ];
        });
    }
    //تعديل بيانات الطلب عند الشؤون الادارية
    public function update_req_affairs($P_IDreq, $P_NATURE_COMMITTEE, $P_USER_CHAIMAN_ID, $P_END_DATE, $P_LAW)
    {

        $sql = "begin
                BADER.update_req_affairs(:P_IDreq,:P_NATURE_COMMITTEE,:P_USER_CHAIMAN_ID,:P_END_DATE,:P_LAW);
                end;";


        return DB::transaction(function ($conn) use ($sql, $P_IDreq, $P_NATURE_COMMITTEE, $P_USER_CHAIMAN_ID, $P_END_DATE, $P_LAW) {

            $pdo = $conn->getPdo();
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':P_IDreq',$P_IDreq, PDO::PARAM_INT);
            $stmt->bindParam(':P_NATURE_COMMITTEE',$P_NATURE_COMMITTEE, PDO::PARAM_STR);
            $stmt->bindParam(':P_USER_CHAIMAN_ID',$P_USER_CHAIMAN_ID, PDO::PARAM_INT);
            $stmt->bindParam(':P_END_DATE',$P_END_DATE, PDO::PARAM_NULL);
            $stmt->bindParam(':P_LAW',$P_LAW, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt){
                return [
                    'status' => true,
                    'msg' => 'تم الحفظ بنجاح',
                ];
            }
            else{
                return [
                    'status' => false,
                    'msg' => 'فشل الحفظ برجاء المحاوله مجددا',
                ];
            }
        });
    }
}
