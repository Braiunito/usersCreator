<?php

// To require all the controllers, filters and pages
use app\libs\router\Router;
$files = glob(__DIR__ . '/*/*.php');
foreach ($files as $file) { require($file); }
$files = glob(__DIR__ . '/*/*/*.php');
foreach ($files as $file) { require($file); }

// The last parameter is a default entry point
$router = new Router(null, null, null, '/home');

// Initializing Routes
$routes = Array(
    'Home' => new HomeController('GET', '/home', 'auth/home', 'Home'),
    'Access' => new AccessController('GET', '/user', 'access', 'User'),
    'Register' => new RegisterController('POST', '/register', 'access', 'register'),
    'Login' => new LoginController('POST', '/login', 'access', 'Login'),
    'Logout' => new LogoutController('GET', '/logout', 'logout', 'Logout'),
    '500' => new GenericController(null, '/500', 'errors/500', 'Internal Server Error', array('msg' => 'Internal Server error.', 'code' => '500')),
    '404' => new NotFoundController(null, '/404', 'errors/404', 'Page Not Found' ,array('msg' => 'The page that you are requseting does not exist.', 'code' => '404')),
);

// Initializing Filters
$filters = array(
    'Auth' => new AuthFilterController('filter', 'auth'),
);

// Initializing ajax Components
$ajaxPages = array(
    'AjxLogin' => new GenericController('POST', '/ajaxLogin', 'access/login', 'Login'),
    'AjxRegister' => new GenericController('POST', '/ajaxRegister', 'access/register', 'Login'),
);


// Merging all Route-Controllers
$routes = array_merge(
    $routes,
    $filters,
    $ajaxPages
);


// Starting the register of the routes
$router->setRoutes($routes); // Set all the defined routes above
$router->setRouter($router); // Register the router at this point

?>