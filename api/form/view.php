<?php 
date_default_timezone_set('America/Costa_Rica');
require("../conexion.php");
if(isset($_GET['id'])){
	$mov = [];
	$data = new stdClass();
	$idFormulario = $_GET['id'];
	$query = "select
u.nombre,
a.usuario as usuarioid,
a.id as idAntecedente,
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
il.finca_inscrita_derecho,
il.analisis_juridico_caso,
il.recomendacion_legal,
il.historial_registral,
il.analisis_legal,
il.pne,
il.area_traslape,
il.idtraslape,
il.valueTraslape,
i.fecha as fecha_inscripcion,
i.tomo,
i.folio,
i.asiento,
i.matricula,
rv.id as razonid,
rv.razon as nace_por,
i.razon as nace_por_value,
pv.id as parametroid,
i.parametro as parametro_value,
n.notario,
n.juzgado,
n.expediente_numero,
n.propietario_original,
n.propietario_actual,
n.ntomo,
n.nasiento
from antecedentes a
left join usuarios u on u.id = a.usuario
left join  informacion_legal il on il.idAntecedente = a.id
left join  inscripcion i on i.idAntecedente = a.id
left join razones_values rv on rv.id = i.idrazon
left join parametros_values pv on pv.id = i.idparametro
left join notariado n on n.idAntecedente = a.id 
where
a.id = '$idFormulario'
order by a.id DESC  limit 1";
	foreach($cnn->query($query) as $row){
		$data->idAntecedente = $row['idAntecedente'];
		$data->asesor = $row['nombre'];
		$data->usuarioid = $row['usuarioid'];
		$data->finca = $row['finca'];
		$data->d = $row['d'];
		$data->derecho = $row['derecho'];
		$data->identificadorPredial = $row['identificador_predial'];
		$data->plano = $row['plano'];
		$data->area = $row['area'];
		$data->distrito = $row['idDistrito'];
		$data->canton = $row['idCanton'];
		$data->plazo = $row['plazo_convalidacion'];
		$data->otorgamiento = $row['otorgamiento'];
		$data->presentacion = $row['presentacion'];
		$data->ejecutoria_juzgado = $row['ejecutoria_juzgado'];
		$data->finca_inscrita_derecho = $row['finca_inscrita_derecho'];
		$data->analisisCaso = $row['analisis_juridico_caso'];
		$data->recomendacionLegal = $row['recomendacion_legal'];
		$data->asesorRegistral = $row['historial_registral'];
		$data->asesorLegal = $row['analisis_legal'];
		$data->inscripcion = $row['fecha_inscripcion'];
		$data->tomo = $row['tomo'];
		$data->folio = $row['folio'];
		$data->asiento = $row['asiento'];
		$data->matricula = $row['matricula'];
		$data->checkNace = $row['razonid'];
		$data->razones = $row['razonid'];
		$data->nace_por = $row['nace_por'];
		
		if($row['razonid'] == 12){
			$data->otrarazon = $row['nace_por_value'];
			$data->razon = '';
		} else{
			$data->otrarazon = '';
			$data->razon = $row['nace_por_value'];
		}
		$data->checkParam = $row['parametroid'];
		$data->parametros_inscripcion = $row['parametroid'];
		$data->opcParametro = $row['parametro_value'];
		$data->notario = $row['notario'];
		$data->juzgado = $row['juzgado'];
		$data->numExpediente = $row['expediente_numero'];
		$data->propietario = $row['propietario_original'];
		$data->propietarioA = $row['propietario_actual'];
		$data->checkTraslape = $row['idtraslape'];
		$data->traslapes = $row['idtraslape'];
		$data->Traslaperazon = $row['valueTraslape'];
		$data->ntomo = $row['ntomo'];
		$data->nasiento = $row['nasiento'];
		$data->area_traslape = $row['area_traslape'];
		$data->pne = $row['pne'];
		$cont = 0;
		foreach($cnn->query("SELECT movimiento from movimientos where idAntecedente = '$idFormulario' ORDER By id ASC") as $m){
			$mov[$cont]['mov'] = $m['movimiento'];
			$cont++;
		}
		$data->movHistoricos = $mov;
		echo json_encode($data);
    }
} else {
	header("location: ../../");
}
?>