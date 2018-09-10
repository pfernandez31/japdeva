<?php 
	require("../conexion.php");
if(isset($_GET['id'])){
	$data = new stdClass();
	$idFormulario = $_GET['id'];
	$query = "select u.nombre, a.usuario as usuarioid, a.id, a.finca, a.d, a.derecho, a.identificador_predial, a.plano, a.area, a.idDistrito,a.idCanton, a.plazo_convalidacion, a.otorgamiento, a.presentacion, a.ejecutoria_juzgado, canton.canton, distrito.distrito, il.finca_inscrita_derecho, il.analisis_juridico_caso, il.recomendacion_legal, il.historial_registral, il.analisis_legal, i.fecha as fecha_inscripcion,i.tomo, i.folio, i.asiento, rv.razon as nace_por, i.razon, pv.parametro as parametroSelect, i.parametro, n.notario, n.juzgado, n.expediente_numero, n.propietario_original, n.propietario_actual, t.traslape, t.tipo from antecedentes a left join usuarios u on u.id = a.usuario left join  canton on canton.id = a.idCanton left join distrito on distrito.id = a.idDistrito left join  informacion_legal il on il.idAntecedente = a.id left join  inscripcion i on i.idAntecedente = a.id left join razones_values rv on rv.id = i.idrazon left join parametros_values pv on pv.id = i.idparametro left join notariado n on n.idAntecedente = a.id left join traslapes t on t.idAntecedente = a.id where a.id = '$idFormulario' order by a.id DESC";
	foreach($cnn->query($query) as $row){
		$data->asesor = $row['nombre'];
		$data->usuarioid = $row['usuarioid'];
		$data->id = $row['id'];
		$data->finca = $row['finca'];
		$data->d = $row['d'];
		$data->derecho = $row['derecho'];
		$data->identificador_predial = $row['identificador_predial'];
		$data->plano = $row['plano'];
		$data->area = $row['area'];
		$data->idDistrito = $row['idDistrito'];
		$data->idCanton = $row['idCanton'];
		$data->plazo_convalidacion = $row['plazo_convalidacion'];
		$data->otorgamiento = $row['otorgamiento'];
		$data->presentacion = $row['presentacion'];
		$data->ejecutoria_juzgado = $row['ejecutoria_juzgado'];
		$data->canton = $row['canton'];
		$data->distrito = $row['distrito'];
		$data->finca_inscrita_derecho = $row['finca_inscrita_derecho'];
		$data->analisis_juridico_caso = $row['analisis_juridico_caso'];
		$data->recomendacion_legal = $row['recomendacion_legal'];
		$data->historial_registral = $row['historial_registral'];
		$data->analisis_legal = $row['analisis_legal'];
		$data->fecha_inscripcion = $row['fecha_inscripcion'];
		$data->tomo = $row['tomo'];
		$data->folio = $row['folio'];
		$data->asiento = $row['asiento'];
		$data->nace_por = $row['nace_por'];
		$data->razon = $row['razon'];
		$data->parametroSelect = $row['parametroSelect'];
		$data->parametro = $row['parametro'];
		$data->notario = $row['notario'];
		$data->juzgado = $row['juzgado'];
		$data->expediente_numero = $row['expediente_numero'];
		$data->propietario_original = $row['propietario_original'];
		$data->propietario_actual = $row['propietario_actual'];
		$data->traslape = $row['traslape'];
		$data->tipo = $row['tipo'];
		$cont = 0;
		foreach($cnn->query("select movimiento from movimientos where idAntecedente = '$idFormulario'") as $m){
			$mov[$cont]['movimiento'] = $m['movimiento'];
			$cont++;
		}
		$data->movimiento = json_encode($mov);
		/*
		foreach (json_decode($data->movimiento)  as $key => $value) {
			$m = $value->movimiento;
		}
		*/
		echo json_encode($data);
    }
} else {
	header("location: ../../");
}
?>