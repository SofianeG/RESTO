<?php


class UserModel extends AbstracModel
{

    public function findByEmailAndCheckPassword($email, $pwd)
    {
        $query = $this->pdo->prepare('SELECT *
                                            FROM User
                                            WHERE email = :email');

        $query->execute([
            "email" => $email,
        ]);

        $user =  $query->fetch();

        if(!$user)
        {
            throw new DomainException("Désolé, nous ne connaissons pas cet email") ;
        }

        if(!password_verify($pwd, $user['pwd']))
        {
            throw new DomainException("Désolé, mot de pass invalide") ;
        }

        return $user ;
    }



    public function create($forname, $lastname, $adress, $numTel, $email, $password)
    {
        $query = $this->pdo->prepare('INSERT INTO User
                                                (forname, lastname, adress, numTel, email, pwd ,signInDate)
                                                VALUES
                                                (:forname, :lastname, :adress, :numTel, :email, :pwd, NOW())
                                                ');

        try
        {
            $query->execute([
                "forname" => $forname,
                "lastname" => $lastname,
                "adress" => $adress,
                "numTel" => $numTel,
                "email" => $email,
                "pwd" => password_hash($password,PASSWORD_DEFAULT),
            ]);

            return $this->pdo->lastInsertId();
        }
        catch (Exception $e)
        {
            if($e->getCode() == 23000)
            {
                throw  new DomainException("email déjà pris") ;
            }
            else
            {
                throw $e ;
            }
        }

    }

    //    public function update($forname, $lastname, $adress, $numTel, $email, $password)
//    {
//        $query=$this->pdo->prepare("
//                                UPDATE Dish
//                                SET
//                                    forname = :forname,
//                                    lastname = :lastname,
//                                    adress = :adress,
//                                    numTel = :numTel,
//                                    email = :email,
//                                    password = :password
//                                WHERE
//                                    id =:id
//                                   ");
//        $query->execute([
//            "forname"=> $forname,
//            "lastname"=> $lastname,
//            "adress"=>$adress,
//            "numTel"=> $numTel,
//            "email"=> $email,
//            "password"=> $password,
//            "id"=> $id,
//        ]);
//    }

    public function updateImage($id ,$image )
    {
        $query=$this->pdo->prepare("
                                UPDATE User
                                SET
                                    image = :image
                                WHERE 
                                    id =:id
                                   ");
        $query->execute([
            "image"=>$image,
            "id"=> $id,
        ]);
    }




}