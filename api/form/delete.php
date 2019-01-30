<?php
	require("../conexion.php");
	require("../logs.php");

	if(isset($_GET['id']) && isset($_GET['finca'])){
		$idAntecedente = $_GET['id'];
		$finca = $_GET['finca'];
		$usuario = $_GET['idusuario'];
		$cnn->query("delete from antecedentes where id = '$idAntecedente'");
		$cnn->query("delete from informacion_legal where idAntecedente = '$idAntecedente'");
		$cnn->query("delete from inscripcion where idAntecedente = '$idAntecedente'");
		$cnn->query("delete from notariado where idAntecedente = '$idAntecedente'");
		$cnn->query("delete from movimientos where idAntecedente = '$idAntecedente'");

		addregistro('delete',"se elimino el registro de finca ".$finca,$usuario);
		header("location: ../../#!/home/");
	} else{
		header("location: ../../");
	}
?>
