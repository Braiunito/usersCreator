<?php

use app\controllers\Controller;
use app\models\userModel\UserModel;

class LoginController extends Controller {

    private $user;

    function __construct() {
        parent::__construct(...func_get_args());
        $this->user = new UserModel();
    }

    private function validateForm($formData) {
        $email = $formData['email'];
        $password = $formData['password'];
        $valid = (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? FALSE : TRUE;
        if ($valid) {
            $valid = $this->user->isRegistered($email);
            if ($valid) {
                return $this->user->authUser($email, $password);
            }
        }
        return false;
    }

    function preRender($router) {
        $router->getCollector()->{$this->method}($this->route, function () {
            if (isset($_POST)) {
                $formData = array(
                    'email' => $_POST['email'],
                    'password' => $_POST['password']
                );
                $valid = $this->validateForm($formData);
                if ($valid) {
                    $result = $this->user->registerUser($formData);
                    $_SESSION['user'] = $formData['email'];
                    header('Location: /');
                } else {
                    $_SESSION['loginMsg'] = "Your email is invalid or its not registered yet.";
                    header('Location: /user');
                }
            }
            return $this->view->render($this->getParams());
        });
    }
    
}
?>