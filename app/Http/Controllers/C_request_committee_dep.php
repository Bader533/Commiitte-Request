<?php

namespace App\Http\Controllers;

use App\Models\REQUEST_COMMITTEE_TB;
use App\Models\ROLE_MEMBERS_C_TB;
use App\Models\STEPS_TB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class C_request_committee_dep extends Controller
{
    public function index()
    {
        return view('request_committee.dep_index');
    }
    public function GetDataTable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $PageIndex = $start / $length;
        $order = $request->get('order');
        $v_search = $request->search['value'];
        $column = array("id", "name", "updated_at");
        $dir = ($order[0]['dir'] === 'asc' ? 'asc' : 'desc');

        $number_req = $request->get('number_req');
        $status = $request->get('status');
        $date_start = $request->get('date_start');
        $date_end = $request->get('date_end');

        $REQUEST_COMMITTEE_TB = new REQUEST_COMMITTEE_TB();


        $get_a_affairs = $REQUEST_COMMITTEE_TB->get_req_dep($number_req, $status, $date_start, $date_end, (int)$PageIndex, (int)$length); //$dd->where('name', 'like', "%{$v_search}%")->where('isdelete',0)->skip($start)->take($length)->orderBy($column[$order[0]['column']],$dir)->get();
        $data = [];
        $d_count = $get_a_affairs['p_count'];

        foreach ($get_a_affairs['result'] as $index => $res) {
            $url = route('request_committee.department.nomination', ['id' => $res['ID']]);
            $action =   '<a href="' . $url . '" id="' . $res['ID'] . '"
            class=" bg-primary text-light rounded border-0 p-1">ترشيح اعضاء</a>';
            $status = ' <label id="' . $res['ID'] . '"
            class=" bg-warning text-light rounded border-0 p-1">قيد الانتظار</label >';
            if ($res['STATUS_TB_ID'] == 1) {
                $status =   '
              <label id="' . $res['ID'] . '"
            class="bg-primary text-light rounded border-0 p-1">موافقة</label >';
            }
            if ($res['STATUS_TB_ID'] == 2) {
                $status =   '
              <label id="' . $res['ID'] . '"
            class=" bg-danger text-light rounded border-0 p-1">رفض</label >';
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
                ];
        }

        return Response()->json([
            "draw" => $draw,
            "recordsTotal" => $d_count, //->count(),
            "recordsFiltered" => $d_count, //->count(),
            "data" => $data
        ]);
    }

    //عرض التفاصيل عند ادارة معينة
    public function get_detials_req_dep(Request $request)
    {
        $steps = new STEPS_TB();
        $get_detials_req_dep = $steps->get_detials_req_dep($request->id_req);

        $NAME_STEPS = explode(',', $get_detials_req_dep['steps'][0]['NAME_STEPS']);
        $STATUS_NAME = explode(',', $get_detials_req_dep['steps'][0]['STATUS_NAME']);
        return [
            'code' => 200,
            'result' => $get_detials_req_dep,
            'NAME_STEPS' => $NAME_STEPS,
            'STATUS_NAME' => $STATUS_NAME,
        ];
    }
    //صفحة ترشيح اعضاء لجنة معينة
    public function nomination($id)
    {
        $steps = new STEPS_TB();
        $detials_req_dep = $steps->get_detials_req_dep($id);

        // return $detials_req_dep['steps'][0]['ID_REQ'];
        return view('request_committee.committee-members', [
            'detials_req_dep' => $detials_req_dep
        ]);
    }
    // حذف عضو من الترشيح عند ادارة معينة
    public function delete_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
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
        $ROLE_MEMBERS_C =  new ROLE_MEMBERS_C_TB;

         if ($ROLE_MEMBERS_C->delete_user($request->id_user)) {
            return [
                'code' => 200,
                'message' => 'تمت العملية بنجاح'
            ];
         }

    }
    
}
