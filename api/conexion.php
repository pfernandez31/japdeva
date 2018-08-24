<?php 

	//SELECT * FROM `productos` WHERE JSON_CONTAINS(cadenas, '["004"]')



	$servidor = "localhost";

	$usuario = "";

	$password = "";

	$bd = "";

	try{

		$cnn = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8",$usuario,$password);

		//Excepciones

		$cnn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	}

	catch(PDOException $e){

		echo "Error ".$e->getMessage();

	}

?>