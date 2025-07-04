<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('admin', 'Home::index');
$routes->group('admin/products', function ($routes){
    $routes->get('/', 'Products::index');
    $routes->post('get', 'Products::getSingleProduct');
    $routes->post('edit', 'Products::editProduct');
    $routes->post('add', 'Products::addProduct');
    $routes->post('delete', 'Products::deleteProduct');
});
$routes->group('admin/sell', function ($routes) {
    $routes->get('view/iteams', 'SellProduct::index');
    $routes->post('product', 'SellProduct::sellProduct');
});
$routes->group('admin/reports', function ($routes) {
    $routes->get('/', 'SellProduct::report');
    $routes->post('search', 'SellProduct::getReportData');
});
$routes->get('admin/addnewproduct', 'Products::addnewproductpage');
$routes->get('admin/searchProducts', 'SellProduct::searchProducts');