<?php 
date_default_timezone_set('America/Costa_Rica');
require("../conexion.php");
require_once '../vendor/autoload.php';
require("../logs.php");

if(isset($_GET['id'])){
	$data = new stdClass();
	$mov = [];
	$idFormulario = $_GET['id'];
	$query = "select
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
il.pne,
il.area_traslape,
i.fecha as fecha_inscripcion,
i.tomo,
i.folio,
i.asiento,
i.matricula,
rv.razon as nace_por,
i.razon,
pv.parametro as parametroSelect,
i.parametro,
n.notario,
n.juzgado,
n.expediente_numero,
n.propietario_original,
n.propietario_actual,
il.idtraslape,
il.valueTraslape,
tv.traslape,
n.ntomo,
n.nasiento
from antecedentes a
left join usuarios u on u.id = a.usuario
left join  canton on canton.id = a.idCanton
left join distrito on distrito.id = a.idDistrito
left join  informacion_legal il on il.idAntecedente = a.id
left join  inscripcion i on i.idAntecedente = a.id
left join razones_values rv on rv.id = i.idrazon
left join parametros_values pv on pv.id = i.idparametro
left join notariado n on n.idAntecedente = a.id
left join traslapes_values tv on tv.id = il.idtraslape
where 
a.id = '$idFormulario' 
order by a.id DESC";
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

		if($row['otorgamiento'] != null){
			$dateTime2 = strtotime($row['otorgamiento']);
			$data->otorgamiento = date('d-m-Y', $dateTime2);
		} else {
			$data->otorgamiento =  '';
		}

		if($row['presentacion'] != null){
			$dateTime3 = strtotime($row['presentacion']);
			$data->presentacion = date('d-m-Y', $dateTime3);
		} else {
			$data->presentacion =  '';
		}

		if($row['ejecutoria_juzgado'] != null){
			$dateTime4 = strtotime($row['ejecutoria_juzgado']);
			$data->ejecutoria_juzgado = date('d-m-Y', $dateTime4);
		} else {
			$data->ejecutoria_juzgado =  '';
		}
		

		$data->canton = $row['canton'];
		$data->distrito = $row['distrito'];
		$data->finca_inscrita_derecho = strtoupper($row['finca_inscrita_derecho']);
		$data->analisis_juridico_caso = $row['analisis_juridico_caso'];
		$data->recomendacion_legal = $row['recomendacion_legal'];
		$data->historial_registral = $row['historial_registral'];
		$data->analisis_legal = $row['analisis_legal'];

		$dateTime = strtotime($row['fecha_inscripcion']);
		$data->fecha_inscripcion = date('d-m-Y', $dateTime);
		$data->tomo = $row['tomo'];
		$data->folio = $row['folio'];
		$data->asiento = $row['asiento'];
		$data->matricula = $row['matricula'];
		$data->nace_por = $row['nace_por'];
		$data->ntomo = $row['ntomo'];
		$data->nasiento = $row['nasiento'];
		$data->area_traslape = $row['area_traslape'];
		$data->traslape = $row['traslape'];
		$data->valueTraslape = $row['valueTraslape'];
		$data->pne = strtoupper($row['pne']);
		$data->razon = $row['razon'];
		$data->parametroSelect = $row['parametroSelect'];
		$data->parametro = $row['parametro'];
		$data->notario = $row['notario'];
		$data->juzgado = $row['juzgado'];
		$data->expediente_numero = $row['expediente_numero'];
		$data->propietario_original = $row['propietario_original'];
		$data->propietario_actual = $row['propietario_actual'];
		$cont = 0;
		foreach($cnn->query("SELECT movimiento from movimientos where idAntecedente = '$idFormulario' ORDER By id ASC") as $m){
			$mov[$cont]['movimiento'] = $m['movimiento'];
			$cont++;
		}
		$data->movimiento = json_encode($mov);
    }
    addregistro('view',"Consulta formulario PDF asociado a finca ".$data->finca);
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);
    $pdf->AddPage();
    $encabezado = 'ESTUDIO ANTECEDENTES FINCAS';
	    $html = <<<EOF
	<style>
		.center {
			text-align:center;
		}
		.left {
			text-align:left;
		}
	    h1 {
	        font-family: arial;
	        font-size: 18pt;
	        text-decoration: none;
	        font-weight: 500;
	    }
	    .list {
	    	border:0.3px solid #ccc;
	    }
	    .title {
	    	font-weight:bold;
	    }
	    .subtitle{
	    	font-weight:500;
	    }
	    .colHeader{
	    	background-color:#ECECEC;
	    }
	    .coldata{
	    	background-color:#F8F9FA;
	    	color:#212529;
	    }
	    .colextra{
	    	background-color:#E1E1E1;
	    }
	</style>
	<div class="center">
	<h1>$encabezado</h1>
	<span>Fincas que nacen en tomos</span>
	</div>
	<div style="height:50px"></div>
EOF;
	//ASESOR
	$html .= <<<EOF
		<table cellspacing="0" cellpadding="5">
			<tr>
				<td width="15%"  class="colHeader"><span class="title">ASESOR</span></td>
				<td class="coldata" width="85%">$data->asesor</td>
			</tr>
			<tr>
				<td width="15%" class="colHeader"><span class="title">FINCA</span></td>
				<td class="coldata" width="20%">$data->finca</td>
				<td width="4%" class="colHeader"><span class="subtitle">D</span></td>
				<td class="coldata" width="12%">$data->d</td>
				<td width="15%" class="colHeader"><span class="subtitle">DERECHO</span></td>
				<td class="coldata">$data->derecho</td>
			</tr>
			<tr>
				<td width="35%" class="colHeader"><span class="subtitle">IDENTIFICADOR PREDIAL</span></td>
				<td class="coldata"  width="65%">$data->identificador_predial</td>
			</tr>
			<div></div>
			<tr >
				<td width="20%" class="colHeader"><span class="title">INSCRIPCIÓN</span></td>
				<td width="20%" class="colHeader"><span class="subtitle">TOMO</span></td>
				<td width="20%" class="colHeader"><span class="subtitle">FOLIO</span></td>
				<td width="20%" class="colHeader"><span class="subtitle">ASIENTO</span></td>
				<td width="20%" class="colHeader"><span class="subtitle">MATRICULA</span></td>
			</tr>
			<tr>
				<td width="20%" class="coldata">$data->fecha_inscripcion</td>
				<td width="20%" class="coldata">$data->tomo</td>
				<td width="20%" class="coldata">$data->folio</td>
				<td width="20%" class="coldata">$data->asiento</td>
				<td width="20%" class="coldata">$data->matricula</td>
			</tr>
			<tr>
				<td width="25%" class="colHeader"><span class="title">PLANO</span></td>
				<td width="24%" class="coldata">$data->plano</td>
				<td width="2%"></td>
				<td width="25%" class="colHeader"><span class="title">CANTON</span></td>
				<td width="25%" class="coldata">$data->canton</td>
			</tr>
			<tr>
				<td width="25%" class="colHeader"><span class="title">AREA</span></td>
				<td width="24%" class="coldata">$data->area</td>
				<td width="2%"></td>
				<td width="25%" class="colHeader"><span class="title">DISTRITO</span></td>
				<td width="25%" class="coldata">$data->distrito</td>
			</tr>
			<div></div>
			<tr>
				<td width="15%" class="colHeader"><span class="title">NACE POR</span></td>
				<td width="40%" class="coldata">$data->nace_por</td>
				<td width="45%" class="colextra">$data->razon</td>
			</tr>
			<tr>
				<td width="32%" class="colHeader"><span class="title">INSCRIPCIÓN DE LA FINCA</span></td>
				<td width="37%" class="coldata">$data->parametroSelect</td>
				<td width="31%" class="colextra">$data->parametro</td>
			</tr>
			<div></div>
			<tr >
				<td width="50%" class="colHeader"><span class="title">NOTARIO</span></td>
				<td width="50%" class="colHeader"><span class="title">JUZGADO</span></td>
			</tr>
			<tr>
				<td width="50%" class="coldata">$data->notario</td>
				<td width="50%" class="coldata">$data->juzgado</td>
			</tr>
			<tr >
				<td width="25%" class="colHeader"><span class="title">OTORGAMIENTO</span></td>
				<td width="25%" class="colHeader"><span class="title">PRESENTACION</span></td>
				<td width="25%" class="colHeader"><span class="title">PLAZO DE CONVALIDACIÓN</span></td>
			</tr>
			<tr>
				<td width="25%" class="coldata">$data->otorgamiento</td>
				<td width="25%" class="coldata">$data->presentacion</td>
				<td width="25%" class="coldata">$data->plazo_convalidacion</td>
				<td width="25%" class="coldata">$data->ejecutoria_juzgado</td>
			</tr>
			<tr >
				<td width="40%" class="colHeader"><span class="title">EXPEDIENTE NUMERO</span></td>
			</tr>
			<tr>
				<td width="40%" class="coldata">$data->expediente_numero</td>
				<td width="15%" class="colHeader">TOMO</td>
				<td width="15%" class="coldata">$data->ntomo</td>
				<td width="15%" class="colHeader">ASIENTO</td>
				<td width="15%" class="coldata">$data->nasiento</td>
			</tr>
			<div></div>
			<tr>
				<td width="45%"  class="colHeader"><span class="title">PROPIETARIO ORIGINAL</span></td>
				<td class="coldata" width="55%">$data->propietario_original</td>
			</tr>
			<tr>
				<td width="45%"  class="colHeader"><span class="title">PROPIETARIO ACTUAL</span></td>
				<td class="coldata" width="55%">$data->propietario_actual</td>
			</tr>
			<div></div>
			<div></div>
			<tr>
				<td width="32%" class="colHeader"><span class="title">HECHOS RELEVANTES Y TIPOLOGÍA</span></td>
				<td width="37%" class="coldata" >$data->traslape</td>
				<td width="31%" class="colextra">$data->valueTraslape</td>
			</tr>
			<tr>
				<td width="45%"  class="colHeader"><span class="title">PORCENTAJE DEL AREA TRASLAPE</span></td>
				<td class="coldata" width="30%">$data->area_traslape</td>
				<td width="10%"  class="colHeader"><span class="title">PNE</span></td>
				<td class="coldata" width="10%">$data->pne</td>
			</tr>
			<div></div>
			<tr>
				<td width="38%"  class="colHeader"><span class="title">FINCA INSCRITA A DERECHO</span></td>
				<td class="coldata" width="10%">$data->finca_inscrita_derecho</td>
			</tr>
			<tr>
				<td width="38%"  class="colHeader"><span class="title">ANÁLISIS JURÍDICO DEL CASO</span></td>
				<td class="coldata" width="62%">$data->analisis_juridico_caso</td>
			</tr>
			<tr>
				<td width="38%"  class="colHeader"><span class="title">RECOMENDACIÓN LEGAL</span></td>
				<td class="coldata" width="62%">$data->recomendacion_legal</td>
			</tr>
			<div></div>
			<tr>
				<td width="40%"  class="colHeader"><span class="title">ASESOR RESPONSABLE / <br>HISTORIAL REGISTRAL</span></td>
				<td class="coldata" width="60%">$data->historial_registral</td>
			</tr>
			<tr>
				<td width="40%"  class="colHeader"><span class="title">ASESOR RESPONSABLE / <br>ANÁLISIS LEGAL</span></td>
				<td class="coldata" width="60%">$data->analisis_legal</td>
			</tr>
		</table>
EOF;
	//MOVIMIENTOS HISTORICOS
	$html .= <<<EOF
		<div style="height:50px"></div>
		<div class="center title"><h3>MOVIMIENTOS HISTORICOS POSTERIORES A 1950</h3></div>
		<table cellspacing="0" cellpadding="5">
EOF;
	foreach (json_decode($data->movimiento)  as $key => $value) {
		$m = ($key+1).") ".$value->movimiento;
		$html .= <<<EOF
			<tr>
				<td class="colHeader" width="100%">$m</td>
			</tr>	
EOF;
	}
	$html .= <<<EOF
		</table>
EOF;
	 //FIN MOVIMIENTOS HISTORICOS
	//GENERAR
	$pdf->writeHTML($html, true, false, true, false, '');
	$pdf->Output($data->finca.'.pdf', 'I');
} else {
	header("location: ../../");
}

?>