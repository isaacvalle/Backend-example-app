<?php

  header("Access-Control-Allow-Origin: *");

  require_once "conexion.php";

  $data = array();

  $id_encargado = filter_var($_REQUEST['id_encargado'], FILTER_SANITIZE_NUMBER_INT);
  $fecha        = filter_var($_REQUEST['fecha'], FILTER_SANITIZE_STRING);

  try {
    // Attempt to query database table and retrieve data
    $stmt = Conexion::conectar()->prepare('SELECT controlcitas.*, horariocitas.horario FROM controlcitas INNER JOIN horariocitas ON controlcitas.id_horario = horariocitas.id WHERE id_encargado = :id_encargado AND fecha = :fecha AND estado = 1 ORDER BY id_horario ASC');
    $stmt->bindParam(":id_encargado", $id_encargado, PDO::PARAM_INT);
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
