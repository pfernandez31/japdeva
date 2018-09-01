<?php
	require("../conexion.php");
 	$contador = 0;
	
	foreach($cnn->query("SELECT * from provincia") as $row){
		$data[$contador]['id'] = $row['id'];
		$data[$contador]['provincia'] = $row['provincia'];
		$contador++;
    }
	echo json_encode($data);
?>