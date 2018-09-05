<?php
	require("../conexion.php");
 	$contador = 0;
	
	foreach($cnn->query("SELECT * from parametro_inscripcion") as $row){
		$data[$contador]['id'] = $row['id'];
		$data[$contador]['parametro'] = $row['parametro'];
		$contador++;
    }
	echo json_encode($data);
?>