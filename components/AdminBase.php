<?php

class AdminBase
{
    public function checkAdmin()
    {
        $user = new User;

        $userLog = $user->checkLogged();
        $userData = $user->userDataById($userLog);

        if($userData['role'] != 'admin'){
            throw new Exception("Ошибка, вы не являетесь администратором");
        }

        return true;
    }
}