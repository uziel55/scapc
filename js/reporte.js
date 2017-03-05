$(document).ready(function() {
    cargaReportes(4);

    $('#pendientes').click(function() {
        cargaReportes(1);
    });

});

function cargaReportes(folio) {
    $("#inicio").empty();
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "http://localhost/proyecto/php/obtenerReporte.php",
        data: 'folio=' + folio,
        success: function(data) {
            $(data).each(function(indice, registro) {
                $('#folio').hide().append(registro.folio).fadeIn(300);
                $('#solicitante').hide().append(registro.nombre).fadeIn(300);
                $('#solicitud').append(registro.fechaSolicitud);
                $('#respuesta').append(registro.fechaRespuesta);
                $('#conclusion').append(registro.fechaConclusion);
                $('#comite').append(registro.comite);
                $('#telefono').append(registro.telefono);
                $("#inicio").hide().append("<tr><td>" + registro.folio + "</td><td>" + registro.nombre + "</td><td>" + registro.especificaciones +
                    "</td><td>" + registro.fechaSolicitud + "</td><td>" + registro.comite + "</td></tr>").fadeIn(200);
            });
            //Forzar evento onChange del cmbFacultades

        }
    });
}
