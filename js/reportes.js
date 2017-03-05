$(document).ready(function() {

    cargaTablaReporte();
    cargaSolicitante();
    cargaArea();
    $("#cbbArea").on("change", function() {
        cargaServicio();
    });
    $("#txtFecha").val(Date());


    $('#mdBusqueda').modal({ //Modal de busqueda
        dismissible: false
    });
    $('#mdRegistro').modal({ //Modal de registro
        dismissible: false
    });
    $('#mdInformacion').modal({ //Moda de informacion, edicion y eliminacion
        dismissible: false
    });

});
function registraReporte(){
  $.ajax({
      type: "POST",
      dataType: 'json',
      url: "http://localhost/proyecto/php/controladorReporte.php",
      data: 'opcion=1&'+$("#frmRegistraReporte").serialize(),
      success: function(data) { //Carga la tabla
          data = JSON.parse(data);
          if(data.success){
            $('.toast').remove(); //Evita que el mensaje se muestre dos veces
            Materialize.toast(data.message, 3000);
          }else{
            $('.toast').remove(); //Evita que el mensaje se muestre dos veces
            Materialize.toast(data.message, 3000);
          }
      },
      error: function(data) {
          $('.toast').remove(); //Evita que el mensaje se muestre dos veces
          Materialize.toast("Error general." + data, 3000);
      }
  });
}

function cargaTablaReporte() {
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "http://localhost/proyecto/php/controladorReporte.php",
        data: 'opcion=5',
        success: function(data) { //Carga la tabla
            data = JSON.parse(data);
            var rowTemplate = '<tr>' +
                '<td><%this.folio%> </td>' +
                '<td><%this.fechaSolicitud%> </td>' +
                '<td><%this.detalles%> </td>' +
                '<td><%this.nombre%> </td>' +
                '<td><%this.servicio%> </td>' +
                '</tr>';
            $('#cTbReportes').renderTable({
                template: rowTemplate,
                data: data,
                pagination: {
                    rowPageCount: 10
                },
            });
            activaSeleccion(); //Activa la seleccion de registros en la tabla
        },
        error: function(data) {
            $('.toast').remove(); //Evita que el mensaje se muestre dos veces
            Materialize.toast("Error general." + data, 3000);
        }
    });
}



function cargaSolicitante() {
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "http://localhost/proyecto/php/controladorSolicitante.php",
        data: 'opcion=5',
        success: function(data) { //Carga la tabla
            data = JSON.parse(data);
            $(data).each(function(index, el) {
                $("#txtSolicitante").append('<option value="' + el.curp + '"">' + el.nombre + '</option>');
            });
        },
        error: function(data) {
            $('.toast').remove(); //Evita que el mensaje se muestre dos veces
            Materialize.toast("Error general.", 3000);
        }
    });
}

function cargaArea() {
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "http://localhost/proyecto/php/controladorArea.php",
        data: 'opcion=5',
        success: function(data) { //Carga la tabla
            data = JSON.parse(data);
            $(data).each(function(index, el) {
                $("#cbbArea").append('<option value="' + el.idArea + '"">' + el.nombre + '</option>');
            });
            $("cbbArea").change();
        },
        error: function(data) {
            $('.toast').remove(); //Evita que el mensaje se muestre dos veces
            Materialize.toast("Error general.", 3000);
        }
    });
}

function cargaServicio() {
    $('#cbbServicio').empty();
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "http://localhost/proyecto/php/controladorServicio.php",
        data: 'opcion=5&cbbArea=' + $("#cbbArea").val(),
        success: function(data) { //Carga los servicios correctamente
            $(data).each(function(index, el) {
                $("#cbbServicio").append('<option value="' + el.idServicio + '"">' + el.nombre + '</option>');
            });
        },
        error: function(data) {
            $('.toast').remove(); //Evita que el mensaje se muestre dos veces
            Materialize.toast("Error general." + data, 3000);
        }
    });
}


//Esta funcion activa el click en cada registro de la tabla
function activaSeleccion() {
    $('table tbody tr').click(function() {
        var txtCurp = $(this).closest("tr").find('td:eq(0)').text(); //Se obtiene la CURP del registro seleccionado
        var dataString = 'txtCurp=' + txtCurp;
        alert(txtCurp);
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "php/controladorSolicitante.php",
            data: "opcion=4&" + dataString,
            success: function(datos) { //Los datos devueltos se asignan a los Input
                // $('#txtEditaCurp').val(datos[0].CURP);
                // $('#txtEditaNombre').val(datos[0].nombre);
                // $('#txtEditaApellidoP').val(datos[0].apellidoPaterno);
                // $('#txtEditaApellidoM').val(datos[0].apellidoMaterno);
                // $('#txtEditaClaveElector').val(datos[0].claveElector);
                // $('#mdInformacion').modal('open'); //Se abre el Modal de informacion
            },
            error: function(datos) {
                $('.toast').remove(); //Evita que el mensaje se muestre dos veces
                Materialize.toast('Error general.', 4000); //Muestra mensaje en pantalla
            }
        });

        $("#btnEliminaSolicitante").click(function() { //Al hacer click en el boton Eliminar del modal
            $.ajax({
                type: "POST",
                url: "php/controladorSolicitante.php",
                data: "opcion=2&" + dataString,
                success: function(datos) {
                    var respuesta = JSON.parse(datos);
                    if (respuesta.success) { //Se se devuelve un mensaje de exito / Se borra el registro
                        $('.toast').remove(); //Evita que el mensaje se muestre dos veces
                        Materialize.toast(respuesta.message, 2000);

                        cargaTablaSolicitante(); //Se recarga la tabla para limpiarla
                    } else {
                        $('.toast').remove(); //Evita que el mensaje se muestre dos veces
                        Materialize.toast(respuesta.message, 4000);
                    }
                },
                error: function(datos) {
                    $('.toast').remove(); //Evita que el mensaje se muestre dos veces
                    Materialize.toast('Error general.', 4000); //Muestra mensaje en pantalla
                }
            });

        });
    });
}
