<?php

class SiteController
{

    public function actionIndex(){
        
        $category = (new Category)->categoryList();
        $productInstance = new Product;
        
        $latestProduct = $productInstance->getLatestProduct();
        $recProduct    = $productInstance->getRecProduct();

        $image = Product::getImages($recProduct);

        require_once(ROOT . '/views/site/index.php');
        return true;
    }

    public function actionContact(){

        $errors = false;
        $result = false;

        if(isset($_POST['submit'])){

            $email = $_POST['userEmail'];
            $text  = $_POST['userText'];
            $text  = strip_tags($text);

            $errors = Validate::checkEmail($email);

            if($errors == false){

                $adminEmail = 'urbanovigor99@gmail.com';
                $message = "Текст: {$text}. От {$email}";
                $subject = 'Тема письма';
                $result = mail($adminEmail, $subject, $message);
                $result = true;
            }
        }

        require_once(ROOT . '/views/site/contact.php');
        return true;
    }

    public function actionAbout(){

        require_once(ROOT . '/views/site/about.php');
        return true;
    }

}