<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../connection/conexion.php';

interface Modelo
{
    public static function __construct_desde_json(string $json);
    public static function publicar($producto);
}

class Producto implements Modelo
{
    private $nombre;
    private $sku;
    private $type;
    private $regular_price;
    private $description;
    private $short_description;
    private $categories;
    private $images;

    public function __construct($nombre, $sku, $type, $regular_price, $description, $short_description, $categories, $images)
    {
        $this->nombre = $nombre;
        $this->sku = $sku;
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
    public static function __construct_desde_json(string $json): array|bool
    {
        $productos = json_decode(file_get_contents($json), true);
        //var_dump($productos);
        $productos = array_map(function ($producto) {
            return new Producto($producto['nombre'], $producto["sku"], $producto['type'], $producto['regular_price'], $producto['description'], $producto['short_description'], $producto['categories'], $producto['images']);
        }, $productos);
        //var_dump($productos);
        return $productos;
    }


    public static function publicar($producto)
    {
        $woocommerce = Conexion::getConexion();
        $comprobar = false;

        $data = [
            'name' => $producto->nombre,
            "sku" => $producto->sku,
            'type' => $producto->type,
            'regular_price' => $producto->regular_price,
            'description' => $producto->description,
            'short_description' => $producto->short_description,
            'categories' => $producto->categories,
            'images' => $producto->images
        ];

        try {
            $comprobar = $woocommerce->get('products', array("sku" => $producto->sku));
            if (!empty($comprobar)) {
                $comprobar = true;
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        if (!$comprobar) {
            try {
                $woocommerce->post('products', $data);
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }
}