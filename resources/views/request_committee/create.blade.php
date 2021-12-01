@extends('layouts.app')


@section('content')

    <div class="card">
        <div class="card-body p-lg-17">

            <div class="d-flex flex-column flex-lg-row mb-17">
                <!--begin::Content-->
                <div class="flex-lg-row-fluid me-10 me-lg-20">

                    {{-- طلب تقديم طلب --}}
                    <!--begin::Form-->
                    <form class="form mb-15" action="" id="dataform"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        <!--begin::Input group-->
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">عدد افراد اللجنة</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" class="form-control form-control-solid" placeholder=""
                                    name="membercount" />
                                {{-- <small id="membercount_error" class="form-text text-danger"></small> --}}

                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--end::Label-->
                                <label class="required fs-5 fw-bold mb-2">تاريخ البدء</label>
                                <!--end::Label-->
                                <!--end::Input-->
                                <input type="date" class="form-control form-control-solid" placeholder=""
                                    name="start_date" />
                                {{-- <small id="start_date_error" class="form-text text-danger"></small> --}}

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
                                <label class="required fs-5 fw-bold mb-2">مدة عمل اللجنة</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" class="form-control form-control-solid" placeholder=""
                                    name="work_day" />
                                <!--end::Input-->
                                {{-- <small id="work_day_error" class="form-text text-danger"></small> --}}

                            </div>

                        </div>

                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-5">
                            <label class="required fs-6 fw-bold mb-2">سبب انعقاد اللجنة</label>
                            <textarea class="form-control form-control-solid" rows="2" name="experience"
                                placeholder=""></textarea>
                            {{-- <small id="experience_error" class="form-text text-danger"></small> --}}

                        </div>

                        <!--end::Input group-->
                        <!--begin::Separator-->
                        <div class="separator mb-8"></div>
                        <!--end::Separator-->
                        <!--begin::Submit-->
                        <button type="submit" class="btn btn-primary" id="add_request">
                            <!--begin::Indicator-->
                            <span class="indicator-label">طلب تشكيل لجنة</span>
                            <span class="indicator-progress">انتظر من فظلك
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            <!--end::Indicator-->
                        </button>
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


// *************************

        $(document).on('click', '#add_request', function(e) {
            e.preventDefault();

            var formData = new FormData($('#dataform')[0]);
            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: "{{ route('request_committee.storerequest') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    Swal.fire({
                        position: 'top-right',
                        icon: 'success',
                        title: 'تمت العملية بنجاح',
                        showConfirmButton: false,
                        timer: 1500

                    })

                },
                error: function(data) {
                    var response = $.parseJSON(data.responseText);
                    $.each(response.errors, function (key, val) {
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
