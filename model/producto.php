<?php
require __DIR__ . "model/modelo.php";

class Producto extends Modelo
{
    public function __construct($nombre, $type, $regular_price, $description, $short_description, $categories, $images)
    {
        parent::__construct($nombre, $type, $regular_price, $description, $short_description, $categories, $images);
    }

    public static function __constuct_desde_json($json)
    {
        $productos = json_decode(file_get_contents($json), true);
        $productos = array_map(function ($producto) {
            return new Producto($producto['nombre'], $producto['type'], $producto['regular_price'], $producto['description'], $producto['short_description'], $producto['categories'], $producto['images']);
        }, $productos);
        return $productos;
    }

    public static function subir_producto(Producto $producto)
    {
        $woocommerce = Conexion::getConexion();
        $data = [
            'name' => $producto->nombre,
            'type' => $producto->type,
            'regular_price' => $producto->regular_price,
            'description' => $producto->description,
            'short_description' => $producto->short_description,
            'categories' => $producto->categories,
            'images' => $producto->images
        ];
        $woocommerce->post('products', $data);
    }
}
