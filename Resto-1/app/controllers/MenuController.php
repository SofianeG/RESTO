<?php

class MenuController
{
    public function showAllAction()
    {
        $model = new MenuModel();
        $allMenus = $model->findAll();

        $dishModel = new DishModel();
//        $allDishesRaw = $dishModel->findAllByMenu();
        $allDishesRaw = $dishModel->findAllDishesForAllMenus();
        $allDishes = [] ;
        $allPrices = [] ;
        foreach ($allDishesRaw as $dish)
        {
            $allDishes[$dish["menu_id"]][] = $dish ;

            if(isset($allPrices[$dish["menu_id"]] ))
            {
                $allPrices[$dish["menu_id"]]["price"] += $dish['quantity'] * $dish['price'] ;
                $allPrices[$dish["menu_id"]]["quantity"] += $dish['quantity'] ;
            }
            else
            {
                $allPrices[$dish["menu_id"]]["price"] = $dish['quantity'] * $dish['price'] ;
                $allPrices[$dish["menu_id"]]["quantity"] = $dish['quantity'] ;
            }

        }

        return [
                    "template" =>
                        [
                            "folder" => "menu",
                            "file" => "showAll",
                        ],
                    "allMenus" => $allMenus,
                    "allDishes" => $allDishes,
                    "allPrices" => $allPrices,
                    "neededScripts"=>
                        [
                            "FormValidator.class.js",
                            "ajaxRemove.js",
                            "Basket.class.js",
                        ],

        ];
    }


    public function showAction()
    {

        if(isset($_GET['id']) && ctype_digit($_GET['id']) )
        {

            $model = new MenuModel();
            $menu = $model->find($_GET['id']);
            $dishModel = new DishModel() ;
            $allDishes = $dishModel->findAllAndQuantityByMenu($_GET['id']) ;

            if($menu["forcedPrice"])
            {
                $price  = $menu["forcedPrice"] ;
            }
            else
            {
                $price = 0;
                foreach ($allDishes as $dish)
                {
                    $price += $dish["quantity"] * $dish["price"] ;
                }
            }


            if(!$menu)
            {
                return [ "redirect" => "resto_menu_showall"] ;
            }

            return  [
                "template"=>
                    [
                        "folder"=>"menu",
                        "file"=>"show",
                    ],
                "menu" =>$menu,
                "price" =>$price,
                "allDishes" =>$allDishes,
            ];
        }
        else
        {
            return [ "redirect" => "resto_menu_showall"] ;
        }

    }

    public function createAction()
    {
         //Si il faut etre admin pour acceder à la page:

        if (!UserSession::getInstance()->isAdmin())
        {
            return ["redirect" =>"resto_home_main"];
        }

        //Si doit etre seulement connecté:

        if (!UserSession::getInstance()->isAuthenticated())
        {
            Flashbag::getInstance()->addMessage("Veuillez vous connecter pour acceder à cette page");
            return ["redirect"=>"resto_user_login"];
        }


        if (!$_POST)
        {
            $dishModel = new DishModel();
            $allDishes = $dishModel->findAllIdsAndTitles();
            return [
                        "template" =>
                            [
                                "folder" => "menu",
                                "file" => "create",
                            ],
                        "allDishes" => $allDishes,
                        "neededScripts"=>
                            [
                                "FormValidator.class.js",
                            ],
                    ];
        }
        else
        {
            if (isset($_POST["title"]) && strlen(trim($_POST["title"])) > 2
                && isset($_POST["description"]) && strlen(trim($_POST['description'])) >= 150
                && isset($_POST['price']) && isset($_POST['dish-ids']) && count($_POST['dish-ids']) > 1)
            {


                $title = trim($_POST['title']);
                $description = trim($_POST['description']);
                $forcedPrice = 0;
                if (filter_var($_POST["price"], FILTER_VALIDATE_FLOAT))
                {
                    $forcedPrice = $_POST["price"];
                }


                $model = new MenuModel();
                $id = $model->create($title, $description, $forcedPrice);

                $dishQuantitiesByIds = [];
                foreach ($_POST['dish-ids'] as $dishId)
                {
                    $dishQuantitiesByIds[$dishId] = $_POST[$dishId . "-quantity"];
                }

                $model->addDishes($id, $dishQuantitiesByIds);

                $fileHelper = new FileHelper();

                if ($fileHelper->hasValidUploadedFile("image"))
                {
                    $baseName = "menu_$id";
                    $newName = $fileHelper->saveUploadedFile("image", $baseName, "menu");
                    $model->updateImage($id, $newName);
                }

                Flashbag::getInstance()->addMessage("le menu $title a bien été ajouté");

                return ["redirect" => "resto_menu_showall"];


            }
            else
            {
                var_dump("données invalides");
                // die() ;
            }
        }
    }

    public function updateAction()
    {
        $model = new MenuModel();
        $dishModel = new DishModel();

        if (isset($_GET['id']) && ctype_digit($_GET['id']))
        {

            $menu = $model->find($_GET["id"]);
            if(!$menu)
            {
                ["redirect" => "resto_menu_showall"];
            }

            $allDishes = $dishModel->findByMenuAndChecked($menu['id']) ;

            return [
                "template" =>
                    [
                        "folder" => "menu",
                        "file" => "update",
                    ],
                "menu" => $menu,
                "allDishes" => $allDishes,
                "neededScripts"=>
                    [
                        "FormValidator.class.js",
                    ],
            ];
        }
        elseif($_POST)
        {
            $error = false;
            if (!isset($_POST["title"]) || strlen(trim($_POST["title"])) < 3)
            {
                Flashbag::getInstance()->addMessage("Merci d'entrer un nom de menu de plus de 3 caractères");
                $error = true;
            }

            if (!isset($_POST["description"]) || strlen(trim($_POST['description'])) < 250)
            {
                Flashbag::getInstance()->addMessage("Merci d'entrer une description de menu de plus de 255 caractères");
                $error = true;
            }

            if (!isset($_POST['price']))
            {
                Flashbag::getInstance()->addMessage("Merci d'entrer un prix valide");
                $error = true;
            }

            if (!isset($_POST['dish-ids']) || count($_POST['dish-ids']) < 2)
            {
                Flashbag::getInstance()->addMessage("Merci de choisir au moins deux plats");
                $error = true;
            }


            if (!isset($_POST['id']) || !ctype_digit($_POST['id']))
            {
                $error = true;
            }

            if ($error)
            {
                return  ["redirect" => "resto_menu_showall"];
            }



            $id= $_POST['id'];
            $title = trim($_POST['title']);
            $description = trim($_POST['description']);
            $price= 0 ;
            if(filter_var($_POST["price"], FILTER_VALIDATE_FLOAT))
            {
                $price = $_POST["price"] ;
            }



            $menu = $model->find($id);
            $oldDishes = $dishModel->findScalarIdsFromMenu($id);

            //CORRIGER
            $model->update($id, $title, $price, $description);


            // ajout des nouveaux plats, mise à jour de la quantité de ceux déjà présents
            $dishQuantitiesByIds = [];
            foreach ($_POST['dish-ids'] as $dishId)
            {
                $dishQuantitiesByIds[$dishId] = $_POST[$dishId . "-quantity"];
            }
            $model->addDishes($id, $dishQuantitiesByIds);

            //suppression des plats décochés
            $dishesToRemove = array_diff($oldDishes, $_POST["dish-ids"]) ;
            $model->removeDishes($id, $dishesToRemove) ;


            $fileHelper = new FileHelper();
            if(isset($_POST['img-suppr']) || $fileHelper->hasValidUploadedFile("image"))
            {
                if($menu['image'])
                {
                    $fileHelper->removeFile($menu['image'], "menu");
                    $model->updateImage($id, "") ;
                }
            }

            if($fileHelper->hasValidUploadedFile("image"))
            {
                $baseName = "menu_".$id ;
                $newName = $fileHelper->saveUploadedFile("image", $baseName, "menu" ) ;
                $model->updateImage($id, $newName) ;
            }


            Flashbag::getInstance()->addMessage("Le menu $title bien mis à jour");
            return  ["redirect" => "resto_menu_showall"];
        }


    }


    public function removeAction()
    {
        if (isset($_GET['id']) && ctype_digit($_GET['id']))
        {
            $model = new MenuModel();
            $menu = $model->find($_GET['id']);

            if ($menu['image'])
            {
                $fileHelper = new FileHelper();
                $fileHelper->removeImage($menu['image'], "menu");

            }
            $model->remove($_GET["id"]);

            Flashbag::getInstance()->addMessage("menu \"".$menu['title']."\" supprimé");
        }

        return ["jsonResponse" => true];
    }

}

