<?php
include(__DIR__."/controller/controlador.php");

$json=__DIR__."/data_prueba.json";

publicar_productos($json);
//print_r(Conexion::getConexion()->get("products"));