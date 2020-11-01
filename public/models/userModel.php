<?php

namespace app\models\userModel;
use app\libs\model\Model;

class User {

    private $id;
    private $firstname;
    private $lastname;
    private $email;
    private $pass;
    private $reg_date;

    function __construct(int $id = null, String $firstname = null, String $lastname = null, String $email = null, String $pass = null, String $reg_date = null)  {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->pass = $pass;
        $this->reg_date = $reg_date;
        $this->user = array(
            'id' => (int) $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'pass' => $this->pass,
            'reg_date' => $this->reg_date
        );
    }

    function setUserData($user) {
        $tmpUser = new User(
            $id = (int) $user['id'],
            $firstname = $user['firstname'],
            $lastname = $user['lastname'],
            $email = $user['email'],
            $pass = $user['pass'],
            $reg_date = $user['reg_date']
        );
        if ($tmpUser) {
            $this->user = $tmpUser->getUserData();
        } else {
            throw new Exception("Error Processing Request, user data is invalid", 1);
        }
        unset($tmpUser);
    }

    function getUserData() {
        return $this->user;
    }

}

class UserModel extends Model {

    private $user;
    public $username;

    function __construct()  {
        parent::__construct(...func_get_args());
        $this->user = new User();
        $this->username = '';
    }

    function getUser() {
        return $this->user->getUserData();
    }

    function setUser(Array $user) {
        $this->user->setUserData($user);
        $username = $this->getUser()['firstname'] . ' ' . $this->getUser()['lastname'];
        $this->username = $username;
    }

    function getUsername() {
        return $this->username;
    }

    /**
     * Funciton called when you will to register a user.
     * This function returns True or False
     * If the user is registered succesfully returns True.
     */
    function registerUser($formData) {
        $firstname = $formData['firstname'];
        $lastname = $formData['lastname'];
        $email = $formData['email'];
        $pass = $this->encryptPass($formData['password']);
        $columns = array('firstname', 'lastname', 'email', 'pass');
        $values = array($firstname, $lastname, $email, $pass);
        $this->query->queryInsertRow('users', $columns, $values);
        $result = $this->query->fetchResult();

        $this->query->queryGetRow('users', 'email', $email);
        $user = $this->query->fetchResult();
        $this->setUser($user);
        return $result;
    }
    
    /**
     * Funciton called when you will to login as a user.
     * This function returns True or False
     * If the user is info to login is ok returns True.
     */
    function authUser($email, $password) {
        $verify = false;
        $this->query->queryGetRow('users', 'email', $email);
        $user = $this->query->fetchResult();
        if ($user) {
            $hash = $user['pass'];
            $verify = password_verify($password, $hash);
            if ($verify) {
                $this->setUser($user);
            }
        }
        return $verify;
    }

    private function encryptPass($password) {
            $opciones = [
                'cost' => 10,
            ];
            $password = password_hash($password, PASSWORD_BCRYPT, $opciones);
            return $password;
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

    function validateForm($formData) {
        foreach ($formData as $key => $value) {
            if (empty($value)) {
                $msg = "Sorry, field {$key} couldnt be empty";
                return $msg;
            }
        }
        $email = $formData['email'];
        $valid = (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? false : true;
        return $valid;
    }

    function deleteUser($id) {
        $this->query->queryDeleteRow('users', 'id', $id);
        $result = $this->query->fetchResult();
        return $result;
    }

    function getOneUserByEmail($email) {
        $this->query->queryGetRow('users', 'email', $email);
        $user = $this->query->fetchResult();
        return $users;
    }

    function getOneUserById($id) {
        $this->query->queryGetRow('users', 'id', $id);
        $user = $this->query->fetchResult();
        return $user;
    }

    function getAllUsers() {
        $this->query->queryGetAll('users');
        $users = $this->query->fetchResult();
        return $users;
    }
}
?>