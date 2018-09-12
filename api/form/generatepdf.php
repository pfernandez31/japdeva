<?php 
require("../conexion.php");
require_once '../vendor/autoload.php';
require("../logs.php");

if(isset($_GET['id'])){
	$data = new stdClass();
	$mov = [];
	$idFormulario = $_GET['id'];
	$query = "select u.nombre, a.usuario as usuarioid, a.id, a.finca, a.d, a.derecho, a.identificador_predial, a.plano, a.area, a.idDistrito,a.idCanton, a.plazo_convalidacion, a.otorgamiento, a.presentacion, a.ejecutoria_juzgado, canton.canton, distrito.distrito, il.finca_inscrita_derecho, il.analisis_juridico_caso, il.recomendacion_legal, il.historial_registral, il.analisis_legal, i.fecha as fecha_inscripcion,i.tomo, i.folio, i.asiento, rv.razon as nace_por, i.razon, pv.parametro as parametroSelect, i.parametro, n.notario, n.juzgado, n.expediente_numero, n.propietario_original, n.propietario_actual, il.idtraslape from antecedentes a left join usuarios u on u.id = a.usuario left join  canton on canton.id = a.idCanton left join distrito on distrito.id = a.idDistrito left join  informacion_legal il on il.idAntecedente = a.id left join  inscripcion i on i.idAntecedente = a.id left join razones_values rv on rv.id = i.idrazon left join parametros_values pv on pv.id = i.idparametro left join notariado n on n.idAntecedente = a.id where a.id = '$idFormulario' order by a.id DESC";
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
		
		if($row['razon'] != ''){
			$data->razon = "<ul><li>".$row['razon']."</li></ul>";
		} else{
			$data->razon = $row['razon'];
		}

		$data->parametroSelect = $row['parametroSelect'];
		if($row['parametro'] != ''){
			$data->parametro = "<ul><li>".$row['parametro']."</li></ul>";
		} else{
			$data->parametro = $row['parametro'];
		}
		
		$data->notario = $row['notario'];
		$data->juzgado = $row['juzgado'];
		$data->expediente_numero = $row['expediente_numero'];
		$data->propietario_original = $row['propietario_original'];
		$data->propietario_actual = $row['propietario_actual'];
		$cont = 0;
		foreach($cnn->query("select movimiento from movimientos where idAntecedente = '$idFormulario'") as $m){
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
    $encabezado = 'ESTUDIO ANTECEDENTES FINCAS MATAMBU';
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
	</style>
	<div class="center">
	<h1>$encabezado</h1>
	<span>Fincas que nacen en tomos</span>
	</div>
	<div style="height:50px"></div>
EOF;
	//ASESOR
	$html .= <<<EOF
		<table cellspacing="5">
			<tr>
				<td width="25%"><span class="title">ASESOR:</span></td>
				<td>$data->asesor</td>
			</tr>
			<tr>
				<td width="25%"><span class="title">FINCA:</span></td>
				<td>$data->finca</td>
			</tr>
			<div></div>
			<tr >
				<td width="25%"><span class="title">INSCRIPCIÓN</span></td>
				<td width="25%"><span class="title">TOMO: </span>$data->tomo</td>
				<td width="25%"><span class="title">FOLIO: </span>$data->folio</td>
				<td width="25%"><span class="title">ASIENTO: </span>$data->asiento</td>
			</tr>
			<div></div>
			<tr>
				<td width="50%"><span class="title">PLANO: </span>$data->plano</td>
				<td width="50%"><span class="title">ÁREA: </span>$data->area</td>
			</tr>
			<div></div>
			<tr>
				<td width="100%"><span class="title">NACE POR:</span></td>
			</tr>
			<tr>
				<td width="25%"></td>
				<td>$data->nace_por $data->razon</td>
			</tr>
			<div></div>
			<tr>
				<td width="100%"><span class="title">PARAMETRO DE ANALISIS INSCRIPCIÓN DE LA FINCA</span></td>
			</tr>
			<tr>
				<td width="25%"></td>
				<td>$data->parametroSelect $data->parametro</td>
			</tr>
			<div></div>
			<div></div>
			<tr>
				<td width="40%"><span class="title">PROPIETARIO ORIGINAL:</span></td>
				<td>$data->propietario_original</td>
			</tr>
			<tr>
				<td width="40%"><span class="title">PROPIETARIO ACTUAL:</span></td>
				<td>$data->propietario_actual</td>
			</tr>
		</table>
EOF;
	//MOVIMIENTOS HISTORICOS
	$html .= <<<EOF
		<div style="height:50px"></div>
		<div class="center"><h5>MOVIMIENTOS HISTORICOS POSTERIORES A 1975</h5></div>
EOF;
	foreach (json_decode($data->movimiento)  as $key => $value) {
		$m = ($key+1).") ".$value->movimiento;
		$html .= <<<EOF
	        <p class="list">$m</p>	
EOF;
	} //FIN MOVIMIENTOS HISTORICOS
	//GENERAR
	$pdf->writeHTML($html, true, false, true, false, '');
	$pdf->Output($data->finca.'.pdf', 'I');
} else {
	header("location: ../../");
}

?>