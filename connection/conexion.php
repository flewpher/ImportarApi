<?php
require __DIR__ . '/../vendor/autoload.php';
use Automattic\WooCommerce\Client;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__."/..");
$dotenv->load();


Class Conexion{
  private static $instance = null;

  public static function getConexion(){

    
    if (self::$instance == null) {
      try {
        self::$instance = new Client(
          $url=$_ENV["URL"],
          $consumer_key=$_ENV["CONSUMER_KEY"],
          $consumer_secret=$_ENV["CONSUMER_SECRET"],
          [
            'version' => 'wc/v3',
          ]
        );
      } catch (Exception $e) {
        echo $e->getMessage();
      }
    }
    return self::$instance;
  }

}