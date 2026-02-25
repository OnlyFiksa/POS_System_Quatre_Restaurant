<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Auth
$routes->get('/', 'AuthController::index');
$routes->get('/login', 'AuthController::index');
$routes->post('/login', 'AuthController::doLogin');
$routes->get('/logout', 'AuthController::logout');

// Kasir (protected)
$routes->group('kasir', ['filter' => 'auth:kasir,admin'], function($routes) {
    $routes->get('/', 'Kasir::index');
    $routes->post('checkout', 'Kasir::checkout');
    $routes->get('struk/(:num)', 'Kasir::struk/$1');
    $routes->post('cek-promo', 'Kasir::cekPromo');
});

// Admin (protected)
$routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
    $routes->get('/', 'Admin::dashboard');
    $routes->get('dashboard', 'Admin::dashboard');

    // Menu
    $routes->get('menu', 'MenuController::index');
    $routes->get('menu/tambah', 'MenuController::tambah');
    $routes->post('menu/simpan', 'MenuController::simpan');
    $routes->get('menu/edit/(:num)', 'MenuController::edit/$1');
    $routes->post('menu/update/(:num)', 'MenuController::update/$1');
    $routes->get('menu/hapus/(:num)', 'MenuController::hapus/$1');
    $routes->post('menu/toggle/(:num)', 'MenuController::toggle/$1');

    // Transaksi
    $routes->get('transaksi', 'Transaksi::index');
    $routes->get('transaksi/detail/(:num)', 'Transaksi::detail/$1');
    $routes->get('transaksi/batal/(:num)', 'Transaksi::batal/$1');
    $routes->get('transaksi/struk/(:num)', 'Transaksi::struk/$1');

    // Promo
    $routes->get('promo', 'Admin::promo');
    $routes->post('promo/simpan', 'Admin::simpanPromo');
    $routes->get('promo/hapus/(:num)', 'Admin::hapusPromo');

    // API data for charts
    $routes->get('api/pendapatan', 'Admin::apiPendapatan');
});

// ================================================================
// API Routes
// ================================================================

// Login tidak perlu API key
$routes->post('api/login', 'ApiController::login');

// Semua route API lain wajib pakai X-API-KEY di header
$routes->group('api', ['filter' => 'apikey'], function($routes) {
    $routes->post('logout', 'ApiController::logout');
    $routes->get('menu', 'ApiController::menu');
    $routes->get('menu/(:num)', 'ApiController::menuDetail/$1');
    $routes->get('kategori', 'ApiController::kategori');
    $routes->get('transaksi', 'ApiController::transaksi');
    $routes->get('transaksi/(:num)', 'ApiController::transaksiDetail/$1');
    $routes->post('transaksi', 'ApiController::buatTransaksi');
    $routes->get('dashboard', 'ApiController::dashboard');
    $routes->post('promo/cek', 'ApiController::cekPromo');
});