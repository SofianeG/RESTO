<?php


class DishController
{

    public function showAllAction()
    {
        $model = new DishModel();
        $allDishes = $model->findAll();

        return [
                    "template"=>
                        [
                            "folder"=>"dish",
                            "file"=>"showAll",
                        ],
                    "allDishes" =>$allDishes,

                    "neededScripts" =>
                    [
                        "ajaxRemove.js",
                    ],
                ];
    }

    public function showAllImagesAction()
    {
        $model = new DishModel();
        $allDishes = $model->findAllImages();

        return [
            "template"=>
                [
                    "folder"=>"home",
                    "file"=>"main",
                ],
            "allDishes" =>$allDishes,

            "neededScripts" =>
                [
                    "ajaxRemove.js",
                ],
        ];
    }

    public function showAction()
    {

        if(isset($_GET['id']) && ctype_digit($_GET['id']) )
        {

            $model = new DishModel();
            $dish = $model->find($_GET['id']);

            if(!$dish)
            {
                return [ "redirect" => "resto_dish_showall"] ;
            }

            return  [
                "template"=>
                    [
                        "folder"=>"dish",
                        "file"=>"show",
                    ],
                "dish" =>$dish,
            ];
        }
        else
        {
            return [ "redirect" => "resto_dish_showall"] ;
        }

    }

    public function createAction()
    {

        //Si il faut etre admin pour acceder à la page:
        if (!UserSession::getInstance()->isAdmin())
        {
            return ["redirect" =>"resto_home_main"];
        }



        if(!$_POST)
        {
            return [
                "template"=>
                    [
                        "folder"=>"dish",
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
            //var_dump($_FILES);

            if(isset($_POST["title"]) && strlen(trim($_POST["title"]))>2
                && isset($_POST["description"]) && strlen(trim($_POST["description"]))>250
                && isset($_POST["price"]) && filter_var($_POST["price"],FILTER_VALIDATE_FLOAT)
                && isset($_POST["category"]) && $_POST["category"] !== "-1"
            )
            {
                $title = trim($_POST["title"]) ;
                $description = trim($_POST["description"]);
                $price = $_POST["price"];
                $category = $_POST["category"];

                $model = new DishModel();
                $id = $model->create($title, $description, $price, $category) ;

                $fileHelper = new FileHelper();

                if($fileHelper->hasValidUploadedFile("image"))
                {
                    $baseName = "dish_$id";
                    $newName = $fileHelper->saveUploadedFile("image",$baseName,"dish");

                    $model->updateImage($id, $newName) ;
                }

                Flashbag::getInstance()->addMessage("Le plat $title à bien été ajouté");

                return ["redirect" => "resto_dish_showall"] ;

            }
            else{
                var_dump("données invalides.");
                die();
            }

        }
    }

    public function updateAction()
    {
        if(isset($_GET['id']) && ctype_digit($_GET['id']) )
        {

            $model = new DishModel();
            $dish = $model->find($_GET['id']);

            if (!$dish)
            {
                return ["redirect" => "resto_dish_showall"];
            }
            return [
                "template"=>
                    [
                        "folder"=>"dish",
                        "file"=>"update",
                    ],
                "dish" => $dish,
                "neededScripts"=>
                    [
                        "FormValidator.class.js",
                    ],
            ];

        }
        elseif($_POST)
        {
            if( isset($_POST["title"]) && strlen(trim($_POST["title"]))>2
                && isset($_POST["description"]) && strlen(trim($_POST["description"]))>250
                && isset($_POST["price"]) && filter_var($_POST["price"],FILTER_VALIDATE_FLOAT)
                && isset($_POST["category"]) && $_POST["category"] !== "-1"
                && isset($_POST['id']) && ctype_digit($_POST['id'])
            )
            {
                $title = trim($_POST["title"]) ;
                $description = trim($_POST["description"]);
                $id = $_POST['id'] ;

                $model = new DishModel();
                $dish = $model->find($id) ;
                $model->update($id, $title, $_POST["category"], $_POST["price"], $description) ;
                $fileHelper = new FileHelper() ;

                if(isset($_POST["suppr-image"]) || $fileHelper->hasValidUploadedFile("image") )
                {
                    if($dish["image"])
                    {
                        $fileHelper->removeImage($dish['image'], "dish");
                        if(! $fileHelper->hasValidUploadedFile("image") )
                        {
                            $model->updateImage($id, "") ;
                        }
                    }
                }

                if($fileHelper->hasValidUploadedFile("image"))
                {
                    $baseName = "dish_$id";
                    $newName = $fileHelper->saveUploadedFile("image",$baseName,"dish");

                    $model->updateImage($id, $newName) ;
                }


                Flashbag::getInstance()->addMessage("Le plat $title bien mise à jour");

                return [ "redirect" => "resto_dish_showall"] ;
            }
            else
            {
                echo(" données invalides ");
                var_dump($_POST);
                die() ;
            }
        }
        /*
         *  elseif ($_POST)
        {
            $error = false;
            if (!isset($_POST["title"]) || strlen(trim($_POST["title"])) < 3)
            {
                Flashbag::getInstance()->addMessage("Merci d'entrer un nom de plat de plus de 3 caractères");
                $error = true;
            }

            if (!isset($_POST["description"]) || strlen(trim($_POST['description'])) < 255)
            {
                Flashbag::getInstance()->addMessage("Merci d'entrer une description de plat de plus de 255 caractères");
                $error = true;
            }

            if (!isset($_POST['price']) || !filter_var($_POST['price'], FILTER_VALIDATE_FLOAT))
            {

                Flashbag::getInstance()->addMessage("Merci d'entrer un prix valide");
                $error = true;
            }

            if (!isset($_POST['category']) || $_POST['category'] === "-1")
            {
                Flashbag::getInstance()->addMessage("Merci de choisir une catégorie");
                $error = true;
            }

            if (!isset($_POST['id']) || !ctype_digit($_POST['id']))
            {
                $error = true;
            }

            if (!$error)
            {
                $title = trim($_POST['title']);
                $description = trim($_POST['description']);

                $model = new DishModel();
                $dish = $model->find($_POST ['id']);

                $model->update($_POST['id'], $title, $description, $_POST["price"], $_POST['category']);

            }
        }
         $title = trim($_POST["title"]);
        $description = trim($_POST["description"]);
        $price = $_POST["price"];
        $category = $_POST["category"];
        $id = $_POST["id"];
        $model = new DishModel();
        $dish = $model->find($id);
        $model->update($title, $description, $price, $category, $id);

        $fileHelper = new FileHelper();

            if(isset($_POST['img-suppr']) || $fileHelper->hasValidUploadedFile("image"))
            {
                if ( $dish['image'])
                {

                    $fileHelper->removeImage($dish["image"], "dish");
                    if(! $fileHelper->hasValidUploadedFile("image") )
                    {
                        $model->updateImage($id, "") ;
                    }
                }
            }


            if($fileHelper->hasValidUploadedFile("image"))
                {
                    $baseName = "dish_".$id;
                    $newName = $fileHelper->saveUploadedFile("image",$baseName, "dish");
                    $model->updateImage( $id, $newName);

                }
        Flashbag::getInstance()->addMessage("plat $title bien mis à jour");
        return ["redirect" => "resto_dish_showall"];


    }
         */
        else
        {
            var_dump('ni $_GET["id"] ni $_POST') ;
            die();
        }
    }

    public function removeAction()
    {
        if(isset($_GET['id']) && ctype_digit($_GET['id']))
        {
            $model = new DishModel();
            $dish = $model->find($_GET['id']) ;

            if($dish["image"])
            {
                $fileHelper = new FileHelper();
                $fileHelper->removeImage($dish['image'], "dish");
            }

            $model->remove($_GET["id"]);


            return ["jsonResponse"=> true];
        }

    }



}
