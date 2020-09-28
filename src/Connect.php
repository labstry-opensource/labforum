<?php

use Medoo\Medoo;

class Connect{
    public $host = "127.0.0.1";
    public $username;
    public $password;
    public $database;

    function startPDOConnection($server, $username, $password, $database = null){
        //Connecting to the database via PDO
        $this->host = $server;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        try{
            if(!empty($this->database)){
                $connect = new PDO("mysql:host=".$this->host.";dbname=".$this->database.";charset=utf8mb4", $this->username, $this->password);
            }else{
                $connect = new PDO("mysql:host=".$this->host.";charset=utf8mb4", $this->username, $this->password);
            }

            //fallback for PHP prior to 5.3.6
            $connect->exec("SET names utf8mb4");

            //To prevent character displayed incorrectly, we must use utf-8


            return $connect;
        }
        catch(PDOException $e){
            echo "Cannot connect to database. Error: ".$e->getMessage();
        }

    }
    //This function support a wide range of SQL DBs.

    function connectDB($server, $username, $password, $database, $type = 'mysql'){
        return new Medoo(
            [
                // required
                'database_type' => $type,
                'database_name' => $database,
                'server' => $server,
                'username' => $username,
                'password' => $password,
            ]
        );
    }
}


$attribute = new Connect();
global $pdoconnect;
global $connection;

$pdoconnect = $attribute->startPDOConnection(DB_SERVER, DB_USERNAME, DB_PASSWORD, DATABASE);

$connection = $attribute->connectDB(DB_SERVER, DB_USERNAME, DB_PASSWORD, DATABASE, DB_TYPE);


/* mysqli connection part ends here...

   pdo connection starts...
 */

?>