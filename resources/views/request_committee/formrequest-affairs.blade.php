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
                                <select name="status" class="form-control form-control-solid" id="status">
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
                                <input type="date" class="form-control form-control-solid" placeholder="" id="date_start"
                                    name="date_start" />
                                <!--end::Input-->
                            </div>

                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">تاريخ الانتهاء </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" class="form-control form-control-solid" placeholder="" id="date_end"
                                    name="date_end" />
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

    <!--begin::Modal -->
    <div class="modal fade" id="kt_modal_view_users" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                    transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                    fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                    <!--begin::Heading-->
                    <div class="text-center mb-13">
                        <!--begin::Title-->
                        <h1 class="mb-3">تفاصيل الطلب</h1>
                        <!--end::Title-->


                        <!--end::Heading-->
                        <!--begin::Users-->
                        <div class="mb-15">
                            <!--begin::List-->
                            <table class="table table-hover table-row-bordered">
                                <tbody id="steps_req" class="table-bordered">





                                </tbody>
                            </table>
                            <!--end::List-->
                        </div>
                        <!--end::Users-->
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal -->

    @endsection

    @section('js')
        <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

        <script>
            fill_datatable();

            function fill_datatable(number_req = '', status = '', date_start = '', date_end = '') {
                var dataTable = $('#kt_table_ajax_advanced').DataTable({
                    "language": {
                        "sEmptyTable": "ليست هناك بيانات متاحة في الجدول",
                        "sLoadingRecords": "جارٍ التحميل...",
                        "sProcessing": "جارٍ التحميل...",
                        "sLengthMenu": "أظهر _MENU_ مدخلات",
                        "sZeroRecords": "لم يعثر على أية سجلات",
                        "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                        "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
                        "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                        "sInfoPostFix": "",
                        "sSearch": "ابحث:",
                        "sUrl": "",
                        "oPaginate": {
                            "sFirst": "الأول",
                            "sPrevious": "السابق",
                            "sNext": "التالي",
                            "sLast": "الأخير"
                        },
                        "oAria": {
                            "sSortAscending": ": تفعيل لترتيب العمود تصاعدياً",
                            "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"
                        }
                    },
                    "processing": true,
                    "serverSide": true,
                    ajax: {
                        url: "{{ route('request_committee.affairs.GetDataTable') }}",
                        data: {
                            number_req: number_req,
                            status: status,
                            date_start: date_start,
                            date_end: date_end
                        }
                    },
                });

            }
            $('#filter').click(function() {
                var number_req = $('#number_req').val();
                // alert(number_req);
                var status = $('#status').val();
                var date_start = $('#date_start').val();
                var date_end = $('#date_end').val();


                $('#kt_table_ajax_advanced').DataTable().destroy();
                fill_datatable(number_req, status, date_start, date_end);
                //alert(number_req);
            });

            //عرض تفاصيل الطلب
            $(document).on("click", '.get_req_details', function(event) {

              //  alert($(this).attr('id'));
                get_req_details($(this).attr('id'));
            });

            //عرض تفاصيل طلب
            function get_req_details(id_req) {
                $.ajaxSetup({

                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    }

                });
                $.ajax({
                        url: "{{ route('request_committee.affairs.get_detials_req_affairs') }}",
                        method: "get",
                        data: {
                            id_req: id_req
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'جاري الطلب',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        },
                        success: function(data) {
                            $('#steps_req').html('');

                            if (data.code == 200) {
                                //  alert(data.result[0]['NUMBER_COMMITTEE_MEMBER']);
                                if (data.result[0] != null) {
                                    $('#steps_req').html(`
                                    <tr style="font-size: 16px;">
                                        <th scope="row">صاحب الطلب</th>
                                        <th id="USERS_NAME" scope="row">`+data.result[0]['USERS_NAME']+`</th>
                                    </tr>
                                    <tr>
                                        <th scope="row"> عدد اعضاء اللجنة</th>
                                        <th id="NUMBER_COMMITTEE_MEMBER" scope="row"> `+data.result[0]['NUMBER_COMMITTEE_MEMBER']+` </th>
                                    </tr>
                                    <tr>
                                        <th scope="row"> تاريخ البدء</th>
                                        <th id="START_DATE" scope="row">`+data.result[0]['START_DATE']+`</th>
                                    </tr>
                                    <tr>
                                        <th scope="row"> سبب اللجنة</th>
                                        <th id="REASON_COMMITTEE" scope="row">`+data.result[0]['REASON_COMMITTEE']+`</th>
                                    </tr>
                                    `);

                                    data.NAME_STEPS.forEach((element,key) => {
                                            
                                          $('#steps_req').append(`
                                                <tr>
                                                    <th scope="row">`+element+`</th>
                                                    <th id="REASON_COMMITTEE" scope="row">`+data.STATUS_NAME[key]+`</th>
                                                </tr>
                                          `);
                                    });
                                } else {
                                    $('#NUMBER_COMMITTEE_MEMBER').html('لا يوجد بيانات');
                                    $('#START_DATE').html('لا يوجد بيانات');
                                    $('#REASON_COMMITTEE').html('لا يوجد بيانات');
                                    $('#USERS_NAME').html('لا يوجد بيانات');
                                }
                            } else {
                                Swal.fire({
                                    position: 'top-right',
                                    icon: 'error',
                                    title: 'خطا',
                                    showConfirmButton: false,
                                    timer: 1500
                                })

                            }

                        },
                        error: function(data) {
                            Swal.fire({
                                position: 'top-right',
                                icon: 'error',
                                title: 'خطا',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }

                    })
                    .done(function(msg) {

                        //$("#home_message_container").html(msg);
                    });
            }
        </script>
    @endsection
