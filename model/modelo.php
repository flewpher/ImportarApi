<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/connection/conexion.php';

class Modelo{
    protected $nombre;
    protected $type;
    protected $regular_price;
    protected $description;
    protected $short_description;
    protected $categories;
    protected $images;

    public function __construct($nombre, $type, $regular_price, $description, $short_description, $categories, $images){
        $this->nombre = $nombre;
        $this->type = $type;
        $this->regular_price = $regular_price;
        $this->description = $description;
        $this->short_description = $short_description;
        $this->categories = $categories;
        $this->images = $images;
    }
}