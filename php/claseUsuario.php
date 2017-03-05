<?php

include 'claseBD.php';

//Clase usuario
class claseUsuario
{

    //Atributos de la clase
    private $idUsuario;
    private $nombre;
    private $usuario;
    private $contrasena;
    private $tipoUsuario;
    private $estatus;

    //Constructor por default
    public function __construct()
    {
        $this->idUsuario = "";
        $this->nombre = "";
        $this->usuario = "";
        $this->contrasena = "";
        $this->tipoUsuario = "";
        $this->estatus = 0;
    }

   //Métodos setters para todas las propiedades
   public function setIdUsuario($idUsuario)
   {
       $this->idUsuario = $idUsuario;
   }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function setContrasena($contrasena)
    {
        $this->contrasena = $contrasena;
    }

    public function setTipoUsuario($tipoUsuario)
    {
        $this->tipoUsuario = $tipoUsuario;
    }

    public function setEstatus($estatus)
    {
        $this->estatus = $estatus;
    }

    //Métodos getters para todas las propiedades
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getContrasena()
    {
        return $this->contrasena;
    }

    public function geTtipoUsuario()
    {
        return $this->tipoUsuario;
    }

    public function getEstatus()
    {
        return $this->estatus;
    }

    //Metodo registraUsuario
    public function registraUsuario()
    {
        $baseDatos = new claseBD();

        $sentenciaSQL = "INSERT INTO usuarios (idUsuario, nombre, usuario, contrasena, tipoUsuario, estatus) values ('$this->idUsuario','$this->nombre', '$this->usuario', '$this->contrasena', '$this->tipoUsuario', 1)";

        $result = $baseDatos->insertarRegistro($sentenciaSQL);

        $response = array();

        if ($result) {
            $response["success"] = 1;
            $response["message"] = "Usuario registrado correctamente.";
        } else {
            $response["success"] = 0;
            $response["message"] = "Oops! Ocurrió un error.";
        }

        return $response;
    }//Fin del metodo registraUsuario

    //Inicio de la funcion listaUsuarios
    public function listaUsuarios()
    {
        $baseDatos = new claseBD();

        $sentenciaSQL = "SELECT idUsuario, CONCAT(nombre, ' ', usuario, ' ', contrasena) AS nombre, tipoUsuario FROM Usuario WHERE estatus = 1";

        $rs = $baseDatos->consultaRegistro($sentenciaSQL);

        $result = array();

        while ($row = $rs->fetch_assoc()) {
            $result[] = array_map('utf8_encode', $row);
        }

        return json_encode($result, JSON_PRETTY_PRINT);
    }//Fin de la funcion listaUsuarios

    //Inicio de la funcion buscaUsuario
    public function buscaUsuario($criterio)
    {
        $baseDatos = new claseBD();
        if ($criterio == 1) {
            $sentenciaSQL = "SELECT idUsuario, CONCAT(nombre, ' ', usuario, ' ', contrasena) AS nombre, tipoUsuario FROM Usuario WHERE CONCAT(nombre, ' ', usuario, ' ', contrasena) LIKE '$this->nombre%'";
        }
        if ($criterio == 2) {
            $sentenciaSQL = "SELECT idUsuario, CONCAT(nombre, ' ', usuario, ' ', contrasena) AS nombre, tipoUsuario FROM Usuario WHERE idUsuario = '$this->idUsuario'";
        }
        if ($criterio == 3) {
            $sentenciaSQL = "SELECT idUsuario, CONCAT(nombre, ' ', usuario, ' ', contrasena) AS nombre, tipoUsuario FROM Usuario WHERE tipoUsuario = '$this->tipoUsuario'";
        }

        $rs = $baseDatos->consultaRegistro($sentenciaSQL);

        $result = array();

        while ($row = $rs->fetch_assoc()) {
            $result[] = array_map('utf8_encode', $row);
        }

        return json_encode($result);
    }//Fin de la funcion buscaUsuario


    // Método actualizaUsuario, usado para actualizar a un Usuario en la BD
    public function actualizaUsuario()
    {
        $baseDatos = new claseBD();

        $sentenciaSQL="UPDATE usuarios SET nombre = '$this->nombre', usuario = '$this->usuario', contrasena = '$this->contrasena', tipoUsuario = '$this->tipoUsuario' WHERE Usuario.idUsuario = '$this->idUsuario'";
        $result = $baseDatos->modificarRegistro($sentenciaSQL);

        $response = array();

        if ($result) {
            $response["success"] = 1;
            $response["message"] = "Usuario modificado correctamente.";
        } else {
            $response["success"] = 0;
            $response["message"] = "Oops! Ocurrió un error!!";
        }

        return $response;
    } //Fin método actualizaUsuario


    //Método eliminaUsuario, usado para eliminar a un Usuario en la BD
    public function bajaUsuario()
    {
        $baseDatos = new claseBD();

        $sentenciaSQL="UPDATE usuarios SET estatus = '0' WHERE Usuario.idUsuario = '$this->idUsuario'";
        $result = $baseDatos->eliminarRegistro($sentenciaSQL);

        $response = array();

        if ($result) {
            $response["success"] = 1;
            $response["message"] = "Usuario eliminado correctamente.";
        } else {
            $response["success"] = 0;
            $response["message"] = "Ocurrio un error al procesar tu solicitud.";
        }

        return $response;
    }//Fin método eliminaUsuario


    //Método consultaUsuario, usado para consultar registros de un Usuario en la BD
    public function consultaUsuario()
    {
        $baseDatos = new claseBD();

        $sentenciaSQL="SELECT idUsuario, nombre, usuario, contrasena, tipoUsuario FROM usuarios WHERE idUsuario = '$this->idUsuario'";
        $rs = $baseDatos->consultaRegistro($sentenciaSQL);
        $result = array();
        //Arreglo asociativo
        if ($rs->num_rows > 0) {
            while ($row = $rs->fetch_assoc()) {
                $result[] = array_map('utf8_encode', $row);
            }
        } else {
            $result["error"] = 1;
            $result["message"] = "El Usuario no existe.";
        }

        return $result;
    }//Fin método consultaUsuario
} //Fin clase cUsuario
