<?php
  include 'claseReporte.php';

  $reporte = new claseReporte();

  //Opcion 1 - Alta reporte
  if ($_POST['opcion'] == 1) {

      $reporte->setFechaSolicitud(date('d-m-Y'));
      $reporte->setFechaRespuesta(date("d-m-Y", strtotime("+15 days")));
      $reporte->setEspecificaciones($_POST['txtEspecificaciones']);
      $reporte->setCurp($_POST['txtSolicitante']);
      $reporte->setNumeroComite($_POST['txtNumeroComite']);
      $reporte->setIdServicio($_POST['txtIDServicio']);

      $result = $reporte->registraReporte();
  }

  //Opcion 2 - Baja de reporte
  if ($_POST['opcion'] == 2) {
      $reporte->setFolio($_POST['txtFolio']);

      $result = $solicitante->bajaReporte();
  }

  //Opcion 3 - Modifica solicitante
  if ($_POST['opcion'] == 3) {
      $reporte->setFolio($_POST['txtModificaFolio']);

      $result = $reporte->setEspecificaciones($_POST['txtModificaEspecificaciones']);
  }

  //Opcion 4 - Consulta reporte
  if ($_POST['opcion'] == 4) {
      $reporte->setFolio($_POST['txtConsultaFolio']);

      $result = $solicitante->consultaSolicitante();
  }

  //Opcion 5 - Lista reportes
  if ($_POST['opcion'] == 5) {
      $result = $reporte->listaReportes();
  }

  //Opcion 6 - Busca reporte
  if ($_POST['opcion'] == 6) {
      if ($_POST['cbCriterioReporte'] == 1) {
      }
      if ($_POST['cbCriterioReporte'] == 2) {
      }
      if ($_POST['cbCriterioReporte'] == 3) {
      }

      $result = $reporte->buscaReporte($_POST['cbCriterioReporte']);
  }

  //Opcion 7 - Aprueba reporte
  if ($_POST['opcion'] == 7) {
      $reporte->setFolio($_POST['txtModificaFolio']);

      $result = $reporte->apruebaReporte();
  }

  //Opcion 8 - Ejecuta reporte
  if ($_POST['opcion'] == 8) {
      $reporte->setFolio($_POST['txtModificaFolio']);

      $result = $reporte->ejecutaReporte();
  }

  //Opcion 9 - Rechaza reporte
  if ($_POST['opcion'] == 9) {
      $reporte->setFolio($_POST['txtModificaFolio']);

      $result = $reporte->bajaReporte();
  }

  //Opcion 10 - Baja reporte
  if ($_POST['opcion'] == 10) {
      $reporte->setFolio($_POST['txtModificaFolio']);

      $result = $reporte->bajaReporte();
  }

  echo json_encode($result);

?>
