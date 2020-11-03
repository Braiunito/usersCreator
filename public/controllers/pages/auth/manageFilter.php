<?php

use app\controllers\Controller;

class ManageFilterController extends Controller {

    private $pagination = 5;

    function __construct() {
        parent::__construct(...func_get_args());
    }

    function paginateUsers(Array $users, int $current) {
        $pagination = $this->pagination;
        $bounded = array();
        for ($i = ($current * $pagination); $i < (($current+1) * $pagination); $i++) { 
            if (isset($users[$i])) {
                array_push($bounded, $users[$i]);
            } else {
                break;  
            }
        }
        $counters = ceil( count($users) / ($pagination) ) - 1;
        $data = array('bounded' => $bounded, 'counters' => $counters);
        return $data;
    }

    function setUserInCounters($current) {
        $user = $_SESSION['user'];
        $users = $user->getAllUsers();
        $params = $this->getParams();
        $data = $this->paginateUsers($users, $current);
        $params['users'] = $data['bounded'];
        $params['counters']['amount'] = $data['counters'];
        $params['counters']['current'] = $current;
        $this->setParams($params);
        unset($user);
    }


    // @Overrided function from Controller.
    function preRender($router) {
        $router->getCollector()->group(['before' => 'auth'], function($collector) {
            $router = $GLOBALS['router'];
            $router->getCollector()->{$this->method}($this->route, function ($page = null) {
                if (isset($_SESSION['user'])) {
                    if (isset($_POST['page'])) {
                        $page = $_POST['page'];
                        $this->setUserInCounters($page);
                    } else {
                        $page = 0;
                        $this->setUserInCounters($page);
                    }
                }
                $_SESSION['loginMsg'] = null;
                return $this->view->render($this->getParams());
            });
        });
    }
    
}
?>