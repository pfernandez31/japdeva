<?php
	date_default_timezone_set('America/Costa_Rica');
	require("../conexion.php");
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
 	$finca = $request->finca;
 	if($request->fecha != ''){
 		$fecha =  date('Y-m-d H:i:s',strtotime($request->fecha));
 	} else {
 		$fecha = '';
 	}
 	$role = $request->role;


	$data = [];
 	$contador = 0;

 	if($role == "1" || $role == "2"  && $fecha == '' && $finca == ''){  //FILTRO DIGITADOR | ADMINISTRADOR
 		$query = "SELECT u.nombre, u.idrole, a.usuario as usuarioid, a.id, a.finca, a.derecho, a.identificador_predial, a.plano, a.area, i.fecha as fecha_inscripcion FROM antecedentes a left join usuarios u on u.id = a.usuario left join  inscripcion i on i.idAntecedente = a.id WHERE u.idrole = '$role' order by a.id DESC";
 	}
	else if($role == "0"  && $fecha == '' && $finca == ''){	//FILTRO AMBOS DIGITADOR & ADMINISTRADOR
		$query = "SELECT u.nombre, u.idrole, a.usuario as usuarioid, a.id, a.finca, a.derecho, a.identificador_predial, a.plano, a.area, i.fecha as fecha_inscripcion FROM antecedentes a left join usuarios u on u.id = a.usuario left join  inscripcion i on i.idAntecedente = a.id  order by a.id DESC";
	}
	else if($role == ""  && $fecha != '' && $finca == ''){ //FILTRO FECHA INSCRIPCION
		$query = "SELECT u.nombre, u.idrole, a.usuario as usuarioid, a.id, a.finca, a.derecho, a.identificador_predial, a.plano, a.area, i.fecha as fecha_inscripcion FROM antecedentes a left join usuarios u on u.id = a.usuario left join  inscripcion i on i.idAntecedente = a.id  WHERE  i.fecha >= '$fecha'  AND i.fecha < '$fecha'   order by a.id DESC";
	} else {  //MOSTRAR TODOS
		$query = "SELECT u.nombre, u.idrole, a.usuario as usuarioid, a.id, a.finca, a.derecho, a.identificador_predial, a.plano, a.area, i.fecha as fecha_inscripcion FROM antecedentes a left join usuarios u on u.id = a.usuario left join  inscripcion i on i.idAntecedente = a.id order by a.id DESC";
	}


	foreach($cnn->query($query) as $row){
		$data[$contador]['asesor'] = $row['nombre'];
		$data[$contador]['role'] = $row['idrole'];
		$data[$contador]['usuarioid'] = $row['usuarioid'];
		$data[$contador]['id'] = $row['id'];
		$data[$contador]['finca'] = $row['finca'];
		$data[$contador]['derecho'] = $row['derecho'];
		$data[$contador]['identificador_predial'] = $row['identificador_predial'];
		$data[$contador]['plano'] = $row['plano'];
		$data[$contador]['area'] = $row['area'];
		$data[$contador]['fecha_inscripcion'] = $row['fecha_inscripcion'];
		$contador++;
    }
	echo json_encode($data);
?>