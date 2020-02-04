<?php

class ProductController
{
    public function actionView($id){

        $category = (new Category)->categoryList();
        $product  = (new Product)->getProductById($id);

        $image    = Product::getImage($product['id']);
        $avail    = Product::existText($product['availability']);

        require_once(ROOT . '/views/product/view.php');
        return true;
    }
}