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
                if (isset($_POST['delete'])) {
                    $user = $_SESSION['user'];
                    $id = isset($_POST['delete']) ? $_POST['delete'] : null;
                    $result = $user->deleteUser($id);
                    if ($result) {
                        
                    } else {
                        echo "<h1 style='color: white'> Error! </h1>";
                    }
                }
                header("Location: {$_SERVER['HTTP_REFERER']}");
            });
        });
    }
    
}
?>