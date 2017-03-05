<?php

  include 'claseServicio.php';

  $servicio = new claseServicio();

  if($_POST['opcion'] == 5){
    $servicio->setIdArea($_POST['cbbArea']);

    $result = $servicio->listaServicios();
  }
  
  echo json_encode($result);
?>
