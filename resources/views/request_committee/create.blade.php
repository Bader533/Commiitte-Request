@extends('layouts.app')


@section('content')

<div class="card">
    <div class="card-body p-lg-17">

    <div class="d-flex flex-column flex-lg-row mb-17">
        <!--begin::Content-->
        <div class="flex-lg-row-fluid me-10 me-lg-20">
            <!--begin::Form-->
            <form action="{{route('request_committee.storerequest')}}" class="form mb-15" method="post" id="kt_careers_form">
                @csrf
                <!--begin::Input group-->
                <div class="row mb-5">
                    <!--begin::Col-->
                    <div class="col-md-6 fv-row">
                        <!--begin::Label-->
                        <label class="required fs-5 fw-bold mb-2">عدد افراد اللجنة</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="number" class="form-control form-control-solid" placeholder="" name="membercount" />
                        <!--end::Input-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6 fv-row">
                        <!--end::Label-->
                        <label class="required fs-5 fw-bold mb-2">تاريخ البدء</label>
                        <!--end::Label-->
                        <!--end::Input-->
                        <input type="date" class="form-control form-control-solid" placeholder="" name="start_date" />
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
                        <input type="number" class="form-control form-control-solid" placeholder="" name="work_day" />
                        <!--end::Input-->
                    </div>

                </div>

                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="d-flex flex-column mb-5">
                    <label class="required fs-6 fw-bold mb-2">سبب انعقاد اللجنة</label>
                    <textarea class="form-control form-control-solid" rows="2" name="experience" placeholder=""></textarea>
                </div>

                <!--end::Input group-->
                <!--begin::Separator-->
                <div class="separator mb-8"></div>
                <!--end::Separator-->
                <!--begin::Submit-->
                <button type="submit" class="btn btn-primary" id="kt_careers_submit_button">
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
