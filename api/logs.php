<?php 
	session_start();
	date_default_timezone_set('America/Costa_Rica');
	function addregistro($accion,$registro,$userid){
		require("conexion.php");
		//$userid =  $_SESSION['idusuario'];
		$fecha = date('Y-m-d G:i:s');
		$navegador = $_SERVER['HTTP_USER_AGENT'];
		$ip = $_SERVER['REMOTE_ADDR'];
		$cnn->query("INSERT into logs(usuario,fecha,accion,registro,navegador,ip)values('$userid','$fecha','$accion','$registro','$navegador','$ip')");
	}
	
?>