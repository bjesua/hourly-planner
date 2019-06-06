$( document ).ready(function() {
    $.ajax({
        //para ejecutar desde base de datos.
        url: "process/horario.php",
        //para ejecutar desde archivo .json
        // url: "json/file.json",
        type: "GET",
        dataType: "json",
        async: false,
        statusCode: {
            404: function () {
                alert("Página no encontrada");
            }
        },
        success: function (data) {
            var obj = data;
            var ht ='';
            ht += '<table class="table">';
            ht += '<thead class="thead-dark">';
            ht += '<tr>';
            for(key in obj){
                ht += '<th scope="col">'+obj[key]['horario']+'</th>';
            }
            ht += '</tr>';
            ht += '</thead>';
            ht += '<tbody>';
            ht += '<tr>';
            ht += '<div id="htmlPrint"></div>';
            for(akey in obj){
                if(obj[akey]['total_datos']>=3){
                    ht += '<td>';
                    ht += '<div class="text-center"><button type="button" class="text-center btn btn-info btn-sm">'+obj[akey]['total_datos']+'</button></div>';
                    ht += '<ul class="list-group list-group-flush">';
                    for(bkey in obj[akey]['datos']){
                        ht += '<li class="list-group-item">'+ obj[akey]['datos'][bkey].nombre +'</li>';
                    }
                    ht += '</ul>';
                    ht += '</td>';
                }else{
                    ht += '<td>';
                    ht += '<div class="alert alert-danger" role="alert">';
                    ht += 'Not avalible';
                    ht += '</div>';
                    ht += '</td>';
                }
            }
            ht += '</tr>';
            ht += '</tbody>';
            ht += '</table>';
            $('#id_tabla').html(ht);
        }
    });


});