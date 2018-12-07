<?php
	
	header("Access-Control-Allow-Origin: *");
	require_once "conexion.php";

	$id_usuario = filter_var($_REQUEST['id_usuario'], FILTER_SANITIZE_NUMBER_INT);
	$id_encargado = filter_var($_REQUEST['id_encargado'], FILTER_SANITIZE_NUMBER_INT);
	$mensaje = filter_var($_REQUEST['mensaje'], FILTER_SANITIZE_STRING);

	if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ.,]+$/', $mensaje)){

		try {
	      $stmt = Conexion::conectar()->prepare("INSERT INTO comentarios(id_usuario, id_encargado, mensaje) VALUES(:id_usuario, :id_encargado, :mensaje)");
	      $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
	      $stmt->bindParam(":id_encargado", $id_encargado, PDO::PARAM_INT);
	      $stmt->bindParam(":mensaje", $mensaje, PDO::PARAM_STR);

	      if($stmt->execute()){
	      	$var = "ok";
	      	echo json_encode($var);
	      }


	      
	   }
	   catch(PDOException $e)
	   {
	      echo $e->getMessage();
	   }

	}else{
		$var = "error catacter";
	}


	