<?php

class AdminCategoryController extends AdminBase
{
    public function actionIndex(){

        parent::checkAdmin();

        $categoriesList = (new Category)->categoryListAdmin();

        $categoryStatus = Category::getStatusText($categoriesList);

        require_once(ROOT . '/views/admin_category/index.php');
        return true;
    }

    public function actionDelete($id)
    {
        parent::checkAdmin();

        if (isset($_POST['submit'])) {

            (new Category)->deleteCategoryById($id);

            header("Location: /admin/category");
        }

        require_once(ROOT . '/views/admin_category/delete.php');
        return true;
    }

    public function actionCreate()
    {
        parent::checkAdmin();

        if (isset($_POST['submit'])) {

            $name      = $_POST['name'];
            $sortOrder = $_POST['sort_order'];
            $status    = $_POST['status'];

            $errors = false;
            $errors = Validate::isEmpty($name);

            if ($errors == false) {

                (new Category)->createCategory($name, $sortOrder, $status);
                header("Location: /admin/category");
            }
        }

        require_once(ROOT . '/views/admin_category/create.php');
        return true;
    }


    public function actionUpdate($id)
    {

        parent::checkAdmin();

        $cat = new Category;
        $category = $cat->getCategoryById($id);

        if (isset($_POST['submit'])) {

            $name      = $_POST['name'];
            $sortOrder = $_POST['sort_order'];
            $status    = $_POST['status'];

            $cat->updateCategoryById($id, $name, $sortOrder, $status);
            header("Location: /admin/category");
        }

        require_once(ROOT . '/views/admin_category/update.php');
        return true;
    }


}