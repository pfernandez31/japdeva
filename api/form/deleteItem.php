<?php
	require("../conexion.php");
	require("../logs.php");
	if(isset($_GET['id']) && isset($_GET['usuario'])){
		$idAntecedente = $_GET['id'];
		$usuario = $_GET['usuario'];
		$finca = $_GET['finca'];

		$cnn->query("delete from antecedentes where id = '$idAntecedente'");
		$cnn->query("delete from informacion_legal where idAntecedente = '$idAntecedente'");
		$cnn->query("delete from inscripcion where idAntecedente = '$idAntecedente'");
		$cnn->query("delete from notariado where idAntecedente = '$idAntecedente'");
		$cnn->query("delete from traslapes where idAntecedente = '$idAntecedente'");
		$cnn->query("delete from movimientos where idAntecedente = '$idAntecedente'");

		addregistro('delete',"se elimino la fila #".$idAntecedente." asociada a finca ".$finca);
		header("location: ../../#!/home/");
	} else{
		header("location: ../../");
	}
?>
