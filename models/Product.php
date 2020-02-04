<?php

class Product
{
    const DEFAULT = 6;

    public function getProductById($id){

        $db = Db::getConnection();

        $sql = "SELECT * FROM product WHERE status = '1' AND id = :id ";

        $result = $db->pdo->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetch();

    }

    public function getLatestProduct(){

        $db = Db::getConnection();

        $lim = self::DEFAULT;
        $sql = "SELECT * FROM product WHERE status = 1 ORDER BY id DESC LIMIT $lim";
        $result = $db->pdo->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetchAll();
    }

    public function getRecProduct(){

        $db = Db::getConnection();

        $sql = "SELECT * FROM product WHERE status = 1 AND is_recommended = 1";
        $result = $db->pdo->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetchAll();
    }

    public function getCountProduct(){

        $db = Db::getConnection();

        $sql = "SELECT count(id) as count FROM product WHERE status = 1";
        $result = $db->pdo->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $res = $result->fetch();

        return $res['count'];
    }


    public function getCatalogProduct($page){

        $db = Db::getConnection();
        
        $lim = self::DEFAULT;
        $offset = ($page - 1) * $lim;

        $sql = "SELECT * FROM product WHERE status = 1 LIMIT $lim OFFSET $offset";
        $result = $db->pdo->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetchAll();

    }


    public function getProductByCategory($id, $page){

        $db = Db::getConnection();
        $lim = self::DEFAULT;
        $offset = ($page - 1) * $lim;

        $sql = "SELECT * FROM product WHERE status = 1 AND category_id = :id LIMIT $lim OFFSET $offset";
        $result = $db->pdo->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetchAll();
    }

    public function getCountProductsByCategory($id){

        $db = Db::getConnection();
        
        $sql = "SELECT count(id) as count FROM product WHERE status = 1 AND category_id = :id";
        $result = $db->pdo->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $res = $result->fetch();

        return $res['count'];
    }


    public function getProductsByIds($sess){

        $arr_ids = array_keys($sess);
        $ids = implode(',', $arr_ids);

        if(!preg_match("/^([0-9 ,])+$/u", $ids) ){
            unset($_SESSION['products']);
            header("Location: /");
        }

        $db = Db::getConnection();

        $sql = "SELECT * FROM product WHERE status = 1 AND id IN($ids)";
        $result = $db->pdo->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetchAll();
    }

    public function getProductsList()
    {

        $db = Db::getConnection();

        $result = $db->pdo->query('SELECT id, name, price, code FROM product ORDER BY id ASC');
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $productsList = $result->fetchAll();

        return $productsList;
    }

    public function deleteProductById($id)
    {

        $db = Db::getConnection();

        $sql = "DELETE FROM product WHERE id = :id";
        $result = $db->pdo->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        return $result->execute();
    }

    public function newFile($id)
    {
        // Проверим, загружалось ли через форму изображение
        if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
            
            // Если загружалось, переместим его в нужную папку, дадим новое имя
            move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] 
                                . "/upload/images/products/{$id}.jpg");
        }
    }

    public function updateProductById($id, $options){

       $db = Db::getConnection();

       $sql = "UPDATE product
           SET 
               name = :name, 
               code = :code, 
               price = :price, 
               category_id = :category_id, 
               brand = :brand, 
               availability = :availability, 
               description = :description, 
               is_new = :is_new, 
               is_recommended = :is_recommended, 
               status = :status
           WHERE id = :id";

       $result = $db->pdo->prepare($sql);
       $result->bindParam(':id',             $id, PDO::PARAM_INT);
       $result->bindParam(':name',           $options['name'], PDO::PARAM_STR);
       $result->bindParam(':code',           $options['code'], PDO::PARAM_STR);
       $result->bindParam(':price',          $options['price'], PDO::PARAM_STR);
       $result->bindParam(':category_id',    $options['category_id'], PDO::PARAM_INT);
       $result->bindParam(':brand',          $options['brand'], PDO::PARAM_STR);
       $result->bindParam(':availability',   $options['availability'], PDO::PARAM_INT);
       $result->bindParam(':description',    $options['description'], PDO::PARAM_STR);
       $result->bindParam(':is_new',         $options['is_new'], PDO::PARAM_INT);
       $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
       $result->bindParam(':status',         $options['status'], PDO::PARAM_INT);
       return $result->execute();
    }

    public function createProduct($options)
    {
        $db = Db::getConnection();

        $sql = 'INSERT INTO product '
                . '(name, code, price, category_id, brand, availability,'
                . 'description, is_new, is_recommended, status)'
                . 'VALUES '
                . '(:name, :code, :price, :category_id, :brand, :availability,'
                . ':description, :is_new, :is_recommended, :status)';

        $result = $db->pdo->prepare($sql);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);
        if ($result->execute()) {
            return $db->pdo->lastInsertId();
        }
        return 0;
    }


    public static function getImage($id){

        $no_image = 'no-image.jpg';
        $path = '/upload/images/products/';

        $path_image = $path . $id . '.jpg';

        if(file_exists($_SERVER['DOCUMENT_ROOT'].$path_image)){
            return $path_image;
        }
        return $path . $no_image;
    }

    public static function getImages($products){
        foreach($products as $product){
            $no_image = 'no-image.jpg';
            $path = '/upload/images/products/';
            $id = $product['id'];

            $path_image = $path . $id . '.jpg';

            if(file_exists($_SERVER['DOCUMENT_ROOT'].$path_image)){
                $p_im[$id] = $path_image;
            }else{
                $p_im[$id] = $path . $no_image;
            }
        }
        return $p_im;
    }

    public static function existText($avail){
        switch($avail){
            case 0:
                return 'Отсутствует';
                break;
            case 1:
                return 'В наличии';
                break;
        }
    }
}
