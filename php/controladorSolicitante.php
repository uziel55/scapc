<?php
    include 'claseSolicitante.php';

    $solicitante = new claseSolicitante();

    //Opción 1 - Alta solicitante
    if ($_POST['opcion'] == 1) {
        $solicitante->setCurp(utf8_decode($_POST['txtCurp']));
        $solicitante->setNombre(utf8_decode($_POST['txtNombre']));
        $solicitante->setApellidoPaterno(utf8_decode($_POST['txtApellidoPaterno']));
        $solicitante->setApellidoMaterno(utf8_decode($_POST['txtApellidoMaterno']));
        $solicitante->setClaveElector(utf8_decode($_POST['txtClaveElector']));

        $result = $solicitante->registraSolicitante();
    }

    //Opción 2 - baja solicitante
    if ($_POST['opcion']==2) {
        $solicitante->setCurp($_POST['txtCurp']);
        $result = $solicitante->bajaSolicitante();
    }


    //Opción 3 modifica Solicitante
    if ($_POST['opcion']==3) {
        $solicitante->setCurp(utf8_decode($_POST['txtEditaCurp']));
        $solicitante->setNombre(utf8_decode($_POST['txtEditaNombre']));
        $solicitante->setApellidoPaterno(utf8_decode($_POST['txtEditaApellidoP']));
        $solicitante->setApellidoMaterno(utf8_decode($_POST['txtEditaApellidoM']));
        $solicitante->setClaveElector(utf8_decode($_POST['txtEditaClaveElector']));

        $result = $solicitante->actualizaSolicitante();
    }

    //Opción 4 - consulta solicitante
    if ($_POST['opcion']==4) {
        $solicitante->setCurp($_POST['txtCurp']);
        $result = $solicitante->consultaSolicitante();
    }

    //Opcion 5 - lista solicitantes
    if ($_POST['opcion']==5) {
        $result = $solicitante->listaSolicitantes();
    }
    //Opcion 6 - busca solicitante
    if ($_POST['opcion']==6) {
        if ($_POST['cbCriterio'] == 1) {
            $solicitante->setNombre(utf8_decode($_POST['txtBusqueda']));
        }
        if ($_POST['cbCriterio'] == 2) {
            $solicitante->setCurp(utf8_decode($_POST['txtBusqueda']));
        }
        if ($_POST['cbCriterio'] == 3) {
            $solicitante->setClaveElector(utf8_decode($_POST['txtBusqueda']));
        }

        $result = $solicitante->buscaSolicitante($_POST['cbCriterio']);
    }

    echo json_encode($result);

?>
