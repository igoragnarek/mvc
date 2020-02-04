<?php

class CartController
{


    public function actionIndex(){

        $category = (new Category)->categoryList();

        $productsInCart = Cart::getProducts();

        if($productsInCart){
            $products   = (new Product)->getProductsByIds($productsInCart);
            $totalPrice = Cart::getTotalPrice($products);
        }


        require_once(ROOT . '/views/cart/index.php');
        return true;
    }

    public function actionCheckout(){

        $productsInCart = Cart::getProducts();

        if($productsInCart == false){
            header('Location: /');
        }

        $category   = (new Category)->categoryList();
        $products   = (new Product)->getProductsByIds($productsInCart);

        $totalPrice = Cart::getTotalPrice($products);
        $countItems = Cart::countItems();

        $result  = false;
        $userName = null;

        $userInstance = new User;

        if (!$userInstance::isGuest()) {

            $userId = $userInstance->checkLogged();
            $user = $userInstance->userDataById($userId);
            $userName = $user['name'];
        } else {    
            $userId = null;
        }

        if(isset($_POST['submit'])){

            $name    = $_POST['userName'];
            $phone   = $_POST['userPhone'];
            $comment = $_POST['userCommente'];

            $errName  = Validate::checkName($name);
            $errPhone = Validate::checkPhone($phone);
            $comment  = Validate::checkText($comment);

            $errors = [$errName, $errPhone];

            if($errName == false && $errPhone == false){

                $result = (new Order)->save($name, $phone, $comment, $userId, $productsInCart);

                if ($result) {               
                    $adminEmail = 'urbanovigor99@gmail.com';
                    $message = 'Новый заказ!';
                    $subject = 'Новый заказ!';
                    mail($adminEmail, $subject, $message);

                    (new Cart)->clear();
                    
                }

            }

        }

        require_once(ROOT . '/views/cart/checkout.php');
        return true;
    }

    public function actionAddAjax($id){

        echo (new Cart)->addProduct($id);
        return true;
    }

    public function actionDelete($id){

        (new Cart)->deleteProduct($id);
        header("Location: /cart");

        return true;
    }

}