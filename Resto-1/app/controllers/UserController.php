<?php


class UserController
{
    public function createAction()
    {
        if (!$_POST)
        {
            return [
                "template"=>
                    [
                        "folder"=>"user",
                        "file"=>"create",
                    ],
                "neededScripts"=>
                    [
                        "FormValidator.class.js",
                    ],
            ];
        }
        else
        {
            var_dump($_POST);
//            die() ;
            if(isset($_POST["forname"]) && strlen(trim($_POST["forname"]))>=2
                && isset($_POST["lastname"]) && strlen(trim($_POST["lastname"]))>=2
                && isset($_POST["address"]) && strlen(trim($_POST["address"]))>10
                && isset($_POST["num-tel"]) && strlen(trim($_POST["num-tel"]))>9
                && isset($_POST["email"]) && filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)
                && isset($_POST["pwd"]) && strlen($_POST["pwd"]) >= 8
                && isset($_POST["pwd-check"]) && $_POST["pwd-check"] == $_POST["pwd"]
            )
            {
                $forname = trim($_POST["forname"]) ;
                $lastname = trim($_POST["lastname"]) ;
                $email = trim($_POST["email"]) ;
                $numTel = $_POST["num-tel"];
                $adress = trim($_POST["address"]) ;
                $password = trim($_POST["pwd"]);

                $model = new UserModel();
                try
                {
                    $id = $model->create($forname, $lastname, $adress, $numTel,  $email,  $password) ;
                }
                catch (DomainException $e)
                {
                    Flashbag::getInstance()->addMessage($e->getMessage());
                    return ["redirect" => "resto_user_create"] ;
                }


                $fileHelper = new FileHelper();

                if($fileHelper->hasValidUploadedFile("image"))
                {
                    $baseName = "user_$id";
                    $newName = $fileHelper->saveUploadedFile("image",$baseName,"user");

                    $model->updateImage($id, $newName) ;
                }

                Flashbag::getInstance()->addMessage("L'utilisateur $forname $lastname à bien été ajouté");

                return ["redirect" => "resto_home_main"] ;

            }
            else{
                var_dump("données invalides.");
                die();
            }
        }
    }

    public function  loginAction()
    {
        if(!$_POST)
        {
            return [
                "template"=>
                    [
                        "folder"=>"user",
                        "file"=>"login",
                    ],
            ];
        }
        else
        {
            if( isset($_POST["email"]) && isset($_POST["password"]) )
            {


                $model = new UserModel();
                try
                {
                    $user = $model->findByEmailAndCheckPassword($_POST["email"], $_POST["password"]) ;
                }
                catch (DomainException $e)
                {
//                    Flashbag::getInstance()->addMessage($e->getMessage());
                    Flashbag::getInstance()->addMessage("Nom d'utilisateur ou mot de passe inconnu");
                    return ["redirect" => "resto_user_login"] ;
                }

                UserSession::getInstance()->create($user["id"], $user["forname"],$user["lastname"],$user["email"], $user["isAdmin"]);
//                var_dump($user);
//                die() ;


                return ["redirect" => "resto_home_main"] ;

            }
            else{
                var_dump("données invalides.");
                die();
            }

        }
    }

    public function logoutAction()
    {
        UserSession::getInstance()->kill();
        return ["redirect" => "resto_home_main"] ;
    }


}