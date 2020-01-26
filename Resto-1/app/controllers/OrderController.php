<?php


class OrderController
{


    public function showBasketAction()
    {
        if (!UserSession::getInstance()->isAuthenticated())
        {
            Flashbag::getInstance()->addMessage("Merci de vous connecter pour consulter votre panier");
            return ["redirect" => "resto_user_login"];
        }

        $userId = UserSession::getInstance()->getId();
        $model = new OrderModel();

        $basketId = $model->findBasketIdOrCreate($userId) ;

        $orderDetailsModel = new OrderDetailsModel() ;
        $allOrderDetails = $orderDetailsModel->findBasket($basketId) ;

        $totalPrice = 0 ;
        foreach ($allOrderDetails as $orderDetail)
        {
            $totalPrice += $orderDetail["priceEach"] * $orderDetail["quantity"] ;
        }

        return[
            "template"=>
                [
                    "folder" => "order",
                    "file" => "basket",
                ],
            "allOrderDetails" => $allOrderDetails,
            "basketId" => $basketId,
            "totalPrice" => $totalPrice,
            "neededScripts"=>
                [
                    "ajaxRemove.js",
                ],


        ];

    }

    public function addToBasketAction()
    {
        //Si il faut etre connecter pour acceder à la page:
        if (!UserSession::getInstance()->isAuthenticated())
        {
            Flashbag::getInstance()->addMessage("Veuillez vous connecter afin de commander");
            return ["redirect" =>"resto_user_login"];
        }

        if(isset($_GET['id']) && ctype_digit($_GET['id']))
        {
            $menuId = $_GET['id'] ;
            $userId = UserSession::getInstance()->getId() ;

            $menuModel = new MenuModel();
            try
            {
                $menuPrice = $menuModel->findPrice($menuId) ;
            }
            catch (DomainException $e)
            {
                Flashbag::getInstance()->addMessage($e->getMessage());
                return ["redirect" => "resto_menu_showall"] ;
            }

            $model = new OrderModel();
            $basketId = $model->findBasketIdOrCreate($userId) ;

            $orderDetailsModel = new OrderDetailsModel() ;
            $orderDetailsModel->AddMenuToBasketOrIncrementQuantity($menuId, $basketId, $menuPrice) ;

            Flashbag::getInstance()->addMessage("bien ajouté à la commande");

        }

        return ["redirect" => "resto_menu_showall"] ;

    }



    public function removeFromBasketAction()
    {
        //Si il faut etre connecter pour acceder à la page:
        if (!UserSession::getInstance()->isAuthenticated())
        {
            Flashbag::getInstance()->addMessage("Veuillez vous connecter afin de commander");
            return ["redirect" =>"resto_user_login"];
        }

        $userId = UserSession::getInstance()->getId() ;

        $orderDetailsModel = new OrderDetailsModel();
        $model = new OrderModel();

        $basketId = $model->findBasketIdOrCreate($userId) ;
        $menuId = $_GET['id'] ;

        $orderDetailsModel->removeFromBasket($menuId, $basketId);

        return ["jsonResponse" => true];

    }

    public function emptyBasketAction()
    {
        if (!UserSession::getInstance()->isAuthenticated())
        {
            Flashbag::getInstance()->addMessage("Veuillez vous connecter afin de commander");
            return ["redirect" =>"resto_user_login"];
        }

        $userId = UserSession::getInstance()->getId();
        $model = new OrderModel() ;
        $model->emptyBasketByUser($userId) ;

        return ["redirect" => "resto_order_show"] ;

    }

    public function validateAction()
    {
        if (!UserSession::getInstance()->isAuthenticated())
        {
            Flashbag::getInstance()->addMessage("Veuillez vous connecter afin de commander");
            return ["redirect" =>"resto_user_login"];
        }

        $userId = UserSession::getInstance()->getId();
        $model = new OrderModel();
        $basketId = $model->findBasketIdOrCreate($userId);


        $model->confirmOrder($basketId);

        Flashbag::getInstance()->addMessage("Bon appétit !");

        return ["redirect" => "resto_home_main"] ;

    }
}