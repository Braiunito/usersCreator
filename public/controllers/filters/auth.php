<?php

use app\controllers\Controller;

class AuthFilterController extends Controller {

    function __construct() {
        parent::__construct(...func_get_args());
    }

    // @Overrided function from Controller.
    function preRender($router) {
        $router->getCollector()->{$this->method}($this->route, function () {
            $isAlive = true;
            if(!isset($_SESSION['user'])) {
                $_SESSION['loginMsg'] = array('msg' => 'Error, you need to be authenticated first.', 'type' => 'danger');
                header('Location: /user');
                return false;
            } else {
                $user = $_SESSION['user'];
                $id = $user->getUser()['id'];
                $isAlive = $user->getUserById($id);
                unset($user);
                if (!$isAlive) {
                    $_SESSION['loginMsg'] = array('msg' => 'Error, your user no longer exist or was deleted.', 'type' => 'danger');
                    if (!empty($_POST)) {
                        echo json_encode(array('redirect' => '/user'));
                        return false;
                    }
                    header('Location: /user');
                    return false;
                }
            }
        });
    }
    
}
?>