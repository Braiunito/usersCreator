<?php

use app\controllers\Controller;

class ManageController extends Controller {

    private $pagination = 5;

    function __construct() {
        parent::__construct(...func_get_args());
    }

    function paginateUsers(Array $users, int $page) {
        $pagination = $this->pagination;
        $bounded = array();
        for ($i = ($page * $pagination); $i < (($page+1) * $pagination); $i++) { 
            if (isset($users[$i])) {
                array_push($bounded, $users[$i]);
            } else {
                break;  
            }
        }
        $pages = ceil( count($users) / ($pagination) ) - 1;
        $data = array('bounded' => $bounded, 'pages' => $pages);
        return $data;
    }

    function setUserInPages($page) {
        $user = $_SESSION['user'];
        $users = $user->getAllUsers();
        $params = $this->getParams();
        $data = $this->paginateUsers($users, $page);
        $params['users'] = $data['bounded'];
        $params['pages']['amount'] = $data['pages'];
        $params['pages']['current'] = $page;
        $this->setParams($params);
        unset($user);
    }


    // @Overrided function from Controller.
    function preRender($router) {
        $router->getCollector()->group(['before' => 'auth'], function($collector) {
            $router = $GLOBALS['router'];
            $router->getCollector()->{$this->method}($this->route, function ($id = null) {
                if (isset($_SESSION['user'])) {
                    $user = $_SESSION['user'];
                    $params = $this->getParams();
                    $users = $user->getAllUsers();
                    $params['users'] = $users;
                    $this->setParams($params);
                    unset($user);
                }
                $_SESSION['loginMsg'] = null;
                return $this->view->render($this->getParams());
            });
        });
    }
    
}
?>