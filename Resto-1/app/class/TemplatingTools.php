<?php

class TemplatingTools
{
    private static $instance;
    private $months ;

    private function __construct()
    {

        $this->months = ["bogus","janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre" ];

    }


    // à partir d'une chaine de date au format SQL,
    // retourne la date formatée en forme courte ou longue, avec ou sans les heures+minutes suivant les options.
    public function formatSqlDates($sqlDateString, $short = true, $onlyDate = false)
    {
        $date = new DateTime($sqlDateString) ;

        if($short)
        {
            if( $onlyDate)
            {
                return $date->format("d/m/Y") ;
            }
            else
            {
                return $date->format("d/m/Y H:i") ;
            }
        }
        else
        {
            $day = $date->format("j") ;
            if($day == 1)
            {
                $day .= "\\e\\r" ;
            }



            if( $onlyDate)
            {
                return "le $day ".$this->months[intval($date->format("n"))]." ".$date->format(" Y");
            }
            else
            {
                return "le $day ".$this->months[intval($date->format("n"))]." ".$date->format(" Y").$date->format(" à H\\hi");
            }

        }
    }


    public function priceFormat($price, $currency = "€")
    {
        return number_format($price, 2, "&nbsp;$currency&nbsp;", " ") ;
    }


    // génère 3 select html pour choisir jour / mois / et année.
    //
    // arguments optionnels :
    //      - $preSelectDate : chaine acceptable pour le constructeur de DateTime (par ex "2019-11-05")
    //          pour décider la date que doivent afficher les select.
    //          Par défaut, c'est la date du jour qui sera affichée.
    //
    //      - $yearsRange : tableau de deux entier.
    //          Quelles années afficher dans la select des années. Les bornes sont relative à l'année en cours.
    //          ex : on est en 2019 , $yearsRange vaut [0, 5] (valeur par défaut)
    //               -> on aura les années (2019, 2020, 2021, 2022, 2023, 2024)
    //          ex2: on est en 2019 , $yearsRange vaut [-120, 0] (bon range pour les dates de naissance)
    //               -> on aura les années (1899, 1900, 1901, ...., 2017, 2018, 2019)
    //
    //      - $additionalNamesString : permet d'ajouter un complément pour les "names" des select.
    //          ex : on ne renseigne pas le paramètre,
    //               -> les names sont "day", "month" et "year"
    //          ex2: $additionalNamesString vaut "start"
    //               -> les names sont "day-start", "month-start" et "year-start"

    public function renderDateSelects($preSelectDate = "now", $yearsRange = [0, 5],  $additionalNamesString="")
    {
        $date = new DateTime($preSelectDate)  ;
        $now = new DateTime("now") ;
        if($additionalNamesString)
        {
            $additionalNamesString = "-$additionalNamesString" ;
        }

    // Day select
        $selectedDay = intval($date->format("j")) ;
        echo "<select  class='date-reservation' name=\"day$additionalNamesString\">" ;
            for($i = 1; $i <= 31; $i++)
            {
                $selected = "" ;
                if ($selectedDay == $i)
                {
                    $selected = " selected ";
                }

                echo "<option value='$i' $selected>" ;
                   echo str_pad($i, 2, "0", STR_PAD_LEFT)  ;
                echo "</option>" ;
            }
        echo "</select>" ;


    // Month select
        $selectedMonth = $date->format("n") ;
        echo "<select class='date-reservation' name=\"month$additionalNamesString\">" ;
        for($i = 1; $i <= 12; $i++)
        {
            $selected = "" ;
            if ($selectedMonth == $i)
            {
                $selected = " selected ";
            }

            echo "<option value='$i' $selected>" ;
                echo $this->months[$i]  ;
            echo "</option>" ;
        }
        echo "</select>" ;

    // Year select
        $currentYear = intval($now->format("Y")) ;
        $firstYear = $currentYear + $yearsRange[0] ;
        $lastYear = $currentYear + $yearsRange[1];

        $selectedYear = $date->format("Y");

        echo "<select class='date-reservation' name=\"year$additionalNamesString\">" ;
        for($i = $firstYear; $i <= $lastYear; $i++)
        {
            $selected = "" ;
            if ($selectedYear == $i)
            {
                $selected = " selected ";
            }

            echo "<option value='$i' $selected>" ;
                echo $i  ;
            echo "</option>" ;
        }

        echo "</select>" ;

    }



    public static function getInstance()
    {
        if(self::$instance === null)
        {
            self::$instance = new TemplatingTools();
        }

        return self::$instance ;
    }
}