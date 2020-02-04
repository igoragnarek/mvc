<?php

class User
{

    public function edit($id, $name, $pass){

        $db = Db::getConnection();

        $sql = "UPDATE user 
            SET name = :name, password = :pass 
            WHERE id = :id";

        $result = $db->pdo->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':pass', $pass, PDO::PARAM_STR);

        return $result->execute();
    }

    public function register($name, $email, $pass_hash){

        $db = Db::getConnection();

        $sql = 'INSERT INTO user (name, email, password) '
                . 'VALUES (:name, :email, :pass)';
        
        $result = $db->pdo->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':pass', $pass_hash, PDO::PARAM_STR);

        return $result->execute();

    }

    public function getUser($email){

        $db = Db::getConnection();

        $sql = 'SELECT id, password FROM user WHERE email = :email';
        $result = $db->pdo->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        return $result->fetch();
    }

    public function auth($user_id){
        $_SESSION['user'] = $user_id;
    }


    public function checkLogged(){
        if(isset($_SESSION['user'])){
            return $_SESSION['user'];
        }
        header('Location: /');
    }


    public function userDataById($id){

        $db = Db::getConnection();

        $sql = 'SELECT * FROM user WHERE id = :id';
        $result = $db->pdo->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetch();
    }

    public function logout()
    {
        if(isset($_SESSION['user'])){
            
            unset( $_SESSION['user'] );
            header('Location: /');
        }
    }

    public static function isGuest(){
        if(isset($_SESSION['user'])){
            return false;
        }
        return true;
    }



}