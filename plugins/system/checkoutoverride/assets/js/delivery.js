jQuery(function () {

    jQuery('.zc').autocomplete({
        serviceUrl: 'index.php/component/checkout/?task=autocompleteCode',
        paramName: 'search',
        minChars: 1,
        maxHeight: 400,
        width: 300,
        zIndex: 9999,
        deferRequestBy: 500,
        onSelect: function (index) {
            jQuery('.lc').val('');
            jQuery('#town').val('');
            jQuery('.city').val('');
            jQuery('#state').val('');
            jQuery('.lc').autocomplete('search', '');
        }
    });

    jQuery('.lc').focus(function () {
        jQuery('.lc').autocomplete({
            serviceUrl: 'index.php?option=com_checkout&task=autocompleteLocation&zc=' + jQuery('.zc').val(),
            paramName: 'search',
            minChars: 1,
            maxHeight: 400,
            width: 300,
            zIndex: 9999,
            deferRequestBy: 500,
            onSelect: function (index) {
                jQuery('.city').autocomplete({
                    serviceUrl: 'index.php?option=com_checkout&task=autocompleteCity&zc=' + jQuery('.zc').val() + '&location=' + index.value,
                    paramName: 'search',
                    minChars: 1,
                    maxHeight: 400,
                    width: 300,
                    zIndex: 9999,
                    deferRequestBy: 500,
                    onSelect: function (index) {
                        jQuery('#town').autocomplete({
                            serviceUrl: 'index.php?option=com_checkout&task=autocompleteCity&zc=' + jQuery('.zc').val() + '&location=' + jQuery('.lc').val() + '&city=' + index.value,
                            paramName: 'search',
                            minChars: 1,
                            maxHeight: 400,
                            width: 300,
                            zIndex: 9999,
                            deferRequestBy: 500
                        }).val(index.data.town).data('autocomplete');
                    },
                }).val(index.data.city).data('autocomplete');
                jQuery('#town').val(index.data.town);
                jQuery('#state').val(index.data.state);
            }
        });
        jQuery('.lc').val(' ');
        jQuery('.lc').trigger('keyup');
    });

});

function changeCedis(val) {
    var str = window.location.search;
    str = replaceQueryParam('task', 'delivery', str);
    str = replaceQueryParam('cedis', val, str);
    window.location = window.location.pathname + str;
}

function replaceQueryParam(param, newval, search) {
    var regex = new RegExp("([?;&])" + param + "[^&;]*[;&]?");
    var query = search.replace(regex, "$1").replace(/&$/, '');

    return (query.length > 2 ? query + "&" : "?") + (newval ? param + "=" + newval : '');
}

var toggle = false;
function editAddress() {
    var state = document.getElementById('state');
    document.getElementById('city').readOnly = toggle;
    document.getElementById('town').readOnly = toggle;

    if (toggle)
        state.classList.add('disabled');
    else
        state.classList.remove('disabled');


    toggle = !toggle;
}


// LSJ2706191243

jQuery(function ($) {
    function rfcValido(rfc, aceptarGenerico = true) {
        const re = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
        var validado = rfc.match(re);

        if (!validado)  //Coincide con el formato general del regex?
            return false;

        //Separar el dígito verificador del resto del RFC
        const digitoVerificador = validado.pop(),
                rfcSinDigito = validado.slice(1).join(''),
                len = rfcSinDigito.length,
                //Obtener el digito esperado
                diccionario = "0123456789ABCDEFGHIJKLMN&OPQRSTUVWXYZ Ñ",
                indice = len + 1;
        var suma,
                digitoEsperado;

        if (len == 12)
            suma = 0
        else
            suma = 481; //Ajuste para persona moral

        for (var i = 0; i < len; i++)
            suma += diccionario.indexOf(rfcSinDigito.charAt(i)) * (indice - i);
        digitoEsperado = 11 - suma % 11;
        if (digitoEsperado == 11)
            digitoEsperado = 0;
        else if (digitoEsperado == 10)
            digitoEsperado = "A";

        //El dígito verificador coincide con el esperado?
        // o es un RFC Genérico (ventas a público general)?
        if ((digitoVerificador != digitoEsperado)
                && (!aceptarGenerico || rfcSinDigito + digitoVerificador != "XAXX010101000"))
            return false;
        else if (!aceptarGenerico && rfcSinDigito + digitoVerificador == "XEXX010101000")
            return false;
        return rfcSinDigito + digitoVerificador;
    }

    function matchRfcAndBirthday() {
        var rfcNode = jQuery('#field-rfc');
        var birthdayNode = jQuery('#field-birthday');
        var rfc = rfcNode.val();
        var birthday = birthdayNode.val();
        var rfcYear = rfc.substring(4, 6);
        var rfcMonth = rfc.substring(6, 8);
        var rfcDay = rfc.substring(8, 10);
        var bDay = birthday.substring(0, 2);
        var bMonth = birthday.substring(3, 5);
        var bYear = birthday.substring(8, 10);
        console.log(rfcYear);
        console.log(bYear);
        console.log(rfcMonth);
        console.log(bMonth);
        console.log(rfcDay);
        console.log(bDay);
        return (rfcYear === bYear) && (rfcMonth === bMonth) && (rfcDay === bDay);
    }

    var fields = {       
        "street": {
            "node": jQuery('#street'),
            "status": true,
            "validation": function () {
                var node = jQuery('#street');
                node.removeClass("invalid");
                $("#street_err").remove();
                var validation = new RegExp(/^[A-z 0-9 ÁÉÍÓÚáéíóúÑñ]+$/);
                if (node.val().length < 10) {
                    $('<span id="street_err" class="invalidField">' + Joomla.JText._('COM_CHECKOUT_FIELD_ERROR_STREET') + '</span>').insertAfter('#street');
                    node.addClass("invalid");
                    fields["street"]['status'] = false;
                    return;
                } else if (!validation.test(node.val())) {
                    $('<span id="street_err" class="invalidField">' + Joomla.JText._('COM_CHECKOUT_FIELD_ERROR_STREET') + '</span>').insertAfter('#street');
                    node.addClass("invalid");
                    fields["street"]['status'] = false;
                    return;
                }
                 $("#street_err").remove();
                fields["street"]['status'] = true;
            }
        },
        "num_ext": {
            "node": jQuery('#num_ext'),
            "status": true,
            "validation": function () {
                var node = jQuery('#num_ext');
                node.removeClass("invalid");
                jQuery('[data-admin-user-form-error="num_ext"]').text("");
                var validation = new RegExp(/^[A-z 0-9 // ÁÉÍÓÚáéíóúÑñ]+$/);
                if (node.val().length < 1) {
                     $('<span id="num_ext_err" class="invalidField">' + Joomla.JText._('COM_CHECKOUT_FIELD_ERROR_STREET') + '</span>').insertAfter('#num_ext');
                    
                    node.addClass("invalid");
                    fields["num_ext"]['status'] = false;
                    return;
                } else if (!validation.test(node.val())) {
                    $('<span id="num_ext_err" class="invalidField">' + Joomla.JText._('COM_CHECKOUT_FIELD_ERROR_STREET') + '</span>').insertAfter('#num_ext');
                    
                    node.addClass("invalid");
                    fields["num_ext"]['status'] = false;
                    return;
                }
                 $("#num_ext_err").remove();
                fields["num_ext"]['status'] = true;
            }
        },
        "num_int": {
            "node": jQuery('#num_int'),
            "status": true,
            "validation": function () {
                return true;
            }
        },
        "reference": {
            "node": jQuery('#reference'),
            "status": true,
            "validation": function () {
                var node = jQuery('#reference');
                node.removeClass("invalid");
                jQuery('[data-admin-user-form-error="reference"]').text("");
                var validation = new RegExp(/^[A-z ÁÉÍÓÚáéíóúÑñ]+$/);
                if (node.val().length < 10) {
                    jQuery('[data-admin-user-form-error="reference"]').text(Joomla.JText._("COM_CHECKOUT_FIELD_EMPTY"));
                    node.addClass("invalid");
                    fields["reference"]['status'] = false;
                    return;
                } else if (!validation.test(node.val())) {
                    jQuery('[data-admin-user-form-error="reference"]').text(Joomla.JText._("COM_CHECKOUT_FIELD_INCORRECT"));
                    node.addClass("invalid");
                    fields["reference"]['status'] = false;
                    return;
                }

                fields["reference"]['status'] = true;
            }
        },
        "zip_code": {
            "node": jQuery('#zip_code'),
            "status": true,
            "validation": function () {
                var node = jQuery('#zip_code');
                var validation = new RegExp(/^(\d{5})+$/);
                node.removeClass("invalid");
                jQuery('[data-admin-user-form-error="zip_code"]').text("");
                if (node.val().length !== 5) {
                    jQuery('[data-admin-user-form-error="zip_code"]').text(Joomla.JText._("COM_CHECKOUT_FIELD_EMPTY"));
                    node.addClass("invalid");
                    fields["zip_code"]['status'] = false;
                    return;
                } else if (!validation.test(node.val())) {
                    jQuery('[data-admin-user-form-error="zipCode"]').text(Joomla.JText._("COM_CHECKOUT_FIELD_INCORRECT"));
                    node.addClass("invalid");
                    fields["zip_code"]['status'] = false;
                    return;
                }

                fields["zip_code"]['status'] = true;
            }
        },
        "location": {
            "node": jQuery('#location'),
            "status": true,
            "validation": function () {
                var node = jQuery('#location');
                var validation = new RegExp(/^[A-z ÁÉÍÓÚáéíóúÑñ]+$/);
                node.removeClass("invalid");
                jQuery('[data-admin-user-form-error="location"]').text("");
                if (node.val().length <= 3) {
                    jQuery('[data-admin-user-form-error="location"]').text(Joomla.JText._("COM_CHECKOUT_FIELD_EMPTY"));
                    node.addClass("invalid");
                    fields["location"]['status'] = false;
                    return;
                } else if (!validation.test(node.val())) {
                    jQuery('[data-admin-user-form-error="location"]').text(Joomla.JText._("COM_CHECKOUT_FIELD_INCORRECT"));
                    node.addClass("invalid");
                    fields["location"]['status'] = false;
                    return;
                }

                fields["location"]['status'] = true;
            }
        },
        "city": {
            "node": jQuery('#city'),
            "status": true,
            "validation": function () {
                return true;
            }
        },
        "town": {
            "node": jQuery('#town'),
            "status": true,
            "validation": function () {
                var node = jQuery('#town');
                var validation = new RegExp(/^[A-z ÁÉÍÓÚáéíóúÑñ]+$/);
                node.removeClass("invalid");
                jQuery('[data-admin-user-form-error="town"]').text("");
                if (node.val().length <= 1) {
                    jQuery('[data-admin-user-form-error="town"]').text(Joomla.JText._("COM_CHECKOUT_FIELD_EMPTY"));
                    node.addClass("invalid");
                    fields["town"]['status'] = false;
                    return;
                } else if (!validation.test(node.val())) {
                    jQuery('[data-admin-user-form-error="town"]').text(Joomla.JText._("COM_CHECKOUT_FIELD_INCORRECT"));
                    node.addClass("invalid");
                    fields["town"]['status'] = false;
                    return;
                }

                fields["town"]['status'] = true;
            }
        },
        "state": {
            "node": jQuery('#state'),
            "status": true,
            "validation": function () {
                var node = jQuery('#state');
                var validation = new RegExp(/^[A-z ÁÉÍÓÚáéíóúÑñ]+$/);
                node.removeClass("invalid");
                if (node.children("option:selected").val() == '' || !validation.test(node.children("option:selected").val())) {
                    jQuery('[data-admin-user-form-error="state"]').text(Joomla.JText._("COM_CHECKOUT_FIELD_EMPTY"));
                    fields["state"]['status'] = false;
                    node.addClass("invalid");
                    return;
                }

                fields["state"]['status'] = true;
            }
        },
        "between_street1":{
            "node": jQuery('#between_street1'),
            "status": true,
          
            "validation": function () {
                var node = jQuery('#between_street1');
                node.removeClass("invalid");
                jQuery('[data-admin-user-form-error="between_street1"]').text("");
                if (node.val().trim().length <= 10) {
                    jQuery('[data-admin-user-form-error="between_street1"]').text(Joomla.JText._("COM_CHECKOUT_FIELD_EMPTY"));
                    node.addClass("invalid");
                    fields["between_street1"]['status'] = false;
                    return;
                }  
                fields["between_street1"]['status'] = true;
            }
           },
            "between_street2":{
            "node": jQuery('#between_street2'),
            "status": true,
          
            "validation": function () {
                var node = jQuery('#between_street2');
                node.removeClass("invalid");
                jQuery('[data-admin-user-form-error="between_street2"]').text("");
                if (node.val().trim().length < 10) {
                    jQuery('[data-admin-user-form-error="between_street2"]').text(Joomla.JText._("COM_CHECKOUT_FIELD_EMPTY"));
                    node.addClass("invalid");
                    fields["between_street2"]['status'] = false;
                    return;
                } 
                fields["between_street2"]['status'] = true;
            }
           },

        "cellphone": {
            "node": jQuery('#cellphone'),
            "status": true,
            "validation": function () {

                var node = jQuery('#cellphone');
                var validation = new RegExp(/^\d*$/);
                node.removeClass("invalid");
                jQuery('[data-admin-user-form-error="cellphone"]').text("");
                if (node.val().length === 0)
                {
                    jQuery('[data-admin-user-form-error="cellphone"]').text(Joomla.JText._("COM_CHECKOUT_FIELD_EMPTY"));
                    fields["cellphone"]['status'] = false;
                    node.addClass("invalid");
                    return;
                } else if (!validation.test(node.val()))
                {
                    jQuery('[data-admin-user-form-error="cellphone"]').text(Joomla.JText._("COM_CHECKOUT_FIELD_INCORRECT"));
                    fields["cellphone"]['status'] = false;
                    node.addClass("invalid");
                    return;
                } else if (node.val().length !== 10)
                {
                    jQuery('[data-admin-user-form-error="cellphone"]').text(Joomla.JText._("COM_CHECKOUT_FIELD_INCORRECT_CELLPHONE"));
                    fields["cellphone"]['status'] = false;
                    node.addClass("invalid");
                    return;
                }

                fields["cellphone"]['status'] = true;
            }
        },

        "phone": {
            "node": jQuery('#phone'),
            "status": true,
            "validation": function () {

                var node = jQuery('#phone');
                var validation = new RegExp(/^\d*$/);
                node.removeClass("invalid");
                jQuery('[data-admin-user-form-error="phone"]').text("");
                if (node.val().length === 0)
                {
                    jQuery('[data-admin-user-form-error="phone"]').text(Joomla.JText._("COM_CHECKOUT_FIELD_EMPTY"));
                    fields["phone"]['status'] = false;
                    node.addClass("invalid");
                    return;
                } else if (!validation.test(node.val()))
                {
                    jQuery('[data-admin-user-form-error="phone"]').text(Joomla.JText._("COM_CHECKOUT_FIELD_INCORRECT"));
                    fields["phone"]['status'] = false;
                    node.addClass("invalid");
                    return;
                } else if (node.val().length !== 10)
                {
                    jQuery('[data-admin-user-form-error="phone"]').text(Joomla.JText._("COM_CHECKOUT_FIELD_INCORRECT_CELLPHONE"));
                    fields["phone"]['status'] = false;
                    node.addClass("invalid");
                    return;
                }

                fields["phone"]['status'] = true;
            }
        },
  

    };
    jQuery("#cellphone").attr('minlength', '10');
    jQuery("#cellphone").attr('maxlength', '10');
    jQuery("#phone").attr('minlength', '10');
    jQuery("#phone").attr('maxlength', '10');
    jQuery("#zip_code").attr('minlength', '5');
    jQuery("#zip_code").attr('maxlength', '5');
    jQuery("#field-rfc").attr('minlength', '13');
    jQuery("#field-rfc").attr('maxlength', '13');
    
    jQuery('#cellphone','#phone').keydown(function (event) {
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
    jQuery('#zip_code').keydown(function (event) {
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
    jQuery("#adminForm-user input, #adminForm-user select, #adminForm-user textarea").focusout(function () {
        var field = jQuery(this).attr('name');
        if (field)
            fields[field]['validation']();
    });
    jQuery("#adminForm-user input, #adminForm-user select, #adminForm-user textarea").keyup(function () {
        var field = jQuery(this).attr('name');
        if (field)
            fields[field]['validation']();
    });
    jQuery(document).on('submit', "#adminForm-user", function () {
        var allow = true;
        jQuery('[data-admin-user-form-error]').text('');
        Object.keys(fields).forEach(function (field, index) {
            fields[field]['validation']();
            allow = fields[field]['status'] && allow;
        });
        if (!allow) {
            Swal.fire({
              title: 'Datos incorrectos',
              text: "Favor de verificar sus datos",
              type: 'error',
              allowOutsideClick:false,
              confirmButtonColor: '#3085d6', 
              confirmButtonText: 'Aceptar'
            }).then((result) => {
              if (result.value) {
            
              }
            })
            return false;
        }

    });
});