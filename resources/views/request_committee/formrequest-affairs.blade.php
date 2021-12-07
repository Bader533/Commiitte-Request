@extends('layouts.app')


@section('content')

<div class="card">
    <div class="card-body p-lg-17">

        <div class="d-flex flex-column flex-lg-row mb-17">
            <!--begin::Content-->
            <div class="flex-lg-row-fluid me-10 me-lg-20">
                <!--begin::Form-->
                <div class="form mb-15" id="kt_careers_form">

                    <!--begin::Input group-->
                    <div class="row mb-5">
                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-5 fw-bold mb-2">رقم اللجنة</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input id="number_req" type="number" class="form-control form-control-solid" placeholder=""
                                name="number_req" />
                            <!--end::Input-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <!--end::Label-->
                            <label class="required fs-5 fw-bold mb-2"> الحالة</label>
                            <!--end::Label-->
                            <!--begin::Select-->
                            <select  name="status" class="form-control form-control-solid" id="status">
                                <option value=""></option>
                                <option value="1">موافقة</option>
                                <option value="2">رفض</option>
                                <option value="3">قيد التدقيق</option>

                            </select>
                            <!--end::Select-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-5">
                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-5 fw-bold mb-2"> تاريخ البدء </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="date" class="form-control form-control-solid" placeholder="" id="date_start" name="date_start" />
                            <!--end::Input-->
                        </div>

                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-5 fw-bold mb-2">تاريخ الانتهاء </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="date" class="form-control form-control-solid" placeholder="" id="date_end" name="date_end" />
                            <!--end::Input-->
                        </div>

                    </div>

                    <!--end::Input group-->

                    <!--begin::Separator-->
                    <div class="separator mb-8 ">

                    </div>
                    <button class="mb-8 bg-primary text-light rounded border-0 fs-3" id="filter">بحث</button>


                    <!--end::Separator-->

                    <div class="row mb-5">

                        <table class="table table-row-bordered" id="kt_table_ajax_advanced">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">رقم اللجنة</th>
                                    <th scope="col">طلب اللجنة</th>
                                    <th scope="col">تفاصيل</th>
                                    <th scope="col">الحالة</th>
                                    <th scope="col" width="25%">اجراءات</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                </div>


            </div>

        </div>
    </div>
</div>


@endsection

@section('js')
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>

<script>
fill_datatable();
function fill_datatable(number_req = '', status = '', date_start = '', date_end = '')
{
    var dataTable = $('#kt_table_ajax_advanced').DataTable( {
            "language": {
                "sEmptyTable":     "ليست هناك بيانات متاحة في الجدول",
                "sLoadingRecords": "جارٍ التحميل...",
                "sProcessing":   "جارٍ التحميل...",
                "sLengthMenu":   "أظهر _MENU_ مدخلات",
                "sZeroRecords":  "لم يعثر على أية سجلات",
                "sInfo":         "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                "sInfoEmpty":    "يعرض 0 إلى 0 من أصل 0 سجل",
                "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                "sInfoPostFix":  "",
                "sSearch":       "ابحث:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "الأول",
                    "sPrevious": "السابق",
                    "sNext":     "التالي",
                    "sLast":     "الأخير"
                },
                "oAria": {
                    "sSortAscending":  ": تفعيل لترتيب العمود تصاعدياً",
                    "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"
                }
            },
            "processing": true,
            "serverSide": true,
            ajax:{
                url: "{{route('request_committee.affairs.GetDataTable')}}",
                data:{number_req:number_req,status:status, date_start:date_start,date_end:date_end}
            },
        });

}
$('#filter').click(function(){
    var number_req = $('#number_req').val();
   // alert(number_req);
    var status = $('#status').val();
    var date_start = $('#date_start').val();
    var date_end = $('#date_end').val();


    $('#kt_table_ajax_advanced').DataTable().destroy();
    fill_datatable(number_req,status,date_start,date_end);
    //alert(number_req);
});
</script>
@endsection
