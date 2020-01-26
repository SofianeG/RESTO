<?php


class OrderDetailsModel extends AbstracModel
{
    public function AddMenuToBasketOrIncrementQuantity($menuId, $orderId , $price)
    {
        $query = $this->pdo->prepare('INSERT INTO OrderDetails
                                                (order_id, menu_id, quantity, priceEach)
                                                VALUES 
                                                (:order_id, :menu_id, 1, :priceEach)
                                                ON DUPLICATE KEY UPDATE 
                                                quantity = quantity + 1 
                                                ');
        $query->execute([
                            "order_id"=>$orderId,
                            "menu_id"=>$menuId,
                            "priceEach"=>$price,
                        ]);

    }

    public function findBasket($orderId)
    {

        $query= $this->pdo->prepare('SELECT menu_id, quantity, priceEach, title, image
                                               FROM OrderDetails OD
                                               INNER JOIN Menu M
                                                    ON OD.menu_id = M.id
                                               WHERE order_id  = :orderId' );

        $query->execute([
            "orderId" => $orderId,
        ]);

        return $query->fetchAll() ;
    }

    public function removeFromBasket($menuId, $orderId)
    {
        $query = $this->pdo->prepare('DELETE FROM OrderDetails
                                                WHERE 
                                                      order_id = :orderId
                                                      AND menu_id = :menuId

                                                ');
        $query->execute([
            "orderId" => $orderId,
            "menuId" => $menuId,
        ]);

    }


}