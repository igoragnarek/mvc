<?php

class Category
{
    public function categoryList(){

        $db = Db::getConnection();

        $result = $db->pdo->query('SELECT id, name FROM category WHERE status = 1');
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetchAll();
    }

    public function categoryListAdmin(){

        $db = Db::getConnection();

        $result = $db->pdo->query('SELECT * FROM category');
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetchAll();
    }


    public function deleteCategoryById($id)
    {

        $db = Db::getConnection();

        $sql = 'DELETE FROM category WHERE id = :id';

        $result = $db->pdo->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        return $result->execute();
    }


    public function createCategory($name, $sortOrder, $status)
    {

        $db = Db::getConnection();

        $sql = 'INSERT INTO category (name, sort_order, status) '
                . 'VALUES (:name, :sort_order, :status)';

        $result = $db->pdo->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':sort_order', $sortOrder, PDO::PARAM_INT);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        return $result->execute();
    }


    public function getCategoryById($id)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM category WHERE id = :id';

        $result = $db->pdo->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetch();
    }

    public function updateCategoryById($id, $name, $sortOrder, $status)
    {

        $db = Db::getConnection();

        $sql = "UPDATE category
            SET 
                name = :name, 
                sort_order = :sort_order, 
                status = :status
            WHERE id = :id";

        $result = $db->pdo->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':sort_order', $sortOrder, PDO::PARAM_INT);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        return $result->execute();
    }

    public static function getStatusText($categoriesList){
        foreach($categoriesList as $category){

            $id = $category['id'];
            $status = $category['status'];

            switch($status){
                case 0:
                    $status = 'Не отображается';
                    break;
                case 1:
                    $status = 'Отображается';
                    break;
            }

            $categoryStatus[$id] = $status;
        }

        return $categoryStatus;
    }

    
}