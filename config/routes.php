<?php

return [

    'product/([0-9]+)' => 'product/view/$1',

    'about'      => 'site/about',
    'contacts'   => 'site/contact',
    'index.php'  => 'site/index',
    ''           => 'site/index',

    'catalog' => 'catalog/index',
    'catalog/page-([0-9]+)' => 'catalog/index/$1',
    'category/([0-9]+)' => 'catalog/category/$1',
    'category/([0-9]+)/page-([0-9]+)' => 'catalog/category/$1/$2',

    'cart/addAjax/([0-9]+)' => 'cart/addAjax/$1',
    'cart/delete/([0-9]+)' => 'cart/delete/$1',
    'cart/checkout' => 'cart/checkout',
    'cart' => 'cart/index',

    'user/register' => 'user/register',
    'user/login'    => 'user/login',
    'user/logout'   => 'user/logout',

    'cabinet'      => 'cabinet/index',
    'cabinet/edit' => 'cabinet/edit',

    'admin' => 'admin/index',
    'admin/product' => 'adminProduct/index',
    'admin/product/create' => 'adminProduct/create',
    'admin/product/delete/([0-9]+)' => 'adminProduct/delete/$1',
    'admin/product/update/([0-9]+)' => 'adminProduct/update/$1',

    'admin/category' => 'adminCategory/index',
    'admin/category/create' => 'adminCategory/create',
    'admin/category/delete/([0-9]+)' => 'adminCategory/delete/$1',
    'admin/category/update/([0-9]+)' => 'adminCategory/update/$1',

    'admin/order' => 'adminOrder/index',
    'admin/order/delete/([0-9]+)' => 'adminOrder/delete/$1',
    'admin/order/view/([0-9]+)' => 'adminOrder/view/$1',
    'admin/order/update/([0-9]+)' => 'adminOrder/update/$1',












];