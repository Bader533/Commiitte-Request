<?php

namespace App\Http\Controllers;

use App\Models\DEPARTMENTS_RESOLUTION_C_TB;
use App\Models\REQUEST_COMMITTEE_TB;
use App\Models\USERS_TB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use PDO;
use phpDocumentor\Reflection\Types\This;
use PhpParser\Node\Stmt;


class C_decision_committee extends Controller
{
    public function decision_committee()
    {
        return view('request_committee.decision-to-prepare-a-committee');
    }
    //عرض بيانات اللجنة
    public function get_request_committee($id)
    {

        session()->forget('TrashItems');
        $sql = "begin BADER.get_request_commmittee(:IDreq,:p_request); end;";
        return DB::transaction(function ($conn) use ($sql, $id) {
            $pdo = $conn->getPdo();
            $stmt = $pdo->prepare($sql);
            $IDreq = $id;
            $stmt->bindParam(':IDreq', $IDreq, PDO::PARAM_INT);
            $stmt->bindParam(':p_request', $p_request, PDO::PARAM_STMT);
            $stmt->execute();
            oci_execute($p_request, OCI_DEFAULT);
            oci_fetch_all($p_request, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            oci_free_cursor($p_request);

            $USERS = new USERS_TB;
            $users = $USERS->get_users_affairs();
            $array;
            return view('request_committee.decision-to-prepare-a-committee', [
                'result' => $array,
                'dp' => $this->get_department(),
                'request_dep' => $this->get_request($id),
                'users' => $users


            ]);
        });
    }
    // عرض الاقسام
    public function get_department()
    {
        $sql = "begin BADER.get_department(:p_department); end;";
        return DB::transaction(function ($conn) use ($sql) {
            $pdo = $conn->getPdo();
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':p_department', $p_department, PDO::PARAM_STMT);
            $stmt->execute();
            oci_execute($p_department, OCI_DEFAULT);
            oci_fetch_all($p_department, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            oci_free_cursor($p_department);
            return $array;
        });
    }
    //عرض اقسام الخاصة بالطلب
    public function get_request($id)
    {

        $sql = "begin BADER.get_request_department(:IDreq,:P_request); end;";

        return DB::transaction(function ($conn) use ($sql, $id) {
            $pdo = $conn->getPdo();
            $stmt = $pdo->prepare($sql);
            $IDreq = $id;
            $stmt->bindParam(':IDreq', $IDreq, PDO::PARAM_INT);
            $stmt->bindParam(':p_request', $p_request, PDO::PARAM_STMT);
            $stmt->execute();
            oci_execute($p_request, OCI_DEFAULT);
            oci_fetch_all($p_request, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            oci_free_cursor($p_request);
            return $array;
        });
    }
    //اضافة على بيانات  على الطلب
    public function update_request(REQUEST $request)
    {

        if ($request->_btn == "add_department") {
            // اضافة الادارات المعنية للجنة
            $empdata = session()->get('TrashItems');

            if ($empdata == null) {
                //  $item[] = array("depID" => $request->depID ,"department" => $request->input('department'), "numofemployee" => $request->numofemployee);
                //  session()->put('TrashItems', $item);
                $item[] = array("depID" => $request->depID, "department" => $request->input('department'), "numofemployee" => $request->numofemployee);
                session()->put('TrashItems', $item);
                return Response()->json([

                    'data' => session()->get('TrashItems'),
                    'status' => true,
                    'msg' => 'تم الحفظ بنجاح',
                ]);
            } else {
                if (collect($empdata)->where('depID', $request->depID)->where('department', $request->input('department'))->where('numofemployee', $request->numofemployee)->count() > 0) {
                    $arr = array('message' => 'عذراً .. الصنف مدخل مسبقاً', 'status' => 0);
                    return Response()->json($arr);
                } else {

                    $arr = array();

                    foreach ($empdata as $i) {

                        $arr[] = [
                            "department" => $i['department'],
                            "numofemployee" => $i['numofemployee'],
                            "depID" => $i['depID'],

                        ];
                    }
                    $item = array("depID" => $request->depID, "department" => $request->input('department'), "numofemployee" => $request->numofemployee);
                    array_push($arr, $item);
                    session()->put('TrashItems', $arr); //put

                    return Response()->json([
                        'data' => session()->get('TrashItems'),
                        'status' => true,
                        'msg' => 'تم الحفظ بنجاح',
                    ]);
                }
            }
        } elseif ($request->_btn == "update_request") {
            // dd($request->_btn);
            session()->forget('TrashItems');
        } elseif ($request->_btn == "remove_department") {

            //حذف ادارة المعنية
            $TrashItems = session()->get('TrashItems');
            $arr = array();

            $collect = collect($TrashItems)->where('department', '!=', $request->department);
            foreach ($collect as $i) {
                $arr[] =
                    [
                        "department" => $i['department'],
                        "numofemployee" => $i['numofemployee'],
                        "depID" => $i['depID'],
                    ];
            }
            session()->forget('TrashItems');
            session()->put('TrashItems', $arr); //put

            return Response()->json([
                'data' => session()->get('TrashItems'),
                'status' => true,
                'msg' => 'تم الحفظ بنجاح',
            ]);
        }


        // if($request->_btn == "add_department")
        // {
        //     dd('action done');
        // }
        // elseif($request->_btn == "update_request")
        // {

        //     $validator = Validator::make($request->all(), [
        //         'department' => 'required',
        //         'numofemployee' => 'required',
        //         'nature_committe' => 'required',
        //         'law' => 'required',
        //     ]);

        //     if ($validator->fails()) {
        //         return response()->json(
        //             [
        //                 'code' => 400,
        //                 'message' => $validator->errors()
        //             ],
        //             400
        //         );
        //     }

        //     $pdo = DB::getPdo();
        //     $P_ID = $request->id_request;
        //     $department = $request->department;
        //     $numofemployee = $request->numofemployee;
        //     $naturecommitte = $request->nature_committe;
        //     $law = $request->law;



        //     //اضافة طلب تشكيل لجنة
        //     $stmt = $pdo->prepare("begin BADER.insert_request_committe(:IDreq,:NATURECOMMITTEE,:LAWS,:DEPARTMENTS_ID,:NUMBER_EMPLOYEE); end;");

        //     $stmt->bindParam(':IDreq', $P_ID, PDO::PARAM_INT);
        //     $stmt->bindParam(':NATURECOMMITTEE', $naturecommitte, PDO::PARAM_STR);
        //     $stmt->bindParam(':LAWS', $law, PDO::PARAM_STR);
        //     $stmt->bindParam(':DEPARTMENTS_ID', $department, PDO::PARAM_INT);
        //     $stmt->bindParam(':NUMBER_EMPLOYEE', $numofemployee, PDO::PARAM_INT);
        //     // $stmt->bindParam(':REASON_COMMITTEE', $experience, PDO::PARAM_STR, 225);
        //     // $stmt->bindParam(':p_cur', $p_cur, PDO::PARAM_INT);
        //     $stmt->execute();

        //     if ($stmt)
        //         return response()->json([
        //             'status' => true,
        //             'msg' => 'تم الحفظ بنجاح',

        //         ]);

        //     else
        //         return response()->json([
        //             'status' => false,
        //             'msg' => 'فشل الحفظ برجاء المحاوله مجددا',
        //         ]);


        // }


    }
    //اضافة البيانات في db
    public function update_insert(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'ID_REQ' => 'required',
            'NATURE_COMMITTEE' => 'required',
            'END_DATE' => 'required',
            'LAW' => 'required',
        ]);
        $empdata = session()->get('TrashItems');
        if ($empdata == null) {
            return response()->json(
                [
                    'code' => 400,
                    'message' => $validator->errors()
                ],
                400
            );
        }
        if ($validator->fails()) {
            return response()->json(
                [
                    'code' => 400,
                    'message' => $validator->errors()
                ],
                400
            );
        }

        $REQUEST_COMMITTEE = new REQUEST_COMMITTEE_TB();
        $DEPARTMENTS_RESOLUTION = new DEPARTMENTS_RESOLUTION_C_TB();

        $result =  $REQUEST_COMMITTEE->update_req_affairs($request->ID_REQ, $request->NATURE_COMMITTEE, $request->USER_CHAIMAN_ID, $request->END_DATE, $request->LAW);

        foreach ($empdata as $i) {

            $DEPARTMENTS_RESOLUTION->insert_dep_affairs($request->ID_REQ,$i['department'],$i['numofemployee']);
        }
        if ($result) {
            return [
                'code' => 200,
                'message' => 'تمت العملية بنجاح',
            ];
        } else {
            return [
                'code' => 400,
                'message' => 'يوجد خطا',
            ];
        }
    }
}
