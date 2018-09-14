<?php
	require("../conexion.php");
	require("../logs.php");
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);

	$resp = new stdClass();
	
	$usuario = $request->usuarioId;
 	$movHistoricos = $request->movHistoricos; //ARRAY
	$asesor = $request->asesor;
	$canton = (int)$request->canton;
	$distrito = (int)$request->distrito;
	$razones = $request->razones;
	if($razones == 12){
		$razon = $request->otrarazon;
	} else{
		$razon = $request->razon;
	}
	$ntomo = $request->ntomo;
	$nasiento = $request->nasiento;
	$area_traslape = $request->area_traslape;
	$pne = $request->pne;
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

	$creado = date('Y-m-d G:i:s');
	//ANTECEDENTES
	$cnn->query("INSERT into antecedentes(usuario,finca,d,derecho,identificador_predial,plano,area,idDistrito,idCanton,plazo_convalidacion,otorgamiento,presentacion,ejecutoria_juzgado,fecha_creacion,fecha_modificacion)values('$usuario','$finca','$d','$derecho','$identificadorPredial','$plano','$area','$distrito','$canton','$plazo','$otorgamiento','$presentacion','$ejecutoria_juzgado','$creado','$creado')");
	$idAntecedente = $cnn->lastInsertId();

	$cnn->query("INSERT into inscripcion(idAntecedente,fecha,tomo,folio,asiento,idrazon,idparametro,razon,parametro)value('$idAntecedente','$inscripcion','$tomo','$folio','$asiento','$razones','$parametros_inscripcion','$razon','$opcParametro')");

	foreach ($movHistoricos as $key => $value) {
		if($value->mov != ''){
			$cnn->query("INSERT into movimientos(idAntecedente,movimiento)value('$idAntecedente','$value->mov')");
		}
	}

	$cnn->query("INSERT into notariado(idAntecedente,notario,juzgado,expediente_numero,propietario_original,propietario_actual,ntomo,nasiento)value('$idAntecedente','$notario','$juzgado','$numExpediente','$propietario','$propietarioA','$ntomo','$nasiento')");

	$cnn->query("INSERT into informacion_legal(idAntecedente,idtraslape,finca_inscrita_derecho,analisis_juridico_caso,recomendacion_legal,historial_registral,analisis_legal,area_traslape,pne)value('$idAntecedente','$traslapes','$finca_inscrita_derecho','$analisisCaso','$recomendacionLegal','$asesorRegistral','$asesorLegal','$area_traslape','$pne')");
	//OK
	$resp->success = "Insertado con Exito!";
	addregistro('insert','registro formulario finca #'.$finca.' creado por '.$asesor);
	echo json_encode($resp);
?>
