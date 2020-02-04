<?php

class AdminProductController extends AdminBase
{

    public function actionIndex(){

        parent::checkAdmin();

        $productsList = (new Product)->getProductsList();

        require_once(ROOT . '/views/admin_product/index.php');
        return true;
    }

    public function actionDelete($id){

        parent::checkAdmin();

        if(isset($_POST['submit'])){

            (new Product)->deleteProductById( (int) $id );
            header('Location: /admin/product');
        }

        require_once(ROOT . '/views/admin_product/delete.php');
        return true;
    }

    public function actionUpdate($id){

        parent::checkAdmin();

        $productInstance = new Product;
        $categoriesList = (new Category)->categoryList();
        $product = $productInstance->getProductById($id);


        if (isset($_POST['submit'])) {
            
            $options['name']           = $_POST['name'];
            $options['code']           = (int) $_POST['code'];
            $options['price']          = $_POST['price'];
            $options['category_id']    = $_POST['category_id'];
            $options['brand']          = $_POST['brand'];
            $options['availability']   = $_POST['availability'];
            $options['description']    = $_POST['description'];
            $options['is_new']         = $_POST['is_new'];
            $options['is_recommended'] = $_POST['is_recommended'];
            $options['status']         = $_POST['status'];

            if ($productInstance->updateProductById($id, $options)) {
                
                $productInstance->newFile($id);
            }

            header("Location: /admin/product");
        }
        

        require_once(ROOT . '/views/admin_product/update.php');
        return true;
    }

    public function actionCreate(){

        parent::checkAdmin();

         $categoriesList = (new Category)->categoryList();
         $productInstance = new Product;
 
         if (isset($_POST['submit'])) {

             $options['name']           = $_POST['name'];
             $options['code']           = (int) $_POST['code'];
             $options['price']          = $_POST['price'];
             $options['category_id']    = $_POST['category_id'];
             $options['brand']          = $_POST['brand'];
             $options['availability']   = $_POST['availability'];
             $options['description']    = $_POST['description'];
             $options['is_new']         = $_POST['is_new'];
             $options['is_recommended'] = $_POST['is_recommended'];
             $options['status']         = $_POST['status'];
 
             $errors = false;
             $errors = Validate::isEmpty($options['name']);
 
             if ($errors == false) {

                 $id = $productInstance->createProduct($options);
                 if ($id) {

                    $productInstance->newFile($id);
                 };
 
                 header("Location: /admin/product");
             }
         }
 
         require_once(ROOT . '/views/admin_product/create.php');
         return true;
    }




}