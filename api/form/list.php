<?php
	require("../conexion.php");
	$data = [];
 	$contador = 0;
	$query = "
	select
	u.nombre,
	a.usuario as usuarioid,
	a.id,
	a.finca,
	a.d,
	a.derecho,
	a.identificador_predial,
	a.plano,
	a.area,
	a.idDistrito,
	a.idCanton,
	a.plazo_convalidacion,
	a.otorgamiento,
	a.presentacion,
	a.ejecutoria_juzgado,
	canton.canton,
	distrito.distrito,
	il.finca_inscrita_derecho,
	il.analisis_juridico_caso,
	il.recomendacion_legal,
	il.historial_registral,
	il.analisis_legal,
	i.fecha as fecha_inscripcion,
	i.tomo,
	i.folio,
	i.asiento,
	rv.razon as nace_por,
	i.razon,
	pv.parametro as parametroSelect,
	i.parametro,
	n.notario,
	n.juzgado,
	n.expediente_numero,
	n.propietario_original,
	n.propietario_actual,
	t.traslape,
	t.tipo
	from antecedentes a
	inner join usuarios u on u.id = a.usuario
	inner join  canton on canton.id = a.idCanton
	inner join distrito on distrito.id = a.idDistrito
	inner join  informacion_legal il on il.idAntecedente = a.id
	inner join  inscripcion i on i.idAntecedente = a.id
	inner join razones_values rv on rv.id = i.idrazon
	inner join parametros_values pv on pv.id = i.idparametro
	inner join notariado n on n.idAntecedente = a.id
	inner join traslapes t on t.idAntecedente = a.id
	order by a.id DESC
	";
	foreach($cnn->query($query) as $row){
		$data[$contador]['asesor'] = $row['nombre'];
		$data[$contador]['usuarioid'] = $row['usuarioid'];
		$data[$contador]['id'] = $row['id'];
		$data[$contador]['finca'] = $row['finca'];
		$data[$contador]['d'] = $row['d'];
		$data[$contador]['derecho'] = $row['derecho'];
		$data[$contador]['identificador_predial'] = $row['identificador_predial'];
		$data[$contador]['plano'] = $row['plano'];
		$data[$contador]['area'] = $row['area'];
		$data[$contador]['idDistrito'] = $row['idDistrito'];
		$data[$contador]['idCanton'] = $row['idCanton'];
		$data[$contador]['plazo_convalidacion'] = $row['plazo_convalidacion'];
		$data[$contador]['otorgamiento'] = $row['otorgamiento'];
		$data[$contador]['presentacion'] = $row['presentacion'];
		$data[$contador]['ejecutoria_juzgado'] = $row['ejecutoria_juzgado'];
		$data[$contador]['canton'] = $row['canton'];
		$data[$contador]['distrito'] = $row['distrito'];
		$data[$contador]['finca_inscrita_derecho'] = $row['finca_inscrita_derecho'];
		$data[$contador]['analisis_juridico_caso'] = $row['analisis_juridico_caso'];
		$data[$contador]['recomendacion_legal'] = $row['recomendacion_legal'];
		$data[$contador]['historial_registral'] = $row['historial_registral'];
		$data[$contador]['analisis_legal'] = $row['analisis_legal'];
		$data[$contador]['fecha_inscripcion'] = $row['fecha_inscripcion'];
		$data[$contador]['tomo'] = $row['tomo'];
		$data[$contador]['folio'] = $row['folio'];
		$data[$contador]['asiento'] = $row['asiento'];
		$data[$contador]['nace_por'] = $row['nace_por'];
		$data[$contador]['razon'] = $row['razon'];
		$data[$contador]['parametroSelect'] = $row['parametroSelect'];
		$data[$contador]['parametro'] = $row['parametro'];
		$data[$contador]['notario'] = $row['notario'];
		$data[$contador]['juzgado'] = $row['juzgado'];
		$data[$contador]['expediente_numero'] = $row['expediente_numero'];
		$data[$contador]['propietario_original'] = $row['propietario_original'];
		$data[$contador]['propietario_actual'] = $row['propietario_actual'];
		$data[$contador]['traslape'] = $row['traslape'];
		$data[$contador]['tipo'] = $row['tipo'];
		$contador++;
    }
	echo json_encode($data);
?>