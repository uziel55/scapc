$(document).ready(function() {

    cargaTablaUsuario();
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

    // Modal Registra Usuario ---------------------------------------

    //Limpia campos al presionar "Cancelar" en el formulario de registro
    $("#btnCRegistraUsuario").click(function() {
        $('#frmRegistraUsuario').each(function() {
            this.reset();
        });
    });

    //Agrega Usuarios al presionar "Registrar" en el formulario de registro
    $("#btnRegistraUsuario").click(function() {
        var vacio = false;

        if($("#txtIdUsuario").val() === ""){
          vacio = true;
        }
        if($("#txtNombre").val() === ""){
          vacio = true;
        }
        if($("#txtUsuario").val() === ""){
          vacio = true;
        }
        if($("#txtContrasena").val() === ""){
          vacio = true;
        }

        if (vacio === true) {
          $('.toast').remove(); //Evita que el mensaje se muestre dos veces
          Materialize.toast(data.message, 3000, 'red');
        }else{
          registraUsuario();
        }
        vacio = false;

    });

    // Modal Busca Usuario ---------------------------------------

    //Busca al Usuario dependiendo del criterio
    $("#btnBuscaUsuario").click(function() {
        cargaTablaUsuarioResultado(); //Muestra los resultados en la tabla

        $('#frmBuscaUsuario').each(function() { //Limpia el formulario de busqueda
            this.reset();
        });
    });

    //Cierra el formulario de busqueda si se presiona "Cancelar"
    $("#btnCBuscaUsuario").click(function() {
        $('#frmBuscaUsuario').each(function() { //Limpia el formulario de busqueda
            this.reset();
        });
    });

    // Modal Edita Usuario ---------------------------------------

    //Activa la posibilidad de editar los datos del Usuario
    $("#btnEditaUsuario").click(function() {
        //Activa los Input para editarlos
        $("#frmEditaUsuario :input").prop('disabled', false);
        $("#frmEditaUsuario #txtEditaIdUsuario").prop('disabled', true); //Desactiva el campo CURP, no es editable esta informacion
        $("#btnGuardaEditaUsuario").prop('disabled', false);
    });

    $("#btnGuardaEditaUsuario").click(function() { //Al cguardar y cerrar el modal
        $("#frmEditaUsuario #txtEditaIdUsuario").prop('disabled', false);
        var dataString = $("#frmEditaUsuario").serialize(); //Asigna el valor de los campos a una variable
        $("#frmEditaUsuario #txtEditaIdUsuario").prop('disabled', true);

        $.ajax({
            type: "POST",
            url: "php/controladorUsuario.php",
            data: "opcion=3&" + dataString,
            success: function(data) {
                data = JSON.parse(data); //Convierte la respuesta en un objeto JSON
                if (data.success) {
                    $('.toast').remove(); //Evita que el mensaje se muestre dos veces
                    Materialize.toast(data.message, 3000);
                    cargaTablaUsuario(); //Recarga la tabla para mostrar cambios
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

        $('#frmEditaUsuario').each(function() {
            this.reset();
        });
        //Desactiva los Input
        $("#frmEditaUsuario :input").prop('disabled', true);
    });
    $("#btnCInfoUsuario").click(function() {
        $('#frmEditaUsuario').each(function() {
            this.reset();
        });
        //Desactiva los Input
        $("#frmEditaUsuario :input").prop('disabled', true);
    });
});


function cargaTablaUsuario() {
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "php/controladorUsuario.php",
        data: 'opcion=5',
        success: function(data) { //Carga la tabla
            data = JSON.parse(data);
            var rowTemplate = '<tr>' +
                '<td><%this.idUsuario%> </td>' +
                '<td><%this.nombre%> </td>' +
                '<td><%this.usuario%> </td>' +
                '</tr>';
            $('#cTbUsuarios').renderTable({
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

//Carga la tabla de Usuarios con el resultado de busqueda
function cargaTablaUsuarioResultado() {
    var dataString = $("#frmBuscaUsuario").serialize();
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "php/controladorUsuario.php",
        data: 'opcion=6&' + dataString,
        success: function(data) { //Carga la tabla
            data = JSON.parse(data);
            var rowTemplate = '<tr>' +
                '<td><%this.idUsuario%> </td>' +
                '<td><%this.nombre%> </td>' +
                '<td><%this.usuario%> </td>' +
                '</tr>';
            $('#cTbUsuarios').renderTable({
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

function registraUsuario() {
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "php/controladorUsuario.php",
        data: "opcion=1&" + $("#frmRegistraUsuario").serialize(),
        success: function(data) {
            if (data.success) {
                $('.toast').remove(); //Evita que el mensaje se muestre dos veces
                Materialize.toast(data.message, 3000);
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
        var txtIdUsuario = $(this).closest("tr").find('td:eq(0)').text(); //Se obtiene la CURP del registro seleccionado
        var dataString = 'txtIdUsuario=' + txtIdUsuario;
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "php/controladorUsuario.php",
            data: "opcion=4&" + dataString,
            success: function(datos) { //Los datos devueltos se asignan a los Input
                $('#txtEditaIdUsuario').val(datos[0].idUsuario);
                $('#txtEditaNombre').val(datos[0].nombre);
                $('#txtEditaUsuario').val(datos[0].usuario);
                $('#txtEditaContrasena').val(datos[0].contrasena);
                $('#cbTipo').val(datos[0].tipoUsuario);
                $('#mdInformacion').modal('open'); //Se abre el Modal de informacion
            },
            error: function(datos) {
                $('.toast').remove(); //Evita que el mensaje se muestre dos veces
                Materialize.toast('Error general.', 4000); //Muestra mensaje en pantalla
            }
        });

        $("#btnEliminaUsuario").click(function() { //Al hacer click en el boton Eliminar del modal
            $.ajax({
                type: "POST",
                url: "php/controladorUsuario.php",
                data: "opcion=2&" + dataString,
                success: function(datos) {
                    var respuesta = JSON.parse(datos);
                    if (respuesta.success) { //Se se devuelve un mensaje de exito / Se borra el registro
                        $('.toast').remove(); //Evita que el mensaje se muestre dos veces
                        Materialize.toast(respuesta.message, 2000);

                        cargaTablaUsuario(); //Se recarga la tabla para limpiarla
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
