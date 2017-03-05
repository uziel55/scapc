<?php

include 'claseBD.php';

//Clase solicitante
class claseSolicitante
{

    //Atributos de la clase
    private $curp;
    private $nombre;
    private $apellidoPaterno;
    private $apellidoMaterno;
    private $claveElector;
    private $estatus;

    //Constructor por default
    public function __construct()
    {
        $this->curp = "";
        $this->nombre = "";
        $this->apellidoPaterno = "";
        $this->apellidoMaterno = "";
        $this->claveElector = "";
        $this->estatus = 0;
    }

   //Métodos setters para todas las propiedades
   public function setCurp($curp)
   {
       $this->curp = $curp;
   }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setApellidoPaterno($apellidoPaterno)
    {
        $this->apellidoPaterno = $apellidoPaterno;
    }

    public function setApellidoMaterno($apellidoMaterno)
    {
        $this->apellidoMaterno = $apellidoMaterno;
    }

    public function setClaveElector($claveElector)
    {
        $this->claveElector = $claveElector;
    }

    public function setEstatus($estatus)
    {
        $this->estatus = $estatus;
    }

    //Métodos getters para todas las propiedades
    public function getCurp()
    {
        return $this->curp;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellidoPaterno()
    {
        return $this->apellidoPaterno;
    }

    public function getApellidoMaterno()
    {
        return $this->apellidoMaterno;
    }

    public function getClaveElector()
    {
        return $this->claveElector;
    }

    public function getEstatus()
    {
        return $this->estatus;
    }

    //Metodo registraSolicitante
    public function registraSolicitante()
    {
        $baseDatos = new claseBD();

        $sentenciaSQL = "INSERT INTO solicitante (CURP, nombre, apellidoPaterno, apellidoMaterno, claveElector, estatus) values ('$this->curp','$this->nombre', '$this->apellidoPaterno', '$this->apellidoMaterno', '$this->claveElector', 1)";

        $result = $baseDatos->insertarRegistro($sentenciaSQL);

        $response = array();

        if ($result) {
            $response["success"] = 1;
            $response["message"] = "Solicitante registrado correctamente.";
        } else {
            $response["success"] = 0;
            $response["message"] = "Oops! Ocurrió un error.";
        }

        return $response;
    }//Fin del metodo registraSolicitante

    //Inicio de la funcion listaSolicitantes
    public function listaSolicitantes()
    {
        $baseDatos = new claseBD();

        $sentenciaSQL = "SELECT CURP, CONCAT(nombre, ' ', apellidoPaterno, ' ', apellidoMaterno) AS nombre, claveElector FROM solicitante WHERE estatus = 1";

        $rs = $baseDatos->consultaRegistro($sentenciaSQL);

        $result = array();

        while ($row = $rs->fetch_assoc()) {
            $result[] = array_map('utf8_encode', $row);
        }

        return json_encode($result);
    }//Fin de la funcion listaSolicitantes

    //Inicio de la funcion buscaSolicitante
    public function buscaSolicitante($criterio)
    {
        $baseDatos = new claseBD();
        if ($criterio == 1) {
            $sentenciaSQL = "SELECT CURP, CONCAT(nombre, ' ', apellidoPaterno, ' ', apellidoMaterno) AS nombre, claveElector FROM solicitante WHERE CONCAT(nombre, ' ', apellidoPaterno, ' ', apellidoMaterno) LIKE '$this->nombre%'";
        }
        if ($criterio == 2) {
            $sentenciaSQL = "SELECT CURP, CONCAT(nombre, ' ', apellidoPaterno, ' ', apellidoMaterno) AS nombre, claveElector FROM solicitante WHERE CURP = '$this->CURP'";
        }
        if ($criterio == 3) {
            $sentenciaSQL = "SELECT CURP, CONCAT(nombre, ' ', apellidoPaterno, ' ', apellidoMaterno) AS nombre, claveElector FROM solicitante WHERE claveElector = '$this->claveElector'";
        }

        $rs = $baseDatos->consultaRegistro($sentenciaSQL);

        $result = array();

        while ($row = $rs->fetch_assoc()) {
            $result[] = array_map('utf8_encode', $row);
        }

        return json_encode($result);
    }//Fin de la funcion buscaSolicitante


    // Método actualizaSolicitante, usado para actualizar a un solicitante en la BD
    public function actualizaSolicitante()
    {
        $baseDatos = new claseBD();

        $sentenciaSQL="UPDATE solicitante SET nombre = '$this->nombre', apellidoPaterno = '$this->apellidoPaterno', apellidoMaterno = '$this->apellidoMaterno', claveElector = '$this->claveElector' WHERE solicitante.CURP = '$this->curp'";
        $result = $baseDatos->modificarRegistro($sentenciaSQL);

        $response = array();

        if ($result) {
            $response["success"] = 1;
            $response["message"] = "Solicitante modificado correctamente.";
        } else {
            $response["success"] = 0;
            $response["message"] = "Oops! Ocurrió un error!!";
        }

        return $response;
    } //Fin método actualizasolicitante


    //Método eliminasolicitante, usado para eliminar a un solicitante en la BD
    public function bajaSolicitante()
    {
        $baseDatos = new claseBD();

        $sentenciaSQL="UPDATE solicitante SET estatus = '0' WHERE solicitante.CURP = '$this->curp'";
        $result = $baseDatos->eliminarRegistro($sentenciaSQL);

        $response = array();

        if ($result) {
            $response["success"] = 1;
            $response["message"] = "Solicitante eliminado correctamente.";
        } else {
            $response["success"] = 0;
            $response["message"] = "Ocurrio un error al procesar tu solicitud.";
        }

        return $response;
    }//Fin método eliminasolicitante


    //Método consultasolicitante, usado para consultar registros de un solicitante en la BD
    public function consultaSolicitante()
    {
        $baseDatos = new claseBD();

        $sentenciaSQL="SELECT CURP, nombre, apellidoPaterno, apellidoMaterno, claveElector FROM solicitante WHERE CURP = '$this->curp'";
        $rs = $baseDatos->consultaRegistro($sentenciaSQL);
        $result = array();
        //Arreglo asociativo
        if ($rs->num_rows > 0) {
            while ($row = $rs->fetch_assoc()) {
                $result[] = array_map('utf8_encode', $row);
            }
        } else {
            $result["error"] = 1;
            $result["message"] = "El solicitante no existe.";
        }

        return $result;
    }//Fin método consultasolicitante
} //Fin clase solicitante
