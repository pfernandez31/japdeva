<?php
	require("../conexion.php");
 	$contador = 0;
	
	foreach($cnn->query("SELECT * from razones_values") as $row){
		$data[$contador]['id'] = $row['id'];
		$data[$contador]['razon'] = $row['razon'];
		$contador++;
    }
	echo json_encode($data);
?>