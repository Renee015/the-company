<?php
//レシピ
//connection to the database

//★★ここ(class Database)では、PHPとmysqlを繋げる動きに関する手順（method）
//website内でのユーザーができる動き以外★★

class Database
{
    private $server_name  = "localhost";
    private $username      = "root";
    private $password     = "root";
    private $db_name      = "the_company"; //the same name as the database we use
    protected $conn; 

    //don't need to add parameter since we have variable in the class
    public function __construct()
    {
        //it's just a connection between PHP and Database
        $this->conn = new mysqli($this->server_name, $this->username, $this->password, $this->db_name);
        //$this->conn holds the connection to the db

        if($this->conn->connect_error){
            die("Unable to connect to the database: ". $this->conn->connect_error);
        }
    }
}

?>