    function showDetail(){

        if ( $("#demo").css("display") == "block" ) {
            $("#btnDetail").text(Joomla.JText._('MOD_ACCOUNT_BTN_DETAILS'));

        }else{
            $("#btnDetail").text(Joomla.JText._('MOD_ACCOUNT_DETAIL_FRONT_PUNTOSCANJEHIDE'));

        }

        $('#demo').toggle("slow");


    }

function showTable(object) {
	$(object.dataset.target).toggle( "slow", function(element) {
  		var active=$(object).children().first().hasClass('fa-plus');
  		if (active) {
		$(object).children().first().removeClass('fa-plus');
  		$(object).children().first().addClass('fa-minus');
  	
  		}else{
  		$(object).children().first().removeClass('fa-minus');
  		$(object).children().first().addClass('fa-plus');
  	
  		}

  });
}

