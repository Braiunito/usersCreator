<?php

namespace app\models\userModel;
use app\libs\model\Model;

class UserModel extends Model{

    private $user;

    function __construct()  {
        parent::__construct(...func_get_args());
        $this->user = array();
    }

    // TODO Change template to accept this params
    function registerUser($formData) {
        //$firstname = $formData['firsname'];
        //$lastname = $formData['lastname'];
        $firstname = 'El';
        $lastname = 'Pepe';
        $email = $formData['email'];
        $pass = $this->encryptPass($formData['password']);
        $columns = array('firstname', 'lastname', 'email', 'pass');
        $values = array($firstname, $lastname, $email, $pass);
        $this->query->queryInsertRow($columns, $values);
        $result = $this->query->fetchResult();
        return $result;
    }

    private function encryptPass($password) {
            $opciones = [
                'cost' => 11,
            ];
            $password = password_hash($password, PASSWORD_BCRYPT, $opciones);
            return $password;
    }

    function authUser($email, $password) {
        $verify = false;
        $this->query->queryGetRow('users', 'email', $email);
        $user = $this->query->fetchResult();
        if ($user) {
            $hash = $user['pass'];
            $verifyPass = password_verify($password, $hash);
            $verify = $verifyPass;
        }
        return $verify;
    }

    function isRegistered($email) {
        $this->query->queryGetColumn('users', 'email');
        $valid = false;
        $emails = $this->query->fetchResult();
        if ($emails) {
            foreach($emails as $key => $value) {
                if ($value['email'] == $email) {
                    $valid = true;
                }
            }
        }
        return $valid;
    }

    function getAllUsers() {
        $this->query->queryGetAll('users');
        $users = $this->query->fetchResult();
        return $users;
    }
}
?>