<?php
	require("../conexion.php");
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	$resp = new stdClass();
	
	$resp->success = "Formulario Guardado con Exito.";
	echo json_encode($resp);
	

?>
