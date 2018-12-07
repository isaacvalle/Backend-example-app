<?php

	header("Access-Control-Allow-Origin: *");
	require_once "conexion.php";


	$numControl = filter_var($_REQUEST['numControl'], FILTER_SANITIZE_STRING);
	$password = filter_var($_REQUEST['password'], FILTER_SANITIZE_STRING);

	if (!$numControl || !$password) {

		//ERROR 1 - NO RE RECIBIERON PARAMETROS

		$respuesta = array(
			'error' => TRUE,
			'mensaje' => 'Valores incorrectos'
		);

		echo json_encode($respuesta);
		return;

	}else{

		if(preg_match('/^[0-9]+$/', $numControl) && 
			preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ]+$/', $password)){

				$resultado = array();

			//TENEMOS CORREO Y CONTRASEÑA CORRECTOS

				$stmt = Conexion::conectar()->prepare('SELECT * FROM usuarios WHERE numControl = :numControl AND password = :password');
				$stmt->bindValue(":numControl", $numControl, PDO::PARAM_STR);
				$stmt->bindValue(":password", $password, PDO::PARAM_STR);
  				$stmt->execute();
  				
  				$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

  				if(!$resultado){

  					// ERROR 3 - LOS DATOS NO COINCIDEN CON LOS DE LA DB

  					$respuesta = array(
						'error' => TRUE,
						'mensaje' => 'El número de control o la contraseña no son correctos'
					);

					echo json_encode($respuesta);
  					return;

  				}else{
  					
  					$token = hash('ripemd160', $numControl);

  					$stmt = Conexion::conectar()->prepare('UPDATE usuarios SET token = :token WHERE id = :id_usuario');
  					$stmt->bindValue(":token", $token, PDO::PARAM_STR);
  					$stmt->bindValue(":id_usuario", $resultado['id'], PDO::PARAM_STR);
  					$stmt->execute();

  					$respuesta = array(
  						'error' => FALSE,
  						'id_usuario' => $resultado['id'],
  						'nombre' => $resultado['nombre'],
  						'numControl' => $resultado['numControl'],
  						'token' => $token
  					);

  					echo json_encode($respuesta);

  				}
  				


		}else{

			// ERROR 2 - SE ESCRIBIERON CARACTERES ESPECIALES

			$respuesta = array(
				'error' => TRUE,
				'mensaje' => 'No se permiten caracteres especiales en el número de control o en la contraseña'
			);

			echo json_encode($respuesta);
			return;
		}
	}

		