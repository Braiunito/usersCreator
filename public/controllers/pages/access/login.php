<?php

use app\controllers\Controller;
use app\models\userModel\UserModel;

class LoginController extends Controller {

    private $user;

    function __construct() {
        parent::__construct(...func_get_args());
        $this->user = new UserModel();
    }

    private function loginMessage($msg) {
        $_SESSION['loginMsg'] = $msg;
        header('Location: /user');
        return false;
    }

    function preRender($router) {
        $router->getCollector()->{$this->method}($this->route, function () {
            if (isset($_POST)) {
                $formData = array(
                    'email' => isset($_POST['email']) ? $_POST['email'] : null,
                    'password' => isset($_POST['password']) ? $_POST['password'] : null
                );
                $valid = $this->user->validateForm($formData);
                if ($valid) {
                    $auth = $this->user->authUser($formData['email'], $formData['password']);
                    if ($auth) {
                        $_SESSION['user'] = $this->user->getUser();
                        header('Location: /');
                        return false;
                    }
                }
                $msg = "Your email is invalid or its not registered yet.";
                $this->loginMessage($msg);
            }
            return $this->view->render($this->getParams());
        });
    }
    
}
?>