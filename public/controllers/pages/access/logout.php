<?php

use app\controllers\Controller;

class LogoutController extends Controller {

    function __construct() {
        parent::__construct(...func_get_args());
    }

    // @Overrided function from Controller.
    function preRender($router) {
        $router->getCollector()->{$this->method}($this->route, function () {
            session_unset();
            if(isset($_SESSION['user'])) {
                session_destroy();
                $_SESSION['user'] = null;
            }
            header("Location: /user");
            return false;
        });
    }
    
}
?>