<?php

use app\controllers\Controller;


// TODO: Complete as an extra
class ManagePagerController extends ManageController {

    function __construct() {
        parent::__construct(...func_get_args());
    }

    // @Overrided function from Controller.
    function preRender($router) {
        $router->getCollector()->group(['before' => 'auth'], function($collector) {
            $router = $GLOBALS['router'];
            $router->getCollector()->{$this->method}($this->route, function () {
                $data = null;
                $success = false;
                if (isset($_POST['page'])) {
                    $page = $_POST['page'];
                    $this->setUserInPages($page);
                    $data = $this->getParams()['users'];
                    if ($data) {
                        $success = true;
                    }
                } 
                echo json_encode(array('users' => $data, 'success' => $success));
                unset($data);
                return false;
            });
        });
    }
    
}
?>