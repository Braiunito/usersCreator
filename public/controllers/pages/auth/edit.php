<?php

use app\controllers\Controller;

class EditController extends Controller {

    function __construct() {
        parent::__construct(...func_get_args());
    }

    // @Overrided function from Controller.
    function preRender($router) {
        $router->getCollector()->group(['before' => 'auth'], function($collector) {
            $router = $GLOBALS['router'];
            $router->getCollector()->{$this->method}($this->route, function () {
                $success = false;
                $data = null;
                if (isset($_POST['id'])) {
                    $user = $_SESSION['user'];
                    $id = isset($_POST['id']) ? $_POST['id'] : null;
                    if ($id == null) {
                        echo json_encode(array('success' => $success));
                        return false;
                    }
                    $data = array(
                        "firstname" => !empty($_POST['firstname']) ? $_POST['firstname'] : null,
                        "lastname" => !empty($_POST['lastname']) ? $_POST['lastname'] : null,
                        "email" => !empty($_POST['email']) ? $_POST['email'] : null,
                        "pass" => !empty($_POST['pass']) ? $_POST['pass'] : null,
                    );
                    $result = $user->updateUserById($id, $data);
                    if ($result) {
                        $user = $user->getUserById($id);
                        $data = array(
                            "firstname" => $user['firstname'],
                            "lastname" => $user['lastname'],
                            "email" => $user['email'],
                        );
                        $success = true;
                    } else {
                        $data = null;
                        $success = false;
                    }
                    unset($user);
                }
                echo json_encode(array('success' => $success, 'user' => $data));
                return false;
            });
        });
    }
    
}
?>