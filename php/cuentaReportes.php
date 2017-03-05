<?php
  //$estatus = $_POST['folio'];
  $estatus = $_POST['estatus'];

  include 'claseBD.php';
  $baseDatos = new claseBD();
  $sentencia = "SELECT COUNT(*) AS oficios FROM oficio WHERE estatus = ".$estatus;
  $rs = $baseDatos->consultaRegistros($sentencia);
  $result = array();
  while($row = $rs->fetch_assoc()){
    $result[] = array_map('utf8_encode', $row);
  }
  echo json_encode($result);
?>
