<?php
	require("../conexion.php");
 	$contador = 0;
	
	foreach($cnn->query("SELECT logs.fecha, usuarios.nombre, usuarios.usuario, logs.accion, logs.registro from logs inner join usuarios on usuarios.id = logs.usuario order by logs.id DESC") as $row){
		$data[$contador]['usuario'] = $row['nombre']." (".$row['usuario'].")";
        $data[$contador]['fecha'] = $row['fecha'];
        $data[$contador]['accion'] = $row['accion'];
        $data[$contador]['registro'] = $row['registro'];
		$contador++;
    }
	echo json_encode($data);
?>