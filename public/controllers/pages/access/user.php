<?php

use app\controllers\Controller;

class AccessController extends Controller {

    function __construct() {
        parent::__construct(...func_get_args());
    }

    // @Overrided function from Controller.
    function preRender($router) {
        $router->getCollector()->{$this->method}($this->route, function () {
            $authMsg = !isset($_SESSION['loginMsg']) ? null : $_SESSION['loginMsg'];
            $params = array_merge($this->getParams(), array('loginMsg' => $authMsg));
            $this->setParams($params);
            return $this->view->render($this->getParams());
        });
    }
    
}
?>