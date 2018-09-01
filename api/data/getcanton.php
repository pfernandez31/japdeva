<?php
	require("../conexion.php");
 	$contador = 0;
	$id = $_GET['id'];
	foreach($cnn->query("SELECT * from canton where provicia = '$id'") as $row){
		$data[$contador]['id'] = $row['id'];
		$data[$contador]['canton'] = $row['canton'];
		$contador++;
    }
	echo json_encode($data);
?>