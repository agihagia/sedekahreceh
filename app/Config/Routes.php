<?php

namespace Config;



// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// $routes->get('/', 'Home::index');

$routes->get('/', 'Home::index');
$routes->add('/home/loadmore', 'Home::loadMore');

$routes->get('/register', 'Auth::register');
$routes->get('/login', 'Auth::index');
$routes->get('/logout', 'Auth::logout');
$routes->group('auth', [], function ($routes) {
	$routes->add('login', 'Auth::login');
	$routes->post('save_register', 'Auth::save_register');
});


$routes->group('', ['filter' => 'AuthFilters'], function ($routes) {
	$routes->get('/dashboard', 'Dashboard::index');

	$routes->get('/transaksi', 'Transaksi::index');
	$routes->post('/transaksi/hapus', 'Transaksi::hapus');
	$routes->get('/transaksi/setor/(:any)', 'Transaksi::setor/$1');
	$routes->post('/transaksi/save_setor', 'Transaksi::setorsedekah');
	$routes->get('/transaksi/tarik/(:any)', 'Transaksi::tarik/$1');
	$routes->post('/transaksi/save_tarik', 'Transaksi::tarikSaldo');
	$routes->get('/transaksi/getDetail', 'Transaksi::getDetail');
	$routes->get('/transaksi/rekap', 'Transaksi::rekap');
	$routes->get('/transaksi/cetakTransaksi/(:num)', 'Transaksi::cetakTransaksi/$1');
	$routes->add('/transaksi/listdata', 'Transaksi::listData');
	$routes->post('/transaksi/proses_penarikan', 'Transaksi::prosesPenarikan');

	$routes->get('/datasedekah', 'sedekah::index');
	$routes->get('/sedekah/create', 'sedekah::create');
	$routes->post('/sedekah/save', 'sedekah::save');
	$routes->get('/sedekah/edit/(:segment)', 'sedekah::edit/$1');
	$routes->post('/sedekah/update/(:segment)', 'sedekah::update/$1');
	$routes->delete('/sedekah/delete/(:num)', 'sedekah::delete/$1');
	$routes->get('/sedekah/detail/(:any)', 'sedekah::detail/$1');
	$routes->add('/sedekah/listdata', 'sedekah::listData');

	$routes->get('/user', 'User::index');
	$routes->add('/user/loadmore', 'User::loadMore');
	$routes->add('/user/listdata', 'User::listData');
	$routes->get('/user/register', 'User::register');
	$routes->get('/user/edit/(:segment)', 'User::edit_user/$1');
	$routes->post('/user/update/(:num)', 'User::update_user/$1');
	$routes->get('/user/reset/(:any)', 'User::resetpw/$1');
	$routes->post('/user/reset_pass/(:num)', 'User::reset_password/$1');
	$routes->get('/user/getTransaksiUser', 'User::getTransaksiUser');

	$routes->get('/akun', 'User::akun');
	$routes->get('/akun/detail/(:any)', 'User::detail/$1');
	$routes->get('/akun/register', 'User::register');
	$routes->post('/akun/save_register', 'User::save_register');
	$routes->get('/akun/edit/(:any)', 'User::edit_akun/$1');
	$routes->post('/akun/update/(:num)', 'User::update_akun/$1');
	$routes->get('/akun/reset/(:any)', 'User::reset/$1');
	$routes->post('/akun/reset_pass/(:num)', 'User::reset_pass/$1');
	$routes->delete('/akun/delete/(:num)', 'User::delete/$1');
	$routes->post('/akun/user/toggle', 'User::toggle');
	$routes->add('/akun/loadmore', 'User::detailLoadMore');

	$routes->get('/faq', 'Faq::index');
	$routes->add('/faq/listdata', 'Faq::listData');
	$routes->add('/faq/create', 'Faq::create');
	$routes->add('/faq/save', 'Faq::save');
	$routes->add('/faq/edit', 'Faq::edit');
	$routes->add('/faq/update', 'Faq::update');
	$routes->delete('/faq/delete/(:num)', 'Faq::delete/$1');
	$routes->add('/faq/refresh', 'Faq::refresh');

	$routes->get('/setting', 'Setting::index');
	$routes->add('/setting/listdata', 'Setting::listData');
	$routes->add('/setting/edit', 'Setting::edit');
	$routes->add('/setting/update', 'Setting::update');
	$routes->delete('/setting/delete/(:num)', 'Setting::delete/$1');
	$routes->add('/setting/refresh', 'Setting::refresh');

	$routes->get('/backup', 'Backup::index');
	$routes->add('/backup/listdata', 'Backup::listData');
	$routes->add('/backup/create', 'Backup::create');
	$routes->add('/backup/save', 'Backup::save');
	$routes->delete('/backup/delete/(:num)', 'Backup::delete/$1');
	$routes->add('/backup/refresh', 'Backup::refresh');

});

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
