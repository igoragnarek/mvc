<?php

class AdminController extends AdminBase
{
    
    public function actionIndex(){

        parent::checkAdmin();

        require_once(ROOT . '/views/admin/index.php');
        return true;
    }
}