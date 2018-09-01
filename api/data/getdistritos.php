<?php
	require("../conexion.php");
 	$contador = 0;
	$id = $_GET['id'];
	foreach($cnn->query("SELECT d.id, d.distrito, c.canton, p.provincia from distrito d inner join canton c on c.id = d.canton inner join provincia p on p.id = c.provicia where d.canton = '$id'") as $row){
		$data[$contador]['id'] = $row['id'];
		$data[$contador]['distrito'] = $row['distrito'];
		$data[$contador]['canton'] = $row['canton'];
		$data[$contador]['provincia'] = $row['provincia'];
		$contador++;
    }
	echo json_encode($data);
?>