<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PDO;

class C_request_committee_agent extends Controller
{
    private $id_rq = 1;
    //الموافقة على الطلب من قبل الوكيل
    public function Post_req_agent(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:1,0',
        ]);

        if ($validator->fails()) {
            return response()->json(
                ['code' => 400,
                 'message' => $validator->errors()],
                400
            );
        }

        $STATUS_TB_ID = 0;
        if ($request->status == 1) {
            //موافقة
            $STATUS_TB_ID = 1;
        }
        if ($request->status == 0) {
            //رفض
            $STATUS_TB_ID = 2;
        }

        $pdo = DB::getPdo();

        $REQUEST_COMMITTEE_TB = $request->id_req;
        $USERS_TB_ID = 2;
        $NAME = 'الوكيل يوافق على الطلب';
        $stmt = $pdo->prepare("begin HANI.Post_req_agent(:STATUS_TB_ID,:REQUEST_COMMITTEE_TB,:USERS_TB_ID,:NAME); end;");
        $stmt->bindParam(':STATUS_TB_ID', $STATUS_TB_ID, PDO::PARAM_INT);
        $stmt->bindParam(':REQUEST_COMMITTEE_TB', $REQUEST_COMMITTEE_TB, PDO::PARAM_INT);
        $stmt->bindParam(':USERS_TB_ID', $USERS_TB_ID, PDO::PARAM_INT);
        $stmt->bindParam(':NAME', $NAME, PDO::PARAM_STR, 200);
        $stmt->execute();
        return [
            'code' => 200,
            'message' => 'تمت العملية بنجاح'
        ];
    }
    //عرض جميع الطلبات للوكيل
    public function formrequest()
    {
        $sql = "begin
           HANI.Get_req_agent(:pageNumber,:req);
               end;";
        return DB::transaction(function ($conn) use ($sql) {
            $pdo = $conn->getPdo();
            $stmt = $pdo->prepare($sql);
            $pageNumber = 1;
            $stmt->bindParam(':pageNumber', $pageNumber, PDO::PARAM_INT);
            $stmt->bindParam(':req', $req, PDO::PARAM_STMT);
            $stmt->execute();
            oci_execute($req, OCI_DEFAULT);
            oci_fetch_all($req, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            oci_free_cursor($req);


            return view('request_committee.request_committee_agent', [
                'result' => $array
            ]);
        });
    }
    //json
    public function req_all_json()
    {
        $sql = "begin
           HANI.Get_req_agent(:pageNumber,:req);
               end;";
        return DB::transaction(function ($conn) use ($sql) {
            $pdo = $conn->getPdo();
            $stmt = $pdo->prepare($sql);
            $pageNumber = 1;
            $stmt->bindParam(':pageNumber', $pageNumber, PDO::PARAM_INT);
            $stmt->bindParam(':req', $req, PDO::PARAM_STMT);
            $stmt->execute();
            oci_execute($req, OCI_DEFAULT);
            oci_fetch_all($req, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            oci_free_cursor($req);

            return [
                   'result' => $array
                  ];
        });
    }
    //عرض تفاصيل الطلب
    public function details_req(Request $request)
    {
        $sql = "begin
        HANI.Get_committee_details(:id_rq,:req);
              end;";
        $this->id_rq = $request->id_req;
        return DB::transaction(function ($conn) use ($sql) {
            $pdo = $conn->getPdo();

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_rq', $this->id_rq, PDO::PARAM_INT);
            $stmt->bindParam(':req', $req, PDO::PARAM_STMT);
            $stmt->execute();
            oci_execute($req, OCI_DEFAULT);
            oci_fetch_all($req, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            oci_free_cursor($req);

            return [
                'code' => 200,
                'result' => $array
            ];
        });
    }
    public function GetDataTable(Request $r)
    {
        $draw = $r->get('draw');
        $start = $r->get('start');
        $length = $r->get('length');
        $order = $r->get('order');
        $v_search = $r->search['value'];
        $column = array("id", "name", "updated_at");
        $dir = ($order[0]['dir'] ==='asc' ? 'asc' : 'desc');

        $dd = new Test();

        $d_count = 10;//$dd->Count();
        $d = $dd->get();//$dd->where('name', 'like', "%{$v_search}%")->where('isdelete',0)->skip($start)->take($length)->orderBy($column[$order[0]['column']],$dir)->get();
        //$data_res = $d->skip($start)->take($length)->get();
        $data = [];
        //dd($d);
        foreach($d as $index => $res)
        {
            $data []=
            [$index+1,
            $res['ID'],
            $res['REASON_COMMITTEE'],
            '<span class="svg-icon svg-icon-primary svg-icon-2x get_req_details" id="'.$res['ID'].'" data-bs-toggle="modal"
            data-bs-target="#kt_modal_view_users" scope="row">
            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Code/Warning-1-circle.svg--><svg
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24" />
                    <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
                    <rect fill="#000000" x="11" y="7" width="2" height="8" rx="1" />
                    <rect fill="#000000" x="11" y="16" width="2" height="2"
                        rx="1" />
                </g>
            </svg>
            <!--end::Svg Icon-->
        </span>',
        '<button id="'.$res['ID'].'"
        class="Post_req_agent_accept bg-primary text-light rounded border-0">موافقة</button>
    <button id="'.$res['ID'].'"
        class="Post_req_agent_reject bg-danger text-light rounded border-0">رفض</button>'
            // '<a href="add/'.encrypt($res->id).'" class="btn btn-sm btn-brand btn-elevate btn-icon" data-toggle="tooltip" title="تعديل"><i class="fa fa-edit"></i></a>
            // <button type="button" class="btn btn-sm btn-danger btn-elevate btn-icon btnDeleteItem" data-id="'.$res->id.'" data-skin="dark" data-toggle="tooltip" title="حذف"><i class="fa fa-times"></i></button>'
        ];
        }

        return Response()->json([
            "draw" => $draw,
            "recordsTotal" => $d_count,//->count(),
            "recordsFiltered" => $d_count,//->count(),
            "data" => $data
                    ]);
    }
}

