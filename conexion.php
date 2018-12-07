<?php

class Conexion{

	public function conectar(){

		header("Access-Control-Allow-Origin: *");

		$link = new PDO("mysql:host=192.168.0.109;dbname=sindicato",
						"tienda_user",
						"123456",
						array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
								PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")

					);

		return $link;

	}
}
