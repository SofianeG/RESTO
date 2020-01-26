<?php

abstract class AbstracModel
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getPdo();
    }
}
