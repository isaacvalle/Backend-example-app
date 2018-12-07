<?php

  header("Access-Control-Allow-Origin: *");

  require_once "conexion.php";

  $data = array();

  // Attempt to query database table and retrieve data
  try {
    $stmt = Conexion::conectar()->prepare("SELECT * FROM horariocitas ORDER BY id ASC");
    $stmt->execute();

    while($row  = $stmt->fetchAll(PDO::FETCH_OBJ))
    {         // Assign each row of data to associative array
       $data = $row;
    }

    // Return data as JSON
    echo json_encode($data);
  }
  catch(PDOException $e)
  {
    echo $e->getMessage();
  }
