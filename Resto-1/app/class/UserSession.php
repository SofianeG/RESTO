<?php


class UserSession
{
    private static $instance = null;

    private function __construct()
    {
        if (session_status() == PHP_SESSION_NONE)
        {
            session_start();
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null)
        {
            self::$instance = new UserSession();
        }
        return self::$instance;
    }

    public function create($id, $forname, $lastname, $email, $isAdmin)
    {
        $_SESSION["user"] = ["id"=> $id,
                             "forname"=> $forname,
                             "lastname"=> $lastname,
                             "email"=> $email,
                             "isAdmin"=> $isAdmin,
                            ];
    }

    public function kill()
    {
        $_SESSION = [];
        session_destroy();
    }

    public function isAuthenticated()
    {
        return isset($_SESSION["user"]);
    }

    public  function isAdmin()
    {
        if (!$this->isAuthenticated())
        {
            return false;
        }

        return $_SESSION["user"]["isAdmin"];
    }

    public  function getId()
    {
        if (!$this->isAuthenticated())
        {
            return false;
        }

        return $_SESSION["user"]["id"];
    }

    public  function getForname()
    {
        if (!$this->isAuthenticated())
        {
            return false;
        }

        return $_SESSION["user"]["forname"];
    }

    public  function getLastname()
    {
        if (!$this->isAuthenticated())
        {
            return false;
        }

        return $_SESSION["user"]["lastname"];
    }

    public  function getEmail()
    {
        if (!$this->isAuthenticated())
        {
            return false;
        }

        return $_SESSION["user"]["email"];
    }
}
