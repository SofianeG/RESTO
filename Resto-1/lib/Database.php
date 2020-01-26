<?php

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $this->pdo = new PDO
        (
            "mysql:host=localhost;dbname=Resto_DB; 
             charset=UTF8",
             "root",
             "",
            [
                PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
            ]
        ) ;
    }
    public function getPdo()
    {
        return $this->pdo;
    }
    // $_SESSION tableau qui regarde l utilisateur en cours de connexion POUR SUPPRIMER LES MESSAGE D ERREUR
    public static function getInstance()
    {
        if(self::$instance === null)
        {
            self::$instance = new Database();
        }
        return self::$instance;
    }

}