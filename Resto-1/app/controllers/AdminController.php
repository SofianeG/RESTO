<?php


class AdminController
{
    public function interfaceAction()
    {
        if (!UserSession::getInstance()->isAdmin())
        {
            return ["redirect" => "resto_home_main"];
        }

        $allOrders  = new AdminModel();
        $order = $allOrders->findAllOrders();

        $allBooking = new AdminModel();
        $booking = $allBooking->findAllBooking();

        $allUser = new AdminModel();
        $user = $allUser->findAllUser();

        return[
            "template"=>
                [
                    "folder" => "admin",
                    "file" => "interface",
                ],
            "order" => $order,
            "booking" => $booking,
            "user" => $user,

            "neededScripts"=>
                [
                    "ajaxRemove.js",
                ],


        ];
    }
        public function showAllBookingAction()
    {
        if (!UserSession::getInstance()->isAdmin())
        {
            return ["redirect" => "resto_home_main"];
        }

        $booking  = new AdminModel();
        $allBooking = $booking->showAllBooking();
        return[
            "template"=>
                [
                    "folder" => "admin",
                    "file" => "showAllBooking",
                ],
            "allBooking" => $allBooking,
            "neededScripts"=>
                [
                    "ajaxRemove.js",
                ],


        ];
    }
        public function showAllOrderAction()
    {
        if (!UserSession::getInstance()->isAdmin())
        {
            return ["redirect" => "resto_home_main"];
        }

        $adminModel  = new AdminModel();
        $allOrders = $adminModel->showAllOrders();
        return[
            "template"=>
                [
                    "folder" => "admin",
                    "file" => "showAllOrder",
                ],
            "allOrders" => $allOrders,
            "neededScripts"=>
                [
                    "ajaxRemove.js",
                ],


        ];
    }
    public function showAllUserAction()
    {
        if (!UserSession::getInstance()->isAdmin())
        {
            return ["redirect"=>"resto_home_main"];
        }

        $adminModel = new AdminModel();
        $allUser = $adminModel->showAllUser();
//        if ($allUser['isAdmin'] == 0)
//        {
//            return $allUser['isAdmin'] == "Non";
//        }
//        else
//        {
//            return $allUser['isAdmin'] == "Oui";
//        }
        return[
            "template"=>
                [
                    "folder" => "admin",
                    "file" => "showAllUser",
                ],
            "allUser" => $allUser,
            "neededScripts"=>
                [
                    "ajaxRemove.js",
                ],


        ];
    }
}