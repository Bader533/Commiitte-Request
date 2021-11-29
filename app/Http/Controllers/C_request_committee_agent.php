<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class C_request_committee_agent extends Controller
{
   //الموافقة على الطلب من قبل الوكيل
   public function Post_req_agent()
   {
       $pdo = DB::getPdo();
       $ID = 10;
       $STATUS_TB_ID=2;
       $REQUEST_COMMITTEE_TB=2;
       $USERS_TB_ID=2;
       $NAME='الوكيل يوافق على الطلب';
   }
}
