<?php

namespace app\controllers;
use app\libs\view\View;
use app\libs\router\Router;

    class Controller {
        private $params;
        private $data;
        public $route;
        public $method;
        public $view;

        /*  In data->params the value 'page' is a reserved key value for the array
        *   Dont use the key page to send data to the view 
        */
        function __construct(String $method = null, String $route = null, String $page = null, String $title = null, Array $data = null) {
            $this->method = !isset($method) ? 'any' : $method;
            $this->route = !isset($route) ? '/404' : $route;
            $this->page = !isset($page) ? '404' : $page;
            $this->data = !isset($data) ? '' : $data;
            $this->title = !isset($title) ? $page : $title;
            $this->params = array(
                'page' => $this->page,
                'title' => $this->title
            );
            $this->params = !isset($data) ? $this->params : array_merge($this->params, $data);
            $this->view = new View();
        }

        /**
         * This function its called just before to render the view.
         * TRY TO AVOID OVERRIDE THIS FUNCTION IF YOU NEED OVERRIDE PLEASE
         * preRender function
         */
        function process($router) {
            if (isset($_SESSION['user'])) {
                $user = $_SESSION['user'];
                $username = $user->getUsername();
                $userdata = $user->getUser();
                // Custom array to not give the password in the array to twig.
                $user = array(
                    'id' => $userdata['id'],
                    'firstname' => $userdata['firstname'],
                    'lastname' => $userdata['lastname'],
                    'username' => $username,
                    'email' => $userdata['email'],
                    'reg_date' => $userdata['reg_date']
                );
                $params = $this->getParams();
                $params['user'] = $user;
                $this->setParams($params);
                unset($user);
            }
            $this->view->setTwig($router->getTwig());
            $this->preRender($router);
        }

        function getParams() {
            return $this->params;
        }

        function setParams($params) {
            $this->params = $params;
        }

        function preRender($router) {
            $router->getCollector()->{$this->method}($this->route, function () {
                return $this->view->render($this->getParams());
            });
        }

    }

?>