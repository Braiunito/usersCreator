<?php

namespace app\libs\app;
use app\libs\router\Router;

class App {
    private $response;

    function __construct(Router $router) {
        $this->response = null;
        $this->router = $router;
    }

    function run() {
        session_start();
        //$_SESSION['user'] = 'Mockup';
        $response = $this->router->register();
        echo $response;
    }
    
}
?>