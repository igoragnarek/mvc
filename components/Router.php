<?php

class Router
{

    private $routes;

    public function __construct(){
        $path = ROOT . '/config/routes.php';
        $this->routes = require_once($path);
    }


    public function getUri(){
        if(!empty($_SERVER['REQUEST_URI'])){
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run(){

        $uri   = $this->getUri();

        $preg = preg_replace('([0-9]+)', '([0-9]+)', $uri);
        
        foreach($this->routes as $routePatt => $route){
            if($routePatt == $preg && strlen($uri < 300)){
                
                $inter_rout = preg_replace("~$routePatt~", $route, $uri);
               
                $arr_route  = explode('/', $inter_rout);
                $controller = array_shift($arr_route);
                $controller = ucfirst( $controller ) . 'Controller';

                $contr_path = ROOT. '/controller/' . $controller . '.php';

                if(is_file($contr_path)){
                    require_once($contr_path);
                }
                
                $action = array_shift($arr_route);
                $action = 'action' . ucfirst( $action );

                $new_controller = new $controller;
                $parameters = $arr_route;

                $result = call_user_func_array(array($new_controller, $action), $parameters);

                if($result != null){
                    return;
                }
            }
        }
        require_once(ROOT . '/views/site/404.php');
    }
}