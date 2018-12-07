<?php

  header("Access-Control-Allow-Origin: *");

  require_once "conexion.php";

  $data = array();

  $id_usuario = filter_var($_REQUEST['id_usuario'], FILTER_SANITIZE_NUMBER_INT);
  $fecha        = filter_var($_REQUEST['fecha'], FILTER_SANITIZE_STRING);

  try {
    // Attempt to query database table and retrieve data
    $stmt = Conexion::conectar()->prepare('SELECT controlcitas.*, horariocitas.horario, oficinas.titulo, oficinas.encargado FROM controlcitas INNER JOIN horariocitas ON controlcitas.id_horario = horariocitas.id INNER JOIN oficinas ON controlcitas.id_encargado = oficinas.id WHERE controlcitas.id_usuario = :id_usuario AND controlcitas.fecha >= :fecha AND controlcitas.estado = 1 ORDER BY controlcitas.fecha ASC');
    $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
    $stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);
    $stmt->execute();

    while($row  = $stmt->fetchAll(PDO::FETCH_OBJ))
    {         // Assign each row of data to associative array
      $data = $row;
    }

    echo json_encode($data);
  }
  catch(PDOException $e)
  {
      echo $e->getMessage();
  }
