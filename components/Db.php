<?php

class Db
{
    
    private static $instance;
    public $pdo;
    
    private function __construct()
    {
        $params = require_once(ROOT . '/config/db_params.php');

        try{
            $this->pdo = new PDO(
                'mysql:host=' . $params['host'] . ';dbname=' . $params['dbname'],
                $params['user'],
                $params['pass'],
                [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]
            );
        }catch(PDOException $e){
            echo "No database connection";
            die();
        }

    }
    
    private function __wakeup() { }

    private function __clone() { }

    public static function getConnection()
    {
        return self::$instance ?? ( self::$instance = new self() );
    }

}

