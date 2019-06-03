jQuery(function ($) {
    SqueezeBox.initialize({});
    SqueezeBox.assign($('a.modal').get(), {
        parse: 'rel'
    });
});

window.jModalClose = function () {
    SqueezeBox.close();
};
function  disabledfields() {
    $("#jform_name").hide();
    $("#jform_email1").hide();
    $("#jform_cellphone").hide();
    $("#jform_password1").hide();
    $("#jform_password2").hide();

    //labels

    $("#jform_name-lbl").hide();
    $("#jform_email1-lbl").hide();
    $("#jform_cellphone-lbl").hide();
    $("#jform_password1-lbl").hide();
    $("#jform_password2-lbl").hide();
    $("#btnGuardar").hide();;

}

function enabledfields(){
    $("#jform_username").show();
    $("#jform_name").show();
    $("#jform_email1").show();
    $("#jform_cellphone").show();
    $("#jform_password1").show();
    $("#jform_password2").show();
    //labels
    $("#jform_name-lbl").show();
    $("#jform_email1-lbl").show();
    $("#jform_cellphone-lbl").show();
    $("#jform_password1-lbl").show();
    $("#jform_password2-lbl").show();
    $("#btnGuardar").show();

}


// Add extra modal close functionality for tinyMCE-based editors
document.onreadystatechange = function () {
    disabledfields();
    if (document.readyState == 'interactive' && typeof tinyMCE != 'undefined' && tinyMCE) {
        if (typeof window.jModalClose_no_tinyMCE === 'undefined') {
            window.jModalClose_no_tinyMCE = typeof (jModalClose) == 'function' ? jModalClose : false;
            jModalClose = function () {
                if (window.jModalClose_no_tinyMCE)
                    window.jModalClose_no_tinyMCE.apply(this, arguments);
                tinyMCE.activeEditor.windowManager.close();
            };
        }
        if (typeof window.SqueezeBoxClose_no_tinyMCE === 'undefined') {
            if (typeof (SqueezeBox) == 'undefined') {
                SqueezeBox = {};
            }
            window.SqueezeBoxClose_no_tinyMCE = typeof (SqueezeBox.close) == 'function' ? SqueezeBox.close : false;
            SqueezeBox.close = function () {
                if (window.SqueezeBoxClose_no_tinyMCE) {
                    window.SqueezeBoxClose_no_tinyMCE.apply(this, arguments);
                }
                tinyMCE.activeEditor.windowManager.close();
            };
        }
    }
};
(function ($) {
    $(document).ready(function () {
        $("#btnGuardar").hide();
        //Función para validar una CURP
        var validaCurp = function (curp) {
            var re = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
                    validado = curp.match(re);

            if (!validado) { //Coincide con el formato general?
                return false;
            }

            //Validar que coincida el dígito verificador
            function digitoVerificador(curp17) {
                //Fuente https://consultas.curp.gob.mx/CurpSP/
                var diccionario = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
                        lngSuma = 0.0,
                        lngDigito = 0.0;
                for (var i = 0; i < 17; i++) {
                    lngSuma = lngSuma + diccionario.indexOf(curp17.charAt(i)) * (18 - i);
                }
                lngDigito = 10 - lngSuma % 10;
                if (lngDigito == 10) {
                    return 0;
                } else {
                    return lngDigito;
                }
            }

            if (validado[2] != digitoVerificador(validado[1])) {
                return false;
            }

            return true; //Validado
        };

        var isRfcValid = function (id) {
            let pattern = /^[a-zA-Z]{3,4}(\d{6})((\D|\d){2,3})?$/;
            let rfc = document.getElementById(id).value;
            if (pattern.test(rfc)) {
                $('#' + id + '_err').remove();
                $('#' + id + '-lbl, ' + id).removeClass('invalid');
                return true;
            }
            $('#' + id + '_err').remove();
            $('#' + id + '-lbl, ' + id).addClass('invalid');
            $('<div id="' + id + '_err" class="invalid">' + Joomla.JText._('PLG_USEROVERRIDE_INVALID_FIELD') + '</div>').insertAfter('#' + id);
            return false;
        };

        var matchRfc = function () {
            let rfc = document.getElementById("jform_rfc").value;
            let username = document.getElementById("jform_username").value;
            if (rfc !== username) {
                $('#jform_rfc_err').remove();
                $('#jform_username_err').remove();
                $('#jform_rfc-lbl, #jform_rfc').addClass('invalid');
                $('#jform_username-lbl, #jform_username').addClass('invalid');
                $('<div id="jform_rfc_err" class="invalid">' + Joomla.JText._('PLG_USEROVERRIDE_NOTMATCH_FIELD') + '</div>').insertAfter('#jform_rfc');
                $('<div id="jform_username_err" class="invalid">' + Joomla.JText._('PLG_USEROVERRIDE_NOTMATCH_FIELD') + '</div>').insertAfter('#jform_username');
                return false;
            }
            $('#jform_rfc_err').remove();
            $('#jform_username_err').remove();
            $('#jform_rfc-lbl, #jform_rfc').removeClass('invalid');
            $('#jform_username-lbl, #jform_username').removeClass('invalid');
            return true;
        };

        var isDateValid = function (dateString) {
            // revisar el patrón
            if (!/^\d{4}\-\d{1,2}\-\d{1,2}$/.test(dateString))
                return false;

            // convertir los numeros a enteros
            var parts = dateString.split("/");
            var day = parseInt(parts[2], 10);
            var month = parseInt(parts[1], 10);
            var year = parseInt(parts[0], 10);

            // Revisar los rangos de año y mes
            if ((year < 1000) || (year > 3000) || (month === 0) || (month > 12))
                return false;

            var monthLength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

            // Ajustar para los años bisiestos
            if (year % 400 === 0 || (year % 100 !== 0 && year % 4 === 0))
                monthLength[1] = 29;

            // Revisar el rango del dia
            return day > 0 && day <= monthLength[month - 1];
        };

        var isCellphoneValid = function () {
            let cel = parseInt($('#jform_cellphone').val());
            if (isNaN(cel)) {
                $('#jform_cellphone_err').remove();
                $('#jform_cellphone-lbl, #jform_cellphone').addClass('invalid');
                $('<div id="jform_cellphone_err" class="invalid">' + Joomla.JText._('PLG_USEROVERRIDE_INVALID_FIELD') + '</div>').insertAfter('#jform_cellphone');
                return false;
            }
            $('#jform_cellphone_err').remove();
            $('#jform_cellphone-lbl, #jform_cellphone').removeClass('invalid');
            return true;
        };


        var isCardNumberValid = function () {
            let number = parseInt($('#jform_card_number').val());
            if (isNaN(cel)) {
                $('#jform_card_number_err').remove();
                $('#jform_card_number-lbl, #jform_card_number').addClass('invalid');
                $('<div id="jform_card_number_err" class="invalid">' + Joomla.JText._('PLG_USEROVERRIDE_INVALID_FIELD') + '</div>').insertAfter('#jform_cellphone');
                return false;
            }
            $('#jform_card_number_err').remove();
            $('#jform_card_number-lbl, #jform_card_number').removeClass('invalid');
            return true;
        };


        var isCurpValid = function () {
            var isValid = false;
            var curp = $('#jform_curp').val();
            if (curp.length === 18) {
                isValid = validaCurp(curp);
            }
            if (!isValid) {
                $('#jform_curp_err').remove();
                $('#jform_curp-lbl, #jform_curp').addClass('invalid');
                $('<div id="jform_curp_err" class="invalid">' + Joomla.JText._('PLG_USEROVERRIDE_INVALID_FIELD') + '</div>').insertAfter('#jform_curp');
                return false;
            }
            $('#jform_curp_err').remove();
            $('#jform_curp-lbl, #jform_curp').removeClass('invalid');
            return true;
        };

        var isAdmissionDateValid = function () {
//            if ($('#jform_admissiondate').val() === '') {
//                $('#jform_admissiondate_err').remove();
//                $('#jform_admissiondate-lbl, #jform_admissiondate').addClass('invalid');
//                $('<div id="jform_admissiondate_err" class="invalid">' + Joomla.JText._('PLG_USEROVERRIDE_INVALID_FIELD') + '</div>').insertAfter('#jform_admissiondate');
//                return false;
//            }
//            $('#jform_admissiondate').remove();
//            $('#jform_admissiondate-lbl, #jform_admissiondate').removeClass('invalid');
            return true;
        };
        var isBirthdayValid = function () {
            if ($('#jform_birthday').val() === '') {
                $('#jform_birthday_err').remove();
                $('#jform_birthday-lbl, #jform_birthday').addClass('invalid');
                $('<div id="jform_birthday_err" class="invalid">' + Joomla.JText._('PLG_USEROVERRIDE_INVALID_FIELD') + '</div>').insertAfter('#jform_birthday');
                return false;
            }
            $('#jform_birthday_err').remove();
            $('#jform_birthday-lbl, #jform_birthday').removeClass('invalid');
            return true;
        };

        var isPidValid = function () {
            if ($('#jform_pid').val().length < 6) {
                $('#jform_pid_err').remove();
                $('#jform_pid-lbl, #jform_pid').addClass('invalid');
                $('<div id="jform_pid_err" class="invalid">' + Joomla.JText._('PLG_USEROVERRIDE_INVALID_FIELD') + '</div>').insertAfter('#jform_pid');
                return false;
            }
            $('#jform_pid_err').remove();
            $('#jform_pid-lbl, #jform_pid').removeClass('invalid');
            return true;
        };

        var isGminValid = function () {
            if ($('#jform_gmin').val().length !== 9) {
                $('#jform_gmin_err').remove();
                $('#jform_gmin-lbl, #jform_gmin').addClass('invalid');
                $('<div id="jform_gmin_err" class="invalid">' + Joomla.JText._('PLG_USEROVERRIDE_INVALID_FIELD') + '</div>').insertAfter('#jform_gmin');
                return false;
            }
            $('#jform_gmin_err').remove();
            $('#jform_gmin-lbl, #jform_gmin').removeClass('invalid');
            return true;
        };

        var isIneValid = function () {
            var ine = $('#jform_ine');
            var filename = ine.val();
            var ext = filename.substring(filename.length - 4).toLowerCase();
            if (ext == '.jpg' || ext == 'jpeg' || ext == '.png' || ext == '.pdf') {
                $('#jform_ine_err').remove();
                $('#jform_ine-lbl, #jform_ine').removeClass('invalid');
                return true;
            }
            $('#jform_ine_err').remove();
            $('#jform_ine-lbl, #jform_ine').addClass('invalid');
            $('<div id="jform_ine_err" class="invalid">' + Joomla.JText._('PLG_USEROVERRIDE_INVALID_FIELD') + '</div>').insertAfter('#jform_ine');
            return false;
        };

        $("#jform_tyc-lbl").click(function () {
            document.getElementById('terminos').click();
        });

        $('#jform_dealer').val('');
        $('#jform_profile').val('');


        $('#jform_rfc').keyup(function () {
            return isRfcValid('jform_rfc');
        });




        $('#jform_curp').keyup(function () {
            isCurpValid();
        });

        $('#jform_cellphone').change(function () {
            return isCellphoneValid();
        });

        $('#jform_admissiondate').change(function () {
            return isAdmissionDateValid();
        });

        $('#jform_birthday').change(function () {
            return isBirthdayValid();
        });

        $('#jform_pid').change(function (event) {
            return isPidValid();
        });

        $('#jform_gmin').change(function (event) {
            return isGminValid();
        });

        $('#jform_curp').change(function () {
            $('#jform_curp').val($('#jform_curp').val().toUpperCase());
            isCurpValid();
        });
        $('#jform_birthday').keydown(function (event) {
            // Ensure that it is a number and stop the keypress
            event.preventDefault();
        });
//        $('#jform_admissiondate').keydown(function (event) {
//            // Ensure that it is a number and stop the keypress
//            event.preventDefault();
//        });
        $('#jform_gmin').keydown(function (event) {
            // Allow: backspace, delete, tab, escape, and enter
            // Allow: Ctrl+A
            // Allow: home, end, left, right
            // Allow 1-9 
            // Allow 1-9 Numeric PAD
            // let it happen, don't do anything
            if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || (event.keyCode == 65 && event.ctrlKey === true) || (event.keyCode >= 35 && event.keyCode <= 39) || (event.keyCode >= 48 && event.keyCode <= 57 && !event.shiftKey) || (event.keyCode >= 96 && event.keyCode <= 105)) {
                return;
            } else {
                // Ensure that it is a number and stop the keypress
                event.preventDefault();
            }
        });
        $('#jform_pid').keydown(function (event) {
            // Allow: backspace, delete, tab, escape, and enter
            // Allow: Ctrl+A
            // Allow: home, end, left, right
            // Allow 1-9
            // Allow 1-9 Numeric PAD
            // let it happen, don't do anything
            if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || (event.keyCode == 65 && event.ctrlKey === true) || (event.keyCode >= 35 && event.keyCode <= 39) || (event.keyCode >= 48 && event.keyCode <= 57 && !event.shiftKey) || (event.keyCode >= 96 && event.keyCode <= 105)) {
                return;
            } else {
                // Ensure that it is a number and stop the keypress
                event.preventDefault();
            }
        });

        $('#jform_cellphone').keydown(function (event) {
            // Allow: backspace, delete, tab, escape, and enter
            // Allow: Ctrl+A
            // Allow: home, end, left, right
            // Allow 1-9 
            // Allow 1-9 Numeric PAD
            // let it happen, don't do anything
            if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || (event.keyCode == 65 && event.ctrlKey === true) || (event.keyCode >= 35 && event.keyCode <= 39) || (event.keyCode >= 48 && event.keyCode <= 57 && !event.shiftKey) || (event.keyCode >= 96 && event.keyCode <= 105)) {
                return;
            } else {
                // Ensure that it is a number and stop the keypress
                event.preventDefault();
            }
        });

        $('#jform_username').keydown(function (event) {
            // Allow: backspace, delete, tab, escape, and enter
            // Allow: Ctrl+A
            // Allow: home, end, left, right
            // Allow 1-9
            // Allow 1-9 Numeric PAD
            // let it happen, don't do anything
            if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || (event.keyCode == 65 && event.ctrlKey === true) || (event.keyCode >= 35 && event.keyCode <= 39) || (event.keyCode >= 48 && event.keyCode <= 57 && !event.shiftKey) || (event.keyCode >= 96 && event.keyCode <= 105)) {
                return;
            } else {
                // Ensure that it is a number and stop the keypress
                event.preventDefault();
            }
        });

        $('#jform_ine').focusout(function () {
            return isIneValid();
        });

        $('#jform_name').on('keydown keyup change', function(){

        });


        $("#jform_state").change(function(){
            //var key = $('#token').val();
            var key = $("#token").attr("name");
            var url = 'index.php?plg=usercustom&task=get_sucursal';
        if($(this).val()!=""||$(this).val()!=null){
                $.ajax({
                type:"POST",
                url: url,
                async: false,
                data:{estado_id:$(this).val(),token:key},
                context: document.body
            }).done(function(data) {
            $("#jform_office").empty();
            if(data!=null){
            var data = $.parseJSON(data);
            $.each(data, function(i, item) {
                $("#jform_office").append(new Option(item.Sucursal, item.Sucursal)
                );
            });
        }
        });
    }

        });



        $("#jform_username").blur(function(){

            var key = $("#token").attr("name");
            var url = 'index.php?plg=usercustom&task=valida_numero_tarjeta';
            var numero=$("#jform_username").val();
            if(numero!=""||numero!=null){
                $.ajax({
                    type:"POST",
                    url: url,
                    async: false,
                    data:{numero_tarjeta:numero,token:key},
                    context: document.body
                }).done(function(data) {
                    var data = $.parseJSON(data);
                    if(data!=null){
                       if(data.data==true||data.data=="true"){
                           $("#jform_id").val(data.id_user);
                           enabledfields();
                       }else{
                           $("#jform_username_err").remove();
                           $("#jform_username").parent().append('<div id="jform_username_err" class="invalid">' + Joomla.JText._('PLG_USERS_REGISTER_USERNAME_INVALID') + '</div>');
                           disabledfields();
                           setTimeout(function(){
                               $("#jform_username_err").remove();

                               }, 9000);
                             }
                    }else{
                        $("#jform_username_err").remove();
                        $("#jform_username").parent().append('<div id="jform_username_err" class="invalid">' + Joomla.JText._('PLG_USERS_REGISTER_USERNAME_INVALID') + '</div>');
                        //Error numero
                        setTimeout(function(){
                            $("#jform_username_err").remove();

                        }, 9000);
                    }
                });
            }

        });




        $('#jform_dealer').change(function () {
            if ($('#div_jform_profile').is(':visible')) {
                setFields();
                $('#jform_profile').val("");
            } else {
                $('#div_jform_profile').show("slow");
            }
        });

        function setFields(flag) {
            switch (flag) {
                case 'AV':
                    $('#div_jform_manager').show("slow");
                    $('#jform_manager').val("");
                    $('#div_jform_fyi').show("slow");
                    $('#jform_fyi').val("");
                    $('#div_jform_afyi').show("slow");
                    $('#jform_afyi').val("");
                    break;
                case 'GTE':
                case 'GTEN':
                case 'GTENS':
                case 'GTSM':
                case 'FYI':
                    $('#div_jform_manager').hide("slow");
                    $('#jform_manager').val("");
                    $('#div_jform_fyi').hide("slow");
                    $('#jform_fyi').val("");
                    $('#div_jform_afyi').show("slow");
                    $('#jform_afyi').val("");
                    break;
                default:
                    $('#div_jform_manager').hide("slow");
                    $('#jform_manager').val("");
                    $('#div_jform_fyi').hide("slow");
                    $('#jform_fyi').val("");
                    $('#div_jform_afyi').hide("slow");
                    $('#jform_afyi').val("");
                    break;
            }
        }

        $('#jform_profile').change(function () {
            var dealer_id = parseInt($('#jform_dealer').val());
            if (dealer_id > 0) {
                load_team(dealer_id, this.value);
            }
        });

        function setMessage(msg, cssClass) {
            $('#messages').empty();
            $('#messages').addClass(cssClass);
            $('#messages').append(msg);

        }

        function load_team(value, user_role) {
            var profile = $('#jform_profile').val();
            var key = $('#__f__').val();
            var url = 'index.php?plg=usercustom&task=load_team';

            $('#jform_manager').empty();
            $('#jform_fyi').empty();
            $('#jform_afyi').empty();

            if (profile != '') {
                $.ajax({
                    type: 'POST',
                    async: false,
                    url: url,
                    data: {dealer: value, token: key}
                }).done(function (data) {
                    //console.log(data);
                    setFields(user_role);
                    var d = $.parseJSON(data);
                    for (var i = 0; i < d.length; i++) {
                        switch (d[i].profile) {
                            case 'GTE':
                            case 'GTEN':
                            case 'GTENS':
                            case 'GTEF':
                            case 'GTSM':
                                if (user_role == 'AV') {
                                    $('#jform_manager').append('<option value="' + d[i].id + '">' + d[i].name + '</option>');
                                }
                                break;
                            case 'FYI':
                                if (user_role == 'AV') {
                                    $('#jform_fyi').append('<option value="' + d[i].id + '">' + d[i].name + '</option>');
                                }
                                break;
                            case 'AFYI':
                                if (user_role != 'AFYI') {
                                    $('#jform_afyi').append('<option value="' + d[i].id + '">' + d[i].name + '</option>');
                                }
                                break;
                        }
                    }
                }).fail(function (data) {
                    setMessage(Joomla.JText._('PLG_USEROVERRIDE_ERROR_DATA'), 'alert alert-danger');
                });
            } else {
                setMessage(Joomla.JText._('PLG_USEROVERRIDE_FIELD_PROFILE_MSG'), 'alert alert-danger');
            }
        }

        function validatePIN(pin1,pin2){
            if(pin1==pin2){
                if(pin1.length>=8){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }


        var href='<a style="color:black" href="#" data-toggle="modal" data-target="#tc_modal" >'+Joomla.JText._("PLG_USERS_TERM_COND")+'' +
            ' </a>'+'|'+'<a  style="color:black" href="#" data-toggle="modal" data-target="#ap_modal" >'+Joomla.JText._("PLG_USERS_PRI")+' </a>';

        $('#jform_TERM').parent().html(
            $('#jform_TERM').parent().html()+href);

        $("#member-registration").on('submit', function (event) {
            var pin= $("#jform_password1").val();
            var pin2=$("#jform_password2").val();


            if ( !$('#jform_TERM').is(':checked')) {
                swal('Corregir los datos', 'Debe aceptar los términos y condiciones', "warning");
                return false;
            }


            if(validatePIN(pin,pin2)){
                var nameLength = $("#jform_name").val();
                if(nameLength.length>10){
                    return true;
                }else{
                    event.preventDefault();
                    $("#jform_name_err").remove();
                   $("#jform_name").parent().append('<div id="jform_name_err" class="invalid">' + Joomla.JText._('PLG_USER_REGISTER_NAMEERROR') + '</div>');
                }
            }else{
                event.preventDefault();
                $("#jform_password_err").remove();
                $("#jform_password1").parent().append('<div id="jform_password_err" class="invalid">' + Joomla.JText._('PLG_USER_REGISTER_PASSWORD') + '</div>');

            }

        });
        $('#jform_gmin-lbl').attr('title', Joomla.JText._('COM_USERS_REGISTER_GMIN_DESC'));
        $('#jform_pid-lbl').attr('title', Joomla.JText._('COM_USERS_REGISTER_PID_DESC'));
    });

})(jQuery);
