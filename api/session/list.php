<?php
	require("../conexion.php");
	
	$objeto = [];
	$contador = 0;

	foreach($cnn->query("SELECT  u.id,  u.nombre  FROM usuarios u") as $row){
			$objeto[$contador]['nombre'] = $row['nombre'];
			$objeto[$contador]['id'] = $row['id'];
			$contador++;
	    }


	echo json_encode($objeto);
?>