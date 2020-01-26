<?php


class OrderModel extends AbstracModel
{
    public function findBasketIdOrCreate($userId)
    {
        $query = $this->pdo->prepare('
                                                SELECT id
                                                FROM `Order`
                                                WHERE status = "basket"
                                                AND user_id = :userId
                                                ');
        $query->execute([
                            "userId"=>$userId,
                        ]);

        $id = $query->fetch(PDO::FETCH_COLUMN);

        if ($id)
        {
            return $id;
        }

        $query = $this->pdo->prepare('INSERT INTO `Order`
                                                (user_id, status)
                                                VALUES
                                                (:userId, "basket")
                                                ');
        $query->execute([
                            "userId"=> $userId,
                        ]);

        return $this->pdo->lastInsertId();
    }

    public function confirmOrder($id)
    {
        $query = $this->pdo->prepare("UPDATE `Order`
                                                SET 
                                                    orderDate = NOW(),
                                                    status = 'pending'
                                                WHERE id = :id
                                                ");

        $query->execute(
                        [
                            "id" => $id,
                        ]
        );
    }



    public function emptyBasketByUser($userId)
    {
        $query = $this->pdo->prepare('DELETE FROM `Order`
                                                WHERE 
                                                    user_id = :userId
                                                    AND status = "basket" 
                                                ');
        $query->execute(
            [
                "userId"=> $userId,
            ]
        );
    }

    public function emptyBasketByOrder($orderId)
    {
        $query = $this->pdo->prepare('DELETE FROM `Order`
                                                WHERE 
                                                    order_id = :orderId 
                                                ');
        $query->execute(
            [
                "orderId"=> $orderId,
            ]
        );
    }


}