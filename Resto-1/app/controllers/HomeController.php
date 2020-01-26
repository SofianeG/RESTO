<?php

class HomeController
{
    public function mainAction()
    {
        return [
                "template"=>
                [
                    "folder"=>"home",
                    "file"=>"main",
                ],
        ];
    }
}