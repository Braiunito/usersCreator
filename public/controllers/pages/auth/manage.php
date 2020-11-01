<?php

use app\controllers\Controller;

class ManageController extends Controller {

    function __construct() {
        parent::__construct(...func_get_args());
    }

    // @Overrided function from Controller.
    function preRender($router) {
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $params = $this->getParams();
            $params['users'] = $user->getAllUsers();
            $this->setParams($params);
        }
        $router->getCollector()->group(['before' => 'auth'], function($collector) {
            $router = $GLOBALS['router'];
            $router->getCollector()->{$this->method}($this->route, function ($id = null) {
                $_SESSION['loginMsg'] = null;
                return $this->view->render($this->getParams());
            });
        });
    }
    
}
?>