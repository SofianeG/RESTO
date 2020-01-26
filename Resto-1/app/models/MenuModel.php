<?php
class MenuModel extends AbstracModel
{
    public function findAll()
    {
        $resp = $this->pdo->query('SELECT id, title, forcedPrice, image, SUBSTR(description, 1, 100) AS description
                                            FROM Menu
                                            ORDER BY title');
        return $resp->fetchAll();
    }

    public function find($id)
    {
        $query = $this->pdo->prepare('
                                            SELECT *
                                            FROM Menu
                                            WHERE id = :id
                                            ');

        $query->execute([
            "id" => $id,
        ]);

        return $query->fetch();
    }

    public function findPrice($id)
    {
        $query = $this->pdo->prepare('
                                            SELECT SUM(quantity * price) AS price, forcedPrice
                                            FROM Menu_Dish
                                            INNER JOIN Menu M on Menu_Dish.menu_id = M.id AND menu_id = :id
                                            INNER JOIN Dish ON Menu_Dish.dish_id = Dish.id
                                            ');

        $query->execute([
            "id" => $id,
        ]);

        $prices =  $query->fetch();

        if(!$prices)
        {
            throw new DomainException("le menu demandé n'existe pas") ;
        }

        if($prices['forcedPrice'])
        {
            return  $prices['forcedPrice'];
        }
        else
        {
            return $prices['price'] ;
        }
    }

    public function create($title, $description, $price)
    {
        $query = $this->pdo->prepare('INSERT INTO Menu
                                                (title, description, forcedPrice, image)
                                                VALUES
                                                (:title, :description, :price, "")
                                                ');
        $query->execute([
            "title" => $title,
            "description" => $description,
            "price" => $price,
        ]);

        return $this->pdo->lastInsertId();
    }

    public function addDishes($menuId, $dishQuantitiesByIds)
    {
        $query = $this->pdo->prepare('INSERT INTO Menu_Dish
                                                (menu_id, dish_id, quantity)
                                                VALUES                                             
                                                (:menuId, :dishId, :quantity)
                                                ON DUPLICATE KEY UPDATE
                                                quantity = :quantity
                                                ');
        foreach ($dishQuantitiesByIds as $dishId => $quantity)
        {
            $query->execute([
                "menuId" => $menuId,
                "dishId" => $dishId,
                "quantity" => $quantity,
            ]);
        }

    }

    public function update($id ,$title ,$price ,$description )
    {
        $query=$this->pdo->prepare("
                                UPDATE Menu
                                SET
                                    title = :title,
                                    description = :description,
                                    forcedPrice = :price
                                WHERE 
                                    id =:id
                                   ");
        $query->execute([
            "title"=> $title,
            "price"=> $price,
            "description"=> $description,
            "id"=> $id,
        ]);
    }

    public function updateImage($id ,$image )
    {
        $query=$this->pdo->prepare("
                                UPDATE Menu
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


    public function removeDishes($menuId, $dishIds)
    {
        $query = $this->pdo->prepare("DELETE FROM Menu_Dish
                                                WHERE menu_id = :menuId
                                                AND dish_id = :dishId
                                                ") ;

        foreach ($dishIds as $dishId)
        {
            $query->execute([
                "menuId" => $menuId,
                "dishId" => $dishId,
            ]);
        }
    }

    public function remove($id)
    {
        $query = $this->pdo->prepare("
                                            DELETE FROM Menu
                                            WHERE id = :id
                                         ");
        $query->execute([
            "id"=> $id,
        ]);
    }

}