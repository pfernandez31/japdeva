<?php
	//require("../conexion.php");
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
 	$usuario = $request->usuario;
 	$pass = $request->pass;
 	$objeto = new stdClass();
	
	/*$count = $cnn->query("SELECT  usuario FROM usuarios where usuario = '$usuario' && AES_DECRYPT(password,'labsFacturAPP') = '$pass'");
	$rows = $count->fetchAll();
	$num_rows = count($rows);

	if($num_rows == 1){
		foreach($cnn->query("SELECT  * FROM usuarios where usuario = '$usuario' && AES_DECRYPT(password,'labsFacturAPP') = '$pass'") as $row){
			$objeto->usuario = $row['usuario'];
			$objeto->empresaId = $row['empresaId'];
			$objeto->loggin = true;
			$id = $row['empresaId'];
			foreach($cnn->query("SELECT NombreComercial FROM empresas where id = '$id'") as $r){
				$objeto->NombreComercial = $r['NombreComercial'];
		    }
	    }
	}else{
		$objeto->loggin = false;
		$objeto->error = "Usuario o Contraseña Incorrecta";
	}
	echo json_encode($objeto);*/
	$objeto->usuario = "japdeva_admin";
	$objeto->id = "1";
	$objeto->role = "admin"; //digitador
	$objeto->loggin = true;
	echo json_encode($objeto);
?>