<?php

class AdminOrderController extends AdminBase
{


    public function actionIndex(){

        parent::checkAdmin();

        $ordersList = (new Order)->getOrderList();

        $status = Order::getStatusText($ordersList);

        require_once(ROOT . '/views/admin_order/index.php');
        return true;
    }

    public function actionDelete($id){

        parent::checkAdmin();

        if (isset($_POST['submit'])) {

            (new Order)->deleteOrderById($id);
            header("Location: /admin/order");
        }

        require_once(ROOT . '/views/admin_order/delete.php');
        return true;
    }

    public function actionView($id){

        parent::checkAdmin();

        $order            = (new Order)->getOrderById($id);
        $productsQuantity = json_decode($order['products'], true);
        $productsIds      = array_keys($productsQuantity);
        $products         = (new Product)->getProductsByIds(array_flip($productsIds));
        $status           = Order::getStatusText(array($order));

        require_once(ROOT . '/views/admin_order/view.php');
        return true;
    }

    public function actionUpdate($id){

        parent::checkAdmin();

        $orderInstance = new Order;
        $order = $orderInstance->getOrderById($id);

        if (isset($_POST['submit'])) {

            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
            $userComment = $_POST['userComment'];
            $date = $_POST['date'];
            $status = $_POST['status'];

            $orderInstance->updateOrderById($id, $userName, $userPhone, $userComment, $date, $status);

            header("Location: /admin/order/view/$id");
        }

        require_once(ROOT . '/views/admin_order/update.php');
        return true;
    }
}