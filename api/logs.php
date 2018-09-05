<?php 
	date_default_timezone_set('America/Costa_Rica');
	function addregistro($userauth,$accion,$registro){
		require("conexion.php");
		$fecha = date('Y-m-d G:i:s');
		$navegador = $_SERVER['HTTP_USER_AGENT'];
		$ip = $_SERVER['REMOTE_ADDR'];
		$cnn->query("INSERT into logs(usuario,fecha,accion,registro,navegador,ip)values('$userauth','$fecha','$accion','$registro','$navegador','$ip')");
	}
	
?>