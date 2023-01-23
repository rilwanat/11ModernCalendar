<?php
class Product{
 
    // database connection and table name
    private $conn;
    private $table_name = "civil_reg_table";

 
    // object properties
    public $reg_id;
    public $reg_date;
    public $reg_edited;
    public $reg_username;
    public $reg_password;
    public $reg_firstname;
    public $reg_lastname;
    public $reg_department;
    public $reg_birthday;
    public $reg_phone;
    public $reg_email;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function read(){
 
        // select all query
        $query = "SELECT
                    p.reg_id,
                    p.reg_date,
                    p.reg_edited,
                    p.reg_username,
                    p.reg_password,
                    p.reg_firstname,
                    p.reg_lastname,
                    p.reg_department,
                    p.reg_birthday,
                    p.reg_phone,
                    p.reg_email
                FROM
                    " . $this->table_name . " p
                    
                ORDER BY
                    p.reg_id DESC";
        
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }


    function create(){
 
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    reg_date=:reg_date,
                    reg_edited=:reg_edited,
                    reg_username=:reg_username, 
                    reg_password=:reg_password, 
                    reg_firstname=:reg_firstname, 
                    reg_lastname=:reg_lastname, 
                    reg_department=:reg_department,
                    reg_birthday=:reg_birthday, 
                    reg_phone=:reg_phone,
                    reg_email=:reg_email";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // bind values
        //$stmt->bindParam(":reg_id", $this->reg_id);
        $stmt->bindParam(":reg_date", $this->reg_date);
        $stmt->bindParam(":reg_edited", $this->reg_edited);
        $stmt->bindParam(":reg_username", $this->reg_username);
        $stmt->bindParam(":reg_password", $this->reg_password);
        $stmt->bindParam(":reg_firstname", $this->reg_firstname);
        $stmt->bindParam(":reg_lastname", $this->reg_lastname);
        $stmt->bindParam(":reg_department", $this->reg_department);
        $stmt->bindParam(":reg_birthday", $this->reg_birthday);
        $stmt->bindParam(":reg_phone", $this->reg_phone);
        $stmt->bindParam(":reg_email", $this->reg_email);
    
     
        // execute query
        if($stmt->execute()){
            return true;
        }
     
        return false;     
    }
    

}

//echo "good";
?>