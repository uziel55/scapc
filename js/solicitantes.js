$(document).ready(function() {

    cargaTablaSolicitante();
    // Activa los modals

    $('#mdBusqueda').modal({ //Modal de busqueda
        dismissible: false
    });
    $('#mdRegistro').modal({ //Modal de registro
        dismissible: false
    });
    $('#mdInformacion').modal({ //Moda de informacion, edicion y eliminacion
        dismissible: false
    });

    // Modal Registra Solicitante ---------------------------------------

    //Limpia campos al presionar "Cancelar" en el formulario de registro
    $("#btnCRegistraSolicitante").click(function() {
        $('#frmRegistraSolicitante').each(function() {
            this.reset();
        });
    });

    //Agrega solicitantes al presionar "Registrar" en el formulario de registro
    $("#btnRegistraSolicitante").click(function() {
        var vacio = false;

        if($("#txtCurp").val() === ""){
          vacio = true;
        }
        if($("#txtNombre").val() === ""){
          vacio = true;
        }
        if($("#txtApellidoPaterno").val() === ""){
          vacio = true;
        }
        if($("#txtApellidoMaterno").val() === ""){
          vacio = true;
        }
        if($("#txtClaveElector").val() === ""){
          vacio = true;
        }

        if (vacio === true) {
          $('.toast').remove(); //Evita que el mensaje se muestre dos veces
          Materialize.toast(data.message, 3000, 'red');
        }else{
          registraSolicitante();
        }

        vacio = false;
        $('#frmRegistraSolicitante').modal('close');

    });

    // Modal Busca Solicitante ---------------------------------------

    //Busca al solicitante dependiendo del criterio
    $("#btnBuscaSolicitante").click(function() {
        var vacio = false;

        
        cargaTablaSolicitanteResultado(); //Muestra los resultados en la tabla

        $('#frmBuscaSolicitante').each(function() { //Limpia el formulario de busqueda
            this.reset();
        });
    });

    //Cierra el formulario de busqueda si se presiona "Cancelar"
    $("#btnCBuscaSolicitante").click(function() {
        $('#frmBuscaSolicitante').each(function() { //Limpia el formulario de busqueda
            this.reset();
        });
    });

    // Modal Edita Solicitante ---------------------------------------

    //Activa la posibilidad de editar los datos del solicitante
    $("#btnEditaSolicitante").click(function() {
        //Activa los Input para editarlos
        $("#frmEditaSolicitante :input").prop('disabled', false);
        $("#frmEditaSolicitante #txtEditaCurp").prop('disabled', true); //Desactiva el campo CURP, no es editable esta informacion
        $("#btnGuardaEditaSolicitante").prop('disabled', false);
    });

    $("#btnGuardaEditaSolicitante").click(function() { //Al cguardar y cerrar el modal
        $("#frmEditaSolicitante #txtEditaCurp").prop('disabled', false);
        var dataString = $("#frmEditaSolicitante").serialize(); //Asigna el valor de los campos a una variable
        $("#frmEditaSolicitante #txtEditaCurp").prop('disabled', true);

        $.ajax({
            type: "POST",
            url: "http://localhost/proyecto/php/controladorSolicitante.php",
            data: "opcion=3&" + dataString,
            success: function(data) {
                data = JSON.parse(data); //Convierte la respuesta en un objeto JSON
                if (data.success) {
                    $('.toast').remove(); //Evita que el mensaje se muestre dos veces
                    Materialize.toast(data.message, 3000);
                    cargaTablaSolicitante(); //Recarga la tabla para mostrar cambios
                } else {
                    $('.toast').remove(); //Evita que el mensaje se muestre dos veces
                    Materialize.toast(data.message, 3000);
                }
            },
            error: function(data) {
                $('.toast').remove(); //Evita que el mensaje se muestre dos veces
                Materialize.toast("Error general.", 3000);
            }
        });

        $('#frmEditaSolicitante').each(function() {
            this.reset();
        });
        //Desactiva los Input
        $("#frmEditaSolicitante :input").prop('disabled', true);
    });
    $("#btnCInfoSolicitante").click(function() {
        $('#frmEditaSolicitante').each(function() {
            this.reset();
        });
        //Desactiva los Input
        $("#frmEditaSolicitante :input").prop('disabled', true);
    });
});


function cargaTablaSolicitante() {
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "http://localhost/proyecto/php/controladorSolicitante.php",
        data: 'opcion=5',
        success: function(data) { //Carga la tabla
            data = JSON.parse(data);
            var rowTemplate = '<tr>' +
                '<td><%this.CURP%> </td>' +
                '<td><%this.nombre%> </td>' +
                '<td><%this.claveElector%> </td>' +
                '</tr>';
            $('#cTbSolicitantes').renderTable({
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
            Materialize.toast("Error general.", 3000);
        }
    });
}

//Carga la tabla de solicitantes con el resultado de busqueda
function cargaTablaSolicitanteResultado() {
    var dataString = $("#frmBuscaSolicitante").serialize();
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "http://localhost/proyecto/php/controladorSolicitante.php",
        data: 'opcion=6&' + dataString,
        success: function(data) { //Carga la tabla
            data = JSON.parse(data);
            var rowTemplate = '<tr>' +
                '<td><%this.CURP%> </td>' +
                '<td><%this.nombre%> </td>' +
                '<td><%this.claveElector%> </td>' +
                '</tr>';
            $('#cTbSolicitantes').renderTable({
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
            Materialize.toast("Error general.", 3000);
        }
    });
}

function registraSolicitante() {
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "http://localhost/proyecto/php/controladorSolicitante.php",
        data: "opcion=1&" + $("#frmRegistraSolicitante").serialize(),
        success: function(data) {
            if (data.success) {
                $('.toast').remove(); //Evita que el mensaje se muestre dos veces
                Materialize.toast(data.message, 3000);
                cargaTablaSolicitante();
            } else {
                $('.toast').remove(); //Evita que el mensaje se muestre dos veces
                Materialize.toast(data.message, 3000);
            }
        },
        error: function(data) {
            $('.toast').remove(); //Evita que el mensaje se muestre dos veces
            Materialize.toast('Error general.', 4000); //Muestra mensaje en pantalla
        }
    });
}

//Esta funcion activa el click en cada registro de la tabla
function activaSeleccion() {
    $('table tbody tr').click(function() {
        var txtCurp = $(this).closest("tr").find('td:eq(0)').text(); //Se obtiene la CURP del registro seleccionado
        var dataString = 'txtCurp=' + txtCurp;
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "php/controladorSolicitante.php",
            data: "opcion=4&" + dataString,
            success: function(datos) { //Los datos devueltos se asignan a los Input
                $('#txtEditaCurp').val(datos[0].CURP);
                $('#txtEditaNombre').val(datos[0].nombre);
                $('#txtEditaApellidoP').val(datos[0].apellidoPaterno);
                $('#txtEditaApellidoM').val(datos[0].apellidoMaterno);
                $('#txtEditaClaveElector').val(datos[0].claveElector);
                $('#mdInformacion').modal('open'); //Se abre el Modal de informacion
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
