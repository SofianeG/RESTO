<?php


class BookingController
{
    public function createAction()
    {

        if(!UserSession::getInstance()->isAuthenticated())
        {
            Flashbag::getInstance()->addMessage("Merci de vous connecter pour faire une réservation");
            return ["redirect" => "resto_user_login"];
        }

        if(!$_POST)
        {
            return [
                        'template' =>
                        [
                            "folder"=>"booking",
                            "file" =>"create",
                        ],
                        "maxSeats" => BookingModel::MAX_SEATS,
                        "shifts" => BookingModel::SHIFTS,
                    ] ;

        }
        else
        {


            $error = false;

            if ($_POST["shift"] == -1)
            {
                Flashbag::getInstance()->addMessage("Veuillez choisir un service de midi et du soir svp");
                $error = true;

            }

            if (!in_array($_POST["shift"], BookingModel::SHIFTS))
            {
                Flashbag::getInstance()->addMessage("service inconnu");
                $error = true;
            }

            $sqlDateStr = $_POST["year"]. "-".$_POST["month"]."-". $_POST["day"];
            $bookingDate = new DateTime($sqlDateStr);

            if ($bookingDate < new DateTime("now"))
            {
                Flashbag::getInstance()->addMessage("Merci de réserver à une date après le ".TemplatingTools::getInstance()->formatSqlDates("n")); // A REVERIFIER !!
                $error = true;
            }

            if (!$_POST["seats"] || !ctype_digit($_POST["seats"]))
            {
                if ($_POST["seats"] == "-1")
                {
                    Flashbag::getInstance()->addMessage("Merci de choisir un nombre de place");
                }
                else
                {
                    Flashbag::getInstance()->addMessage("Nombre siège invalide");
                }

                $error = true;
            }

            if ($error)
            {
                return ["redirect" => "resto_booking_create"];
            }

            $model = new BookingModel();

            $takenSeats =  $model->findTakeASeatsByDateAndShift($sqlDateStr, $_POST["shift"]);
            $leftSeats = BookingModel::MAX_SEATS - $takenSeats ;

            if ($_POST['seats'] > $leftSeats)
            {
                if ($leftSeats == 0)
                {
                    Flashbag::getInstance()->addMessage("Il ne nous reste malheureusement plus de place pour ce service.");
                }
                else
                {
                    Flashbag::getInstance()->addMessage("Il nous reste seulement $leftSeats pour ce service");
                }
                return ["redirect" => "resto_booking_create"] ;
            }

            $model->create(UserSession::getInstance()->getId(), $sqlDateStr, $_POST['shift'], $_POST['seats']) ;

            $dateStr = $bookingDate->format("d/m/Y") ;
            Flashbag::getInstance()->addMessage("Votre réservation du $dateStr a bien été enregistrée. Merci !");

            return ["redirect" => "resto_home_main"] ;

        }


//        if(!in_array($_POST["service"], BookingModel::SERVICES))
//        {
//            $error = true ;
//            Flashbag::getInstance()->addMessage("Service inconnu");
//        }
    }

}