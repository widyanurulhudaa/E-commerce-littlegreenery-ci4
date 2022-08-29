<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index', ['filter' => 'role:admin']);
$routes->get('/', 'Home::index');
$routes->get('/about', 'Pages::index');
$routes->get('/contact', 'Pages::contact');
$routes->get('/login', 'Login::index');
$routes->get('/register', 'Login::daftar');
$routes->get('/shop/cart', 'Shop::cart');
$routes->get('/shop/checkout', 'Shop::checkout', ['filter' => 'role:customer']);
$routes->get('/customers/orders/view/(:num)', 'Orders::view/$1');
$routes->get('/admin', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('/admin_products/add_new_product', 'Admin_Products::add_new_product', ['filter' => 'role:admin']);
$routes->get('/admin_products', 'Admin_Products::index', ['filter' => 'role:admin']);
$routes->get('/admin_customers', 'Admin_Customers::index', ['filter' => 'role:admin']);
$routes->get('/admin_contacts', 'Admin_Contacts::index', ['filter' => 'role:admin']);
$routes->get('/admin_orders', 'Admin_Orders::index', ['filter' => 'role:admin']);
$routes->get('/admin_payments', 'Admin_Payments::index', ['filter' => 'role:admin']);
$routes->get('/admin_reviews', 'Admin_Reviews::index', ['filter' => 'role:admin']);
$routes->get('/admin_settings', 'Admin_Settings::index', ['filter' => 'role:admin']);

$routes->get('/customer_payments/confirm', 'Customer_Payments::confirm', ['filter' => 'role:customer']);
$routes->get('/customer_orders', 'Customer_Orders::index', ['filter' => 'role:customer']);
$routes->get('/customer_profile', 'Customer_Profile::index', ['filter' => 'role:customer']);

/*
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
