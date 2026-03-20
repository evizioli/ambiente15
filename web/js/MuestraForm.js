
$(document).ready(function(){
    $('#muestra_lugar_de_extraccion_id').on('change',function(e){
        $.ajax({
            url: urlLugarExtraccionAjax,
            data: { id: $(this).val() },
        }).done( function( data ) { 
            $('#muestra_tipo_id').val(data.res.TipoId);
        }).error( function(){
        });
    });
});