<?php
class DishModel extends AbstracModel
{
    public function findAll()
    {
        $resp = $this->pdo->query('SELECT id, title, price, category, image, SUBSTR(description, 1, 100) AS description
                                            FROM Dish
                                            ORDER BY title');
        return $resp->fetchAll();
    }
    public function findAllImages()
    {
        $resp = $this->pdo->query('SELECT image
                                            FROM Dish
                                           ');
        return $resp->fetchAll();
    }
    public function find($id)
    {
        $query = $this->pdo->prepare('
                                            SELECT *
                                            FROM Dish
                                            WHERE id = :id
                                            ');

        $query->execute([
                            "id" => $id,
                        ]);

        return $query->fetch();
    }

    public function findAllIdsAndTitles()
    {
        $resp = $this->pdo->query('SELECT id, title
                                            FROM Dish
                                            ORDER BY title');
        return $resp->fetchAll();
    }

    public function findScalarIdsFromMenu($menuId)
    {
        $query = $this->pdo->prepare('SELECT id
                                            FROM Dish
                                            INNER JOIN Menu_Dish MD 
                                                ON Dish.id = MD.dish_id 
                                                AND menu_id = :menuId');
        $query->execute([
                            "menuId" => $menuId,
                        ]);

        return $query->fetchAll(PDO::FETCH_COLUMN);
    }

    public function findAllDishesForAllMenus()
    {
        $resp = $this->pdo->query('SELECT id, title, price, quantity, menu_id
                                            FROM Dish
                                            INNER JOIN Menu_Dish ON Dish.id = Menu_Dish.dish_id
                                            ORDER BY id');
        return $resp->fetchAll();
    }

    public function findAllAndQuantityByMenu($menuId)
    {
        $query = $this->pdo->prepare("SELECT Dish.*, quantity
                                            FROM Menu_Dish
                                            INNER JOIN Dish ON Dish.id = Menu_Dish.dish_id
                                            ORDER BY menu_id");
        $query->execute([
                            "menuId" => $menuId,
                        ]);

        return $query->fetchAll();
    }

    public function findByMenuAndChecked($menuId)
    {

        $query = $this->pdo->prepare("SELECT Dish.id, Dish.title, quantity, (dish_id IS NOT NULL) AS isChecked 
                                                FROM Dish 
                                                LEFT JOIN Menu_Dish ON Dish.id = Menu_Dish.dish_id
                                                AND menu_id = :id 
                                                ORDER BY title");

        $query->execute([
            "id" => $menuId,
        ]);

        return $query->fetchAll() ;
    }


    public function create($title, $description, $price, $category)
    {
        $query = $this->pdo->prepare('INSERT INTO Dish
                                                (title, description, price, category, image)
                                                VALUES
                                                (:title, :description, :price, :category,"")
                                                ');
        $query->execute([
            "title" => $title,
            "description" => $description,
            "price" => $price,
            "category" => $category,
        ]);

        return $this->pdo->lastInsertId();
    }

    public function update($id ,$title ,$category ,$price ,$description )
    {
        $query=$this->pdo->prepare("
                                UPDATE Dish
                                SET
                                    title = :title,
                                    description = :description,
                                    category = :category,
                                    price = :price
                                WHERE 
                                    id =:id
                                   ");
        $query->execute([
                            "title"=> $title,
                            "category"=> $category,
                            "price"=>$price,
                            "description"=> $description,
                            "id"=> $id,
                        ]);
    }

    public function updateImage($id ,$image )
    {
        $query=$this->pdo->prepare("
                                UPDATE Dish
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



    public function remove($id)
    {
        $query = $this->pdo->prepare("
                                            DELETE FROM Dish
                                            WHERE id = :id
                                         ");
        $query->execute([
            "id"=> $id,
        ]);
    }

    public function findScalarDishesIdsInMenu($menuId)
    {
        $query = $this->pdo->prepare("SELECT dish_id
                                                FROM Menu_Dish
                                                WHERE menu_id = :menu_id");

        $query->execute([
            "menu_id" => $menuId,
        ]);

        return $query->fetchAll(PDO::FETCH_COLUMN) ;

    }
}
