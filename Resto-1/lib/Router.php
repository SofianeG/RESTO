<?php

class Router
{
    private static $instance = null;
    private $allRoutes =
        //appel le controller
        [
            //---------------------------- MAIN ----------------------------//
            "/"=>
            //acceder au main
                [
                    "controller"=> "Home",
                    "method"=>"main",
                    "name"=>"resto_home_main",
                ],
            //---------------------------- DISH ----------------------------//
            "/plat"=>
                [
                    "controller"=> "Dish",
                    "method"=>"showAll",
                    "name"=>"resto_dish_showall",
                ],
            "/plat/afficher"=>
                [
                    "controller"=> "Dish",
                    "method"=>"show",
                    "name"=>"resto_dish_show",
                ],

            "/plat/ajouter"=>
                [
                    "controller"=> "Dish",
                    "method"=>"create",
                    "name"=>"resto_dish_create",
                ],
            "/plat/modifier"=>
                [
                    "controller"=>"Dish",
                    "method"=>"update",
                    "name"=>"resto_dish_update",
                ],
            "/plat/effacer"=>
                [
                    "controller"=>"Dish",
                    "method"=>"remove",
                    "name"=>"resto_dish_remove",
                ],
            //---------------------------- MENU ----------------------------//
            "/menu"=>
                [
                    "controller"=> "Menu",
                    "method"=>"showAll",
                    "name"=>"resto_menu_showall",
                ],
            "/menu/afficher"=>
                [
                    "controller"=> "Menu",
                    "method"=>"show",
                    "name"=>"resto_menu_show",
                ],

            "/menu/ajouter"=>
                [
                    "controller"=> "Menu",
                    "method"=>"create",
                    "name"=>"resto_menu_create",
                ],
            "/menu/modifier"=>
                [
                    "controller"=>"Menu",
                    "method"=>"update",
                    "name"=>"resto_menu_update",
                ],
            "/menu/effacer"=>
                [
                    "controller"=>"Menu",
                    "method"=>"remove",
                    "name"=>"resto_menu_remove",
                ],

            //---------------------------- USER ----------------------------//
            "/inscription"=>
                [
                    "controller"=>"User",
                    "method"=>"create",
                    "name"=>"resto_user_create",
                ],
            "/inscription/modifier"=>
                [
                    "controller"=>"User",
                    "method"=>"update",
                    "name"=>"resto_user_update",
                ],
            "/login"=>
                [
                    "controller"=> "User",
                    "method"=> "login",
                    "name"=> "resto_user_login",
                ],
            "/logout"=>
                [
                    "controller"=> "User",
                    "method"=> "logout",
                    "name"=> "resto_user_logout",
                ],


            //---------------------------- BOOKING ----------------------------//
            "/reservation"=>
                [
                    "controller"=>"Booking",
                    "method"=>"create",
                    "name"=>"resto_booking_create",
                ],

            //---------------------------- ORDER ----------------------------//
            "/panier"=>
                [
                    "controller"=>"Order",
                    "method"=>"showBasket",
                    "name"=>"resto_order_show",
                ],

            "/ajouter-au-panier"=>
                [
                    "controller"=>"Order",
                    "method"=>"addToBasket",
                    "name"=>"resto_order_addtobasket",
                ],

            "/panier/vider"=>
                [
                    "controller"=>"Order",
                    "method"=>"emptyBasket",
                    "name"=>"resto_order_emptybasket",
                ],

            "/supprimer-du-panier"=>
                [
                    "controller"=>"Order",
                    "method"=>"removeFromBasket",
                    "name"=>"resto_order_remove",
                ],
            "/validation-du-panier"=>
                [
                    "controller"=>"Order",
                    "method"=>"validate",
                    "name"=> "resto_order_validation"
                ],
            //---------------------------- ADMIN ----------------------------//

            "/administrateur"=>
                [
                    "controller"=>"Admin",
                    "method"=>"interface",
                    "name"=>"resto_admin_interface",
                ],
             "/administrateur/detail-des-commandes"=>
                [
                    "controller"=>"Admin",
                    "method"=>"showAllOrder",
                    "name"=>"resto_admin_showallorder",
                ],
            "/administrateur/detail-des-reservations"=>
                [
                    "controller"=>"Admin",
                    "method"=>"showAllBooking",
                    "name"=>"resto_admin_showallbooking",
                ],
            "/administrateur/detail-des-utilisateurs"=>
                [
                    "controller"=>"Admin",
                    "method"=>"showAllUser",
                    "name"=>"resto_admin_showalluser",
                ],

        ];
    private $allUrls;//keys
    private $rootUrl;
    private $wwwPath;
    private $localhostPath;

    public function getRoute($requestPath)
    {
        if(isset($this->allRoutes[$requestPath]))
        {
            return $this->allRoutes[$requestPath];
        }else
        {
            throw new ErrorException("pas de route trouvé pour l'url:\"$requestPath\"");
        }
    }
    private function __construct()
    {
        $this->rootUrl = $_SERVER["SCRIPT_NAME"];
        $this->wwwPath = dirname($this->rootUrl)."/www";
        $this->localhostPath = $_SERVER["DOCUMENT_ROOT"];
        $this->allUrls =[];
        foreach ($this->allRoutes as $url=>$route)
        {
            $this->allUrls[$route["name"]] = $url;
        }
    }
    public function generateUrl($routeName)
    {
        if (isset($this->allUrls[$routeName]))
        {
            return $this->rootUrl.$this->allUrls[$routeName];
        }
        else
        {
            throw new ErrorException("pas de route\"$routeName\" dans le router");
        }
    }
    public function getWwwPath($absolute = false)
    {
        if ($absolute)
        {
            return $this->localhostPath.$this->wwwPath;
        }
        else
        {
            return $this->wwwPath;
        }
    }
    public static function getInstance()
    {
        if (self::$instance === null)
        {
            self::$instance = new Router();
        }
        return self::$instance;
    }
}