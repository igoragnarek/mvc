<?php

class Validate
{

    public static function isEmpty($val)
    {
        if(empty($val)){

            $errors[] = '- Заполните поля';
            return $errors;
        }
    }

    public static function passLen($val)
    {
        if(strlen($val) < 6 || strlen($val) > 70){

            return '- Пароль должен быть от 6 до 70 символов';
        }
    }


    
    public static function checkName($name)
    {

        $preg = "/^([A-z А-я])+$/u";

        if(!preg_match($preg, $name) || empty($name)){
            return '- Не корректное имя';
        }
    }


    public static function checkPhone($phone)
    {

        $preg = "/^([0-9 +])+$/u";
        
        if(!preg_match($preg, $phone) || empty($phone)){
            return '- Не корректный номер';
        }
    }

    public static function checkText($text)
    {
        $text = strip_tags($text);
        $text = htmlspecialchars($text);
        $text = trim($text);

        return $text;
    }

    public static function checkEmail($email){
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){

            return '- Не корректный email';
        }
    }

    public function checkEmailExist($email){

        $db = Db::getConnection();

        $sql = "SELECT COUNT(*) FROM user WHERE email = :email";
        $result = $db->pdo->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        if($result->fetchColumn())
            return true;
        return false;
    }

    public function checkUser($name, $email, $password){

        $errors[] = self::checkName($name);
        $errors[] = self::passLen($password);
        $errors[] = self::checkEmail($email);
        $errors[] = $this->checkEmailExist($email) ? '- Такой email уже используется' : false;

        if(in_array(true, $errors))
            return $errors;
        return false;
    }

    public function checkLogin($email, $password){

        $errors[] = self::passLen($password);
        $errors[] = self::checkEmail($email);

        if(in_array(true, $errors))
            return $errors;
        return false;
    }

}