<?php
	require("../conexion.php");
 	$contador = 0;
	
	foreach($cnn->query("SELECT * from logs") as $row){
		$data[$contador]['usuario'] = $row['usuario'];
        $data[$contador]['fecha'] = $row['fecha'];
        $data[$contador]['accion'] = $row['accion'];
        $data[$contador]['registro'] = $row['registro'];
		$contador++;
    }
	echo json_encode($data);
?>