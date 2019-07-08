function activarUsuario(idUsuario,status) {     
disbleSubmit();   
    var key = $("#token").attr("name");
    var button= $("#btnUsuario-"+idUsuario);
    var id=button[0].dataset.id;
    var status=button[0].dataset.status;
    if(status==0){
        status=1;
    }else{
        status=0;
    }
    
    var url='index.php?option=com_perfil&task=funciones.activateUser&format=raw';
    $.ajax({
        type:"POST",
        url: url,
        data:{id:id,status:status,token:key},
    }).done(function(data) {
        var r=jQuery.parseJSON(data);
    if(r.result==true){      
        if(status==1){
           
            $("#complete-data-"+idUsuario).text("Si");
            $("#complete-data-"+idUsuario).removeClass('badge-danger');
            $("#complete-data-"+idUsuario).addClass('badge-success');
             button[0].dataset.status=1;
        }else{
            $("#complete-data-"+idUsuario).text("No");
            $("#complete-data-"+idUsuario).addClass('badge-danger');
            $("#complete-data-"+idUsuario).removeClass('badge-success');
            button[0].dataset.status=0;
        }
        location.reload();
    }else{
            swal('Información', 'Es necesario que este usuario complete sus datos de perfil,\n', "warning");     
            $(".swal2-confirm").click(function() {
          location.reload();
          });
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


