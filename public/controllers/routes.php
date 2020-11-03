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
    'Manage' => new ManageController('GET', '/home/manage', 'auth/manage', 'Manage'),
    'ManageFilter' => new ManageFilterController('POST', '/home/manage/page', 'auth/tableUsers', 'Manage'),
    
    'Home' => new HomeController('GET', '/home', 'auth/home', 'Home'),

    'Edit' => new EditController('POST', '/home/manage/edit/user', 'auth/edit', 'Edit'),
    'Delete' => new DeleteController('POST', '/home/manage/delete/user'),

    'Access' => new AccessController('GET', '/user', 'access', 'User'),
    'Register' => new RegisterController('POST', '/register'),
    'Login' => new LoginController('POST', '/login'),
    'Logout' => new LogoutController('GET', '/logout'),
    
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