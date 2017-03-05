<?php

include 'clasebd.php';

class claseReporte
{
    private $folio;
    private $fechaSolicitud;
    private $fechaRespuesta;
    private $fechaConclusion;
    private $especificaciones;
    private $curp;
    private $nombreSolicitante;
    private $numeroComite;
    private $idServicio;
    private $estatus;

    //Constructor por default
    public function __construct()
    {
        $this->folio = 0;
        $this->fechaSolicitud = "";
        $this->fechaRespuesta = "";
        $this->fechaConclusion = "";
        $this->especificaciones = "";
        $this->curp = "";
        $this->numeroComite = 0;
        $this->idServicio = 0;
        $this->estatus = 0;
    }

    //Metodos setters para todas las propiedades
    public function setFolio($folio)
    {
        $this->folio = $folio;
    }

    public function setFechaSolicitud($fechaSolicitud)
    {
        $this->fechaSolicitud = $fechaSolicitud;
    }

    public function setFechaRespuesta($fechaRespuesta)
    {
        $this->fechaRespuesta = $fechaRespuesta;

    }

    public function setFechaConclusion($fechaConclusion)
    {
        $this->fechaConclusion = $fechaConclusion;
    }

    public function setEspecificaciones($especificaciones)
    {
        $this->especificaciones = $especificaciones;
    }

    public function setCurp($curp)
    {
        $this->curp = $curp;
    }
    public function setNombreSolicitante($nombreSolicitante){

      $this->nombreSolicitante = $nombreSolicitante;
    }

    public function setNumeroComite($numeroComite)
    {
        $this->numeroComite = $numeroComite;
    }

    public function setIdServicio($idServicio)
    {
        $this->idServicio = $idServicio;
    }

    public function setEstatus($estatus)
    {
        $this->estatus = $estatus;
    }

    //Metodos getters para todas las propiedades
    public function getFolio()
    {
        return $this->folio;
    }

    public function getFechaSolicitud()
    {
        return $this->fechaSolicitud;
    }

    public function getFechaRespuesta()
    {
        return $this->fechaRespuesta;
    }

    public function getFechaConclusion()
    {
        return $this->fechaConclusion;
    }

    public function getEspecificaciones()
    {
        return $this->especificaciones;
    }

    public function getCurp()
    {
        return $this->curp;
    }

    public function getNumeroComite()
    {
        return $this->numeroComite;
    }

    public function getIdServicio()
    {
        return $this->idServicio;
    }

    public function getEstatus()
    {
        return $this->estatus;
    }


    //Metodo registraReporte
    public function registraReporte()
    {
        $baseDatos = new claseBD();

        $sentenciaSQL = "INSERT INTO oficio (fechaSolicitud, fechaRespuesta, fechaConclusion, especificaciones, curp, numeroComite, idServicio, estatus) values ('$this->fechaSolicitud', '$this->fechaRespuesta', '$this->fechaConclusion', '$this->especificaciones', '$this->curp', '$this->numeroComite', '$this->idServicio', 1)";

        $result = $baseDatos->insertarRegistro($sentenciaSQL);

        $response = array();

        if ($result) {
            $response["success"] = 1;
            $response["message"] = "Oficio registrado correctamente.";
        } else {
            $response["success"] = 0;
            $response["message"] = "Oops! Ocurrió un error.";
        }

        return $response;
    }//Fun del metodo registraReporte

    //Inicio de la funcion listaOficios
    public function listaReportes()
    {
        $baseDatos = new claseBD();

        $sentenciaSQL = "SELECT folio, fechaSolicitud, LEFT(especificaciones , 30) AS detalles, CONCAT(solicitante.nombre, ' ', solicitante.apellidoPaterno, ' ', solicitante.apellidoMaterno) AS nombre, catalogo_servicios.descripcion AS servicio FROM solicitante, catalogo_servicios, oficio WHERE oficio.curp = solicitante.curp AND oficio.idServicio = catalogo_servicios.idServicio;";

        $rs = $baseDatos->consultaRegistro($sentenciaSQL);

        $result = array();

        while ($row = $rs->fetch_assoc()) {
            $result[] = array_map('utf8_encode', $row);
        }

        return json_encode($result);
    }//Fin del metodo listaOficios

    //Inicio de la funcion buscaReporte
    public function buscaReporte($criterio)
    {
        $baseDatos = new claseBD();

        if ($criterio == 1) { //Criterio 1, busqueda por CURP del solicitante
          $sentenciaSQL = "SELECT folio, fechaSolicitud, LEFT(especificaciones , 30) AS detalles, CONCAT(solicitante.nombre, ' ', solicitante.apellidoPaterno, ' ', solicitante.apellidoMaterno) AS nombre, catalogo_servicios.descripcion AS servicio FROM solicitante, catalogo_servicios, oficio WHERE oficio.curp = solicitante.curp AND oficio.idServicio = catalogo_servicios.idServicio AND oficio.curp = '$this->curp';";
        }
        if ($criterio == 2) { //Criterio 2, busqueda por folio del reporte
          $sentenciaSQL = "SELECT folio, fechaSolicitud, LEFT(especificaciones , 30) AS detalles, CONCAT(solicitante.nombre, ' ', solicitante.apellidoPaterno, ' ', solicitante.apellidoMaterno) AS nombre, catalogo_servicios.descripcion AS servicio FROM solicitante, catalogo_servicios, oficio WHERE oficio.curp = solicitante.curp AND oficio.idServicio = catalogo_servicios.idServicio AND oficio.folio = '$this->folio';";
        }
        if ($criterio == 3) { //Creiterio 3, busqueda por fecha de solicitud
            $sentenciaSQL = "SELECT folio, fechaSolicitud, LEFT(especificaciones , 30) AS detalles, CONCAT(solicitante.nombre, ' ', solicitante.apellidoPaterno, ' ', solicitante.apellidoMaterno) AS nombre, catalogo_servicios.descripcion AS servicio FROM solicitante, catalogo_servicios, oficio WHERE oficio.curp = solicitante.curp AND oficio.idServicio = catalogo_servicios.idServicio AND oficio.fechaSolicitud = '$this->fechaSolicitud';";
        }
        if ($criterio == 4) { //Criterio 3, busqueda por nombre del solicitante
          $sentenciaSQL = "SELECT folio, fechaSolicitud, LEFT(especificaciones , 30) AS detalles, CONCAT(solicitante.nombre, ' ', solicitante.apellidoPaterno, ' ', solicitante.apellidoMaterno) AS nombreSolicitante, catalogo_servicios.descripcion AS servicio FROM solicitante, catalogo_servicios, oficio WHERE oficio.curp = solicitante.curp AND oficio.idServicio = catalogo_servicios.idServicio AND CONCAT(solicitante.nombre, ' ', solicitante.apellidoPaterno, ' ', solicitante.apellidoMaterno) LIKE '$this->nombreSolicitante';";
        }

        $rs = $baseDatos->consultaRegistro($sentenciaSQL);

        $result = array();

        while ($row = $rs->fetch_assoc()) {
            $result[] = array_map('utf8_encode', $row);
        }

        return json_encode($result);
    }//Fin del metodo buscaReporte

    //Inicio de la funcion actualizaReporte
    public function actualizaReporte()
    {
        $baseDatos = new claseBD();

        $sentenciaSQL = "UPDATE oficio SET especificaciones = '$this->especificaciones' WHERE oficio.folio = '$this->folio';";
        $result = $baseDatos->modificarRegistro($sentenciaSQL);

        $response = array();

        if ($result) {
            $response["success"] = 1;
            $response["message"] = "Reporte modificado correctamente.";
        } else {
            $response["success"] = 0;
            $response["message"] = "Oops! Ocurrió un error!!";
        }

        return $response;
    }//Fin del metodo registraSolicitante

    public function concluyeReporte(){
      $baseDatos = new claseBD();

      $sentenciaSQL = "UPDATE oficio SET fechaConclusion = '$this->fechaSolicitud', estatus = '4' WHERE oficio.folio = '$this->folio';";
      $result = $baseDatos->modificarRegistro($sentenciaSQL);

      $response = array();

      if ($result) {
          $response["success"] = 1;
          $response["message"] = "Reporte concluido correctamente.";
      } else {
          $response["success"] = 0;
          $response["message"] = "Oops! Ocurrió un error!!";
      }

      return $response;
    }

    public function apruebaReporte(){
      $baseDatos = new claseBD();

      $sentenciaSQL = "UPDATE oficio SET estatus = '2' WHERE oficio.folio = '$this->folio';";
      $result = $baseDatos->modificarRegistro($sentenciaSQL);

      $response = array();

      if ($result) {
          $response["success"] = 1;
          $response["message"] = "Reporte aprobado correctamente.";
      } else {
          $response["success"] = 0;
          $response["message"] = "Oops! Ocurrió un error!!";
      }

      return $response;
    }

    public function ejecutaReporte(){
      $baseDatos = new claseBD();

      $sentenciaSQL = "UPDATE oficio SET estatus = '3' WHERE oficio.folio = '$this->folio';";
      $result = $baseDatos->modificarRegistro($sentenciaSQL);

      $response = array();

      if ($result) {
          $response["success"] = 1;
          $response["message"] = "Reporte en ejecucion.";
      } else {
          $response["success"] = 0;
          $response["message"] = "Oops! Ocurrió un error!!";
      }

      return $response;
    }

    public function rechazaReporte(){
      $baseDatos = new claseBD();

      $sentenciaSQL = "UPDATE oficio SET estatus = '5' WHERE oficio.folio = '$this->folio';";
      $result = $baseDatos->modificarRegistro($sentenciaSQL);

      $response = array();

      if ($result) {
          $response["success"] = 1;
          $response["message"] = "Reporte rechazado correctamente.";
      } else {
          $response["success"] = 0;
          $response["message"] = "Oops! Ocurrió un error!!";
      }

      return $response;
    }

    //Inicio de la funcion bajaReporte
    public function bajaReporte()
    {
        $baseDatos = new claseBD();

        $sentenciaSQL = "UPDATE reporte SET estatus = '0' WHERE folio = '$this->folio'";
        $result = $baseDatos->eliminarRegistro($sentenciaSQL);

        $response = array();

        if ($result) {
            $response["success"] = 1;
            $response["message"] = "Reporte eliminado correctamente.";
        } else {
            $response["success"] = 0;
            $response["message"] = "Ocurrio un error al procesar tu solicitud.";
        }

        return $response;
    }//Fin del metodo registraSolicitante

    //Inicio de la funcion consultaReporte
    public function consultaReporte()
    {
        $baseDatos = new claseBD();

        $sentenciaSQL = "SELECT folio, fechaSolicitud, LEFT(especificaciones , 30) AS detalles, CONCAT(solicitante.nombre, ' ', solicitante.apellidoPaterno, ' ', solicitante.apellidoMaterno) AS nombre, catalogo_servicios.descripcion AS servicio FROM solicitante, catalogo_servicios, oficio WHERE oficio.curp = solicitante.curp AND oficio.idServicio = catalogo_servicios.idServicio AND oficio.folio = '$this->folio';";
        $rs = $baseDatos->consultaRegistro($sentenciaSQL);
        $result = array();

        if ($rs->num_rows > 0) {
            while ($row = $rs->fetch_assoc()) {
                $result[] = array_map('utf8_encode', $row);
            }
        } else {
            $result["error"] = 1;
            $result["message"] = "El reporte no existe.";
        }

        return $result;
    }//Fin del metodo consultaReporte
}
