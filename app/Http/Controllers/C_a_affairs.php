<?php

namespace App\Http\Controllers;

use App\Models\REQUEST_COMMITTEE_TB;
use App\Models\STEPS_TB;
use Illuminate\Http\Request;
//صفحة الشؤون الادارية
class C_a_affairs extends Controller
{

    //عرض الصفحة
    public function index()
    {

        return view('request_committee.formrequest-affairs');
    }
    //كل الطلبات ما بعد موافقة الوكيل
    public function GetDataTable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $PageIndex=$start/$length;
        $order = $request->get('order');
        $v_search = $request->search['value'];
        $column = array("id", "name", "updated_at");
        $dir = ($order[0]['dir'] === 'asc' ? 'asc' : 'desc');

        $number_req = $request->get('number_req');
        $status = $request->get('status');
        $date_start = $request->get('date_start');
        $date_end = $request->get('date_end');

        $REQUEST_COMMITTEE_TB= new REQUEST_COMMITTEE_TB();


        $get_a_affairs= $REQUEST_COMMITTEE_TB->get_req_affairs($number_req, $status, $date_start, $date_end,(int)$PageIndex,(int)$length); //$dd->where('name', 'like', "%{$v_search}%")->where('isdelete',0)->skip($start)->take($length)->orderBy($column[$order[0]['column']],$dir)->get();
        //$data_res = $d->skip($start)->take($length)->get();
        $data = [];
        $d_count = $get_a_affairs['p_count'];
        //dd($d);

        foreach ($get_a_affairs['result'] as $index => $res) {
         $url = route('request_committee.get_request_committee',['id' =>$res['ID']]);
            $action =   '<a href="'.$url.'" id="' . $res['ID'] . '"
            class=" bg-primary text-light rounded border-0">اعداد قرار تشكيل لجنة</a>';
            $status = ' <label id="' . $res['ID'] . '"
            class=" bg-warning text-light rounded border-0">قيد الانتظار</label >';
            if ($res['STATUS_TB_ID'] == 1) {
                $status =   '
              <label id="' . $res['ID'] . '"
            class="bg-primary text-light rounded border-0">موافقة</label >';
            }
            if ($res['STATUS_TB_ID'] == 2) {
                $status =   '
              <label id="' . $res['ID'] . '"
            class=" bg-danger text-light rounded border-0">رفض</label >';
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
                    $status,
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
    //عرض التفاصيل عند الشؤون الادارية
    public function get_detials_req_affairs(Request $request)
    {
        $steps = new STEPS_TB();
        $get_detials_req_affairs = $steps->get_detials_req_affairs(202);

        $NAME_STEPS = explode(',', $get_detials_req_affairs[0]['NAME_STEPS']);
        $STATUS_NAME = explode(',', $get_detials_req_affairs[0]['STATUS_NAME']);
        return [
            'code' => 200,
            'result' => $get_detials_req_affairs,
            'NAME_STEPS'=>$NAME_STEPS,
            'STATUS_NAME'=>$STATUS_NAME,
        ];

    }
}
