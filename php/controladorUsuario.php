<?php
    include 'claseUsuario.php';

    $Usuario = new claseUsuario();

    //Opción 1 - Alta Usuario
    if ($_POST['opcion'] == 1) {
        $Usuario->setIdUsuario(utf8_decode($_POST['txtIdUsuario']));
        $Usuario->setNombre(utf8_decode($_POST['txtNombre']));
        $Usuario->setUsuario(utf8_decode($_POST['txtUsuario']));
        $Usuario->setContrasena(utf8_decode($_POST['txtContrasena']));
        $Usuario->setTipoUsuario(utf8_decode($_POST['cbTipo']));

        $result = $Usuario->registraUsuario();
    }

    //Opción 2 - baja Usuario
    if ($_POST['opcion']==2) {
        $Usuario->setIdUsuario($_POST['txtIdUsuario']);
        $result = $Usuario->bajaUsuario();
    }


    //Opción 3 modifica Usuario
    if ($_POST['opcion']==3) {
        $Usuario->setIdUsuario(utf8_decode($_POST['txtEditaIdUsuario']));
        $Usuario->setNombre(utf8_decode($_POST['txtEditaNombre']));
        $Usuario->setUsuario(utf8_decode($_POST['txtEditaUsuario']));
        $Usuario->setContrasena(utf8_decode($_POST['txtEditaContrasena']));
        $Usuario->setTipoUsuario(utf8_decode($_POST['txtEditaTipo']));

        $result = $Usuario->actualizaUsuario();
    }

    //Opción 4 - consulta Usuario
    if ($_POST['opcion']==4) {
        $Usuario->setIdUsuario($_POST['txtIdUsuario']);
        $result = $Usuario->consultaUsuario();
    }

    //Opcion 5 - lista Usuarios
    if ($_POST['opcion']==5) {
        $result = $Usuario->listaUsuarios();
    }
    //Opcion 6 - busca Usuario
    if ($_POST['opcion']==6) {

        if ($_POST['cbCriterio'] == 1) {
            $Usuario->setNombre(utf8_decode($_POST['txtBusqueda']));
        }
        if ($_POST['cbCriterio'] == 2) {
            $Usuario->setIdUsuario(utf8_decode($_POST['txtBusqueda']));
        }
        if ($_POST['cbCriterio'] == 3) {
            $Usuario->setTipoUsuario(utf8_decode($_POST['txtBusqueda']));
        }

        $result = $Usuario->buscaUsuario($_POST['cbCriterio']);
    }

    echo json_encode($result);
