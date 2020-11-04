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

    function setUserInCounters($current, $text = null) {
        $user = $_SESSION['user'];
        $users = $user->getAllUsers();
        $params = $this->getParams();
        if (!empty($text)) {
            $newUsers = array();
            foreach ($users as $pos => $user) {
                foreach ($user as $key => $value) {
                    if ($key != 'pass') {
                    if (strpos(strtolower($value), strtolower($text)) !== false) {
                    if (!in_array($user, $newUsers)) {
                        array_push($newUsers, $user);
                    }
                    }
                    }
                }
            }
            $data['bounded'] = (!empty($newUsers)) ? $newUsers : $users;
        } else {
            $data = $this->paginateUsers($users, $current);
            $params['counters']['amount'] = $data['counters'];
            $params['counters']['current'] = $current;
        }
        $params['users'] = $data['bounded'];
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
                        if (isset($_POST['text'])) {
                            $text = $_POST['text'];
                            $this->setUserInCounters($page, $text);
                        } else {
                            $this->setUserInCounters($page);
                        }
                    }
                }
                $_SESSION['loginMsg'] = null;
                return $this->view->render($this->getParams());
            });
        });
    }
    
}
?>