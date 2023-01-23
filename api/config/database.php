<?php
class Database{
 
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "my_demos";
    private $username = "croot";//"mydemosuser";//
    private $password = "sroot";//"akELd4oRiL9k";//
    public $conn;
 
    // get the database connection
    public function getConnection(){
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");            
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
    
}

//echo "good";
?>