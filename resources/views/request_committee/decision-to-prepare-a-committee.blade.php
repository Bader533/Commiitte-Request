@extends('layouts.app')


@section('content')

    <div class="card">
        <h3 class="p-6">اعداد قرار تشكيل لجنة</h3>
        <div class="card-body p-lg-17">

            <div class="d-flex flex-column flex-lg-row mb-17">
                <!--begin::Content-->
                <div class="flex-lg-row-fluid me-10 me-lg-20">
                    <!--begin::Form-->
                    <form action="" class="form mb-15" method="post" id="updatedformreq">
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
                                    <input type="number" class="form-control form-control-solid" placeholder=""
                                        value="{{ $arr['ID'] }}" name="id_request" />
                                    <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--end::Label-->
                                <label class="required fs-5 fw-bold mb-2">مدة عمل اللجنة</label>
                                <!--end::Label-->
                                <!--end::Input-->

                                <input type="number" class="form-control form-control-solid" placeholder=""
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

                                <input type="date" class="form-control form-control-solid" placeholder=""
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
                                <input type="date" class="form-control form-control-solid" placeholder="" name="end_date" />
                                <!--end::Input-->
                            </div>



                        </div>

                        <div class="row mb-5">
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2"> طبيعة الادارة </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" placeholder=""
                                    name="nature_committe" />
                                    <small id="nature_committe_error" class="form-text text-danger"></small>
                                <!--end::Input-->
                            </div>

                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2"> رئيس اللجنة </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" placeholder=""
                                    name="user_chaiman" />
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

                                @foreach ($dp as $dp)

                                    <select name="department" class="form-control" id="">
                                        <option value=""></option>
                                        <option value="{{$dp['ID']}}">{{ $dp['NAME'] }}</option>
                                    </select>

                                @endforeach
                                <small id="department_error" class="form-text text-danger"></small>


                                <!--end::Input-->
                            </div>

                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2"> عدد الموظفين </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" class="form-control form-control-solid" placeholder=""
                                    name="numofemployee" />
                                    <small id="numofemployee_error" class="form-text text-danger"></small>

                                <!--end::Input-->
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

                                <textarea name="law" id="" class="form-control form-control-solid" cols="30"
                                    rows="10"></textarea>
                                    <small id="law_error" class="form-text text-danger"></small>

                                <!--end::Input-->
                            </div>

                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2"> الادارات المعنية </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <table  class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">الادارة</th>
                                            <th scope="col">عدد الموظفين المرشحين</th>
                                            <th scope="col">تعديل \ حذف</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                                <!--end::Input-->
                            </div>

                            <div class="col-md-3 fv-row" style="margin-top: 27px">
                                <button type="submit" id="update_req" class="btn btn-primary">موافق</button>
                            </div>



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

                    </form>
                    <!--end::Form-->

                </div>

            </div>
        </div>
    </div>

@endsection

@push('script')

    <script>
         $(document).on('click', '#update_req', function(e) {
            e.preventDefault();


            $('#nature_committe_error').text('');
            $('#department_error').text('');
            $('#numofemployee_error').text('');
            $('#law_error').text('');

            var formData = new FormData($('#updatedformreq')[0]);
            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: "{{ route('request_committee.update_request') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    if (data.status == true) {
                        Swal.fire({
                            position: 'top-right',
                            icon: 'success',
                            title: 'تمت العملية بنجاح',
                            showConfirmButton: false,
                            timer: 1500

                        })
                    }
                },
                error: function(data) {

                    var errors = data.responseJSON;
                    $.each(errors.message, function (key, val) {
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
    </script>

@endpush
