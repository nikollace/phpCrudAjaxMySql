<?php 

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

class Database{
  private $host = "localhost"; // Host
  private $db_name = "itehphp"; // DB Name
  private $username = "root"; // DB Username
  private $password = ""; // DB Password

  private static $instance = null; // Instanca klase
  public $connection = null; // Konekcija

  private function __construct() {
    //PDO uspostavlja konekciju izmedju PHP i database server
    try {
      $this->connection = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name . ';charset=utf8mb4', $this->username, $this->password);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      echo "<p class='alert mb-0 alert-danger'>PDO EXCEPTION: " . $e->getMessage() . "</p>";

      exit();
    }

    // $this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
  }

  public function getConnection(){
      return $this->connection;
  }
  
  public static function getInstance(){
      if(!isset(self::$instance)){
          self::$instance = new Database();
      }

      return self::$instance;
  }   
}

