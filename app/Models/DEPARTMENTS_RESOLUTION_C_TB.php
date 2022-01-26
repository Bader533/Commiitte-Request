<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDO;

class DEPARTMENTS_RESOLUTION_C_TB extends Model
{
    use HasFactory;
    public function insert_dep_affairs($P_IDreq, $P_DEPARTMENTS_ID,$P_NUMBER_EMPLOYEE)
    {

        $sql = "begin
                BADER.insert_dep_affairs(:P_IDreq,:P_DEPARTMENTS_ID,:P_NUMBER_EMPLOYEE);
                end;";

        return DB::transaction(function ($conn) use ($sql,$P_IDreq,$P_DEPARTMENTS_ID,$P_NUMBER_EMPLOYEE) {

            $pdo = $conn->getPdo();
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':P_IDreq',$P_IDreq, PDO::PARAM_INT);
            $stmt->bindParam(':P_DEPARTMENTS_ID',$P_DEPARTMENTS_ID, PDO::PARAM_INT);
            $stmt->bindParam(':P_NUMBER_EMPLOYEE',$P_NUMBER_EMPLOYEE, PDO::PARAM_INT);

            $stmt->execute();


        });
    }




}
