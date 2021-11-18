@extends('layouts.app')


@section('content')

<div class="card">
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
                        <input type="number" class="form-control form-control-solid" placeholder="" name="first_name" />
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
                        <label class="required fs-5 fw-bold mb-2">تاريخ الانتهاء  </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="date" class="form-control form-control-solid" placeholder="" name="email" />
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

                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">رقم اللجنة</th>
                            <th scope="col">طلب اللجنة</th>
                            <th scope="col">تفاصيل</th>
                            <th scope="col">موافقة / رفض</th>

                          </tr>
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
            </form>
            <!--end::Form-->

        </div>

    </div>
    </div>
</div>

@endsection
