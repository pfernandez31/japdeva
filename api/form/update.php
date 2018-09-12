<?php
	require("../conexion.php");
	require("../logs.php");
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);

	$resp = new stdClass();
	$idAntecedente = $request->idAntecedente;
	$usuario = $request->usuarioId;
 	$movHistoricos = $request->movHistoricos; //ARRAY
	$asesor = $request->asesor;
	$canton = (int)$request->canton;
	$distrito = (int)$request->distrito;
	$razon = $request->razon;
	$razones = $request->razones;
	$opcParametro = $request->opcParametro;
	$traslapes = $request->traslapes;
	$parametros_inscripcion = $request->parametros_inscripcion;
	$otorgamiento = $request->otorgamiento;
	$presentacion = $request->presentacion;
	$ejecutoria_juzgado = $request->ejecutoria_juzgado;
	$finca = $request->finca;
	$d = $request->d;
	$derecho = $request->derecho;
	$identificadorPredial = $request->identificadorPredial;
	$plano = $request->plano;
	$area = $request->area;
	$inscripcion = $request->inscripcion;
	$tomo = $request->tomo;
	$folio = $request->folio;
	$asiento = $request->asiento;
	$plazo = $request->plazo;
	$notario = $request->notario;
	$juzgado = $request->juzgado;
	$numExpediente = $request->numExpediente;
	$propietario = $request->propietario;
	$propietarioA = $request->propietarioA;
	$analisisCaso = $request->analisisCaso;
	$recomendacionLegal = $request->recomendacionLegal;
	$asesorRegistral = $request->asesorRegistral;
	$asesorLegal = $request->asesorLegal;
	$finca_inscrita_derecho = $request->finca_inscrita_derecho;

	$modificado = date('Y-m-d G:i:s');
	//ANTECEDENTES
	$cnn->query("UPDATE antecedentes set usuario ='$usuario', finca = '$finca', d = '$d', derecho = '$derecho', identificador_predial ='$identificadorPredial', plano ='$plano', area ='$area', idDistrito ='$distrito', idCanton ='$canton', plazo_convalidacion ='$plazo', otorgamiento ='$otorgamiento', presentacion ='$presentacion', ejecutoria_juzgado ='$ejecutoria_juzgado', fecha_modificacion = '$modificado' where id = '$idAntecedente'");


	$cnn->query("UPDATE inscripcion set fecha = '$inscripcion', tomo = '$tomo', folio = '$folio', asiento = '$asiento', idrazon = '$razones', idparametro = '$parametros_inscripcion', razon = '$razon', parametro = '$opcParametro' where idAntecedente = '$idAntecedente'");

	$cnn->query("DELETE from movimientos where idAntecedente = '$idAntecedente'");
	foreach ($movHistoricos as $key => $value) {
		if($value->mov != ''){
			$cnn->query("INSERT into movimientos(idAntecedente,movimiento)value('$idAntecedente','$value->mov')");
		}
	}


	$cnn->query("UPDATE notariado set notario = '$notario', juzgado = '$juzgado', expediente_numero = '$numExpediente', propietario_original = '$propietario', propietario_actual = '$propietarioA' where idAntecedente = '$idAntecedente'");

	$cnn->query("UPDATE informacion_legal set finca_inscrita_derecho = '$finca_inscrita_derecho', idtraslape = '$traslapes' , analisis_juridico_caso = '$analisisCaso', recomendacion_legal = '$recomendacionLegal', historial_registral = '$asesorRegistral', analisis_legal = '$asesorLegal' where idAntecedente = '$idAntecedente'");
	//OK
	$resp->success = "Actualizado con Exito!";
	addregistro('update','registro actualizado finca #'.$finca.' creado por '.$asesor);
	echo json_encode($resp);
?>
