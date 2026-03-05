<?php
session_start();

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Core\Router;
use App\Controllers\CustomerController;
use App\Controllers\DriverController;
use App\Controllers\UserController;
use App\Controllers\AuthController;
use App\Controllers\CustomerLocationController;
use App\Controllers\FruitTypeController;
use App\Controllers\FruitPurchaseVariantController;
use App\Controllers\FruitBoxTypeController;
use App\Controllers\FruitBoxTypeItemController;

// Load environment
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Router
$router = new Router();
$customerController = new CustomerController();
$driverController = new DriverController();
$userController = new UserController();
$authController = new AuthController();
$locationController = new CustomerLocationController();
$fruitTypeController = new FruitTypeController();
$variantController = new FruitPurchaseVariantController();
$boxTypeController = new FruitBoxTypeController();
$boxTypeItemController = new FruitBoxTypeItemController();

// Routes
$router->get('/', function() {
    \App\Core\View::render('home', ['title' => 'Dashboard']);
});


// Authentication
$router->get('/login', [$authController, 'login']);
$router->post('/login', [$authController, 'login']);
$router->get('/logout', [$authController, 'logout']);

// Customer routes
$router->get('/customers', [$customerController, 'index']);
$router->get('/customers/view/{id}', [$customerController, 'show']);
$router->get('/customers/create', [$customerController, 'create']);
$router->post('/customers/create', [$customerController, 'create']);
$router->get('/customers/edit/{id}', [$customerController, 'edit']);
$router->post('/customers/edit/{id}', [$customerController, 'edit']);
$router->get('/customers/delete/{id}', [$customerController, 'delete']);

// Driver routes
$router->get('/drivers', [$driverController, 'index']);
$router->get('/drivers/create', [$driverController, 'create']);
$router->post('/drivers/create', [$driverController, 'create']);
$router->get('/drivers/edit/{id}', [$driverController, 'edit']);
$router->post('/drivers/edit/{id}', [$driverController, 'edit']);
$router->get('/drivers/delete/{id}', [$driverController, 'delete']);


// Gebruikers admin
$router->get('/users', [$userController, 'index']);
$router->get('/users/create', [$userController, 'create']);
$router->post('/users/create', [$userController, 'create']);
$router->get('/users/edit/{id}', [$userController, 'edit']);
$router->post('/users/edit/{id}', [$userController, 'edit']);
$router->get('/users/delete/{id}', [$userController, 'delete']);



// Location routes
$router->get('/locations', [$locationController, 'index']);
$router->get('/locations/create', [$locationController, 'create']);
$router->post('/locations/create', [$locationController, 'create']);
$router->get('/locations/view/{id}', [$locationController, 'show']);
$router->get('/locations/edit/{id}', [$locationController, 'edit']);
$router->post('/locations/edit/{id}', [$locationController, 'edit']);
$router->get('/locations/delete/{id}', [$locationController, 'delete']);



$router->get('/fruittypes', [$fruitTypeController, 'index']);
$router->get('/fruittypes/create', [$fruitTypeController, 'create']);
$router->post('/fruittypes/create', [$fruitTypeController, 'create']);
$router->get('/fruittypes/view/{id}', [$fruitTypeController, 'show']);
$router->get('/fruittypes/edit/{id}', [$fruitTypeController, 'edit']);
$router->post('/fruittypes/edit/{id}', [$fruitTypeController, 'edit']);
$router->get('/fruittypes/delete/{id}', [$fruitTypeController, 'delete']);

$router->get('/variants/create', [$variantController, 'create']);
$router->post('/variants/create', [$variantController, 'create']);
$router->get('/variants/edit/{id}', [$variantController, 'edit']);
$router->post('/variants/edit/{id}', [$variantController, 'edit']);
$router->get('/variants/delete/{id}', [$variantController, 'delete']);

$router->get('/boxtypes', [$boxTypeController, 'index']);
$router->get('/boxtypes/create', [$boxTypeController, 'create']);
$router->post('/boxtypes/create', [$boxTypeController, 'create']);
$router->get('/boxtypes/view/{id}', [$boxTypeController, 'show']);
$router->get('/boxtypes/edit/{id}', [$boxTypeController, 'edit']);
$router->post('/boxtypes/edit/{id}', [$boxTypeController, 'edit']);
$router->get('/boxtypes/delete/{id}', [$boxTypeController, 'delete']);


$router->get('/boxtypeitems/create', [$boxTypeItemController, 'create']);
$router->post('/boxtypeitems/create', [$boxTypeItemController, 'create']);
$router->get('/boxtypeitems/edit/{id}', [$boxTypeItemController, 'edit']);
$router->post('/boxtypeitems/edit/{id}', [$boxTypeItemController, 'edit']);
$router->get('/boxtypeitems/delete/{id}', [$boxTypeItemController, 'delete']);

// Dispatch
$router->resolve();