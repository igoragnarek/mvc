<?php

class CatalogController
{

    public function actionIndex($page = 1){

        $category = (new Category)->categoryList();
        $productInstance = new Product;

        $totalCount = $productInstance->getCountProduct();
        $currentPage = $productInstance->getCatalogProduct($page);

        $pagination = new Pagination($totalCount, $page, Product::DEFAULT, 'page-');

        require_once(ROOT . '/views/catalog/index.php');  
        return true;
    }

    public function actionCategory($id, $page = 1){

        $category = (new Category)->categoryList();
        $productInstance = new Product;

        $categories = $productInstance->getProductByCategory($id, $page);
        $totalCount = $productInstance->getCountProductsByCategory($id);

        $category_id = $id;

        $pagination = new Pagination($totalCount, $page, Product::DEFAULT, 'page-');


        require_once(ROOT . '/views/catalog/category.php');
        return true;
    }

}