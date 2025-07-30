<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::index');
$routes->get('/test', 'TesController::index');

$routes->get('/login', 'AuthController::index');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');

// ADMIN
// $routes->get('/admin', 'Admin\DashboardController::index', ['filter' => 'auth']);
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth']);

//**PERPUSTAKAAN */
$routes->get('/perpustakaan', 'PerpustakaanController::index', ['filter' => 'auth']);
$routes->put('/perpustakaan/(:num)', 'PerpustakaanController::update/$1', ['filter' => 'auth']);

//**RAK */ 
$routes->get('/rak', 'RakController::index', ['filter' => 'auth']);
$routes->get('/rak/create', 'RakController::create', ['filter' => 'auth']);
$routes->post('/rak', 'RakController::store', ['filter' => 'auth']);
$routes->get('/rak/edit/(:num)', 'RakController::edit/$1', ['filter' => 'auth']);
$routes->put('/rak/(:num)', 'RakController::update/$1', ['filter' => 'auth']);
$routes->delete('/rak/(:num)', 'RakController::destroy/$1', ['filter' => 'auth']);

//**USER */ 
$routes->get('/user', 'UserController::index', ['filter' => 'auth']);
$routes->get('/user/create', 'UserController::create', ['filter' => 'auth']);
$routes->post('/user', 'UserController::store', ['filter' => 'auth']);
$routes->get('/user/edit/(:num)', 'UserController::edit/$1', ['filter' => 'auth']);
$routes->put('/user/(:num)', 'UserController::update/$1', ['filter' => 'auth']);
$routes->delete('/user/(:num)', 'UserController::destroy/$1', ['filter' => 'auth']);

//**TEMA */ 
$routes->get('/tema', 'TemaController::index', ['filter' => 'auth']);
$routes->get('/tema/create', 'TemaController::create', ['filter' => 'auth']);
$routes->post('/tema', 'TemaController::store', ['filter' => 'auth']);
$routes->get('/tema/edit/(:num)', 'TemaController::edit/$1', ['filter' => 'auth']);
$routes->put('/tema/(:num)', 'TemaController::update/$1', ['filter' => 'auth']);
$routes->delete('/tema/(:num)', 'TemaController::destroy/$1', ['filter' => 'auth']);

//**BUKU */ 
$routes->get('/buku', 'BukuController::index', ['filter' => 'auth']);
$routes->get('/buku/create', 'BukuController::create', ['filter' => 'auth']);
$routes->post('/buku', 'BukuController::store', ['filter' => 'auth']);
$routes->get('/buku/(:num)', 'BukuController::show/$1', ['filter' => 'auth']);
$routes->get('/buku/edit/(:num)', 'BukuController::edit/$1', ['filter' => 'auth']);
$routes->put('/buku/(:num)', 'BukuController::update/$1', ['filter' => 'auth']);
$routes->delete('/buku/(:num)', 'BukuController::destroy/$1', ['filter' => 'auth']);

//**PENGATURAN DENDA */
$routes->get('/pengaturan-denda', 'PengaturanDendaController::index', ['filter' => 'auth']);
$routes->put('/pengaturan-denda/(:num)', 'PengaturanDendaController::update/$1', ['filter' => 'auth']);

//**BUKU MASUK */
$routes->get('/buku_masuk', 'BukuMasukController::index', ['filter' => 'auth']);
$routes->get('/buku_masuk/create', 'BukuMasukController::create', ['filter' => 'auth']);
$routes->post('/buku_masuk', 'BukuMasukController::store', ['filter' => 'auth']);
$routes->get('/buku_masuk/(:num)', 'BukuMasukController::show/$1', ['filter' => 'auth']);
$routes->get('/buku_masuk/edit/(:num)', 'BukuMasukController::edit/$1', ['filter' => 'auth']);
$routes->put('/buku_masuk/(:num)', 'BukuMasukController::update/$1', ['filter' => 'auth']);
$routes->delete('/buku_masuk/(:num)', 'BukuMasukController::destroy/$1', ['filter' => 'auth']);

//**BUKU KELUAR */
$routes->get('/buku_keluar', 'BukuKeluarController::index', ['filter' => 'auth']);
$routes->get('/buku_keluar/create', 'BukuKeluarController::create', ['filter' => 'auth']);
$routes->post('/buku_keluar', 'BukuKeluarController::store', ['filter' => 'auth']);
$routes->get('/buku_keluar/(:num)', 'BukuKeluarController::show/$1', ['filter' => 'auth']);
$routes->get('/buku_keluar/edit/(:num)', 'BukuKeluarController::edit/$1', ['filter' => 'auth']);
$routes->put('/buku_keluar/(:num)', 'BukuKeluarController::update/$1', ['filter' => 'auth']);
$routes->delete('/buku_keluar/(:num)', 'BukuKeluarController::destroy/$1', ['filter' => 'auth']);

//**ANGGOTA */
$routes->get('/anggota', 'AnggotaController::index', ['filter' => 'auth']);
$routes->get('/anggota/create', 'AnggotaController::create', ['filter' => 'auth']);
$routes->post('/anggota', 'AnggotaController::store', ['filter' => 'auth']);
$routes->get('/anggota/(:num)', 'AnggotaController::show/$1', ['filter' => 'auth']);
$routes->get('/anggota/edit/(:num)', 'AnggotaController::edit/$1', ['filter' => 'auth']);
$routes->put('/anggota/(:num)', 'AnggotaController::update/$1', ['filter' => 'auth']);
$routes->delete('/anggota/(:num)', 'AnggotaController::destroy/$1', ['filter' => 'auth']);

$routes->get('/presensi', 'PresensiController::index', ['filter' => 'auth']);
$routes->post('/presensi', 'PresensiController::store', ['filter' => 'auth']);

//**PEMINJAMAN */
$routes->get('/peminjaman', 'PeminjamanController::index', ['filter' => 'auth']);
$routes->get('/peminjaman/create', 'PeminjamanController::create', ['filter' => 'auth']);
$routes->post('/peminjaman', 'PeminjamanController::store', ['filter' => 'auth']);
$routes->get('/peminjaman/(:num)', 'PeminjamanController::show/$1', ['filter' => 'auth']);
$routes->get('/peminjaman/edit/(:num)', 'PeminjamanController::edit/$1', ['filter' => 'auth']);
$routes->put('/peminjaman/(:num)', 'PeminjamanController::update/$1', ['filter' => 'auth']);
$routes->delete('/peminjaman/(:num)', 'PeminjamanController::destroy/$1', ['filter' => 'auth']);

//**DENDA */
$routes->get('/denda', 'DendaController::index', ['filter' => 'auth']);
$routes->get('/denda/(:num)/create', 'DendaController::create/$1', ['filter' => 'auth']);
$routes->post('/denda', 'DendaController::store', ['filter' => 'auth']);
$routes->get('/denda/(:num)', 'DendaController::show/$1', ['filter' => 'auth']);
$routes->get('/denda/edit/(:num)', 'DendaController::edit/$1', ['filter' => 'auth']);
$routes->put('/denda/(:num)', 'DendaController::update/$1', ['filter' => 'auth']);
$routes->delete('/denda/(:num)', 'DendaController::destroy/$1', ['filter' => 'auth']);

$routes->get('report/buku_masuk', 'ReportController::bukuMasuk', ['filter' => 'auth']);
$routes->get('report/buku_masuk/export', 'ReportController::exportBukuMasuk', ['filter' => 'auth']);

$routes->get('report/buku_keluar', 'ReportController::bukuKeluar', ['filter' => 'auth']);
$routes->get('report/buku_keluar/export', 'ReportController::exportBukuKeluar', ['filter' => 'auth']);

$routes->get('report/denda', 'ReportController::denda', ['filter' => 'auth']);
$routes->get('report/denda/export', 'ReportController::exportdenda', ['filter' => 'auth']);

$routes->get('report/peminjaman', 'ReportController::peminjaman', ['filter' => 'auth']);
$routes->get('report/peminjaman/export', 'ReportController::exportPeminjaman', ['filter' => 'auth']);
