
    (function ($) {
        $(document).ready(function () {

            $("#jform_state").attr("data-show-subtext","true");
            $("#jform_state").attr("data-live-search","true");
            $('#jform_state').selectpicker();


            $("#jform_zip_code").attr("data-show-subtext","true");
            $("#jform_zip_code").attr("data-live-search","true");
            $('#jform_zip_code').selectpicker();
            $("#jform_zip_code").parent().append('<ul id="searchResult"></ul>');



            //$("#state").addClass("");


            $('#jform_TERM').parent().html($('#jform_TERM').parent().html()+Joomla.JText._("COM_USERS_TERM_COND"));

            var isCellphoneValid = function () {
                let cel = parseInt($('#jform_cellphone').val());
                if (isNaN(cel)) {
                    $('#jform_cellphone_err').remove();
                    $('#jform_cellphone-lbl, #jform_cellphone').addClass('invalid');
                    $('<div id="jform_cellphone_err" class="invalid">El valor que ingresaste no es válido.</div>').insertAfter('#jform_cellphone');
                    return false;
                }
                $('#jform_cellphone_err').remove();
                $('#jform_cellphone-lbl, #jform_cellphone').removeClass('invalid');
                return true;
            };
            var isEmailValid = function () {
                var isValid = true;
                var email = $('#jform_email').val();
                if (!email) {
                    isValid = false;
                }
                if (!isValid) {
                    $('#jform_email_err').remove();
                    $('#jform_email-lbl, #jform_email').addClass('invalid');
                    $('<div id="jform_email_err" class="invalid">El valor que ingresaste no es válido.</div>').insertAfter('#jform_email');
                    return false;
                }
                $('#jform_email_err').remove();
                $('#jform_email-lbl, #jform_email').removeClass('invalid');
                return true;
            };
            $('#jform_cellphone').change(function () {
                return isCellphoneValid();
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




            $('#jform_cellphone').change(function () {
                return isCellphoneValid();
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

            $('#jform_pid').keyup(function (event) {
                return isPidValid();
            });

            $('#jform_gmin').keyup(function (event) {
                return isGminValid();
            });


            $('#jform_rfc').keyup(function () {
                return isRfcValid('jform_rfc');
            });

            var isRfcValid = function (id) {
                if ( $("#jform_rfc").length ) {
                    let pattern = /^[a-zA-Z]{3,4}(\d{6})((\D|\d){2,3})?$/;
                    let rfc =$('#jform_rfc').val();
                    if (pattern.test(rfc)) {
                        $('#' + id + '_err').remove();
                        $('#' + id + '-lbl, ' + id).removeClass('invalid');
                        return true;
                    }
                    $('#' + id + '_err').remove();
                    $('#' + id + '-lbl, ' + id).addClass('invalid');
                    $('<div id="' + id + '_err" class="invalid">' + Joomla.JText._('COM_PERFIL_REGISTER_RFC_INVALID_FIELD') + '</div>').insertAfter('#' + id);
                    return false;
                }
            };


            var isPidValid = function () {
                if ( $("#jform_gmin").length ) {
                    if ($('#jform_pid').val().length < 6) {
                        $('#jform_pid_err').remove();
                        $('#jform_pid-lbl, #jform_pid').addClass('invalid');
                        $('<div id="jform_pid_err" class="invalid">' + Joomla.JText._('COM_PERFIL_REGITER_INVALID_FIELD') + '</div>').insertAfter('#jform_pid');
                        return false;
                    }
                    $('#jform_pid_err').remove();
                    $('#jform_pid-lbl, #jform_pid').removeClass('invalid');
                    return true;
                }

            };

            var isGminValid = function () {
                if ( $("#jform_gmin").length ) {

                    if ($('#jform_gmin').val().length !== 9) {
                        $('#jform_gmin_err').remove();
                        $('#jform_gmin-lbl, #jform_gmin').addClass('invalid');
                        $('<div id="jform_gmin_err" class="invalid">' + Joomla.JText._('COM_PERFIL_REGITER_INVALID_FIELD') + '</div>').insertAfter('#jform_gmin');
                        return false;
                    }
                    $('#jform_gmin_err').remove();
                    $('#jform_gmin-lbl, #jform_gmin').removeClass('invalid');
                    return true;
                }

            };


            $('#perfilForm').submit(function (event) {
                var response = true;

                if (!isEmailValid()) {
                    response = false;
                }
                if (!isCellphoneValid()) {
                    response = false;
                }
                if (!isRfcValid('jform_rfc')) {
                    response = false;
                }
                if (!isPidValid()) {
                    response = false;
                }
                if (!isGminValid()) {
                    response = false;
                }
                if (!$('#jform_TERM').is(':checked')) {
                    swal('Corregir los datos', 'Debe aceptar los términos y condiciones', "warning");
                    return false;
                }
                var nameLength = $("#jform_name").val();

                if(nameLength.length>10){
                    response =true;
                }else{
                    $("#jform_name_err").remove();
                    $("#jform_name").parent().append('<div id="jform_name_err" class="invalid">' + Joomla.JText._('COM_PERFIL_REGITER_INVALID_NAME_FIELD') + '</div>');
                    response=false;

                }
                if (!response) {
                    //scrollTop();
                    swal('Corregir los datos', 'Hay campos en el formulario que no se han capturado correctamente\nFavor de corregirlos', "warning");
                    return false;
                }
            });

            $("#jform_zip_code").keypress(function(event) {
                if(event.keyCode == 13&&event.target.value.length==5) {
                    event.preventDefault();
                    console.log(event);

                    var key = $("#token").attr("name");
                    var url='index.php?option=com_perfil&task=datosperfil.getZip&format=raw';

                    $.ajax({
                        type:"POST",
                        url: url,
                        data:{zip:event.target.value,token:key},
                    }).done(function(data) {

                        if(data!=""||data!=null){
                            var data = $.parseJSON(data);
                            //type 2 = zip unico
                            //type 1 lista de zip
                            if(data.type==1){
                                //llenar lista
                                llenarLista(data.data);
                            }else{
                                setText(data.data,2);
                            }

                        }

                    }).fail(function() {
                        console.log("error");
                    });
                }
            });
            $("#jform_zip_code").keyup(function(event){
                var zip=$(this).val();
                if(zip.length>1){
        if(event.keyCode!=13){

            var key = $("#token").attr("name");
            var url='index.php?option=com_perfil&task=datosperfil.getDatos&format=raw';
            if(zip!=""||zip!=null){
                $.ajax({
                    type:"POST",
                    url: url,
                    data:{zip:zip,token:key},
                }).done(function(data) {

                    if(data!=""||data!=null){
                        var data = $.parseJSON(data);
                        $("#searchResult").empty();

                        llenarLista(data);
                    }

                }).fail(function() {
                    console.log("error");
                });
            }
        }


                }

            });

    function llenarLista(data){
        $("#searchResult").empty();
        $.each(data, function(i, item) {
            var datos_zip= item.zip_code+" - "+item.location;
            $("#searchResult").append("<li data-zip='"+item.zip_code+"' data-location='"+item.location+"' data-town='"+item.town+"' data-city='"+item.city+"'  data-state='"+item.state+"'>"+datos_zip+" </li>");
        });

        $("#searchResult li").bind("click",function(){
            setText(this,1);
        });

    }


            function setText(element,type){
                if(type==2){
                    $("#jform_zip_code").val(element.zip_code);
                    $("#searchResult").empty();
                    $("#jform_location").val(element.location);
                    $("#jform_city").val(element.city);
                    $("#jform_state").val(element.state);
                }else{
                    $("#jform_zip_code").val(element.dataset.zip);
                    $("#searchResult").empty();
                    $("#jform_location").val(element.dataset.location);
                    $("#jform_city").val(element.dataset.city);
                    $("#jform_state").val(element.dataset.state);
                }
            }
        });


        function scrollTop(){
            $('html, body').animate({scrollTop:0},500);
        }

    }
    )(jQuery);



