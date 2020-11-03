<?php

use app\controllers\Controller;
use app\models\userModel\UserModel;

class DeleteController extends Controller {

    function __construct() {
        parent::__construct(...func_get_args());
    }

    function preRender($router) {
        $router->getCollector()->group(['before' => 'auth'], function($collector) {
        $router = $GLOBALS['router'];
            $router->getCollector()->{$this->method}($this->route, function () {
                $success = false;
                if (isset($_POST['id'])) {
                    $user = $_SESSION['user'];
                    $id = isset($_POST['id']) ? $_POST['id'] : null;
                    if ($user->getUser()['id'] == $id) {
                        unset($user);
                        echo json_encode(array('success' => $success, 'msg' => 'You can\'t delete yourself.'));
                        return false;
                    }
                    $result = $user->deleteUserById($id);
                    if ($result) {
                        $success = true;
                    } else {
                        $success = false;
                    }
                    unset($user);
                }
                echo json_encode(array('success' => $success));
                return false;
            });
        });
    }
    
}
?>