<?php
	date_default_timezone_set('America/Costa_Rica');
	require("../conexion.php");
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
 	$finca = $request->finca;
 	if($request->fecha != ''){
 		$fecha =  date('Y-m-d',strtotime($request->fecha));
 		$fecha2 =  date('Y-m-d',strtotime($request->fecha. ' + 1 days'));
 	} else {
 		$fecha = '';
 		$fecha2 = '';
 	}

 	$usuario = $request->usuario;

	$data = [];
 	$contador = 0;


 	if($usuario != "0"  && $fecha == '' && $finca == ''){  //FILTRO USUARIO
 		$query = "SELECT u.nombre, u.idrole, a.usuario as usuarioid, a.id, a.finca, a.derecho, a.identificador_predial, a.plano, a.area, i.fecha as fecha_inscripcion FROM antecedentes a left join usuarios u on u.id = a.usuario left join  inscripcion i on i.idAntecedente = a.id WHERE u.id = '$usuario' order by a.id DESC";
 	}
	else if($usuario == "0"  && $fecha == '' && $finca == ''){	//FILTRO AMBOS DIGITADOR & ADMINISTRADOR
		$query = "SELECT u.nombre, u.idrole, a.usuario as usuarioid, a.id, a.finca, a.derecho, a.identificador_predial, a.plano, a.area, i.fecha as fecha_inscripcion FROM antecedentes a left join usuarios u on u.id = a.usuario left join  inscripcion i on i.idAntecedente = a.id  order by a.id DESC";
	}
	else if($usuario == "0"  && $fecha != '' && $finca == ''){ //FILTRO FECHA INSCRIPCION
		$query = "SELECT u.nombre, u.idrole, a.usuario as usuarioid, a.id, a.finca, a.derecho, a.identificador_predial, a.plano, a.area, i.fecha as fecha_inscripcion FROM antecedentes a left join usuarios u on u.id = a.usuario left join  inscripcion i on i.idAntecedente = a.id  WHERE  i.fecha >= '$fecha'  AND i.fecha < '$fecha2'   order by a.id DESC";
	}
	else if($usuario == "0"  && $fecha == '' && $finca != ''){ //FILTRO FINCA
		$query = "SELECT u.nombre, u.idrole, a.usuario as usuarioid, a.id, a.finca, a.derecho, a.identificador_predial, a.plano, a.area, i.fecha as fecha_inscripcion FROM antecedentes a left join usuarios u on u.id = a.usuario left join  inscripcion i on i.idAntecedente = a.id  WHERE  a.finca = '$finca'   order by a.id DESC";
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