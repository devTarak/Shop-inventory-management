<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LoginController::index', ["namespace" => "App\Controllers", "filter" => "deauth"]);
$routes->group('admin', ["namespace" => "App\Controllers\Admin", "filter" => "auth"], function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('user', 'Home::user');
    $routes->post('user/password', 'Home::changePassword');
    $routes->get('sellbulk', 'InvoiceController::sellBulkPage');
    $routes->post('sellbulk', 'InvoiceController::sellProductBalk');
    $routes->get('invoice-list', 'InvoiceController::invoicePage');
    $routes->get('invoice/(:segment)', 'InvoiceController::viewInvoice/$1');
    $routes->get('expenses', 'ExpenseController::index');
    $routes->post('expenses/add', 'ExpenseController::addExpense');
    $routes->get('invesmant','Investrator::index');
    $routes->post('invesmant','Investrator::addInvesmentData');

});
$routes->group('admin/products', ["namespace" => "App\Controllers\Admin", "filter"=>"auth"], function ($routes){
    $routes->get('/', 'Products::index');
    $routes->post('get', 'Products::getSingleProduct');
    $routes->post('edit', 'Products::editProduct');
    $routes->post('add', 'Products::addProduct');
    $routes->delete('delete', 'Products::deleteProduct');
});
$routes->group('admin/sell', ["namespace" => "App\Controllers\Admin", "filter" => "auth"], function ($routes) {
    $routes->get('view/iteams', 'SellProduct::index');
    $routes->post('product', 'SellProduct::sellProduct');
});
$routes->group('admin/reports', ["namespace" => "App\Controllers\Admin", "filter" => "auth"], function ($routes) {
    $routes->get('/', 'SellProduct::report');
    $routes->post('search', 'SellProduct::getReportData');
});
$routes->get('admin/addnewproduct', 'Products::addnewproductpage', ["namespace" => "App\Controllers\Admin", "filter" => "auth"]);
$routes->get('admin/searchProducts', 'SellProduct::searchProducts', ["namespace" => "App\Controllers\Admin", "filter" => "auth"]);
$routes->get('logout', 'LoginController::logout', ["namespace" => "App\Controllers", "filter" => "auth"]);
$routes->post('login', 'LoginController::login', ["namespace" => "App\Controllers", "filter" => "deauth"]);