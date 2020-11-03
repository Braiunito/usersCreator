<?php

use app\controllers\Controller;
use app\models\userModel\UserModel;

class RegisterController extends Controller {

    private $user;
    private $msg;
    private $type;

    function __construct() {
        parent::__construct(...func_get_args());
        $this->user = new UserModel();
        $this->msg = null;
        $this->type = 'warning';
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
        $_SESSION['loginMsg'] = array('msg' => $this->msg, 'type' => $this->type);
        header('Location: /user');
        return false;
    }


    // ToDo: Implement SendGrid email to send a confirmation mail after registration.
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
                    // Enable or disable this for auto-login after registration.
                    /* if ($result) {
                        $_SESSION['user'] = $this->user;
                    } */
                    $this->msg = ($result) ? "Congratulations you are registered!" : "Sorry, something wents wrong in the registration.";
                    $this->type = ($result) ? "success" : "danger";
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