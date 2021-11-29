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
                                <input type="number" class="form-control form-control-solid" placeholder=""
                                    name="first_name" />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--end::Label-->
                                <label class="required fs-5 fw-bold mb-2"> الحالة</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="status" class="form-control form-control-solid" id="">
                                    <option value=""></option>
                                    <option value="">موافقة</option>
                                    <option value="">رفض</option>
                                    <option value="">قيد التدقيق</option>

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
                                <input type="date" class="form-control form-control-solid" placeholder="" name="email" />
                                <!--end::Input-->
                            </div>

                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">تاريخ الانتهاء </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" class="form-control form-control-solid" placeholder="" name="email" />
                                <!--end::Input-->
                            </div>

                        </div>

                        <!--end::Input group-->

                        <!--begin::Separator-->
                        <div class="separator mb-8 ">

                        </div>
                        <button class="mb-8 bg-primary text-light rounded border-0 fs-3">بحث</button>


                        <!--end::Separator-->

                        <div class="row mb-5">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">رقم اللجنة</th>
                                        <th scope="col">طلب اللجنة</th>
                                        <th scope="col">تفاصيل</th>
                                        <th scope="col">موافقة / رفض</th>

                                    </tr>

                                    @foreach ($result as $key => $value)
                                        <tr>

                                            <td scope="row">{{$value['ID']}}</td>
                                            <td scope="row">{{ $value['REASON_COMMITTEE'] }}</td>
                                            <td scope="row"><span class="svg-icon svg-icon-primary svg-icon-2x">
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
                                                </span></td>
                                            <td scope="row"><button id="{{$value['ID']}}"
                                                    class="Post_req_agent_accept bg-primary text-light rounded border-0">موافقة</button> <button
                                                    id="{{$value['ID']}}"
                                                    class="Post_req_agent_reject bg-danger text-light rounded border-0">رفض</button></td>

                                        </tr>
                                    @endforeach
                                </thead>
                                <tbody>

                                </tbody>
                            </table>


                        </div>

                        <!--begin::Submit-->
                        {{-- <button type="submit" class="btn btn-primary" id="kt_careers_submit_button">
                    <!--begin::Indicator-->
                    <span class="indicator-label">طلب تشكيل لجنة</span>
                    <span class="indicator-progress">انتظر من فظلك
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    <!--end::Indicator-->
                </button> --}}
                        <!--end::Submit-->
                    </div>
                    <!--end::Form-->

                </div>

            </div>
        </div>
    </div>

@endsection

@section('js')


    <script>
        //موافقة
        $(document).on("click", '.Post_req_agent_accept', function(event) {

            Post_req_agent(1,$(this).attr('id'));

        });
        //رفض
        $(document).on("click", '.Post_req_agent_reject', function(event) {

            Post_req_agent(0,$(this).attr('id'));

        });
        //الموافقة او الرفض للطلب من قبل الوكيل
        function Post_req_agent(status,id_req) {

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });
            $.ajax({

                    url: "{{ route('request_committee.request_committee_agent') }}",
                    method: "POST",
                    data: {
                        status: status,
                        id_req:id_req
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

                        if (data.data == 200) {
                            Swal.fire({
                                position: 'top-right',
                                icon: 'success',
                                title: 'تمت العملية بنجاح',
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
