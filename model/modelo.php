<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../connection/conexion.php';

interface Modelo{
    public static function __construct_desde_json($json);
    public static function publicar($producto);
}

class Producto implements Modelo{
    private $nombre;
    private $type;
    private $regular_price;
    private $description;
    private $short_description;
    private $categories;
    private $images;

    public function __construct($nombre, $type, $regular_price, $description, $short_description, $categories, $images){
        $this->nombre = $nombre;
        $this->type = $type;
        $this->regular_price = $regular_price;
        $this->description = $description;
        $this->short_description = $short_description;
        $this->categories = $categories;
        $this->images = $images;
    }

    /**
     * Creates an array of Producto objects from a JSON file.
     *
     * @param string $json The path to the JSON file.
     * @return array An array of Producto objects.
     */
    public static function __construct_desde_json($json)
    {
        $productos = json_decode(file_get_contents($json), true);
        //var_dump($productos);
        $productos = array_map(function ($producto) {
            return new Producto($producto['nombre'], $producto['type'], $producto['regular_price'], $producto['description'], $producto['short_description'], $producto['categories'], $producto['images']);
        }, $productos);
        //var_dump($productos);
        return $productos;
    }

    /**
     * Publishes a product to the WooCommerce API.
     *
     * @param object $producto The product object to be published.
     * @throws \Throwable if an error occurs while publishing the product.
     */
    public static function publicar($producto)
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

        try {
            $woocommerce->post("products",$data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}