<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('admin', 'Home::index');
$routes->get('admin/products', 'Products::index');
$routes->post('admin/getproduct', 'Products::getSingleProduct');
$routes->post('admin/editproduct', 'Products::editProduct');
$routes->post('admin/addproduct', 'Products::addProduct');
$routes->post('admin/deleteproduct', 'Products::deleteProduct');
$routes->get('admin/addnewproduct', 'Products::addnewproductpage');
$routes->get('admin/sellproduct', 'SellProduct::index');
$routes->get('admin/searchProducts', 'SellProduct::searchProducts');
$routes->post('admin/sellproduct', 'SellProduct::sellProduct');
$routes->get('admin/reports', 'SellProduct::report');
$routes->post('admin/reports/searchReports', 'SellProduct::getReportData');