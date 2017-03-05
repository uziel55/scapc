<?php
class claseBD{
	//Declaracion de variables de la clase
	private $user;
	private $password;
	private $server;
	private $database;
	private $mysqli;

	function __construct(){
		$this->user = 'root';
		$this->password = '12345';
		$this->database = 'scapc';
		$this->server = 'localhost';
	}

	function abrirConexion(){
		$this->mysqli = new mysqli($this->server, $this->user, $this->password, $this->database);
		if ($this->mysqli->connect_errno) {
			echo 'Ha ocurrido un error al conectar a la base de datos. '. $this_mysqli->mysqli->connect_errno . " - " . $this_mysqli->mysqli->connect_error;
			exit();
		}
	}
	function cerrarConexion(){
		$this->mysqli->close();
	}
	function insertarRegistro($sentenciaSQL){
		$this->abrirConexion();
		$result = $this->mysqli->query($sentenciaSQL);
		$this->cerrarConexion();
		return $result;
	}

	function eliminarRegistro($sentenciaSQL){
		$this->abrirConexion();
		$result = $this->mysqli->query($sentenciaSQL);
		$this->cerrarConexion();
		return $result;
	}
	function modificarRegistro($sentenciaSQL){
		$this->abrirConexion();

		$result = $this->mysqli->query($sentenciaSQL);
		$modificados = $this->mysqli->affected_rows;
		$this->cerrarConexion();

		return $modificados;
	}
	function consultaRegistro($sentenciaSQL){
		$this->abrirConexion();
		$result = $this->mysqli->query($sentenciaSQL);
		$this->cerrarConexion();
		return $result;
	}

}
?>
