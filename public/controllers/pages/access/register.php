<?php

use app\controllers\Controller;
use app\models\userModel\UserModel;

class RegisterController extends Controller {

    private $user;
    private $msg;

    function __construct() {
        parent::__construct(...func_get_args());
        $this->user = new UserModel();
        $this->msg = null;
    }

    private function validateRegistrationForm($formData, $msg = null) {
        $validData = $this->user->validateForm($formData);
        if ($validData !== true) {
            $this->msg = $validData;
            return false;
        }
        $isNotRegistered = !$this->user->isRegistered($formData['email']);
        if ($isNotRegistered !== true) {
            $this->msg = 'Your email is already taken.';
            return false;
        }
        return true;
    }

    private function loginMessage() {
        $_SESSION['loginMsg'] = $this->msg;
        header('Location: /user');
        return false;
    }

    function preRender($router) {
        $router->getCollector()->{$this->method}($this->route, function () {
            if (isset($_POST)) {
                $formData = array(
                    'firstname' => isset($_POST['firstname']) ? $_POST['firstname'] : null,
                    'lastname' => isset($_POST['lastname']) ? $_POST['lastname'] : null,
                    'email' => isset($_POST['email']) ? $_POST['email'] : null,
                    'password' => isset($_POST['password']) ? $_POST['password'] : null
                );
                $valid = $this->validateRegistrationForm($formData, $this->msg);
                if ($valid) {
                    $result = $this->user->registerUser($formData);
                    if ($result) {
                        $_SESSION['user'] = $this->user;
                    }
                    $this->msg = ($result) ? "Congratulations you are registered!" : "Sorry something wents wrong in the registration.";
                    $this->loginMessage();
                } else {
                    $this->loginMessage();
                }
            }
            header("Location: {$_SERVER['HTTP_REFERER']}");
        });
    }
    
}
?>