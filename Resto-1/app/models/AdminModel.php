<?php


class AdminModel extends AbstracModel
{
    public function findAllOrders()
    {
        $resp = $this->pdo->query("
                                                SELECT COUNT(quantity) AS totalquantity, SUM(priceEach * quantity) AS totalprice
                                                FROM `orderdetails`
                                                ");

        return $resp->fetch();
    }

    public function findAllBooking()
    {
        $resp = $this->pdo->query("
                                                SELECT COUNT(id) AS totalresa, SUM(seatCount) AS totalseats
                                                FROM Booking
                                                ");

        return $resp->fetch();
    }
    public function findAllUser()
    {
        $resp = $this->pdo->query("
                                                SELECT COUNT(id) AS totaluser
                                                FROM User
                                                ");
        return $resp->fetch();
    }
    public function showAllOrders()
    {
        $resp = $this->pdo->query("SELECT order_id, orderDate, deliveryDate, status, forname, lastname, adress, numTel, user_id, priceEach
                                             FROM `Order`
                                             INNER JOIN User ON User.id = order.user_id
                                             INNER JOIN OrderDetails ON  order_id = order.id
                                             
                                             ");
        return $resp->fetchAll();
    }
    public function showAllBooking()
    {
        $resp = $this->pdo->query("
                                            SELECT seatCount,bookingDate,shift, lastname, forname, numTel
                                            FROM Booking
                                            INNER JOIN  User ON User.id = Booking.user_id
                                            ");
        return $resp->fetchAll();
    }

    public function showAllUser()
    {
        $resp = $this->pdo->query("
                                            SELECT forname, lastname, adress, numTel, email, isAdmin
                                            FROM User 
                                            ");
        return $resp->fetchAll();
    }
}