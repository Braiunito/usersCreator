<?php

use app\controllers\Controller;

class HomeController extends Controller {

    function __construct() {
        parent::__construct(...func_get_args());
    }

    // @Overrided function from Controller.
    function preRender($router) {
        $params = $this->getParams();
        $params['name'] = isset($_SESSION['user']) ? $_SESSION['user'] : null;
        $this->setParams($params);

        $router->getCollector()->group(['before' => 'auth'], function($collector) {
            $router = $GLOBALS['router'];
            $router->getCollector()->{$this->method}($this->route, function () {
                $_SESSION['loginMsg'] = null;
                return $this->view->render($this->getParams());
            });
        });
    }
    
}
?>