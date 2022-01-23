@extends('layouts.app')


@section('content')

    <div class="card">
        <h3 class="p-6">اعداد قرار تشكيل لجنة</h3>
        <div class="card-body p-lg-17">

            <div class="d-flex flex-column flex-lg-row mb-17">
                <!--begin::Content-->
                <div class="flex-lg-row-fluid me-10 me-lg-20">



                    <!--begin::Form-->
                    {{-- <form action="" class="form mb-15" method="post" id="updatedformreq"> --}}
                    <form id="AddItemFormNew" data-toggle="ajaxformmultipart" data_acallback="rebind_dn" autocomplete="off">

                        @csrf
                        <!--begin::Input group-->
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->

                                @foreach ($result as $arr)
                                    <label class="required fs-5 fw-bold mb-2">رقم اللجنة</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input id="id_req" readonly type="number" class="form-control form-control-solid"
                                        placeholder="" value="{{ $arr['ID'] }}" name="id_request" />
                                    <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--end::Label-->
                                <label class="required fs-5 fw-bold mb-2">مدة عمل اللجنة</label>
                                <!--end::Label-->
                                <!--end::Input-->

                                <input readonly type="number" class="form-control form-control-solid" placeholder=""
                                    value="{{ $arr['COMMITTEE_TERM'] }}" name="committe_term_reqest" />

                                <!--end::Input-->
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

                                <input readonly type="date" class="form-control form-control-solid" placeholder=""
                                    value="{{ \Carbon\Carbon::parse($arr['START_DATE'])->format('Y-m-d') }}"
                                    name="start_date" />
                                <!--end::Input-->
                            </div>


                            @endforeach

                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">تاريخ انتهاء تشكيل اللجنة </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input id="end_date" type="date" class="form-control form-control-solid" placeholder=""
                                    name="end_date" />
                                <!--end::Input-->
                            </div>



                        </div>

                        <div class="row mb-5">
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2"> طبيعة اللجنة </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input id="nature_committe" type="text" class="form-control form-control-solid"
                                    placeholder="" name="nature_committe" />
                                <small id="nature_committe_error" class="form-text text-danger"></small>
                                <!--end::Input-->
                            </div>

                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2"> رئيس اللجنة </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="user_chaiman" class="form-control" id="user_chaiman">

                                    @foreach ($users as $user)

                                        <option @if ($user['ID'] == $arr['NAME'])
                                            selected
                                            @endif value="{{ $user['ID'] }}">{{ $user['NAME'] }}
                                        </option>

                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>

                        </div>

                        <div class="row mb-5">
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2"> الادارة المعنية </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                {{-- <input type="text" class="form-control form-control-solid" placeholder="" name="" /> --}}


                                <select name="department" class="form-control" id="depID">
                                    <option value="">--</option>
                                    @foreach ($dp as $dp)
                                        <option value="{{ $dp['ID'] }}">{{ $dp['NAME'] }}
                                        </option>
                                    @endforeach
                                </select>

                                <small id="department_error" class="form-text text-danger"></small>

                                <!--end::Input-->
                            </div>

                            <div class="col-md-3 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2"> عدد الموظفين </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" class="form-control form-control-solid" id="empnum" placeholder=""
                                    name="numofemployee" />
                                <small id="numofemployee_error" class="form-text text-danger"></small>

                                <!--end::Input-->
                            </div>
                            {{-- اضافة القسم --}}
                            <div class="col-md-3 fv-row" style="margin-top: 29px">
                                <button type="submit" name="action" id="add_dep" value="add_department"
                                    class="btn btn-primary">+</button>
                            </div>

                        </div>

                        <!--end::Input group-->
                        {{-- <!--begin::Input group-->
                <div class="d-flex flex-column mb-5">
                    <label class="fs-6 fw-bold mb-2">سبب انعقاد اللجنة</label>
                    <textarea class="form-control form-control-solid" rows="2" name="experience" placeholder=""></textarea>
                </div>

                <!--end::Input group--> --}}
                        <!--begin::Separator-->
                        <div class="separator mb-8"></div>

                        <!--end::Separator-->

                        <div class="row mb-5">
                            {{-- <h5>الاعضاء</h5> --}}

                            <div class="col-md-3 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2"> اللوائح و القوانين </label>
                                <!--end::Label-->
                                <!--begin::Input-->

                                <textarea name="law" id="law" class="form-control form-control-solid" cols="30"
                                    rows="10"></textarea>
                                <small id="law_error" class="form-text text-danger"></small>

                                <!--end::Input-->
                            </div>

                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2"> الادارات المعنية </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">الادارة</th>
                                            <th scope="col">عدد الموظفين المرشحين</th>
                                            <th scope="col">تعديل \ حذف</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_dep">
                                    </tbody>
                                </table>

                                <!--end::Input-->
                            </div>


                            <div class="col-md-3 fv-row" style="margin-top: 27px">

                                <a id="update_request" class="btn btn-primary">موافق</a>

                            </div>


                        </div>

                    </form>
                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')



    <script>
        $(document).on('click', 'button[name="action"]', function(e) {
            e.preventDefault();
            // var formData = new FormData($('#AddItemFormNew')[0]);
            // console.log(formData)
            // var entrepreneur_id = $('#action').val();
            // alert(entrepreneur_id);

            var form = $("#AddItemFormNew");
            var btnName = $(this).val();
            var formData = new FormData();
            form.find('.custom-summary').html('');

            var id = $("#AddItemFormNew").attr('id');
            var action = $("#AddItemFormNew").attr('action');
            var method = $("#AddItemFormNew").attr('method');
            var extraVals = $("#AddItemFormNew").data('extravals') || '';
            var acallback = $("#AddItemFormNew").attr('data_acallback') || '';
            var bcallback = $("#AddItemFormNew").data('bcallback') || '';
            var realvals = extraVals.split(',');
            //var serialzeArr = [];
            var serialized = '';
            var lastparam = $("#AddItemFormNew").data('lastparam') || false;

            bcb = eval(bcallback)
            if (typeof bcb === 'function') {
                var ret = bcb(formData, form);
                if (ret == false) {
                    return false;
                }
            }
            var d = $("#AddItemFormNew").parents().eq(0).contents();
            var thi = d[3];
            realForm = new FormData(thi);
            realForm.append('_token', $('input[name="_token"]').val());
            realForm.append('_btn', $(this).val());
            realForm.append('_data_index', $(this).attr('data-index'));

            let name = $('#depID option:selected').text();
            realForm.append('depID', name);
            formData.forEach(function(value, key) {
                realForm.append(key, value);
            });

            $.ajax({
                type: "post",
                url: "{{ route('request_committee.update_request') }}",
                data: realForm,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.status == true) {
                        Swal.fire({
                            position: 'top-right',
                            icon: 'success',
                            title: 'تمت العملية بنجاح',
                            showConfirmButton: false,
                            timer: 1500

                        });
                        // جلب السشن الاقسام

                        $("#tbody_dep").html('');
                        /*  data..forEach(element => {

                          });*/

                        data.data.forEach(element => {
                            $("#tbody_dep").append(
                                "<tr>" +
                                "<td>" + element.depID + "</td>" +
                                "<td>" + element.numofemployee + "</td>" +
                                "<td>" + "<a id= '" +element.department+ "'  " +
                                "class='btn btn-lg btn-danger delete'>" +
                                "<i class='fa fa-remove'>" + "</i>" + 'حذف' + "</a>" +
                                "</td>" + "</tr>");

                        });

                    }
                },
                error: function(data) {

                    var errors = data.responseJSON;
                    $.each(errors.message, function(key, val) {
                        $("#" + key + "_error").text(val[0]);
                    });
                    Swal.fire({
                        position: 'top-right',
                        icon: 'error',
                        title: 'فشلت العملية',
                        showConfirmButton: false,
                        timer: 1500

                    })

                }
            });

        });

        $(document).on('click', '.delete', function(e) {


            delete_dep( $(this).attr('id') );


            // var dep_id = $(this).attr('id');
            // alert( $(this).attr('id'));


        });

        function delete_dep(dep_id) {
            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                    url: "{{ route('request_committee.delete_request') }}",
                    method: "post",
                    data: {
                        department: dep_id,

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
                    if (data.status == true) {
                        Swal.fire({
                            position: 'top-right',
                            icon: 'success',
                            title: 'تمت العملية بنجاح',
                            showConfirmButton: false,
                            timer: 1500

                        });
                        // جلب السشن الاقسام

                        $("#tbody_dep").html('');
                        /*  data..forEach(element => {

                          });*/

                        data.data.forEach(element => {
                            $("#tbody_dep").append(
                                "<tr>" +
                                "<td>" + element.depID + "</td>" +
                                "<td>" + element.numofemployee + "</td>" +
                                "<td>" + "<a id= '" +element.department+ "'  " +
                                "class='btn btn-lg btn-danger delete'>" +
                                "<i class='fa fa-remove'>" + "</i>" + 'حذف' + "</a>" +
                                "</td>" + "</tr>");

                        });

                    }
                },
                    error: function(data) {
                        Swal.fire({
                            position: 'top-right',
                            icon: 'error',
                            title: 'تاكد من ادخال البيانات',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }

                })
                .done(function(msg) {
                    //$("#home_message_container").html(msg);
                });
        }

        //+++++++++++++

        $(document).on('click', '#update_request', function(e) {

            update_req_affairs($('#id_req').val(), $('#user_chaiman').val(), $('#nature_committe').val(), $(
                '#end_date').val(), $('#law').val());

        });
        // اضافة البيانات db
        function update_req_affairs(id_req, user_chaiman, nature_committe, end_date, law) {
            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                    url: "{{ route('request_committee.update_request_db') }}",
                    method: "post",
                    data: {
                        ID_REQ: id_req,
                        NATURE_COMMITTEE: nature_committe,
                        END_DATE: end_date,
                        LAW: law,
                        USER_CHAIMAN_ID: user_chaiman
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

                        if (data.code == 200) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'تمت المعلية بنجاح',
                                showConfirmButton: false,
                                timer: 1500
                            })
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
                            title: 'تاكد من ادخال البيانات',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }

                })
                .done(function(msg) {
                    //$("#home_message_container").html(msg);
                });
        }



        // $(document).on("change", "#depID", function() {
        //     var code = $(this).val();

        //     $.ajax({
        //         type: "GET",
        //         url: "{{ route('request_committee.update_request') }}",
        //         dataType: "html",
        //         data:""
        //         success: function(res) {
        //             if (data.status == true) {
        //                 Swal.fire({
        //                     position: 'top-right',
        //                     icon: 'success',
        //                     title: 'تمت العملية بنجاح',
        //                     showConfirmButton: false,
        //                     timer: 1500

        //                 })
        //             }
        //             console.log(data[0])
        //         },
        //         error: function(xhr, ajaxOptions, thrownError) {

        //             var errors = data.responseJSON;
        //             $.each(errors.message, function(key, val) {
        //                 $("#" + key + "_error").text(val[0]);
        //             });
        //             Swal.fire({
        //                 position: 'top-right',
        //                 icon: 'error',
        //                 title: 'فشلت العملية',
        //                 showConfirmButton: false,
        //                 timer: 1500

        //             })

        //         }
        //     });

        // });

        // $(document).on('submit', '[data-toggle="ajaxformmultipart"]', function(e) {
        //     e.preventDefault();
        //     var form = $(this);
        //     var formData = new FormData();
        //     realForm = new FormData(this);
        //     realForm.append('_token', $('input[name="_token"]').val());
        //     formData.forEach(function(value, key) {
        //         realForm.append(key, value);
        //     });
        //     $.ajax({

        //         type: method,
        //         enctype: 'multipart/form-data',
        //         url: action,
        //         data: realForm,
        //         processData: false,
        //         contentType: false,
        //         cache: false,
        //         success: function(data) {
        //             if (data.status == true) {
        //                 Swal.fire({
        //                     position: 'top-right',
        //                     icon: 'success',
        //                     title: 'تمت العملية بنجاح',
        //                     showConfirmButton: false,
        //                     timer: 1500

        //                 })
        //             }
        //         },
        //         error: function(data) {

        //             var errors = data.responseJSON;
        //             $.each(errors.message, function(key, val) {
        //                 $("#" + key + "_error").text(val[0]);
        //             });
        //             Swal.fire({
        //                 position: 'top-right',
        //                 icon: 'error',
        //                 title: 'فشلت العملية',
        //                 showConfirmButton: false,
        //                 timer: 1500

        //             })

        //         }
        //     });



        // });


        // $(document).on('submit', '[data-toggle="ajaxformmultipart"]', function(e) {
        //     e.preventDefault();


        //     // $('#nature_committe_error').text('');
        //     // $('#department_error').text('');
        //     // $('#numofemployee_error').text('');
        //     // $('#law_error').text('');

        //     var formData = new FormData($('#AddItemFormNew')[0]);
        //     realForm = new FormData(this);
        //     realForm.append('_token', $('input[name="_token"]').val());
        //     formData.forEach(function(value, key) {
        //         realForm.append(key, value);
        //     });

        //     alert('done');
        //     $.ajax({

        //         type: "post",
        //         enctype: 'multipart/form-data',
        //         url: "{{ route('request_committee.update_request') }}",
        //         data: realForm,
        //         processData: false,
        //         contentType: false,
        //         cache: false,
        //         success: function(data) {
        //             if (data.status == true) {
        //                 Swal.fire({
        //                     position: 'top-right',
        //                     icon: 'success',
        //                     title: 'تمت العملية بنجاح',
        //                     showConfirmButton: false,
        //                     timer: 1500

        //                 })
        //             }
        //         },
        //         error: function(data) {

        //             var errors = data.responseJSON;
        //             $.each(errors.message, function(key, val) {
        //                 $("#" + key + "_error").text(val[0]);
        //             });
        //             Swal.fire({
        //                 position: 'top-right',
        //                 icon: 'error',
        //                 title: 'فشلت العملية',
        //                 showConfirmButton: false,
        //                 timer: 1500

        //             })

        //         }
        //     });

        // });


        // $(document).on('click', '#add_dep', function(e) {
        //     e.preventDefault();

        //     var formData = new FormData($('#updatedformreq')[0]);
        //     $.ajax({
        //         type: 'post',
        //         enctype: 'multipart/form-data',
        //         url: "{{ route('request_committee.update_request') }}",
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         cache: false,
        //         success: function(data) {
        //             if (data.status == true) {
        //                 Swal.fire({
        //                     position: 'top-right',
        //                     icon: 'success',
        //                     title: 'تمت العملية بنجاح',
        //                     showConfirmButton: false,
        //                     timer: 1500

        //                 })
        //             }
        //         },
        //         error: function(data) {

        //             // var errors = data.responseJSON;
        //             // $.each(errors.message, function(key, val) {
        //             //     $("#" + key + "_error").text(val[0]);
        //             // });
        //             Swal.fire({
        //                 position: 'top-right',
        //                 icon: 'error',
        //                 title: 'فشلت العملية',
        //                 showConfirmButton: false,
        //                 timer: 1500

        //             })

        //         }
        //     });

        // });



        // $(document).ready(function() {
        //     $("table").hide();

        //     $("#add_dep").click(function() {
        //         $("table").show();
        //         //$('table').data('info', '222');

        //     });
        // });
    </script>

@endpush
