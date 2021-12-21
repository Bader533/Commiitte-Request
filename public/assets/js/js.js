var hiddenModals = [];
var log = console.log;
var regex = /(<([^>]+)>)/ig
var GetSpliter = function () {
    return ',';
}
var Comp = function () {
    return {
        modal: function (options) {
            options = options || {};
            var title = options.title || '';
            var url = options.url || '';
            var modalContent = options.content || '';
            var width = options.width || '100%';
            var keyboard = options.keyboard || 'false';
            var backdrop = options.backdrop || 'static';
            var effect = options.effect || '';
            var afterLoad = options.after || '';
            var reuse = options.reuse || false;
            var hidden = options.hidden || '';
            var show = options.show || '';
            var id = options.id || '';

            var shown = $('#' + id).data('isshown');
            if (shown) {
                return;
            }
            if (reuse && $('#' + id).length > 0) {
                $('#' + id).modal('show');
                return;
            }
            var m = $('<div>');
            m.addClass('modal onfly');
            m.attr('id', id);
            m.attr('width', width);
            m.data('keyboard', keyboard);
            m.data('backdrop', backdrop);
            if (effect != '') {
                log('effect', effect);
                $(m).attr('data-easein', effect);
            }


            var dialog = $('<div class="modal-dialog">');
            var content = $('<div class="modal-content">');

            $(dialog).append($(content));
            // header
            var header = $('<div class="modal-header">');
            var closeBtn = $('<a type="button " class="close" data-dismiss="modal" aria-hidden="true">');
            $(closeBtn).html('<i class="fa fa-times"></i>');
            var mtitle = $('<h4 class="modal-title">');
            $(mtitle).text(title);
            $(header).append(closeBtn);
            $(header).append(mtitle);
            // end header
            // body
            var body = $('<div class="modal-body">');
            var row = $('<div class="row">');
            var col = $('<div class="col-xs-12">');
            var container = $('<div class="app-container">');
            $(row).append($(col));
            $(container).append(modalContent);
            $(col).append($(container));
            $(body).append($(row));
            // end body
            // footer
            var footer = $('<div class="modal-footer">');
            var fCloseBtn = $('<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">');
            $(fCloseBtn).text('Close');
            $(footer).append(fCloseBtn);
            // end footer

            $(content).append($(header));
            $(content).append($(body));
            $(content).append($(footer));

            $(m).append($(dialog));

            $('body').append($(m));
            $(m).on('show.bs.modal', function (e) {
                var o = $(this).attr("data-easein");
                "shake" == o ? $(this).find(".modal-dialog").velocity("callout." + o) : "pulse" == o ? $(this).find(".modal-dialog").velocity("callout." + o) : "tada" == o ? $(this).find(".modal-dialog").velocity("callout." + o) : "flash" == o ? $(this).find(".modal-dialog").velocity("callout." + o) : "bounce" == o ? $(this).find(".modal-dialog").velocity("callout." + o) : "swing" == o ? $(this).find(".modal-dialog").velocity("callout." + o) : $(this).find(".modal-dialog").velocity("transition." + o);

                if (typeof show === 'function') {
                    show(this, options, e);
                }

                $(m).data('isshown', true);
            });

            $(m).modal('show');

            $(m).on('hidden.bs.modal', function (e) {
                if (typeof hidden === 'function') {
                    hidden(this, options, e);
                }
                if (!reuse) {
                    $(m).remove();
                }
                $(m).data('isshown', false);
            });

            if (typeof afterLoad === 'function') {
                afterLoad($(m), options);
            }
        }
    }
}();
var Util = function () {
    return {

        init: function () {
            Util.initComponents();
            Util.clearForm();
            Util.stackModal();

        },
        initializePlugins: function(scope){
            //$(scope).find('.cdate, .date, .restricted-date').inputmask("y/m/d", {
            //    "placeholder": "yyyy/mm/dd"
            //});
            $(scope).find('.date').datepicker({
                format: "yyyy/mm/dd",
                todayHighlight: true,
                "setDate": new Date()
            });

            $(scope).find('.cdate').datepicker({
                format: "yyyy/mm/dd",
                todayHighlight: true
            });

            $(scope).find('.cTime').timepicker();
            $(scope).find('.cdate').datepicker('setDate', new Date());
            $(scope).find('.date').on('changeDate', function (ev) {
                $(this).datepicker('hide');
            });
        },
        cloneObject: function (obj) {
            return JSON.parse(JSON.stringify(obj));
        },
        modal: function (url, data, src) {
            var isExecuted = $(src).data('isExecuted');
            log('isExecuted',isExecuted);
            if (isExecuted === undefined) {
                try {
                    $(src).data('isExecuted', true);
                    var m = $('<div class="modal fade" tabindex="-1" role="dialog" id="OnFlyModal" width="100%" data-keyboard="false" data-backdrop="static" data-resetmodal="true"></div>');
                    $(m).append('<div class="modal-dialog modal-lg" role="document"></div>');
                    $(m).find('.modal-dialog').append('<div class="portlet box blue noborder" id="modal-portlet"></div>');
                    $(m).find('#modal-portlet').append('<div class="portlet-title"></div>');
                    $(m).find('.portlet-title').append('<div class="caption"><button class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i></button></span></div>');
                    $(m).find('#modal-portlet').append('<div class="portlet-body"></div>');
                    App.blockUI({
                        target: '#OnFlyModal'
                    });
                    $(m).find('.portlet-body').load(url, data, function () {
                        // Initialize Plugins
                        Util.initializePlugins(m);

                        App.unblockUI('#OnFlyModal');
                        $(m).modal('show');
                    });


                    $(document).on('hidden.bs.modal', '#OnFlyModal', function () {
                        $(this).remove();
                    });
                } catch (e) {
                    App.unblockUI('#OnFlyModal');
                    ('#OnFlyModal').remove();
                } finally {
                    $(src).removeData('isExecuted');
                }
            }


        },
         clearValidation : function(formElement){
             //Internal $.validator is exposed through $(form).validate()
             var validator = $(formElement).validate();
             //Iterate through named elements inside of the form, and mark them as error free
             $('[data-val-required],[data-val-regex]', formElement).each(function () {

            validator.successList.push(this);//mark as error free
            validator.showErrors();//remove error messages if present
            });
            validator.resetForm();//remove error class on name elements and clear history
            validator.reset();//remove all error and success data

         },

         Confirm: function (func) {
            Swal.fire({
                 title: "رسالة تأكيد",
                 text: "هل تريد الحذف فعلاً",
                 type: "warning",
                 showCancelButton: true,
                 confirmButtonColor: '#3598dc',
                 cancelButtonColor: '#ed6b75',
                 confirmButtonText: 'نعم   ',
                 cancelButtonText: "إلغاء",
                 closeOnConfirm: true,
                 closeOnCancel: true
                }).then((result) => {
                    if (result.value) {
                        func();
                        return true;
                    } else {
                        return false;

                    };
                  });
            },
            ConfirmAprove: function (func) {
                Swal.fire({
                     title: "رسالة تأكيد",
                     text: "هل تريد الموافقة فعلاً",
                     type: "warning",
                     showCancelButton: true,
                     confirmButtonColor: '#3598dc',
                     cancelButtonColor: '#ed6b75',
                     confirmButtonText: 'نعم   ',
                     cancelButtonText: "إلغاء",
                     closeOnConfirm: true,
                     closeOnCancel: true
                    }).then((result) => {
                        if (result.value) {
                            func();
                            return true;
                        } else {
                            return false;

                        };
                      });
                },
                ConfirmReject: function (func) {
                    Swal.fire({
                         title: "رسالة تأكيد",
                         text: "هل تريد الرفض فعلاً",
                         type: "warning",
                         showCancelButton: true,
                         confirmButtonColor: '#3598dc',
                         cancelButtonColor: '#ed6b75',
                         confirmButtonText: 'نعم   ',
                         cancelButtonText: "إلغاء",
                         closeOnConfirm: true,
                         closeOnCancel: true
                        }).then((result) => {
                            if (result.value) {
                                func();
                                return true;
                            } else {
                                return false;

                            };
                          });
                    },
                ConfirmRest: function (func) {
                    Swal.fire({
                         title: "رسالة تأكيد",
                         text: "هل تريد إعادة تعيين كلمة المرور فعلاً",
                         type: "warning",
                         showCancelButton: true,
                         confirmButtonColor: '#3598dc',
                         cancelButtonColor: '#ed6b75',
                         confirmButtonText: 'نعم   ',
                         cancelButtonText: "إلغاء",
                         closeOnConfirm: true,
                         closeOnCancel: true
                        }).then((result) => {
                            if (result.value) {
                                func();
                                return true;
                            } else {
                                return false;

                            };
                          });
                    },
                    ConfirmCanselAudit: function (func) {
                        Swal.fire({
                             title: "رسالة تأكيد",
                             text: "هل تريد إلغاء التدقيق فعلاً",
                             type: "warning",
                             showCancelButton: true,
                             confirmButtonColor: '#3598dc',
                             cancelButtonColor: '#ed6b75',
                             confirmButtonText: 'نعم   ',
                             cancelButtonText: "إلغاء",
                             closeOnConfirm: true,
                             closeOnCancel: true
                            }).then((result) => {
                                if (result.value) {
                                    func();
                                    return true;
                                } else {
                                    return false;

                                };
                              });
                        },
         /*
        Confirm: function (func) {
            Swal.fire({
                title: "Confirmation",
                text: "Are You Sure!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3598dc',
                cancelButtonColor: '#ed6b75',
                confirmButtonText: 'yes   ',
                cancelButtonText: "cancel",
                closeOnConfirm: true,
                closeOnCancel: true
            }).then((result) => {
                if (result.value) {
                    func();
                    return true;
                } else {
                    return false;

                };
              });
        },
        */
        ConfirmBox: function (type,title, text, func) {

            swal({
                title: title,
                text: text,
                type: type,
                showCancelButton: true,
                confirmButtonColor: '#3598dc',
                cancelButtonColor: '#ed6b75',
                confirmButtonText: 'yes   ',
                cancelButtonText: "cancel",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    func();
                    return true;
                } else {
                    return false;

                };
            });
        },
        clearForm: function () {
            $('[data-toggle="clear_form"]').on('click', function (e) {
                e.preventDefault();
                var form = $(this).data('target');
                if ($(form).hasClass('staydd')) {

                } else {
                    $(form).find('input, select').val('');
                    $(form).find('.TablHideen').hide();
                    $(form).find('select').trigger('change');
                }

                return false;
            })
        },
        serialize: function (elem, o) {
            var inputs = $(elem).find('input, select');
            var arr = [];
            $.each(inputs,function (i, e) {

                if (o == 'true') {
                    var p = $.param($(e));
                    arr.push(p.slice(p.lastIndexOf('.') + 1, p.length));
                } else {
                    arr.push($.param($(e)));
                }
            });
            return arr.join('&');
        },
        stackModal: function () {
            $('[data-toggle="stack-modal"]').on('click', function (e) {
                e.preventDefault();
                var modal = $(this).data('target');
                var parentModal = $(this).closest('.modal.fade');
                hiddenModals.push(parentModal);
                $(parentModal).modal('hide');
                $(modal).modal('show');

                $(modal).on('hidden.bs.modal', function () {
                    var parentModal = hiddenModals.pop();
                    $(parentModal).modal('show');


                });

                return false;
            })
        },
        bindInputs: function (elem, obj, prefix) {

            if (prefix != '') {
                prefix = prefix + '_';
            }
            if (Object.getOwnPropertyNames(obj).length === 0) {
                $(elem).find('input, select').not('[data-can-binder-change]="false"').val('');
            } else {
                for (var property in obj) {
                    if (obj.hasOwnProperty(property)) {
                        if (typeof obj[property] == "object" && obj[property] != null) {
                            this.bindInputs(obj[property], property);
                        } else {
                            //log('property', property);
                            //log('obj[property]',obj[property]);
                            if (obj[property] == 'null' || obj[property] == null) {
                                continue; // skip value if it equals null
                            }

                            var target = $(elem).find('#' + prefix + property);
                            if (target.data('can-binder-change') == false) {
                                continue;
                            }
                            /*setTimeout(function () {

                            }, 10);*/

                            if (target.is('img')) {
                                if (obj[property] == null) {
                                    //  console.log('empty img');
                                    // target.attr('src', '/Content/assets/img/no-pi-placeholder.png');
                                } else {
                                    target.attr('src', obj[property]);
                                }

                            } else {
                                if (target.is('select')) {
                                    target.val(obj[property]);
                                    log('target', target);
                                    log('value', obj[property]);
                                    target.val(obj[property]).trigger('change');
                                }else if (target.attr('type') == 'checkbox') {
                                    var checked = false;
                                    if (obj[property]) {
                                        checked = true;

                                        $(target).closest('.checker').find('span').addClass('checked');
                                    } else {
                                        $(target).closest('.checker').find('span').removeClass('checked');
                                    }
                                    target.prop('checked', checked);
                                    var targetName = $(target).attr('name');
                                    var hiddenChecbox = $(target).closest('.checker').next('input[name="' + targetName + '"]');
                                    hiddenChecbox.val(checked);
                                    $(target).trigger('change');
                                    $(hiddenChecbox).trigger('change');
                                }else if ($(target).is('label')) {
                                    if (obj[property] != null) {
                                        $(target).text(obj[property]);
                                    }

                                } else {
                                    var regex = /(<([^>]+)>)/ig
                                    var prop = obj[property] + '';
                                    $(target).val(prop.replace(regex, " | "));
                                }




                            }

                        }
                    }
                }
            }


           /* for (var prop in object) {
                if (object.hasOwnProperty(prop)) {
                    log('#' + prop);
                    log(object[prop]);
                    $(elem).find('#' + prop).val(object[prop]);
                }

            }*/
        },

        initComponents: function () {
            /*
            var arrRules = '';
            $("#AddItemForm :input").each(function(){
                var input = $(this).attr('name');
                var valid = $(this).attr('data-valid') || '';
                if(valid != '')
                {
                    arrRules +=input+':{required: true},';
                }
               });
            */

            $('.date').datepicker({
                format: "yyyy/mm/dd",
                todayHighlight: true,
                "setDate": new Date()
            });
            $('.date').on('changeDate', function (ev) {
                $(this).datepicker('hide');
            });
            $(document).on('change', '.checker > span > input', function () {
                var name = $(this).attr('name');
                var checked = $(this).is(':checked');
                $(this).closest('.checker').next('input[name="' + name + '"]').val(checked);

            });
            $(document).on('click', '[data-toggle="modal"]', function (e) {
                e.preventDefault();
                var modal = $(this).data('target');
                $(modal).modal('show');

                return false;
            });




            $('[data-modaltite]').on('shown.bs.modal', function (e) {

            });

            $('[data-resetmodal="true"]').on('hidden.bs.modal', function () {
                $(this).find('input, select').val('');
                //$(this).find('select').trigger('change');
                $(this).find('.custom-summary').html('');
            });
            $('[data-keepdonor="true"]').on('hidden.bs.modal', function () {
                $(this).find('input').val('');
                //$(this).find('select').trigger('change');
                $(this).find('.custom-summary').html('');
            });

            $('input[type="checkbox"]').on('change', function () {

                $(this).val($(this).is(':checked'))

            });
            $(document).on('submit', '[data-toggle="ajaxrepform"]', function (e) {
                e.preventDefault();
                //if()
                //log(e);

                var form = $(this);
                form.find('.custom-summary').html('');

                var id = $(this).attr('id');
                var action = $(this).attr('action');
                var method = $(this).attr('method');
                var extraVals = $(this).data('extravals') || '';
                var acallback = $(this).data('acallback') || '';
                var required = $(this).data('required'); // to be deleted
                var realvals = extraVals.split(',');
                var serialzeArr = [];
                var serialized = '';
                var lastparam = $(this).data('lastparam') || false;
                $.each(realvals, function (i, e) {
                    if (lastparam) {
                        var p = $.param($(e));
                        serialzeArr.push(p.slice(p.lastIndexOf('.') + 1, p.length));
                    } else {
                        serialzeArr.push($.param($(e)));
                    }

                });


                if (serialzeArr.length == 0) {
                    serialized = $(this).serialize();
                } else {
                    serialized = serialzeArr.join('&') + '&' + $(this).serialize();
                }
                try {
                    App.blockUI({
                        target: '#' + id
                    })
                    $[method](action, serialized)
                    .done(function (data) {
                        if (data) {
                            if (data.hasOwnProperty("validationError")) {
                                form.find('.custom-summary').html('');
                                form.find('.custom-summary').html(data.validationMessage);
                                form.find('.custom-summary').goto('-30', 2000);
                            }
                            if (data.hasOwnProperty("status") && data.hasOwnProperty("message")) {
                                m.toast(data);
                            }
                            cb = eval(acallback);
                            if (typeof cb === 'function') {
                                cb(data, form);
                            }
                            if (data.hasOwnProperty("ReportStatus") && data.ReportStatus == "ok") {
                                window.open(data.url);
                            }



                        } else {
                            log('');
                        }


                    })
                    .fail(function () {

                    })
                    .always(function () {
                        App.unblockUI(
                            '#' + id
                        )
                    });
                } catch (err) {
                    App.unblockUI(
                            '#' + id
                        )
                } finally {

                }
                return false;
            })



            $(document).on('submit', '[data-toggle="ajaxform"]', function (e) {
                e.preventDefault();
                //if()
                //log(e);

                var form = $(this);
                form.find('.custom-summary').html('');

                var id = $(this).attr('id');
                var action = $(this).attr('action');
                var method = $(this).attr('method');
                var extraVals = $(this).data('extravals') || '';
                var acallback = $(this).data('acallback') || '';
                var bcallback = $(this).data('bcallback') || '';
                var realvals = extraVals.split(',');
                var serialzeArr = [];
                var serialized = '';
                var lastparam = $(this).data('lastparam') || false;
                $.each(realvals, function (i, e) {
                    if (lastparam) {

                        if ($(e).is('div') || $(e).is('form')) {
                            $.each($(e).find('input, select, checkbox, textarea'), function (j, y) {
                                var p = $.param($(y));
                                serialzeArr.push(p.slice(p.lastIndexOf('.') + 1, p.length));
                            })
                        } else {
                            var p = $.param($(e));
                            serialzeArr.push(p.slice(p.lastIndexOf('.') + 1, p.length));
                        }

                    } else {
                        if ($(e).is('div') || $(e).is('form')) {
                            $.each($(e).find('input, select, checkbox, textarea'), function (j, y) {
                                serialzeArr.push($.param($(y)));
                            })
                        }
                        else {
                            serialzeArr.push($.param($(e)));
                        }

                    }

                });

                bcb = eval(bcallback)
                if (typeof bcb === 'function') {
                    var ret = bcb(serialzeArr, form);
                    if (ret == false) {
                        return false;
                    }
                }
                if (serialzeArr.length == 0) {
                    serialized = $(this).serialize();
                }else{
                    serialized = serialzeArr.join('&') + '&' + $(this).serialize();
                }
                try {
                    App.blockUI({
                        target: '#' + id
                    })
                    $[method](action, serialized)
                    .done(function (data) {
                        if (data.hasOwnProperty("validationError")) {
                            form.find('.custom-summary').html('');
                            form.find('.custom-summary').html(data.validationMessage);
                            form.find('.custom-summary').goto('-30', 2000);
                        }
                        if (data.hasOwnProperty("status") && data.hasOwnProperty("message")) {
                            m.toast(data);

                            // this a custom code for item add
                            if (data.status > 0) {
                                var formID = $(form).attr('id');
                                if (formID == 'AddItemForm') {
                                    if (!$(form).hasClass('stay') && !$(form).hasClass('staydd')) {
                                        $(form).find('[data-toggle="clear_form"]').trigger('click');
                                    } else if ($(form).hasClass('staydd')) {

                                    }

                                }
                            }
                        }

                        //loadSideRec(); // refresh side menu

                        cb = eval(acallback);
                        if (typeof cb === 'function') {
                            cb(data, form);
                        }




                    })
                    .fail(function () {

                    })
                    .always(function () {
                        App.unblockUI(
                            '#' + id
                        )

                        try{
                            var chkfrm = eval('checkForm');
                            if (typeof chkfrm === 'function') {
                                chkfrm();
                            }
                        } catch (e) {

                        }

                    });
                } catch (err) {
                    App.unblockUI(
                            '#' + id
                        )
                } finally {

                }
                return false;
            })


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


            $(document).on('click', 'button[name="action"]', function (e) {
                e.preventDefault();
                //if()
                //log(e);
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
                var d = $("#AddItemFormNew").parents().eq(0).contents();
                var thi = d[5];
                // console.log(thi);
                // return false;
                realForm = new FormData(thi);
                realForm.append('_token', $('input[name="_token"]').val());
                realForm.append('_btn', $(this).val());
                realForm.append('_data_index', $(this).attr('data-index'));
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
                                form.find('select[name="'+index+'"]').addClass('is-invalid');
                                });

                            //form.find('.custom-summary').html('');
                            //form.find('.custom-summary').html('<div class="alert alert-danger" role="alert">عذراً .. يجب ادخال جميع الحقول المطلوبة</div>');
                            //form.find('.custom-summary').goto('-80', 1000);
                            form.goto('-80', 1000);
                        }


                        if (data.hasOwnProperty("status") && data.hasOwnProperty("message")) {
                            m.toast(data);

                            // this a custom code for item add
                            if (data.status > 0) {
                                var formID = $(form).attr('id');
                                if (formID == 'AddItemFormNew') {
                                    if (!$(form).hasClass('stay'))
                                        $(form).find('[data-toggle="clear_form"]').trigger('click');
                                }
                                cb = eval(acallback);
                                if (typeof cb === 'function') {
                                    cb(data, form, btnName);
                                }

                            }
                        }

                        //loadSideRec(); // refresh side menu


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

        }

    }
}();

$.fn.CheckBoxList = function (options) {
    var _this = $(this);
    var rem = $(_this).find('.CheckBoxList');
    $(rem).remove();
    var data = options.data || {};
    var cbname = options.name || 'cbName';
    var containerClass = options.containerClass || '';
    var arr = [];
    _this.append('<div class="CheckBoxList" style="display:none;"></div>');
    var container = $(_this).find('.CheckBoxList');

    $.each(data, function (i, e) {
        e.parent = e.parent == "#" ? '0' : e.parent;
        var checked = '';
        if (e.state != null) {
            checked = e.state.selected ? 'checked' : '';
        }
        //var cont = document.createElement('<div id="' + e.id + '" class="cb-tree-container"><div class="cb-tree-entry"><input type="checkbox" id="' + e.id + '" parent="' + e.parent + '" name="' + cbname + '[]"  ' + checked + '/> ' + e.text + '</div></div>');
        var cont = $('<div id="' + e.id + '" class="cb-tree-container"><div class="cb-tree-entry"><input type="checkbox" id="' + e.id + '" data-parent="' + e.parent + '" name="' + cbname + '[]"  ' + checked + '/> ' + e.text + '</div></div>');
        //if (WrapperClass != '') {
        //    log('wrapped');
        //    $(container).append($(cont).wrap('span'));
        //} else {
        //    $(container).append($(cont));
        //}

        $(container).append($(cont));


    });
    var loop = function (d) {
        var e = d.shift();
        e.parent = e.parent == "#" ? '0' : e.parent;
        if (e) {
            var curContainer = $(container).find('#' + e.parent);
            if (curContainer.length == 1) {
                $(curContainer).append($(container).find('#' + e.id));
                $(curContainer).data('hasChildren', 'true');




            }
        }

        if (data.length == 0) {
            return;
        } else {
            loop(d);
        }
    }

    loop(data);


    //var updateLevel = function (elements, level) {

    //    $.each(elements, function (i, e) {
    //        $(e).data(data('hasChildren'))
    //    })
    //    if ($(element).data('hasChildren')) {
    //        $(element).data('level', level);
    //    } else {
    //        return;
    //    }


    //    var containers = $(element).find('> .cb-tree-container');
    //    if (containers.length > 0) {



    //    }
    //}

 //   $(container).find('> .cb-tree-container').addClass(containerClass).append('<hr/>');
   // $(container).find('.cb-tree-container  > .cb-tree-entry').addClass('font-blue bold');
    var containers = $(container).find('.cb-tree-container');

    $(container).find('> .cb-tree-container').addClass(containerClass).append('<div class="clearfix"></div>');
    $(container).find('> .cb-tree-container').data('level', '0');
    $(container).find('> .cb-tree-container').css({ "border": "1px solid #eee", "marginTop": "10px", "marginBottom": "10px", "paddingTop": "10px", "paddingBottom": "10px" });
    // style parents
    var index = 0;
    $.each(containers, function (i, e) {
        if ($(e).data('hasChildren')) {
            $(e).find('> .cb-tree-entry').addClass('font-blue bold');
            if ($(e).parent().data('level') == '0') {
                $(e).addClass('col-xs-4');
                if (index % 3 == 0) {
                    $(e).after('<div class="clearfix"></div>');
                }
            } else {
                $(e).addClass(containerClass)
            }
            index++;

        }
    });



    // bubble sort
    var c = $(container).find('> .cb-tree-container');
    var l = c.length;
    var k = 0;
    for (var i = l - 1; i >= 0 ; i--) {
        for (var j = 1; j <= i; j++) {
            var length1 = $(container).find('> .cb-tree-container').eq(j).find('.cb-tree-container').length;
            var length2 = $(container).find('> .cb-tree-container').eq(j - 1).find('.cb-tree-container').length;
            if (length2 < length1) {
                $(container).find('> .cb-tree-container').eq(j - 1).before($(container).find('> .cb-tree-container').eq(j));
            }
        }
    }
    $(container).removeAttr('style');


    $(container).find('.cb-tree-container  > .cb-tree-entry > input').on('change', function (e) {

        if ($(this).parent().parent().data('hasChildren')) {

            if ($(this).is(':checked')) {

                $(this).parent().parent().find('.cb-tree-container > .cb-tree-entry > input').prop('checked', true);


            } else {
                $(this).parent().parent().find('.cb-tree-container > .cb-tree-entry > input').prop('checked', false);
            }
        }

    })
    //if (data.length > 0) {
    //    $.each(data, function (i, e) {
    //        if (e.parent == '#') {
    //            var checked = '';
    //            if (e.state != null) {
    //                checked = e.state.selected? 'checked': '';
    //            }
    //            $(_this).append('<div id="' + e.id + '" class=""><div class="cb-tree-parent"><input type="checkbox" id="' + e.id + '" parent="' + e.parent + '" name="' + cbname + '[]"  ' + checked + '/> ' + e.text + '</div></div>');
    //        }
    //    });

    //    $.each(data, function (i, e) {
    //        if (e.parent != '#') {
    //            var checked = '';
    //            if (e.state != null) {
    //                checked = e.state.selected ? 'checked' : '';
    //            }

    //        }
    //    });
    //}
}


$.fn.CheckBoxList2 = function (options) {
    var _this = $(this);
    options = options || {};
    var rem = $(_this).find('.CheckBoxList');
    $(rem).remove();
    var data = {};
    if (options.ajax === 'undefined') {
        data = options.data || {};
    } else {
        $.get(options.ajax.url, options.ajax.data())
        .done(function (d) {
            data = d;

            var cols = options.cols || 3;
            var colsOrder = options.colsOrder || [];
            var textID = options.textID || 'id';
            var x = 12 / cols;


            var cbname = options.name || 'cbName';
            var containerClass = options.containerClass || '';
            var arr = [];
            _this.append('<div class="CheckBoxList row" style="padding:10px; border:1px solid #aaa;"></div>');
            var container = $(_this).find('.CheckBoxList');

            for (var i = 1; i <= cols ; i++) {
                container.append('<div id="col' + i + '" class="col-xs-' + x + '"></div>');
            }
            var checked = '';
            $.each(colsOrder, function (i, e) {
                var x = i + 1;
                var colContainer = $(container).find('#col' + x);
                $.each(e, function (j, o) {
                    window.d = data;
                    log('data', data);

                    data.find(function (e) {
                        if (e[textID] == o.title) {
                            if (e.state != null) {
                                checked = e.state.selected ? 'checked' : '';
                            }
                            var bottomBorder = '';
                            if (o.bottomBorder == 'none') {
                                bottomBorder += 'border-bottom:none;';
                            }
                            var html = '<div data-textid="' + e[textID] + '" id="' + e.id + '" class="cb-parent-container" style="">';
                            if (!o.checkable) {
                                html += '<span class="cb-title" style="margin-top:10px;"><strong>';
                            } else {
                                html += '<input type="' + o.type + '" id="' + e.id + '" data-parent="' + e.parent + '" name="' + cbname + '[]"  ' + checked + '/> '

                            }
                            html += e.Name
                            if (!o.checkable) {
                                html += '</strong></span>';
                            }
                            html += '</div>';
                            var elm = $(html);
                            elm.data('obj', o);
                            $(colContainer).append(elm);
                        }
                    })
                });
            });
            $.each(data, function (i, e) {
                var curContainer = $(container).find('#' + e.parent);
                if (curContainer.length > 0) {
                    var obj = $(curContainer).data('obj');
                    $(curContainer).append('<div id="' + e.id + '" class="cb-child-container"><input type="' + obj.childrenType + '" id="' + e.id + '" data-parent="' + e.parent + '" name="' + cbname + '[]"  ' + checked + '/> ' + e.Name + '</div>');
                }

            });

        });
    }
    log('data2', data);


}

$.fn.Ctrl = function (options) {
    var _this = $(this);
    var KeyCodeMap = {
        65 : "a",
        66 : "b",
        67 : "c",
        68 : "d",
        69 : "e",
        70 : "f",
        71 : "g",
        72 : "h",
        73 : "i",
        74 : "j",
        75 : "k",
        76 : "l",
        77 : "m",
        78 : "n",
        79 : "o",
        80 : "p",
        81 : "q",
        82 : "r",
        83 : "s",
        84 : "t",
        85 : "u",
        86 : "v",
        87 : "w",
        88 : "x",
        89 : "y",
        90 : "z",
        48 : "0",
        96 : "0",
        49 : "1",
        97 :"1",
        50 : "2",
        98 : "2",
        51 : "3",
        99 : "3",
        52 : "4",
        100 : "4",
        53 : "5",
        101 : "5",
        54 : "6",
        102 : "6",
        55 : "7",
        103 : "7",
        56 : "8",
        104 : "8",
        57 : "9",
        105:"9",
        9 : "tab",
        19: "shift",
        17: "ctrl",
        18: "alt",
        91: "win",
        112: "f1",
        113: "f2",
        114: "f3",
        115: "f4",
        116: "f5",
        117: "f6",
        118: "f7",
        119: "f8",
        120: "f9",
        121:"f10",
        122: "f11",
        123: "f12"
    }
    //var keyMap = {
    //    "Enter": [13],
    //    "a" : [65],
    //    "b" : [66],
    //    "c" : [67],
    //    "d" : [68],
    //    "e" : [69],
    //    "f" : [70],
    //    "g" : [71],
    //    "h" : [72],
    //    "i" : [73],
    //    "j" : [74],
    //    "k" : [75],
    //    "l" : [76],
    //    "m" : [77],
    //    "n" : [78],
    //    "o" : [79],
    //    "p" : [80],
    //    "q" : [81],
    //    "r" : [82],
    //    "s" : [83],
    //    "t" : [84],
    //    "u" : [85],
    //    "v" : [86],
    //    "w" : [87],
    //    "x" : [88],
    //    "y" : [89],
    //    "z" : [90],
    //    "0" : [48,96],
    //    "1" : [49,97],
    //    "2" : [50,98],
    //    "3" : [51,99],
    //    "4" : [52,100],
    //    "5" : [53,101],
    //    "6" : [54,102],
    //    "7" : [55,103],
    //    "8" : [56,104],
    //    "9" : [57,105],
    //    "tab" : [9],
    //    "shift": [19],
    //    "ctrl": [17],
    //    "alt": [18],
    //    "win": [91],
    //    "f1": [112],
    //    "f2": [113],
    //    "f3": [114],
    //    "f4": [115],
    //    "f5": [116],
    //    "f6": [117],
    //    "f7": [118],
    //    "f8": [119],
    //    "f9": [120],
    //    "f10": [121],
    //    "f11": [122],
    //    "f12": [123]
    //}
    options = options || {};

    for (var e in options) {
        $(_this).bind('ctrl.' + e, options[e]);
        $(_this).data('has_ctrl_' + e, true);

    }
    $(this).on('keydown', function (e) {
        e.stopPropagation();
        var KeyPressed = KeyCodeMap[e.keyCode];
        var hasEvent = $(this).data('has_ctrl_' + KeyPressed);
        if (hasEvent === true) {
            if ((e.ctrlKey === true || e.metaKey === true)) {
                $(this).trigger('ctrl.' + KeyPressed);
                return false;
            }

        }

    });


    return this;

}
$.fn.searchable = function (options) {
    var _this = $(this);
    options = options || {};
    options.value = options.value || 'id';
    options.text = options.text || 'text';
    options.src = options.src || 'data';
    resultobjects = [];
    $(_this).wrap('<div class="searchable">');
    $(_this).parent('.searchable').append('<div class="search-result hidden"></div>');
    var searchResult = $(_this).parent('.searchable').find('.search-result');
    var items = [];
    var result = '';

    /*$(_this).on('blur', function () {
        $(searchResult).addClass('hidden');
    });*/

   //$(_this).on('focus', function () {
   //     $(this).trigger('keyup');
   // });

    $(window).on('click', function () {
        $(searchResult).addClass('hidden');
    });
    $(_this).on('keyup', function () {
        if ($(this).val().length >= options.startWithLength) {

            $.get(options.url + '?query=' + $(this).val())
                .done(function (data) {
                    //log(data);
                    //data = JSON.parse(data);

                    $.each(data[options.src], function (i, e) {

                        resultobjects.push(e);
                        items.push('<li class="jz-list-item" data-id=' + e[options.value] + ' data-name="' + e[options.text] + '">' + e[options.text] + '</li>');
                    });

                    result = '<ul class="jz-result-list">' + items.join('') + '</ul>';
                    items = [];
                    $(searchResult).empty();
                    $(searchResult).html(result);
                    $(searchResult).removeClass('hidden');
                })
                .fail(function () {

                })
                .always(function () {
                    $('.searchable').on('click', function (e) {
                        e.stopPropagation();
                    });
                    $('li.jz-list-item').on('click', function () {
                        var id = $(this).data('id');
                        $('#' + options.targetID).val(id);
                        $(_this).val($(this).data('name'));
                    });
                });

        }
    });


    //$(_this).parent().find('.search-result').css({ "top": height*2 });
    return _this;

}

$.fn.goto = function (margin,speed) {
    _this = this;
    margin = margin || 0;
    var offset = 0;

    if (margin == 0) {
        offset = _this.offset().top
    } else {
        offset = +_this.offset().top + +margin + 'px';
    }
    $("html, body").animate({ scrollTop: offset }, speed);

    setTimeout(function () {
        /*
        $(_this).pulsate({
            color: "#399bc3",
            reach: 10,
            repeat: 2,
            speed: 500,
            glow: false
        });
        */
    },speed)


    return _this;
}

$.fn.ajaxBtn = function (options) {

    return this.each(function () {

        $(this).on('click', function (e) {
            e.preventDefault();

            options = options || {};
            var url = options.url || $(this).data('url');
            options.dataContainer = options.dataContainer || $(this).data('datacontainer');
            options.method = options.method || $(this).data('method') || 'post';
            options.done = options.done || $(this).data('done');
            options.fail = options.fail || $(this).data('fail');
            options.always = options.always || $(this).data('always');
            options.block = options.block || 'true';
            options.confirm = options.confirm || 'false';
            options.data = options.data || '';

            if ($(this).hasClass('disabled') || $(this).data('isdisabled') == 'true') {
                return false;
            }
            _this = $(this);
            var run = function () {
                if (options.block == 'true') {
                    App.blockUI({
                        target: '.page-content'
                    });
                }

                var faClass = $(_this).find('.fa').attr('class');
                var text = $(_this).text();
                var miniLoader = '<i class="fa fa-spinner fa-pulse fa-fw"></i> ' + $(_this).text();
                $(_this).html(miniLoader);

                var postedData = '';
                if (typeof options.data === 'function') {
                    postedData = options.data();
                } else {
                    postedData = Util.serialize(options.dataContainer, 'true')
                }
                if (url != '') {
                    $[options.method](url, postedData)
                    .done(function (d) {
                        if (typeof options.done === 'function') {
                            options.done(d);
                        }

                        //loadSideRec(); // refresh side menu
                    })
                    .fail(function () {
                        if (typeof options.fail === 'function') {
                            options.fail();
                        }
                    })
                    .always(function () {
                        if (typeof options.always === 'function') {
                            options.always(d);
                            try {
                                var chkfrm = eval('checkForm');
                                if (typeof chkfrm === 'function') {
                                    chkfrm();
                                }
                            } catch (e) {

                            }
                        }

                        var text = $(_this).text();
                        var defaultText = '<i class="' + faClass + '"></i> ' + $(_this).text();
                        $(_this).html(defaultText);

                        App.unblockUI('.page-content');
                    });
                }
            }

            if (options.confirm == 'true') {
                Util.Confirm(function () {
                    run();
                })
            } else {
                run();
            }

        });
    });

}

$.fn.AjaxSelect = function (options) {
    var isInit = $(this).data('js_select_initialized');
    if (options == 'reload') {

        if (isInit) {
            $(this).trigger('js.select.reload');
            return;
        }

    }
    options = options || {};
    var url = options.url || '';
    var value = options.value || 'value';
    var text = options.text || 'text';
    var label = options.label || '';
    var postData = options.data || '';

    $(this).data('url', url);
    $(this).data('value', value);
    $(this).data('text', text);
    $(this).data('label', label);
    $(this).data('postData', postData);
    $(this).data('js_select_initialized', true);
    $(this).on('js.select.reload', function () {
        var url = $(this).data('url');
        var value = $(this).data('value');
        var text =$(this).data('text');
        var label =$(this).data('label');
        var funcData = $(this).data('postData');
        var postData = {};
        if (typeof funcData === 'function') {
            funcData(postData);
        }
        $(this).empty();
        var _this = $(this);
        if (url != '') {
            if (label != '') {
                $(_this).append($('<option></option>').attr('value', '').text(label));
            }
            $.post(url, postData)
            .done(function (data) {
                $.each(data, function (i, e) {
                    $(_this).append($('<option></option>').attr('value', e[value]).text(e[text]));
                })
            })
            .fail(function () {

            })
            .always(function () {

            });


        }
    });

    $(this).trigger('js.select.reload');
}
$.fn.ajaxEditBtn = function (options) {

    return this.each(function () {
        options = options || {};
        options.url = options.url || $(this).data('url');
        options.target = options.target || '';
        options.isModal = options.isModal || 'false';
        options.method = options.method || $(this).data('method') || 'post';
        options.done = options.done || $(this).data('done');
        options.fail = options.fail || $(this).data('fail');
        options.always = options.always || $(this).data('always');
        options.block = options.block || 'true';
        options.data = options.data || '';
        options.submitData = {};
        if (typeof options.data === 'function') {
            options.data(this, submitData);
        }
        $(document).on('click',this, function () {
            if (options.block == 'true') {
                App.blockUI({
                    target: options.target
                });
            }
            if (options.url != '') {
                $[options.method](options.url, options.submitData)
                .done(function (d) {
                    if (typeof options.done === 'function') {
                        options.done(d);
                    }
                })
                .fail(function () {
                    if (typeof options.fail === 'function') {
                        options.fail();
                    }
                })
                .always(function () {
                    if (typeof options.always === 'function') {
                        options.always(d);

                    }

                    App.unblockUI(options.target);
                });
            }
        });
    });


}

$.fn.EnterExecuteDiv = function (options) {
    var _this = this;
    $(this).data('EnterExecute', 'initialized');
    options = options || {};
    options.url = options.url || '';
    options.method = options.method || 'post';
    options.bind = options.bind || {};
    options.bind.target = options.bind.target || 'body';



    options.bind.pref = options.bind.pref || '';
    options.done = options.done || '';
    options.data = options.data || '';
    options.src = options.src || '';
    options.override = options.override || 'false';

    var postData = {};
    $(document).on('keydown', '[data-toggle="ajaxform"],[data-toggle="ajaxrepform"]', function (e) {
        if ($(options.bind.target).is('form')) {
            Util.clearValidation(options.bind.target);
        }
        if ($(_this).is(":focus") && (e.keyCode == 13)) {
            setTimeout(function () {
                $(_this).trigger('change');
            }, 200);

            if (_this.valid()) {
                if (typeof options.data === 'function') {
                    postData = options.data($(_this).val());
                } else {
                    var name = _this.attr('name');
                    var value = _this.val();
                    name = name.slice(name.lastIndexOf('.') + 1, name.length);

                    postData[name] = value;
                }

                App.blockUI({
                    target: options.bind.target
                })
                $[options.method](options.url, postData)
                .done(function (data) {
                    if (data.hasOwnProperty("status") && data.hasOwnProperty("message")) {
                        m.toast(data);
                        //$(options.bind.target).find('input, select').val('');
                    }

                    if (data.hasOwnProperty("NotSameCenter")) {
                        if (data.NotSameCenter) {
                            $('form').find('.custom-summary').html('<div class="alert alert-warning">The Data is Returned From Other Center!</div>');
                        } else {
                            $('form').find('.custom-summary').html('');

                        }
                    } else {
                        $('form').find('.custom-summary').html('');
                    }
                    if (typeof options.done === 'function') {
                        if (options.override == 'false') {
                            if (options.src == '') {
                                Util.bindInputs(options.bind.target, data, options.bind.pref);
                            } else {
                                Util.bindInputs(options.bind.target, options.bind.pref);
                            }
                        }
                        options.done(data,_this);
                    } else {
                        if (options.src == '') {
                            Util.bindInputs(options.bind.target, data, options.bind.pref);
                        } else {
                            Util.bindInputs(options.bind.target, options.bind.pref);
                        }
                    }

                })
                .fail(function () {

                })
                .always(function () {
                    App.unblockUI(
                           options.bind.target
                       )

                });
                return false;
            }

        }


    });

    return _this;
}



$.fn.EnterExecute = function (options, func) {
    options.tabbtn = options.tabbtn || 'false';
    if (options == 'refresh') {
        var isInit = $(this).data('EnterExecuteInitialized');
        if (isInit == 'true') {
            var event = jQuery.Event('keydown', { which: 13, keyCode:13 });
            $(this).trigger(event, func);
        } else {
            alert('Error: input is not initiated as Enter Execute');
        }

    } else {
        $(this).data('url', options.url);
        $(this).data('EnterExecuteInitialized', 'true');
        $(this).data('method', options.method);
        $(this).data('target', options.bind.target);
        $(this).data('pref', options.bind.pref);
        $(this).data('done', options.done);
        $(this).data('data', options.data);
        $(this).data('src', options.src);
        $(this).data('override', options.override);
        $(this).data('stay', options.bind.stay);
        $(this).data('tabbtn', options.tabbtn);

        if (options.tabbtn == 'true') {
            $(this).focusout(function () {
                var originalVal = $(this).data('originalval');
                if (originalVal != $(this).val()) {
                    $(this).EnterExecute('refresh');
                }

            });
        }
        $(this).on('keydown', function (keyDownEvent,func) {
            var _this = $(this);
            if ($(_this).attr('disabled') == 'disabled') {
                return;
            }

            var originalVal = $(this).data('originalval');
            if (originalVal == $(this).val()) {
                //return;
                //في حال القيمة لم تتغير يجب منع تفعيل البلجن
            }

            if (_this.val() != '') {
            options = options || {};
            options.url = $(this).data('url') || '';
            options.method = $(this).data('method') || 'post';
            options.bind = options.bind || {};
            options.bind.target = $(this).data('target') || 'body';
            options.tabbtn = $(this).data('tabbtn') || 'false';

            options.bind.pref = $(this).data('pref') || '';
            var stay = $(this).data('stay') || '';
            var originalVal = $(this).val();
            options.done = $(this).data('done') || '';
            options.data = $(this).data('data') || '';
            options.src = $(this).data('src') || '';
            options.override = $(this).data('override') || 'false';
            var postData = {};
            var form = $(_this).closest('form')
            var formBinder = function () {
                return {
                    init: function () {
                        $(document).on('keydown', form, function (e) {
                            if (e.keyCode == 13) {
                                return false;
                            }

                        });
                        $(document).on('keypress', form, function (e) {
                            if (e.keyCode == 13) {
                                return false;
                            }
                        });
                        $(document).on('keyup', form, function (e) {
                            if (e.keyCode == 13) {
                                return false;
                            }
                        });
                        form.on('bind', form, function (e, func) {

                            if ($(options.bind.target).is('form')) {

                                Util.clearValidation(options.bind.target);

                            }

                            var thisForm = $(this);
                            if (e.keyCode == 13) {
                                setTimeout(function () {
                                    $(_this).trigger('change');
                                }, 200);

                                if (_this.valid()) {
                                    if (typeof options.data === 'function') {
                                        postData = options.data();
                                    } else {
                                        var name = _this.attr('name');
                                        var value = _this.val();
                                        name = name.slice(name.lastIndexOf('.') + 1, name.length);

                                        postData[name] = value;
                                    }

                                    App.blockUI({
                                        target: options.bind.target
                                    })
                                    $[options.method](options.url, postData)
                                    .done(function (data) {
                                        if (!stay) {
                                            $(thisForm).find('input, select').not('[data-can-clear="false"]').val('');

                                        }
                                        $(thisForm).find('.custom-summary').html('');
                                        $(thisForm).find('select').trigger('change');


                                        if (data.hasOwnProperty("status") && data.hasOwnProperty("message")) {
                                            m.toast(data);

                                            if (!stay) {
                                                $(options.bind.target).find('input, select').not('[data-can-clear="false"]').val('');
                                            } else {
                                                $(_this).val(originalVal);
                                                $(_this).data('originalval', originalVal);
                                                return 0;
                                            }


                                        }

                                        if (data.hasOwnProperty("NotSameCenter")) {
                                            if (data.NotSameCenter) {
                                                $('form').find('.custom-summary').html('<div class="alert alert-warning">The Data is Returned From Other Center!</div>');
                                            } else {
                                                $('form').find('.custom-summary').html('');

                                            }
                                        } else {
                                            $('form').find('.custom-summary').html('');
                                        }
                                        if (typeof options.done === 'function')
                                        {

                                            if (options.override == 'false') {
                                                    if (options.src == '') {
                                                        Util.bindInputs(options.bind.target, data, options.bind.pref);
                                                    } else {
                                                        Util.bindInputs(options.bind.target, options.bind.pref);
                                                    }


                                            }
                                            options.done(data);
                                        } else {
                                                if (options.src == '') {
                                                    Util.bindInputs(options.bind.target, data, options.bind.pref);
                                                } else {
                                                    Util.bindInputs(options.bind.target, options.bind.pref);
                                                }


                                        }


                                        if (stay) {
                                            $(_this).val(originalVal);

                                        }
                                        $(_this).data('originalval', originalVal);
                                        $(thisForm).find('input').not('#AccountDisplayNo').not('#CashAccountDisplayNo').trigger('change');
                                    })
                                    .fail(function () {

                                    })
                                    .always(function () {
                                        App.unblockUI(
                                               options.bind.target
                                           )
                                        if (typeof func === 'function') {
                                            func();
                                        }
                                        try {
                                            var chkfrm = eval('checkForm');
                                            if (typeof chkfrm === 'function') {
                                                chkfrm();
                                            }
                                        } catch (e) {

                                        }
                                    });
                                    return false;
                                }
                            }


                        });
                    },
                    bind: function (func) {
                        var event = jQuery.Event("bind");
                        event.keyCode = 13;
                            form.trigger(event, func);
                        form.off('bind');
                    }
                }
            }();

//$(_this).is(":focus") &&

                if (keyDownEvent.keyCode == 13) {
                formBinder.init();
                formBinder.bind(func);
            }
            }


            //_this.off('bind');
        })
    }
    return this;
}
$.fn.ClickExectue = function (options) {

    var _this = this;
    options = options || {};
    options.url = options.url || '';
    options.method = options.method || 'post';
    options.bind = options.bind || {};
    options.bind.target = options.bind.target || 'body';



    options.bind.pref = options.bind.pref || '';
    options.done = options.done || '';
    options.data = options.data || '';
    options.src = options.src || '';
    options.override = options.override || 'false';
    var postData = {};
    $(_this).off('click');
    $(_this).on('click', function (e) {
        if ($(options.bind.target).is('form')) {
            Util.clearValidation(options.bind.target);
        }

        var __this = $(this);
        e.preventDefault();
                if (typeof options.data === 'function') {
                    postData = options.data(__this);
                } else {
                    var name = _this.attr('name');
                    var value = _this.val();
                    name = name.slice(name.lastIndexOf('.') + 1, name.length);

                    postData[name] = value;
                }
                App.blockUI({
                    target: options.bind.target
                })
                $[options.method](options.url, postData)
                .done(function (data) {
                    if (data.hasOwnProperty("status") && data.hasOwnProperty("message")) {
                        m.toast(data);
                        return;
                    }
                    if (data.hasOwnProperty("NotSameCenter")) {
                        if (data.NotSameCenter) {
                            $('form').find('.custom-summary').html('<div class="alert alert-warning">The Data is Returned From Other Center!</div>');
                        } else {
                            $('form').find('.custom-summary').html('');

                        }
                    } else {
                        $('form').find('.custom-summary').html('');
                    }
                    if (typeof options.done === 'function') {
                        if (options.override == 'false') {


                            if (options.src == '') {

                                Util.bindInputs(options.bind.target, data, options.bind.pref);
                            } else {
                                Util.bindInputs(options.bind.target, options.bind.pref);
                            }
                        }
                        options.done(data);
                    } else {
                        if (options.src == '') {
                            Util.bindInputs(options.bind.target, data, options.bind.pref);
                        } else {
                            Util.bindInputs(options.bind.target, options.bind.pref);
                        }
                    }

                })
                .fail(function () {

                })
                .always(function () {
                    App.unblockUI(
                            options.bind.target
                        )

                    try {
                        var chkfrm = eval('checkForm');
                        if (typeof chkfrm === 'function') {
                            chkfrm();
                        }
                    } catch (e) {

                    }


                });
                return false;


    });

    return _this;
}

var m = function () {
    return {
        toast: function (d) {
            toastr.options = this.toastSettings;

            if (/[a-zA-Z]/.test(d.status)) {
                toastr["success"](d.message, "success!");
            } else {
                if (d.status > 0) {
                    toastr["success"](d.message, "success!");
                }
                else if (d.status == -2) {
                    toastr["info"](d.message, "info!");
                }
                else {
                    toastr["error"](d.message, "error!");
                }
            }

        },
        toastSettings: {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-bottom-left",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }
}();





$(document).ready(function () {
    Util.init();
    $(document).ajaxComplete(function (event, xhr, settings) {
        var myHeader = xhr.getResponseHeader('custom-session-ended');
        if (myHeader) {
            window.location = "/Logout";
        }
    });
    $(document).ajaxError(function (event, jqxhr, settings, thrownError) {
        toastr.options =  {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-bottom-full-width",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        window.settings = settings;
        window.event = event;
        window.jqxhr = jqxhr;
        window.thrownError = thrownError;
        var HtmlError = $.parseHTML(jqxhr.responseText);
        console.log(jqxhr)
        if (HtmlError != 'undefined' && HtmlError != null) {
            if (Object.keys(HtmlError).length > 0) {
                //console.log(HtmlError[0].text)
                toastr["error"](settings.url + ' says ' + HtmlError[0].wholeText, "error!");
            } else {
                toastr["error"](settings.url + ' says : Unknown Error Occured!', "error!");
            }
        } else {
           // toastr["error"](settings.url + ' says : Unknown Error Occured!', "error!");

        }



    });
/*
    $(".search-select").select2({
        placeholder: "Select from ..",
        allowClear: true
    });
*/






    $(document).on('click', '.clickable-tr', function () {
        $(this).find('.select-item').trigger('click');
        setTimeout(function () {
            $('#AddItemModal').find('#Price').focus();
        },1000)
    });

    //$('.date, .restricted-date').inputmask("y/m/d", {
    //    "placeholder": "yyyy/mm/dd"
    //}); //multi-char placeholder
});
