<?php
  include 'claseArea.php';

  $area = new claseArea();

  //Lista areas
  if ($_POST['opcion'] == 5) {
      $result = $area->listaArea();
  }

  echo json_encode($result);

?>
