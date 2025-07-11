<?php

namespace App\Config;

use App\Config\Abstract\Singleton;
use PDO;



class Database
{
  private $connection;
  protected static $instance = null;

  public static function getInstance()
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }
  protected function __construct()
  {
    try {
      $this->connection = new PDO(
        DSN,
        USER,
        PASSWORD
      );
      $this->connection->exec("SET NAMES 'UTF8'");
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
      throw new \Exception("Erreur de connexion : " . $e->getMessage());
    }
  }

  public function getConnection(): PDO
  {
    return $this->connection;
  }
}

//$repo = Database::getInstance()->getConnection();
