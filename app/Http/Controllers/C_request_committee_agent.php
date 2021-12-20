<?php

namespace App\Http\Controllers;

use App\Models\REQUEST_COMMITTEE_TB;
use App\Models\STEPS_TB;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PDO;
// صفحة الوكيل لعرض الطلبات
class C_request_committee_agent extends Controller
{
    private $id_rq = 1;
    //الموافقة على الطلب من قبل الوكيل
    public function Post_req_agent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:1,0',
            'id_req' =>  'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(
                [
                  'code' => 400,
                  'message' => $validator->errors()
                ],
                400
            );
        }

        $P_STATUS_TB_ID = 0;
        if ($request->status == 1) {
            //موافقة
            $P_STATUS_TB_ID = 1;
        }
        if ($request->status == 0) {
            //رفض
            $P_STATUS_TB_ID = 2;
        }
        $id_req = $request->id_req;
        $STEPS_TB = new STEPS_TB();
        $STEPS_TB->change_status_req_agent($id_req,$P_STATUS_TB_ID);
        return [
            'code' => 200,
            'message' => 'تمت العملية بنجاح'
        ];
    }
    //عرض صفحة الطلبات للوكيل
    public function index()
    {
            return view('request_committee.request_committee_agent');

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
    //عرض جميع الطلبات للوكيل
    public function GetDataTable(Request $request)
    {
        $draw = $request->get('draw');//draw
        $start = $request->get('start');//0
     // $start=1;
        $length = $request->get('length');//10
        $PageIndex=$start/$length;
     // $length=10;
        $order = $request->get('order');
        $v_search = $request->search['value'];
        $column = array("id", "name", "updated_at");
        $dir = ($order[0]['dir'] === 'asc' ? 'asc' : 'desc');

        $number_req = $request->get('number_req');
        $status = $request->get('status');
        $date_start = $request->get('date_start');
        $date_end = $request->get('date_end');

        $REQUEST_COMMITTEE_TB = new REQUEST_COMMITTEE_TB();

         //$dd->Count();

        $get_req_agent = $REQUEST_COMMITTEE_TB->get_req_agent($number_req, $status, $date_start, $date_end,(int)$PageIndex,(int)$length); //$dd->where('name', 'like', "%{$v_search}%")->where('isdelete',0)->skip($start)->take($length)->orderBy($column[$order[0]['column']],$dir)->get();
        //$data_res = $d->skip($start)->take($length)->get();
       // dd($get_req_agent['result']);
        $d_count = $get_req_agent['p_count'];
      //  dd($d_count);
        $data = [];


        foreach ($get_req_agent['result'] as $index => $res) {
            $action =   '<button id="' . $res['ID'] . '"
            class="Post_req_agent_accept bg-primary text-light rounded border-0">موافقة</button>
              <button id="' . $res['ID'] . '"
            class="Post_req_agent_reject bg-danger text-light rounded border-0">رفض</button>';
            if ($res['STATUS_TB_ID'] == 1 || $res['STATUS_TB_ID'] == 2) {
                $action =   '<button id="' . $res['ID'] . '"
            <button id=""
            class="bg-warning text-light rounded border-0">تم الاجراء</button>';
            }
            $data[] =
                [
                    $index + 1,
                    $res['ID'],
                    $res['REASON_COMMITTEE'],
                    '<span class="svg-icon svg-icon-primary svg-icon-2x get_req_details" id="' . $res['ID'] . '" data-bs-toggle="modal"
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
                    $action

                    // '<a href="add/'.encrypt($res->id).'" class="btn btn-sm btn-brand btn-elevate btn-icon" data-toggle="tooltip" title="تعديل"><i class="fa fa-edit"></i></a>
                    // <button type="button" class="btn btn-sm btn-danger btn-elevate btn-icon btnDeleteItem" data-id="'.$res->id.'" data-skin="dark" data-toggle="tooltip" title="حذف"><i class="fa fa-times"></i></button>'
                ];
        }

        return Response()->json([
            "draw" => $draw,
            "recordsTotal" => $d_count, //->count(),
            "recordsFiltered" => $d_count, //->count(),
            "data" => $data
        ]);
    }
}
