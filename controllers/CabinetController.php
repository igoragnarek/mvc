<?php

class CabinetController
{
    public function actionIndex(){

        $userInstance = new User;

        $userId   = $userInstance->checkLogged();
        $userData = $userInstance->userDataById($userId);
        $admin = null;

        if($userData['role'] == 'admin'){
            $admin = "<a href='/admin'>Админ панель</a>";
        }

        require_once(ROOT . '/views/cabinet/index.php');
        return true;
    }

    public function actionEdit(){

        $userInstance = new User;

        $userId   = $userInstance->checkLogged();
        $userData = $userInstance->userDataById($userId);

        $result = false;
        $errors = false;

        if(isset($_POST['submit'])){

            $name = $_POST['name'];
            $pass = $_POST['password'];

            $errorName = Validate::checkName($name);
            $errorPass = Validate::passLen($pass);

            $errors = [$errorName, $errorPass];

            if($errorName == false && $errorPass == false){

                $pass = password_hash($pass, PASSWORD_DEFAULT);
                $result = $userInstance->edit($userId, $name, $pass);
            }
        }

        require_once(ROOT . '/views/cabinet/edit.php');
        return true;
    }
}