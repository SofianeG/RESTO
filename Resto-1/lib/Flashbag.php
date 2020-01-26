<?php

class Flashbag
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        if(session_status()==PHP_SESSION_NONE)
        {
            session_start();
        }
        if(!array_key_exists("flashbag",$_SESSION))
        {
            $_SESSION["flashbag"]=[];
        }
    }
    public function addMessage(string $message)
    {
        $_SESSION["flashbag"][]=$message;
    }
    public function consumeAllMessages()
    {
        $allMessages = $_SESSION["flashbag"];
        $_SESSION["flashbag"]=[];
        return $allMessages;
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
            self::$instance = new Flashbag();
        }
        return self::$instance;
    }

}