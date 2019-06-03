function activarUsuario(idUsuario,status) {
    var key = $("#token").attr("name");
    disbleSubmit();
    var url='index.php?option=com_perfil&task=funcionesAjax.activateUser&format=raw';
    var button= $("#btnUsuario-"+idUsuario);
    var id=button[0].dataset.id;
    var status=button[0].dataset.status;
    $.ajax({
        type:"POST",
        url: url,
        data:{id:id,status:status,token:key},
    }).done(function(data) {

        if(status==0){
            button[0].dataset.status=1;
            button.removeClass('btn-success');
            button.addClass('btn-danger');
            $("#complete-data-"+idUsuario).text("Si");
            $("#complete-data-"+idUsuario).removeClass('badge-danger');
            $("#complete-data-"+idUsuario).addClass('badge-success');
        }else{
            $("#complete-data-"+idUsuario).text("No");
            $("#complete-data-"+idUsuario).addClass('badge-danger');
            $("#complete-data-"+idUsuario).removeClass('badge-success');
            button.removeClass('btn-danger');
            button.addClass('btn-success');
            button[0].dataset.status=0;
        }
    }).fail(function() {
        console.log("error");
    });

}


function disbleSubmit(){
    $( "#adminForm").submit(function( event ) {
        event.preventDefault();
    });
}



