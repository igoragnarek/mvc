<?php

class UserController
{

    public function actionRegister(){

        $errors = false;
        $result = false;

        if(isset($_POST['submit'])){

            $name     = $_POST['name'];
            $email    = $_POST['email'];
            $password = $_POST['password'];

            $errors = (new Validate)->checkUser($name, $email, $password);

            
            if($errors == false){

                $pass_hash = password_hash($password, PASSWORD_DEFAULT);
                $result    = (new User)->register($name, $email, $pass_hash);
            }
        }

        require_once(ROOT . '/views/user/register.php');
        return true;
    }

    public function actionLogin(){
        
        $errors = false;
        $userIstance = new User;

        if(isset($_POST['submit'])){
            $email = $_POST['email'];
            $pass  = $_POST['password'];

            $errors = (new Validate)->checkLogin($email, $pass);
            $user = $userIstance->getUser($email);

            $pass_verify = password_verify($pass, $user['password']);
            if($user && $pass_verify){

                $userIstance->auth($user['id']);
                header('Location: /cabinet');
            }else{
                $errors[] = 'Не правильные данные';
            }
        }

        require_once(ROOT . '/views/user/login.php');
        return true;
    }

    public function actionLogout(){

        (new User)->logout();

    }

}