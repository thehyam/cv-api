<?php
class Database {

/*
    private $host = 'localhost';
    private $db_name = 'myapi_db';
    private $username = 'root';
    private $password = '';
    private $conn;
*/
    private $host = 'studentmysql.miun.se';
    private $db_name = 'emha1904';
    private $username = 'emha1904';
    private $password = '6sktjehm';
    private $conn;

    // Connection 
    public function connect() {
        $this->conn = null;

        try {
          $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name,
          $this->username, $this->password, 
          array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          //echo 'connected';
        } catch(PDOException $e) {
          echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }

    public function closeDb() {
       $this->conn = null;
   }
}