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
                        <form id="AddItemFormNew" action="{{route('request_committee.update_request')}}" method="post" data-toggle="ajaxformmultipart" data_acallback="rebind_dn" autocomplete="off">
                            @csrf
                            {{-- "{{ route('blog.by.slug', ['slug' => 'someslug']) }} --}}
                            {{-- {{ route('project.update',$project->id) --}}

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
                                    value="{{ $arr['NAME'] }}" name="user_chaiman" />
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



                                <select name="department" class="form-control" id="">
                                    <option selected value="0">اختر الادارة</option>
                                    @foreach ($dp as $dp)
                                        <option value="{{ $dp['ID'] }}">{{ $dp['NAME'] }}</option>
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
                            <div class="col-md-3 fv-row">
                                <button type="submit" name="_btn" id="add_dep" value="add_department"
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
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">الادارة</th>
                                            <th scope="col">عدد الموظفين المرشحين</th>
                                            <th scope="col">تعديل \ حذف</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($request_dep as $request_dep)


                                            <tr>
                                                <td scope="row">{{ $request_dep['NAME'] }}</td>
                                                <td scope="row">{{ $request_dep['NUMBER_EMPLOYEES'] }}</td>
                                                <td>
                                                    {{-- dep_id="{{$request_dep -> ID}}" --}}
                                                    <a id="delete-dep" class="btn btn-danger">حذف</a>
                                                </td>
                                            </tr>

                                        @endforeach

                                    </tbody>
                                </table>
                                <!--end::Input-->
                            </div>


                            <div class="col-md-3 fv-row" style="margin-top: 27px">

                                <button type="submit" id="update_req" name="_btn" value="update_request"
                                    class="btn btn-primary">موافق</button>

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

@section('js')
<script>

$(document).on('submit', '[data-toggle="ajaxformmultipart"]', function (e) {
    e.preventDefault();
    alert(1)
    //if()
    //log(e);
    var form = $(this);
    var formData = new FormData();
    form.find('.custom-summary').html('');

    var id = $(this).attr('id');
    var action = $(this).attr('action');
    var method = $(this).attr('method');
    var extraVals = $(this).data('extravals') || '';
    var acallback = $(this).attr('data_acallback') || '';
    var bcallback = $(this).data('bcallback') || '';
    var realvals = extraVals.split(',');
    //var serialzeArr = [];
    var serialized = '';
    var lastparam = $(this).data('lastparam') || false;

    $.each(realvals, function (i, e) {
        if (lastparam) {

            if ($(e).is('div') || $(e).is('form')) {
                $.each($(e).find('input, select, checkbox, textarea, file'), function (j, y) {
                    var p = $.param($(y));
                    var temp = p.slice(p.lastIndexOf('.') + 1, p.length);
                    var x = temp.split('=');
                    formData.append(x[0], x[1]);
                    //serialzeArr.push(p.slice(p.lastIndexOf('.') + 1, p.length));
                })
            } else {
                var p = $.param($(e));
                var temp = p.slice(p.lastIndexOf('.') + 1, p.length);
                var x = temp.split('=');
                formData.append(x[0], x[1]);
            }

        } else {
            if ($(e).is('div') || $(e).is('form')) {
                $.each($(e).find('input, select, checkbox, textarea, file'), function (j, y) {
                    var p = $.param($(y));
                    var temp = p.slice(p.lastIndexOf('.') + 1, p.length);
                    var x = temp.split('=');
                    formData.append(x[0], x[1]);
                })
            }
            else {
                var p = $.param($(e));
                var temp = p.slice(p.lastIndexOf('.') + 1, p.length);
                var x = temp.split('=');
                formData.append(x[0], x[1]);
            }

        }

    });

    bcb = eval(bcallback)
    if (typeof bcb === 'function') {
        var ret = bcb(formData, form);
        if (ret == false) {
            return false;
        }
    }
    realForm = new FormData(this);
    realForm.append('_token', $('input[name="_token"]').val());
    formData.forEach(function (value, key) {
        realForm.append(key, value);
    });
    try {
        App.blockUI({
            target: '#' + id
        })
       $.ajax({
        type: method,
        url: action,
        data: realForm,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {

            if (data.hasOwnProperty("validationError")) {


                $.each(data.validationMessage, function (index, value) {
                    form.find('input[name="'+index+'"]').addClass('is-invalid');
                    });


                    form.goto('-80', 1000);
                    return false;
                //form.find('.custom-summary').html('');
                //form.find('.custom-summary').html(data.validationMessage);
                //form.find('.custom-summary').goto('-30', 2000);
            }
            if (data.hasOwnProperty("status") && data.hasOwnProperty("message")) {
                m.toast(data);

                // this a custom code for item add
                if (data.status > 0) {
                    $('[name="_returnid"]').val(data.status);
                    var formID = $(form).attr('id');
                    if (formID == 'AddItemForm') {
                        if (!$(form).hasClass('stay'))
                            $(form).find('[data-toggle="clear_form"]').trigger('click');
                        $(form).find('[data-toggle="button_form"]').trigger('click');
                    }
                }
                else
                    return false;
            }

            //loadSideRec(); // refresh side menu

            cb = eval(acallback);
            if (typeof cb === 'function') {
                cb(data, form);
            }
        },
        error: function (data) {
            console.log("error");
            console.log(data);
        },
        complete: function () {
            App.unblockUI(
                '#' + id
            )

            try {
                var chkfrm = eval('checkForm');
                if (typeof chkfrm === 'function') {
                    chkfrm();
                }
            } catch (e) {

            }
        }
    });

    } catch (err) {
        App.unblockUI(
            '#' + id
        )
    } finally {

    }
    return false;
});
</script>
@endsection
