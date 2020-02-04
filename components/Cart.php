<?php

class Cart
{

    public function addProduct($id){
        
        $sess_array = array();
        $id = (int) $id;

        if(isset($_SESSION['products'])){
            $sess_array = $_SESSION['products'];
        }

        if(array_key_exists($id, $sess_array)){
            $sess_array[$id]++;
        }else{
            $sess_array[$id] = 1;
        }

        $_SESSION['products'] = $sess_array;

        return static::countItems();
    }

    public static function countItems(){

        $count = 0;

        if(isset($_SESSION['products'])){
            foreach($_SESSION['products'] as $key => $val){
                $count += $val;
            }
        }

        return $count;

    }

    public static function getProducts(){
        if(isset($_SESSION['products'])){
            return $_SESSION['products'];
        }
    }

    public static function getTotalPrice($products){

        $total = 0;
        $sess = static::getProducts();

        foreach($products as $product){

            $total += $product['price'] * $sess[$product['id']];
        }

        return $total;
    }


    public function deleteProduct($id){

        $sess = static::getProducts();
        unset($sess[$id]);
        $_SESSION['products'] = $sess;
    }

    public function clear(){
        if(isset($_SESSION['products'])){
            unset($_SESSION['products']);
        }
    }

}