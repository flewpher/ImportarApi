<?php
require __DIR__."/../model/modelo.php";



/**
 * Publica los productos a partir de un JSON.
 *
 * @param string $json El JSON que contiene los datos de los productos.
 * @return bool|void Retorna true si los productos se publicaron correctamente, de lo contrario imprime el error.
 */
function PublicarProductos($json){
    try {
        $productos=Producto::__constuct_desde_json($json);
        foreach ($productos as $producto) {
            Producto::subir_producto($producto);
        }
        return true;
        
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}