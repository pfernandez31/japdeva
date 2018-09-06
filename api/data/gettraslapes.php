<?php
	require("../conexion.php");
 	$contador = 0;
	
	foreach($cnn->query("SELECT * from traslapes_values") as $row){
		$data[$contador]['id'] = $row['id'];
		$data[$contador]['traslape'] = $row['traslape'];
		$data[$contador]['tipo'] = $row['tipo'];
		$contador++;
    }
	echo json_encode($data);
?>