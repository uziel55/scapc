<?php
  $estatus = $_POST['estatus'];


  include 'claseBD.php';
  $baseDatos = new claseBD();
  $sentencia = "SELECT oficio.folio, CONCAT(solicitante.nombre, ' ', solicitante.apellidoPaterno, ' ', solicitante.apellidoMaterno) AS nombre, especificaciones,
  fechaSolicitud, fechaRespuesta, fechaConclusion, catalogo_comite.nombre AS comite, oficio.estatus FROM
  oficio, solicitante, catalogo_comite WHERE catalogo_comite.numeroComite = oficio.numeroComite
  AND solicitante.curp = oficio.CURP AND oficio.estatus =".$estatus.' ORDER BY folio';
  $rs = $baseDatos->consultaRegistro($sentencia);
  $result = array();
  while($row = $rs->fetch_assoc()){
    $result[] = array_map('utf8_encode', $row);
  }
  echo json_encode($result, JSON_PRETTY_PRINT);
?>
