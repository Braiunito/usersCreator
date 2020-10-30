<?php

use app\controllers\Controller;

class AuthFilterController extends Controller {

    function __construct() {
        parent::__construct(...func_get_args());
    }

    // @Overrided function from Controller.
    function preRender($router) {
        $router->getCollector()->{$this->method}($this->route, function () {
            if(!isset($_SESSION['user'])) {
                $_SESSION['loginMsg'] = 'Error, you need to be authenticated first.';
                header('Location: /user');
                return false;
            }
        });
    }
    
}
?>