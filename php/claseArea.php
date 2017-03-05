<?php

include 'clasebd.php';

class claseArea
{
    private $idArea;
    private $nombre;
    private $representante;
    private $callePrincipal;
    private $cruzamientoUno;
    private $cruzamientoDos;
    private $codigoPostal;
    private $telefono;

    public function __construct()
    {
        $idArea = 0;
        $nombre = "";
        $representante = "";
        $callePrincipal = "";
        $cruzamientoUno = "";
        $cruzamientoDos = "";
        $codigoPostal = "";
        $telefono = "";
    }

    public function setIdArea($idArea)
    {
        $this->idArea = $idArea;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setRepresentante($representante)
    {
        $this->representante = $representante;
    }

    public function setCallePrincipal($callePrincipal)
    {
        $this->callePrincipal = $callePrincipal;
    }

    public function setCruzamientoUno($cruzamientoUno)
    {
        $this->cruzamientoUno = $cruzamientoUno;
    }

    public function setCruzamientoDos($cruzamientoDos)
    {
        $this->cruzamientoDos = $cruzamientoDos;
    }

    public function setCodigoPostal($codigoPostal)
    {
        $this->codigoPostal = $codigoPostal;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }


    //Getters
    public function getIdArea()
    {
        return $this->idArea;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getRepresentante()
    {
        return $this->representante;
    }

    public function getCallePrincipal()
    {
        return $this->callePrincipal;
    }

    public function getCruzamientoUno()
    {
        return $this->cruzamientoUno;
    }

    public function getCruzamientoDos()
    {
        return $this->cruzamientoDos;
    }

    public function getCodigoPostal()
    {
        return $this->codigoPostal;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    //Funciones

    //Lista areas
    public function listaArea(){
      $baseDatos = new ClaseBD();

      $sentenciaSQL = "SELECT idArea, nombre FROM catalogo_areas WHERE estatus = 1";

      $rs = $baseDatos->consultaRegistro($sentenciaSQL);

      $response = array();

      while ($row = $rs->fetch_assoc()){
        $result[] = array_map('utf8_encode', $row);
      }

      return json_encode($result);
    }
}
