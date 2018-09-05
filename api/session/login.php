<?php
	require("../conexion.php");
	require("../logs.php");
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
 	$usuario = $request->usuario;
 	$pass = $request->pass;
 	$objeto = new stdClass();
	
	$count = $cnn->query("SELECT  * FROM usuarios where usuario = '$usuario' && AES_DECRYPT(password,'japdeva') = '$pass'");
	$rows = $count->fetchAll();
	$num_rows = count($rows);

	if($num_rows == 1){
		foreach($cnn->query("SELECT  u.usuario, u.id, r.role, u.idrole, u.nombre  FROM usuarios u inner join roles r on r.id = u.idrole  where usuario = '$usuario' && AES_DECRYPT(password,'japdeva') = '$pass'") as $row){
			$objeto->usuario = $row['usuario'];
			$objeto->idusuario = $row['id'];
			$objeto->role = $row['role'];
			$objeto->idrole = $row['idrole'];
			$objeto->nombre = $row['nombre'];
			$objeto->loggin = true;
	    }
	    addregistro($usuario,'auth','inicio de session');
	}else{
		$objeto->loggin = false;
		$objeto->error = "Usuario o Contraseña Incorrecta";
		addregistro($usuario,'auth','error inicio de session');
	}
	echo json_encode($objeto);
?>