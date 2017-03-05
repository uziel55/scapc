$(document).ready(function() {
    $(".xbutton-collapse").sideNav({
        menuWidth: 270
    });
    // cuentaReportes(1, 'pendiente');
    // cuentaReportes(2, 'aprobado');
    // cuentaReportes(3, 'ejecutado');
    // cuentaReportes(4, 'concluido');
    //cargaReportes(1);


    $('#pendientes').click(function() {
        cargaReportesNew(1);
    });
    $('#aprobados').click(function() {
        cargaReportesNew(2);
    });
    $('#ejecucion').click(function() {
        cargaReportesNew(3);
    });
    $('#concluidos').click(function() {
        cargaReportesNew(4);
    });

});


function cuentaReportes(estatus, id) {
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "http://localhost/proyecto/php/cuentaReportes.php",
        data: 'estatus=' + estatus,
        success: function(data) {
            $(data).each(function(indice, registro) {
                $('#' + id).append(registro.oficios);
            });
        }
    });
}

// function cargaReportes(estatus) {
//     $("#inicio").empty();
//     var resultado;
//     $.ajax({
//         type: "POST",
//         dataType: 'json',
//         url: "http://localhost/proyecto/php/obtenerReportes.php",
//         data: 'estatus=' + estatus,
//         success: function(data) {
//             $(data).each(function(indice, registro) {
//                 //resultado += "<tr><td>" + registro.folio + "</td><td>" + registro.nombre + "</td><td>" + registro.especificaciones +
//                     //"</td><td>" + registro.fechaSolicitud + "</td><td>" + registro.comite + "</td><td><a href='#modal1'>" + registro.folio + "</a></td></tr>";
//                 $("#inicio").hide().append("<tr class='display: table-row;'><td>" + registro.folio + "</td><td>" + registro.nombre + "</td><td>" + registro.especificaciones +
//                 "</td><td>" + registro.fechaSolicitud + "</td><td>" + registro.comite + "</td><td><a href='#modal1'>" + registro.folio + "</a></td></tr>").fadeIn(200);
//                 //$.parseHTML(resultado);
//                 //$('#inicio').html(resultado);
//
//             });
//         }
//     });
// }
