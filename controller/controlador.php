<?php
require_once(__DIR__."/../model/modelo.php");

function publicar_productos($json){
    $productos=Producto::__construct_desde_json($json);
    
    foreach ($productos as $producto) {
        Producto::publicar($producto);
    }
}