<?php


namespace App\Application\Object;

use PDO;
use PDOException;

class Database
{
    private $dbName = "";
    private $host = "";
    private $user = "";
    private $password = "";

    public function __construct()
    {
        $this->dbName = 'pqsg_IoT';
        $this->host = 'pqsg.myd.infomaniak.com';
        $this->user = 'pqsg_Schathe';
        $this->password = 'jemange2pommes';
    }

    /**
     * Cette fonction créé une instance de base de donnée
     * @return PDO|null contient l'objet pdo nécessaire au requètes
     */
    public function getConnection () {
        $connection = null;

        try{
            $connection = new PDO('mysql:host='. $this->host .';dbname=' . $this->dbName, $this->user, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $connection;
    }
}