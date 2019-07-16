
function validaNumericos(event,type) {
    var elemeto=document.getElementById("mensaje");
    if(elemeto!=null){
        elemeto.remove();
    }
    valido=false;
    switch (type) {
        case 1:
            //telefono
            valido =(event.target.value.length==10)?true:false;

            break;
            case 2:
            //nss
            valido =(event.target.value.length==11)?true:false;

            break;

            case 3:
            //otro
            valido =(event.target.value.length>10)?true:false;

            break;
        }

        if(valido){
            event.target.parentElement.classList.remove("alert");
            event.target.parentElement.classList.remove("alert-error");

        }else{


            event.target.parentElement.classList.add("alert");
            event.target.parentElement.classList.add("alert-error");
            var div=document.createElement("div");
            var textoH1=document.createTextNode(Joomla.JText._('COM_PERFIL_INVALID_FIELD'));
            div.appendChild(textoH1);
            div.id="mensaje";
            div.classList.add("alert-heading");
            event.target.parentElement.appendChild(div);

        }


    }
    
    (function ($) {
        $(document).ready(function () {
            var valido=false;
            $('.selectpicker').selectpicker({
                liveSearch: true
            });


           setTimeout(function(){ setTitle() }, 500);
            function setTitle() {


            var car=$("#jform_car_brand").val();
             
            var boton=$(".dropdown-toggle");
            if (boton!=null) {
            if (car!=null&&car!="") {

             boton.addClass('btn-success');
             boton.children().first().text(car);
             $("#jform_car_gasoline").prop("required", true);  
             $("#jform_car_cylinders").prop("required", true);  
             }else{
             boton.addClass('btn-success');
             boton.children().first().text(Joomla.JText._('COM_PERFIL_SELECT_OPTION'));                          
             }   

            }
           
            }


        $("#jform_state_id").change(function(){
            var key = $("#token").attr("name");
            
             var url='index.php?option=com_perfil&task=datosperfil.getSucursales&format=raw';
                       
              if($(this).val()!=""||$(this).val()!=null){
                $.ajax({
                type:"POST",
                url: url,
                async: false,
                data:{estado_id:$(this).val(),token:key},
                context: document.body
            }).done(function(data) {
            $("#jform_branch_office").empty();
            if(data!=null){
            var items = $.parseJSON(data);
            $.each(items, function(i, item) {
                $("#jform_branch_office").append(new Option(item.Sucursal, item.Sucursal)
                );
              
            });
        }
        });
    }
       });

            $('#jform_car').on('change', function() {
                var id=$(this).val();;
                var key = $("#token").attr("name");
                var url='index.php?option=com_perfil&task=datosperfil.getCar&format=raw';
                $.ajax({
                    type:"POST",
                    url: url,
                    data:{id:id,token:key},
                }).done(function(data) {
                    var data=jQuery.parseJSON(data);
                    if(data!=null){
                        $("#jform_car_brand").val(data.brand);                             
                        $("#jform_car_model").val(data.model);
                        $("#jform_car_year").val(data.anio);
                        $("#jform_car_nodata").prop("checked", false);  
                        $("#jform_car_gasoline").prop("required", true);  
                        $("#jform_car_cylinders").prop("required", true);  

                    }
                }).fail(function() {
                    console.log("error");
                });


            });


            function disbleSubmit(){
                $( "#adminForm").submit(function( event ) {
                    event.preventDefault();
                });
            }
     $('#jform_email').blur(function() {
        if(isEmailValid()){    
        if(!validateExistEmail($(this).val())){  
          swal('Correo registrado', 'El correo ya esta registrado, trate con otro', "error");
         $(this).val('');            
        }
         }              
        }); 

            $('#jform_email').keyup(function (event) {
                if(!isEmailValid()){
                    $("#jform_email_err").remove();
                    $("#jform_email").parent().append('<div id="jform_email_err" class="invalid">' + Joomla.JText._('COM_PERFIL_REGISTER_EMAIL_LABEL_ERROR') + '</div>');

                }else{
                    $("#jform_email_err").remove();
                }

            });

            $("#jform_phone" ).keyup(function( event ) {
                this.value = (this.value + '').replace(/[^0-9]/g, '');
                //validaNumericos(event,1);
                let cel = $('#jform_phone').val();       
                if(isCellphoneValid(cel)){     
                    $('#jform_phone_err').remove();
                    $('#jform_phone-lbl, #jform_phone').removeClass('invalid');

                }else{
                    $('#jform_phone_err').remove();
                    $('#jform_phone-lbl, #jform_phone').addClass('invalid');
                    $('<div id="jform_phone_err" class="invalid">' + Joomla.JText._('COM_PERFIL_REGISTER_TELEFONO_LABEL_ERROR') + '</div>').insertAfter('#jform_phone');           

                }

            });
            $("#jform_nss" ).keyup(function( event ) {

                validaNumericos(event,2);
            });

            $("#jform_pid" ).keyup(function( event ) {
                this.value = (this.value + '').replace(/[^0-9]/g, '');
                validaNumericos(event,3);
            });

            disbleSubmit();
            var pas=$("#jform_password");
            if(pas!=null){
                $("#jform_password").removeAttr('value');
                $("#jform_password").attr('value','');
            }

            $("#jform_state").attr("data-show-subtext","true");
            $("#jform_state").attr("data-live-search","true");
            $('#jform_state').selectpicker();


            $("#jform_zip_code").attr("data-show-subtext","true");
            $("#jform_zip_code").attr("data-live-search","true");
            $('#jform_zip_code').selectpicker();
            $("#jform_zip_code").parent().append('<ul id="searchResult"></ul>');



            $('#jform_street').keyup(function (event) {
                if(validateStreet($(this).val().trim())){
                    $("#jform_street_err").remove();
                }else{
                    $("#jform_street_err").remove();
                    $("#jform_street").parent().append('<div id="jform_street_err" class="invalid">' + Joomla.JText._('COM_PERFIL_REGISTER_STREET_ERROR') + '</div>');
                }
            });





            $('#jform_reference').keyup(function (event) {
                if(validateReference($(this).val().trim())){
                    $("#jform_reference_err").remove();
                }else{
                    $("#jform_reference_err").remove();
                    $("#jform_reference").parent().append('<div id="jform_reference_err" class="invalid">' + Joomla.JText._('COM_PERFIL_REGISTER_REFERN_ERROR') + '</div>');
                }
            });

          function setMessage(id,message) {
                  let error=id+'_err';
                          $('#'+error).remove();
                    $('#'+id).parent().append('<div id="'+error+'" class="invalid">' + message + '</div>');               
          }

            $('#jform_last_name1').keyup(function (event) {
                if(isNameValid($(this).val().trim())){
                    $("#jform_last_name1_err").remove();
                }else{
                    $("#jform_last_name1_err").remove();
                    $("#jform_last_name1").parent().append('<div id="jform_last_name1_err" class="invalid">' + Joomla.JText._('COM_PERFIL_REGISTER_LASTNAME1_ERROR') + '</div>');
                
                }
            });


            $('#jform_last_name2').keyup(function (event) {
                if(isNameValid($(this).val().trim())){
                    $("#jform_last_name2_err").remove();
                }else{
                    $("#jform_last_name2_err").remove();
                    $("#jform_last_name2").parent().append('<div id="jform_last_name2_err" class="invalid">' + Joomla.JText._('COM_PERFIL_REGISTER_LASTNAME2_ERROR') + '</div>');
                }
            });


            $('#jform_name').keyup(function (event) {
                if(isNameValid($(this).val().trim())){
                    $("#jform_name_err").remove();
                }else{
                    $("#jform_name_err").remove();
                    $("#jform_name").parent().append('<div id="jform_name_err" class="invalid">' + Joomla.JText._('COM_PERFIL_REGISTER_NAME_ERROR') + '</div>');
                }
            });

            $('#jform_password').keyup(function () {
                if(validatePassword($(this).val().trim())){
                    $('#jform_password_err').remove();
                    $('#jform_password-lbl, #jform_password').removeClass('invalid');

                }else{
                    $('#jform_password_err').remove();
                    $('#jform_password-lbl, #jform_password').addClass('invalid');
                    $('<div id="jform_password_err" class="invalid">' + Joomla.JText._('COM_PERFIL_REGISTER_PIN1_ERROR') + '</div>').insertAfter('#jform_password');                      
                }
            });

            $('#password2').keyup(function () {
                if(validatePIN($('#jform_password').val().trim(),$('#password2').val().trim())){
                    $('#password2_err').remove();
                    $('#password2-lbl, #password2').removeClass('invalid');

                }else{
                    $('#password2_err').remove();
                    $('#password2-lbl, #password2').addClass('invalid');
                    $('<div id="password2_err" class="invalid">' + Joomla.JText._('COM_PERFIL_REGISTER_PIN2_ERROR') + '</div>').insertAfter('#password2');                      
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
                    $('<div id="jform_cellphone_err" class="invalid">' + Joomla.JText._('COM_PERFIL_REGISTER_CELLPHONE_ERROR') + '</div>').insertAfter('#jform_cellphone');           

                }
            });


            $('#jform_cellphone, #jform_phone, #jform_zip_code').keydown(function (event) {
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
                this.value = (this.value + '').replace(/[^0-9]/g, '');

                return isGminValid();
            });


            $('#jform_rfc').keyup(function () {
                return isRfcValid('jform_rfc');
            });


   function validateReference(value){
                if (value.length>=10) {
                    return true;
                }else{
                    return false;
                }
            }         
            function validateStreet(value) {
                if (value.length>=5) {
                    return true;
                }else{
                    return false;
                }

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

            };

            function isEmailValid() {               
                var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

                if (regex.test($('#jform_email').val().trim())) {
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
            if (pin1!=null) {

                if(pin1.length>=8){
                    return true;
                }else{
                    return false;
                }
            }else{
                return true;
            }                 
            }

            function validatePIN(pin1,pin2){
               if (pin1!=null&&pin2!=null) {

                    if(pin1==pin2){
                    if(pin1.length>=8){
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }                   
               }else{
                   return true;
               }

            }


            var isRfcValid = function (id) {

                var rfc=$("#jform_rfc").val();

                if(rfc!=null){
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
                }else{
                    return true;
                }

            };


            var isPidValid = function () {
                var gmid= $("#jform_gmin").val();
                if(gmid!=null){
                    if ( $("#jform_gmin").length>0 ) {
                        if ($('#jform_pid').val().length < 6) {
                            $('#jform_pid_err').remove();
                            $('#jform_pid-lbl, #jform_pid').addClass('invalid');
                            $('<div id="jform_pid_err" class="invalid">' + Joomla.JText._('COM_PERFIL_REGITER_INVALID_FIELD') + '</div>').insertAfter('#jform_pid');
                            return false;
                        }
                        $('#jform_pid_err').remove();
                        $('#jform_pid-lbl, #jform_pid').removeClass('invalid');
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return true;
                }


            };

            var isGminValid = function () {
                if($("#jform_gmin").val()!=null){
                    if ( $("#jform_gmin").length ) {
                        if ($('#jform_gmin').val().length !== 9) {
                            $('#jform_gmin_err').remove();
                            $('#jform_gmin-lbl, #jform_gmin').addClass('invalid');
                            $('<div id="jform_gmin_err" class="invalid">' + Joomla.JText._('COM_PERFIL_INVALID_FIELD') + '</div>').insertAfter('#jform_gmin');
                            return false;
                        }
                        $('#jform_gmin_err').remove();
                        $('#jform_gmin-lbl, #jform_gmin').removeClass('invalid');
                        return true;
                    }
                }else{
                    return true;
                }

            };



            $( '#jform_car_nodata' ).on( 'click', function() {
                disableCar();
            });
            function disableCar() {
                var check=$("#jform_car_nodata").is(':checked');
                if (check) {                  
                    $("#jform_car_brand").val('');
                    $("#jform_car_model").val('');
                    $("#jform_car_year").val('');
                    $("#jform_car_gasoline").val('');       
                    $("#jform_car_cylinders").val('');       
                    $("#jform_car_gasoline").prop("required", false);  
                    $("#jform_car_cylinders").prop("required", false);  

                }
            }

            $('#perfilForm').submit(function (event) {
               disableCar();
            
            event.preventDefault();

            if(!validateForm()) {
             swal(Joomla.JText._('COM_PERFIL_INVALID_DATA_TITLE'),Joomla.JText._('COM_PERFIL_INVALID_DATA') , "warning");              
                    }else{
                        $("#contenedor").show();
                    var key = $("#token").attr("name");
                     var input_token=$("#token");
                    $("#token").remove();
                    var url='index.php?option=com_perfil&task=datosperfil.savePerfil&format=raw';
                    $.ajax({
                        type:"POST",
                        url: url,
                        data:{data:$( this ).serializeArray(),token:key},
                    }).done(function(data) {
                        $("#contenedor").hide();
                            $('#perfilForm').append(input_token);
                        if(data!=""||data!=null){
                           try {
                            var data = $.parseJSON(data);

                              if(data.code==200){
                                Swal.fire({
                                  title: 'Datos actualizados',
                                  text: data.msg,
                                  type: 'success',
                                  allowOutsideClick:false,
                                  confirmButtonColor: '#3085d6', 
                                  confirmButtonText: 'Aceptar'
                                }).then((result) => {
                                  if (result.value) {
                                    window.location.href=window.location.origin;
                                  }
                                })
                                
                            }else{
                                swal('Error', data.msg, "warning");
                            }
                      
                               }        
                                catch(err) {
                              swal('Error',Joomla.JText._('COM_PERFIL_TEXT_SAVE_FAIL') , "danger");   

                                }
                            

                        }

                    }).fail(function() {
                        $("#contenedor").hide();
                        $('#perfilForm').append(input_token);
                        swal('Error',Joomla.JText._('COM_PERFIL_TEXT_SAVE_FAIL') , "danger");
                    });
                    
                    }           
                       // $("#contenedor").toggle();
            });

         
            function validateForm() {
                response = true;

                var name=$("#jform_name").val();
                if(name!=null){
                    if (!isNameValid($("#jform_name").val().trim())) {
                        setMessage("jform_name",Joomla.JText._('COM_PERFIL_INVALID_FIELD'));
                        response = false;               
                    }
                }
                var last1=$("#jform_last_name1").val();
                if(last1!=null){

                    if (!isNameValid($("#jform_last_name1").val().trim())) {
                        response = false;
                        setMessage("jform_last_name1",Joomla.JText._('COM_PERFIL_INVALID_FIELD'));
                    }

                }
                var last2=$("#jform_last_name2").val();
                if(last2!=null){
                    if (!isNameValid($("#jform_last_name2").val().trim())) {
                     setMessage("jform_last_name2",Joomla.JText._('COM_PERFIL_INVALID_FIELD'));
                        response = false;
                    }
                }
                var pass=$("#jform_password").val();
                if(pass!=null){
                    if (!validatePassword($("#jform_password").val().trim())) {
                        setMessage("jform_password",Joomla.JText._('COM_PERFIL_INVALID_FIELD'));
                        response = false;
                    }
                }
                var email=$("#jform_email").val();
                if(email!=null){
                    if (!isEmailValid()) {
                        setMessage("jform_email",Joomla.JText._('COM_PERFIL_INVALID_FIELD'));
                        response = false;
                    }
                }
                var cel=$("#jform_cellphone").val();
                if(cel!=null){                              
                    if (!isCellphoneValid($("#jform_cellphone").val())) {
                        setMessage("jform_cellphone",Joomla.JText._('COM_PERFIL_INVALID_FIELD'));
                        response=false;
                    }
                }
                var phone=$("#jform_phone").val();
                if(phone!=null){
                    if (!isCellphoneValid($("#jform_phone").val())) {
                        setMessage("jform_phone",Joomla.JText._('COM_PERFIL_INVALID_FIELD'));
                        response=false;

                    }
                }
                var street=$("#jform_street").val();
                if(street!=null){
                        if (!validateStreet(street.trim())) {
                        setMessage("jform_street",Joomla.JText._('COM_PERFIL_INVALID_FIELD'));
                            response=false;
                        }
                }
                var ext=$("#jform_ext_number").val();
                if(ext!=null){
                        if (ext=="") {
                            
                        setMessage("jform_ext_number",Joomla.JText._('COM_PERFIL_INVALID_FIELD'));
                            response=false;
                        }
                }   
                //var int=$("#jform_int_number").val();
               // if(int!=null){
                 //       if (int=="") {
                   //         response=false;
                     //   setMessage("jform_int_number",Joomla.JText._('COM_PERFIL_INVALID_FIELD'));
                       // }
                //}   
                var refe=$("#jform_reference").val();
                if(refe!=null){
                        if (!validateReference(refe.trim())) {
                                setMessage("jform_reference",Joomla.JText._('COM_PERFIL_INVALID_FIELD'));
                                response=false;
                        }
                }   

                var dob=$("#jform_dob").val();
                if (dob!=null) {
                        if (dob=="") {
                            setMessage("jform_dob",Joomla.JText._('COM_PERFIL_INVALID_FIELD'));
                            response=false;
                        }
                }        
                var zip=$("#jform_zip_code").val();
                if (zip!=null) {
                    if (zip.lengt<5) {
                        setMessage("jform_zip_code",Joomla.JText._('COM_PERFIL_INVALID_FIELD'));
                        response=false;
                    }
                }

                    if ($("#jform_password").val()!=null&&$("#password2").val()!=null) {
                   if (!validatePIN($("#jform_password").val().trim(),$("#password2").val())) {
                    setMessage("password2",Joomla.JText._('COM_PERFIL_INVALID_FIELD'));
                    response=false;
                }
                        }
                if ($("#jform_email").val()!=null) {
                if (!validateExistEmail($("#jform_email").val().trim())) {
                 setMessage("jform_email",Joomla.JText._('COM_PERFIL_INVALID_EMAIL_EXIST'));   
                response=false;
                }
                }


                    return response;
            }

            $("#jform_zip_code").keypress(function(event) {
                if(event.keyCode == 13&&event.target.value.length==5) {
                    event.preventDefault();

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

  function validateExistEmail(email){
            var key = $("#token").attr("name");
            //var url='index.php?option=com_perfil&task=datosperfil.getDatos&format=raw';
            var url='index.php?option=com_perfil&task=datosperfil.validaCorreo&format=raw';
            var idUsuario=$("input[name=userId]").val();;
            var exist=false;
            var vars = {email:email, id_usuario:idUsuario};
            $.ajax({
                type:"GET",
                url: url,
                async: false,
                dataType: 'json',
                data:{vars,token:key},
                
            }).done(function(data) {
                var data = $.parseJSON(data);
                exist=data;    
            })
             .fail(function() {
              exist=false;
              });

            return exist;
        }

function scrollTop(){
    $('html, body').animate({scrollTop:0},500);
}

}
)(jQuery);



