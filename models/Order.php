<?php

class Order
{
    public function save($name, $phone, $comment, $user_id, $products){

        $db = Db::getConnection();

        $sql = 'INSERT INTO product_order (user_name, user_phone, user_comment, user_id, products) '
                . 'VALUES (:user_name, :user_phone, :user_comment, :user_id, :products)';

        $products = json_encode($products);

        $result = $db->pdo->prepare($sql);
        $result->bindParam(':user_name', $name, PDO::PARAM_STR);
        $result->bindParam(':user_phone', $phone, PDO::PARAM_STR);
        $result->bindParam(':user_comment', $comment, PDO::PARAM_STR);
        $result->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $result->bindParam(':products', $products, PDO::PARAM_STR);

        return $result->execute();
    }

    public function getOrderList(){

        $db = Db::getConnection();

        $result = $db->pdo->query("SELECT id, user_name, user_phone, date, status FROM product_order ORDER BY id DESC");
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetchAll();
    }

    public function deleteOrderById($id)
    {

        $db = Db::getConnection();

        $sql = 'DELETE FROM product_order WHERE id = :id';

        $result = $db->pdo->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }

    public function getOrderById($id)
    {

        $db = Db::getConnection();

        $sql = 'SELECT * FROM product_order WHERE id = :id';

        $result = $db->pdo->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetch();
    }

    public function updateOrderById($id, $userName, $userPhone, $userComment, $date, $status)
    {

        $db = Db::getConnection();

        $sql = "UPDATE product_order
            SET 
                user_name = :user_name, 
                user_phone = :user_phone, 
                user_comment = :user_comment, 
                date = :date, 
                status = :status 
            WHERE id = :id";

        $result = $db->pdo->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':user_name', $userName, PDO::PARAM_STR);
        $result->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
        $result->bindParam(':user_comment', $userComment, PDO::PARAM_STR);
        $result->bindParam(':date', $date, PDO::PARAM_STR);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        return $result->execute();
    }

    public static function getStatusText($ordersList){
        foreach($ordersList as $order){

            $status = $order['status'];

            switch($status){
                case 1:
                    $status = 'Новый заказ';
                    break;
                case 2:
                    $status = 'В обработке';
                    break;
                case 3:
                    $status = 'Доставляется';
                    break;
                case 4:
                    $status = 'Закрыт';
                    break;
            }

            $statusText[$order['id']] = $status;
        }
        return $statusText;
    }


}