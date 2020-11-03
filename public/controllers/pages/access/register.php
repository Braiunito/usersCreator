<?php

use app\controllers\Controller;
use app\models\userModel\UserModel;

class RegisterController extends Controller {

    private $user;
    private $msg;
    private $type;
    private $byModal;
    private $success;

    function __construct() {
        parent::__construct(...func_get_args());
        $this->user = new UserModel();
        $this->msg = null;
        $this->type = 'warning';
        $this->byModal = false;
        $this->success = false;
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
        if (!$this->byModal) {
            $_SESSION['loginMsg'] = array('msg' => $this->msg, 'type' => $this->type);
            header('Location: /user');
        } else {
            echo json_encode(array('success' => $this->success, 'msg' => $this->msg));
            return false;
        }
    }


    // ToDo: Implement SendGrid email to send a confirmation mail after registration.
    function preRender($router) {
        $router->getCollector()->{$this->method}($this->route, function () {
            if (isset($_POST)) {
                $this->byModal = isset($_POST['bymodal']) ? $_POST['bymodal'] : null;
                $formData = array(
                    'firstname' => isset($_POST['firstname']) ? $_POST['firstname'] : null,
                    'lastname' => isset($_POST['lastname']) ? $_POST['lastname'] : null,
                    'email' => isset($_POST['email']) ? $_POST['email'] : null,
                    'password' => isset($_POST['pass']) ? $_POST['pass'] : null
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
                    $this->success = ($result) ? true : false;
                    $this->loginMessage();
                } else {
                    $this->loginMessage();
                }
            }
            if ($this->byModal) {
                return false;
            }
            header("Location: {$_SERVER['HTTP_REFERER']}");
        });
    }
    
}
?>