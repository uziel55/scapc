<?php
  $folio = $_POST['folio'];

  include 'claseBD.php';
  $baseDatos = new claseBD();
  $sentencia = "SELECT oficio.folio, CONCAT(solicitante.nombre, ' ', solicitante.apellidoPaterno, ' ', solicitante.apellidoMaterno) AS nombre, especificaciones,
  fechaSolicitud, fechaRespuesta, fechaConclusion, catalogo_comite.nombre AS comite, telefonos_solicitantes.telefono FROM
  oficio, solicitante, catalogo_comite, telefonos_solicitantes WHERE catalogo_comite.numeroComite = oficio.numeroComite
  AND solicitante.curp = oficio.CURP AND oficio.CURP = telefonos_solicitantes.CURP AND oficio.folio =".$folio;
  $rs = $baseDatos->consultaRegistros($sentencia);
  $result = array();
  while($row = $rs->fetch_assoc()){
    $result[] = array_map('utf8_encode', $row);
  }
  echo json_encode($result);
?>
