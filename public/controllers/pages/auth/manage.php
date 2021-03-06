<?php

use app\controllers\Controller;

class ManageController extends Controller {

    private $pagination = 5;

    function __construct() {
        parent::__construct(...func_get_args());
    }


    // @Overrided function from Controller.
    function preRender($router) {
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