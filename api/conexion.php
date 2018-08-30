<?php 

	//SELECT * FROM `productos` WHERE JSON_CONTAINS(cadenas, '["004"]')



	$servidor = "localhost";

	$usuario = "root";

	$password = "b43e7f69fa152ed976a2349d4a2d49b99ab275501195c047";

	$bd = "form_antecedentes";

	try{
		$cnn = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8",$usuario,$password);
		$cnn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	catch(PDOException $e){
		echo "Error ".$e->getMessage();
	}

?>