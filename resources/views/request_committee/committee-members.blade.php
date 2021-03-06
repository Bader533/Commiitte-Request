@extends('layouts.app')


@section('content')

    <div class="card">
        <h3 class="p-6">ترشيح اعضاء</h3>
        <div class="card-body p-lg-17">

            <div class="d-flex flex-column flex-lg-row mb-17">
                <!--begin::Content-->
                <div class="flex-lg-row-fluid me-10 me-lg-20">
                    <!--begin::Form-->
                    <form action="" class="form mb-15" method="post" id="kt_careers_form">
                        <!--begin::Input group-->
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">رقم اللجنة</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input readonly type="number" value="{{ $detials_req_dep['steps'][0]['ID_REQ'] }}"
                                    class="form-control form-control-solid" placeholder="" name="first_name" />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--end::Label-->
                                <label class="required fs-5 fw-bold mb-2">عدد افراد اللجنة</label>
                                <!--end::Label-->
                                <!--end::Input-->
                                <input readonly type="number"
                                    value="{{ $detials_req_dep['steps'][0]['NUMBER_EMPLOYEES'] }}"
                                    class="form-control form-control-solid" placeholder="" name="last_name" />
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
                                <input type="date" readonly
                                    value="{{ \Carbon\Carbon::parse($detials_req_dep['steps'][0]['START_DATE'])->format('Y-m-d') }}"
                                    class="form-control form-control-solid" placeholder="" name="email" />
                                <!--end::Input-->
                            </div>

                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">رئيس اللجنة </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input readonly type="text" value="{{ $detials_req_dep['steps'][0]['USERS_NAME'] }}"
                                    class="form-control form-control-solid" placeholder="" name="" />
                                <!--end::Input-->
                            </div>

                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2"> الادارة </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input readonly type="text" class="form-control form-control-solid" placeholder=""
                                    name="" />
                                <!--end::Input-->
                            </div>

                        </div>

                        <!--end::Input group-->
                        {{-- <!--begin::Input group-->


                <!--end::Input group--> --}}
                        <!--begin::Separator-->
                        <div class="separator mb-8"></div>

                        <!--end::Separator-->

                        <div class="row mb-5">
                            <h5>اضافة اعضاء</h5>
                            <div class="col-md-3 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2"> اسم العضو </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input id="DEP_R_C_ID" type="hidden" value="{{ $get_users_dep[0]['DEP_R_C_ID'] }}">
                                <select id="users_name" class="form-control form-control-solid">
                                    <option selected value="0">اختر العضو</option>
                                    @foreach ($get_users_dep as $key => $value)
                                        <option value="{{ $value['ID'] }}">{{ $value['NAME'] }}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                            <div class="col-md-3 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2"> المسمى الوظيفى </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input readonly id="job_title" type="text" class="form-control form-control-solid"
                                    placeholder="تظهر هنا بيانات" name="" />
                                <!--end::Input-->
                            </div>
                            <div class="col-md-3 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2"> دوره فى اللجنة </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input id="ROLE_MEMBERS" type="text" class="form-control form-control-solid" placeholder=""
                                    name="" />
                                <!--end::Input-->
                            </div>
                            <div class="col-md-3 fv-row" style="margin-top: 27px">
                                <a id="Post_add_user" class="btn btn-primary">+</a>
                            </div>
                        </div>
                        <div class="row mb-5">


                            <div class="col-md-3 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2"> طبيعة اللجنة </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input readonly type="text" value="{{ $detials_req_dep['steps'][0]['NATURE_COMMITTEE'] }}"
                                    class="form-control form-control-solid" placeholder="" name="" />
                                <!--end::Input-->
                            </div>

                            <div class="col-md-3 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2"> القوانين و النصوص </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input readonly type="text" value="{{ $detials_req_dep['steps'][0]['LAW'] }}"
                                    class="form-control form-control-solid" placeholder="" name="" />
                                <!--end::Input-->
                            </div>

                            <div class="col-md-3 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2"> الديباجة القانونية </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input readonly type="text" class="form-control form-control-solid" placeholder=""
                                    name="" />
                                <!--end::Input-->
                            </div>
                            {{-- <div class="col-md-3 fv-row" style="margin-top: 27px">
                        <button type="submit" class="btn btn-primary">ا</button>
                    </div> --}}



                        </div>
                        <h5>الاعضاء</h5>
                        <div class="row mb-5">
                            <table class="table table-row-bordered  text-right">
                                <thead>
                                    <tr style="font-size: 16px;">
                                        <th>#</th>
                                        <th>الادارة</th>
                                        <th>اسم العضو</th>
                                        <th>المسمى الوظيفى</th>
                                        <th>دورة فى اللجنة</th>
                                        <th> اجراء</th>

                                    </tr>
                                </thead>
                                <tbody id="rol_members" class="table-bordered">

                                </tbody>
                            </table>
                        </div>

                        <!--begin::Submit-->
                        <a class="btn btn-primary" id="Post_add_users">
                            <!--begin::Indicator-->
                            <span class="indicator-label">موافق</span>
                            <span class="indicator-progress">انتظر من فظلك
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            <!--end::Indicator-->
                        </a>
                        <!--end::Submit-->
                    </form>
                    <!--end::Form-->

                </div>

            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).on("click", '.Post_delete_user', function(event) {
            let id = $(this).attr('id');
            Util.ConfirmAprove(function() {
                Post_delete_user(id);
            });

        });
        $(document).on("click", '#Post_add_user', function(event) {
            let role_members = $('#ROLE_MEMBERS').val();
            let name = $('#users_name option:selected').text();
            let id = $('#users_name option:selected').val();
            let job_title = $('#job_title').val();

            Util.ConfirmAprove(function() {
                Post_add_user(id, role_members, name, job_title);
            });
        });
        $(document).on("click", '#Post_add_users', function(event) {
            //   let id = $(this).attr('id');
            let DEP_R_C_ID = $('#DEP_R_C_ID').val();
            //  let role_members = $('#ROLE_MEMBERS').val();
            //   let name = $('#users_name option:selected').text();
            //  let job_title = $('#job_title').val();

            //alert(DEP_R_C_ID +' '+ );
            Util.ConfirmAprove(function() {
                Post_add_users(DEP_R_C_ID);
            });
        });

        //حذف عضو
        function Post_delete_user(name) {

            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

            });
            $.ajax({
                    url: "{{ route('request_committee.department.delete_user') }}",
                    method: "POST",
                    data: {
                        name: name
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        Swal.fire({
                            position: 'top-right',
                            icon: 'success',
                            title: 'جاري الارسال',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    },
                    success: function(data) {

                        if (data.code == 200) {
                            Swal.fire({
                                position: 'top-right',
                                icon: 'success',
                                title: 'تمت العملية بنجاح',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            $('#rol_members').html('');
                            data.data.forEach((element, key) => {

                                $('#rol_members').append(`
                               <tr>
                                   <td>
                                      ` + (key + 1) + `
                                   </td>
                                   <td style="font-size: 16px;">
                                   </td>
                                  <td style="font-size: 16px;">
                                    ` + element.name + `
                                   </td>
                                   <td style="font-size: 16px;">
                                     ` + element.job_title + `
                                    </td>
                                    <td style="font-size: 16px;">
                                       ` + element.role_members + `
                                    </td>
                                    <td style="font-size: 16px;">
                                         <a id="` + element.name + `"class="Post_delete_user btn btn-danger">حذف</a>
                                    </td>
                                </tr>
                           `);
                            });
                        } else {

                            Swal.fire({
                                position: 'top-right',
                                icon: 'error',
                                title: 'خطا' + '!' + data.message,
                                showConfirmButton: false,
                                timer: 1500
                            })

                        }

                    },
                    error: function(data) {
                        Swal.fire({
                            position: 'top-right',
                            icon: 'error',
                            title: 'خطا' + '!' + data.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }

                })
                .done(function(msg) {

                    //$("#home_message_container").html(msg);
                });


        }
        //اضافة عضو
        function Post_add_user(user_id, role_members, name, job_title) {

            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

            });
            $.ajax({
                    url: "{{ route('request_committee.department.add_user') }}",
                    method: "POST",
                    data: {
                        role_members: role_members,
                        name: name,
                        job_title: job_title,
                        user_id: user_id,
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        Swal.fire({
                            position: 'top-right',
                            icon: 'success',
                            title: 'جاري الارسال',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    },
                    success: function(data) {
                        // alert(data.code);

                        if (data.code == 200) {
                            $('#rol_members').html('');
                            Swal.fire({
                                position: 'top-right',
                                icon: 'success',
                                title: 'تمت العملية بنجاح',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            data.data.forEach((element, key) => {

                                $('#rol_members').append(`
                                <tr>
                                            <td>
                                                ` + (key + 1) + `
                                            </td>
                                            <td style="font-size: 16px;">
                                            </td>
                                            <td style="font-size: 16px;">
                                                ` + element.name + `
                                            </td>
                                            <td style="font-size: 16px;">
                                                ` + element.job_title + `
                                            </td>
                                            <td style="font-size: 16px;">
                                                ` + element.role_members + `
                                            </td>
                                            <td style="font-size: 16px;">
                                                <a id="` + element.name + `" class="Post_delete_user btn btn-danger">حذف</a>
                                            </td>
                                        </tr>
                                `);
                            });


                        } else {

                            Swal.fire({
                                position: 'top-right',
                                icon: 'error',
                                title: 'خطا' + '!' + data.message,
                                showConfirmButton: false,
                                timer: 1500
                            });

                        }

                    },
                    error: function(data) {
                        Swal.fire({
                            position: 'top-right',
                            icon: 'error',
                            title: 'خطا' + '!' + data.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }

                })
                .done(function(msg) {

                    //$("#home_message_container").html(msg);
                });


        }

        //اضافة الاعضاء db
        function Post_add_users(DEP_R_C_ID) {

            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

               });
            $.ajax({
                    url: "{{ route('request_committee.department.add_users') }}",
                    method: "POST",
                    data: {
                        DEP_R_C_ID: DEP_R_C_ID,
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        Swal.fire({
                            position: 'top-right',
                            icon: 'success',
                            title: 'جاري الارسال',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    },
                    success: function(data) {
                        // alert(data.code);

                        if (data.code == 200) {
                            $('#rol_members').html('');
                            Swal.fire({
                                position: 'top-right',
                                icon: 'success',
                                title: 'تمت العملية بنجاح',
                                showConfirmButton: false,
                                timer: 1500
                            });


                        } else {

                            Swal.fire({
                                position: 'top-right',
                                icon: 'error',
                                title: 'خطا' + '!' + data.message,
                                showConfirmButton: false,
                                timer: 1500
                            });

                        }

                    },
                    error: function(data) {
                        Swal.fire({
                            position: 'top-right',
                            icon: 'error',
                            title: 'خطا' + '!' + data.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }

                })
                .done(function(msg) {

                    //$("#home_message_container").html(msg);
                });


        }
        $("#users_name").click(function() {
            var users_id = $("#users_name option:selected").val();
            const jobTitle = [];
            @foreach ($get_users_dep as $key => $value)
                jobTitle[`{{ $value['ID'] }}`] ='{{ $value['JOB_TITLE'] }}';
            @endforeach
            if (users_id > 0) {

                console.log(jobTitle);

                $('#job_title').val(jobTitle[users_id]);

            } else {
                $('#job_title').val('تظهر هنا بيانات');
            }
        });
    </script>
@endsection
