<?php

use app\controllers\Controller;

class EditController extends Controller {

    function __construct() {
        parent::__construct(...func_get_args());
    }

    // @Overrided function from Controller.
    function preRender($router) {
        $router->getCollector()->group(['before' => 'auth'], function($collector) {
            if (isset($_GET['id'])) {
                $user = $_SESSION['user'];
                $id = isset($_GET['id']) ? $_GET['id'] : null;
                $user = $user->getOneUserById($id);
                if ($user) {
                    $params = $this->getParams();
                    $params['edit'] = $user;
                    $this->setParams($params);
                } else {
                    echo "<h1 style='color: red'> Error! </h1>";
                }
            }
            $router = $GLOBALS['router'];
            $router->getCollector()->{$this->method}($this->route, function () {
                return $this->view->render($this->getParams());
            });
        });
    }
    
}
?>