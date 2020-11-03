<?php

namespace app\libs\app;
use app\libs\router\Router;
use app\models\userModel\UserModel;

class App {
    private $response;

    function __construct(Router $router) {
        $this->response = null;
        $this->router = $router;
    }

    function checkSchemas() {
        $userSchema = UserModel::checkUserSchema();
    }

    function run() {
        $this->checkSchemas();
        session_start();
        $response = $this->router->register();
        echo $response;
    }
    
}
?>