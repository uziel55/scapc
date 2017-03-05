<?php

include 'clasebd.php';

class claseServicio{

    private $idServicio;
    private $nombre;
    private $estatus;
    private $descripcion;
    private $idArea;

    public function setIdServicio($idServicio)
    {
        $this->idServicio = $idServicio;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setEstatus($estatus)
    {
        $this->estatus = $estatus;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function setIdArea($idArea)
    {
        $this->idArea = $idArea;
    }

    //Getters

    public function getIdServicio()
    {
        return $this->idServicio;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getEstatus()
    {
        return $this->estatus;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getIdArea()
    {
        return $this->idArea;
    }

    public function listaServicios()
    {
        $baseDatos = new claseBD();

        $sentenciaSQL = "SELECT idServicio, nombre FROM catalogo_servicios WHERE estatus = 1 AND idArea = $this->idArea";

        $rs = $baseDatos->consultaRegistro($sentenciaSQL);

        $response = array();

        while($row = $rs->fetch_assoc()){
          $response[] = array_map('utf8_encode', $row);
        }

        return $response;
    }

}
 ?>
