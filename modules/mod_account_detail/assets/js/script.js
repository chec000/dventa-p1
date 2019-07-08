    function showDetail(){

        if ( $("#demo").css("display") == "block" ) {
            $("#btnDetail").text(Joomla.JText._('MOD_ACCOUNT_BTN_DETAILS'));

        }else{
            $("#btnDetail").text(Joomla.JText._('MOD_ACCOUNT_DETAIL_FRONT_PUNTOSCANJEHIDE'));

        }

        $('#demo').toggle("slow");


    }



