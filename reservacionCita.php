<?php

  header("Access-Control-Allow-Origin: *");

  require_once "conexion.php";

  $data = array();

  $id_encargado = filter_var($_REQUEST['id_encargado'], FILTER_SANITIZE_NUMBER_INT);
  $id_usuario   = filter_var($_REQUEST['id_usuario'], FILTER_SANITIZE_NUMBER_INT);
  $id_horario   = filter_var($_REQUEST['id_horario'], FILTER_SANITIZE_NUMBER_INT);
  $fecha        = filter_var($_REQUEST['fecha'], FILTER_SANITIZE_STRING);
  $estado       = filter_var($_REQUEST['estado'], FILTER_SANITIZE_NUMBER_INT);

  $stmt = Conexion::conectar()->prepare('SELECT * FROM controlcitas WHERE id_encargado = :id_encargado AND fecha = :fecha AND id_horario = :id_horario');
  $stmt->bindValue(":id_encargado", $id_encargado, PDO::PARAM_INT);
  $stmt->bindValue(":fecha", $fecha, PDO::PARAM_STR);
  $stmt->bindValue(":id_horario", $id_horario, PDO::PARAM_INT);
  $stmt->execute();

  $data = $stmt->fetch(PDO::FETCH_ASSOC);

  // echo json_encode($data);
  // echo "\n";

  if ($data["id_encargado"] == $id_encargado) {
    // echo "\nEncargado registrado en DB";

    // if($data["id_horario"] == $id_horario && $data["fecha"] == $fecha) {
      // echo "\nEl encargado ya tiene esta fecha y hora. elige otra hora.";
      echo json_encode("err_1 R");
    // }
  }else{
    // echo "\nEncargado NO registrado en DB";

    if ($data["fecha"] != $fecha) {
      // echo "\nDía Nuevo. Se elige la hora.";
      try  {
        $sql  = "INSERT INTO controlcitas(id_encargado, id_usuario, id_horario, fecha, estado) VALUES(:id_encargado, :id_usuario, :id_horario, :fecha, :estado)";
        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->bindParam(':id_encargado', $id_encargado, PDO::PARAM_INT);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':id_horario', $id_horario, PDO::PARAM_INT);
        $stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode("ok 3er lvl NR");
      }
        catch(PDOException $e)
      {
        echo $e->getMessage();
      }
    }
  }
