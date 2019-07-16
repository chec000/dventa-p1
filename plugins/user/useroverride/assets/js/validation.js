jQuery(function ($) {
    SqueezeBox.initialize({});
    SqueezeBox.assign($('a.modal').get(), {
        parse: 'rel'
    });
});

window.jModalClose = function () {
    SqueezeBox.close();
};
var emailValido=false;
function  disabledfields() {
    $("#jform_name").hide();
    $("#jform_name").hide();
   $(".optional").hide();
    $("#jform_last_name1").hide();
    $("#jform_last_name2").hide();
    $("#jform_email1").hide();
    $("#jform_cellphone").hide();
    $("#jform_password1").hide();
    $("#jform_password2").hide();
    $("#jform_business_name").hide();

    //labels

    $("#jform_name-lbl").hide();
    $("#jform_last_name1-lbl").hide();
    $("#jform_last_name2-lbl").hide();
    $("#jform_email1-lbl").hide();
    $("#jform_cellphone-lbl").hide();
    $("#jform_password1-lbl").hide();
    $("#jform_password2-lbl").hide();
    $("#jform_business_name-lbl").hide();
    $("#btnGuardar").hide();;

}

function enabledfields(){
    $("#jform_username").show();
    //$(".optional").show();
    $("#jform_name").show();
    $("#jform_last_name1").show();
    $("#jform_last_name2").show();

    $("#jform_email1").show();
    $("#jform_cellphone").show();
    $("#jform_password1").show();
    $("#jform_password2").show();
    //labels
    $("#jform_last_name1-lbl").show();
    $("#jform_last_name2-lbl").show();
    $("#jform_name-lbl").show();
    $("#jform_email1-lbl").show();
    $("#jform_cellphone-lbl").show();
    $("#jform_password1-lbl").show();
    $("#jform_password2-lbl").show();
    $("#jform_business_name").show();
    $("#jform_business_name-lbl").show();

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


                     
        function validateExistEmail(email){
            var key = $("#token").attr("name");
            var url = 'index.php?plg=usercustom&task=valida_email';
            var exist=false;
            $.ajax({
                type:"POST",
                url: url,
                async: false,
                data:{email:email,token:key},
                context: document.body
            }).done(function(data) {
                var data = $.parseJSON(data);
                exist=data;    
            })
             .fail(function() {
              exist=false;
              });

            return exist;
        }



    $('#jform_email1').keyup(function (event) {
        if(!isEmailValid()){           
          $("#jform_email_err").remove();
            $("#jform_email1").parent().append('<div id="jform_email_err" class="invalid">' + Joomla.JText._('PLG_USERS_REGISTER_EMAIL1_ERROR') + '</div>');
       
        }else{           
        $("#jform_email_err").remove();
        }
        
        }); 

    $('#jform_email1').blur(function() {
        if(isEmailValid()){    
        if(!validateExistEmail($(this).val())){  
          swal('Correo registrado', 'El correo ya esta registrado, ¡Intente con otro!', "error");
         $(this).val('');            
        }
         }              
        }); 
       

    $('#jform_last_name1').keyup(function (event) {
        if(isNameValid($.trim(event.currentTarget.value))){
        $("#jform_last1_name_err").remove();
        }else{
            $("#jform_last1_name_err").remove();
            $("#jform_last_name1").parent().append('<div id="jform_last1_name_err" class="invalid">' + Joomla.JText._('PLG_USERS_REGISTER_LASTNAME1_ERROR') + '</div>');
        }
        });


    $('#jform_last_name2').keyup(function (event) {
        if(isNameValid(event.currentTarget.value)){
        $("#jform_last2_name_err").remove();
        }else{
            $("#jform_last2_name_err").remove();
            $("#jform_last_name2").parent().append('<div id="jform_last2_name_err" class="invalid">' + Joomla.JText._('PLG_USERS_REGISTER_LASTNAME2_ERROR') + '</div>');
        }
        });


        $('#jform_name').keyup(function (event) {
        if(isNameValid($(this).val().trim())){
        $("#jform_name_err").remove();
        }else{
            $("#jform_name_err").remove();
            $("#jform_name").parent().append('<div id="jform_name_err" class="invalid">' + Joomla.JText._('PLG_USERS_REGISTER_NAME_ERROR') + '</div>');
        }
        });

        $('#jform_password1').keyup(function () {
            if(validatePassword($('#jform_password1').val().trim())){
            $('#jform_password1_err').remove();
            $('#jform_cellphone-lbl, #jform_cellphone').removeClass('invalid');
           
            }else{
                $('#jform_password1_err').remove();
                $('#jform_password1-lbl, #jform_password1').addClass('invalid');
                $('<div id="jform_password1_err" class="invalid">' + Joomla.JText._('PLG_USERS_REGISTER_PIN1_ERROR') + '</div>').insertAfter('#jform_password1');                      
            }
        });

        $('#jform_password2').keyup(function () {
            if(validatePIN($('#jform_password1').val(),$('#jform_password2').val())){
            $('#jform_password2_err').remove();
            $('#jform_password2-lbl, #jform_password2').removeClass('invalid');
           
            }else{
                $('#jform_password2_err').remove();
                $('#jform_password2-lbl, #jform_password2').addClass('invalid');
                $('<div id="jform_password2_err" class="invalid">' + Joomla.JText._('PLG_USERS_REGISTER_PIN_ERROR') + '</div>').insertAfter('#jform_password2');                      
            }
        });


        $('#jform_cellphone').keyup(function () {
            let cel = $('#jform_cellphone').val();       
            if(isCellphoneValid(cel)){     
            $('#jform_cellphone_err').remove();
            $('#jform_cellphone-lbl, #jform_cellphone').removeClass('invalid');
           
            }else{
                $('#jform_cellphone_err').remove();
                $('#jform_cellphone-lbl, #jform_cellphone').addClass('invalid');
                $('<div id="jform_cellphone_err" class="invalid">' + Joomla.JText._('PLG_USERS_REGISTER_CELLPHONE_ERROR') + '</div>').insertAfter('#jform_cellphone');           
           
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

     

        $("#jform_state").change(function(){
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

        $( "#jform_username" ).keypress(function( event ) {
            if ( event.which == 13 ) {
                var numero=$("#jform_username").val();
                event.preventDefault();
                getUser(numero);
            }

        });

        function getUser(numero){
            var key = $("#token").attr("name");
            var url = 'index.php?plg=usercustom&task=valida_numero_tarjeta';

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
                        if (data.code==500) {
                    swal('Tarjeta invalida', 'No se encontró ninguna tarjeta con este número, ¡Trate con otra tarjeta!', "error");
                    
                        }else{
                    swal('Tarjeta ya registrada', 'El número de tarjeta ya ha sido registrado, por favor inicia sesión', "error");
                        $("#jform_username_err").remove();
                        $("#jform_username").parent().append('<div id="jform_username_err" class="invalid">' + Joomla.JText._('PLG_USERS_REGISTER_USERNAME_INVALID') + '</div>');
                        disabledfields();
                        setTimeout(function(){
                            $("#jform_username_err").remove();

                        }, 9000);
                    
                        }
                    
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

        $("#jform_username").blur(function(){
            var numero=$("#jform_username").val();
            if(numero!=""||numero!=null){
                if (numero.length==8) {
                getUser(numero);                    
                }else{
                 $("#jform_username_err").remove();
                 $("#jform_username").parent().append('<div id="jform_username_err" class="invalid">' + Joomla.JText._('PLG_USERS_REGISTER_USERNAME_INVALID') + '</div>');                          
                }
            }

        });


     
    

        function setMessage(msg, cssClass) {
            $('#messages').empty();
            $('#messages').addClass(cssClass);
            $('#messages').append(msg);

        }



            var isCellphoneValid = function (value) {
                if (value.length==10) {
                var numero=parseInt(value);
                if (numero>0) {
                    return true;           
                }else{
                    return false;
                }
                }else{
                    return false;  
                }
            }

    function isEmailValid() {               
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

            if (regex.test($('#jform_email1').val().trim())) {
                return true;
            } else {
             return false;
            }
        }



       function isNameValid(value) {
             if (value.length>=3) {
                 return true;
             }else{
                 return false;
             }
         }  

     
        function validatePassword(pin1){

             var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%&]).*$/;
              if(pattern.test(pin1)){
               return true;
                }else{
                 return false;
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

        var href='Acepto <a style="color:black;text-decoration: underline;" href="#" data-toggle="modal" data-target="#tc_modal" >'+Joomla.JText._("PLG_USERS_TERM_COND")+'' +
            ' </a>'+'&nbsp;' +' y '+'&nbsp;'+ ' <a  style="color:black;text-decoration: underline;" href="#" data-toggle="modal" data-target="#ap_modal" > '+Joomla.JText._("PLG_USERS_PRI")+' </a>';
        $('#jform_TERM').parent().html(
        $('#jform_TERM').parent().html()+href);


        function validateForm() {
           var response=true;
              if (!isEmailValid($("#jform_email1").val())) {
                    response=false;
                }

              if (!isNameValid($("#jform_name").val().trim())) {
                    response=false;
                }


              if (!isNameValid($("#jform_last_name1").val().trim())) {
                    response=false;
                }

              if (!isNameValid($("#jform_last_name2").val().trim())) {
                    response=false;
                }


              if (!isCellphoneValid($("#jform_cellphone").val().trim())) {
                    response=false;
                }


              if (!validatePassword($("#jform_password1").val().trim())) {
                    response=false;
                }

                if (!validatePIN($("#jform_password1").val(),$("#jform_password2").val())) {
                       response=false;
                }
                return response;
        }


        $("#member-registration").on('submit', function (event) {
            var pin= $("#jform_password1").val();
            var pin2=$("#jform_password2").val();

            if ( !$('#jform_TERM').is(':checked')) {
                swal('Corregir los datos', 'Debe aceptar los términos y condiciones', "warning");               
                event.preventDefault();
            }

            if(validateForm()){               
                    return true;               
            }else{
                  swal('Corregir los datos', 'Hay campos en el formulario que no se han capturado correctamente\nFavor de corregirlos', "warning");
                    
                
                event.preventDefault();

            }

        });
        $('#jform_gmin-lbl').attr('title', Joomla.JText._('COM_USERS_REGISTER_GMIN_DESC'));
        $('#jform_pid-lbl').attr('title', Joomla.JText._('COM_USERS_REGISTER_PID_DESC'));
    });

})(jQuery);
