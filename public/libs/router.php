<?php

namespace app\libs\router;
use app\controllers\Controller;

use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\RouteCollector;
use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;

    class Router {

        private $entryPoint;
        private $router;
        private $routes;
        private $response;
        private $canonicals;

        private $loader;
        private $twig;
        public $collector;
        private $dispatcher;

        function __construct(Array $routes = null, Router $router = null, $response = null, $entryPoint = null) {
            $this->loader = new FilesystemLoader('./templates/views');
            $this->twig = new Environment($this->loader, ['debug' => true]);
            $this->collector = new RouteCollector();

            $this->routes = !isset($routes) ? null : $routes;
            $this->router = !isset($router) ? null : $router;
            $this->response = !isset($response) ? null : $response;
            $this->dispatcher = !isset($dispatcher) ? null : $dispatcher;
            $this->canonicals = !isset($canonicals) ? array() : $canonicals;
            $this->entryPoint = !isset($entryPoint) ? '/' : $entryPoint;
        }

        private function validate($url) {
            $exist = true;
            foreach ($this->getCanonicals() as $key => $value) {
                if ($url == $value) {
                    $exist = true;
                }
            }
            //die(var_dump($this->getCanonicals(), $exist));
            $url = ($exist == true) ? $url : '/404';
            if ($_SERVER['REQUEST_URI'] == '/') {
                header('Location: ' . $this->entryPoint);
                return false;
            }
            return $url;
        }

        private function resolveDispatch() {
            $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $url = $this->validate($url);
            try {
                $response = $this->dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $url);
            } catch (\Throwable $th) {
                $url = '/500';
                $response = $this->dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $url);
            }
    
            $this->$response = $response;
            return $response;
        }

        function getRoutes() {
            // Each route in this array must belongs to a Controller class
            return $this->routes;
        }

        function setRoutes(Array $routes) {
            $this->routes = $routes;
        }

        function setRouter(Router $router) {
            $this->router = $router;
        }
        
        function getRouter() {
            return $this->router;
        }

        function getCollector() {
            return $this->collector;
        }

        function getTwig() {
            return $this->twig;
        }

        function setCanonicals() {
            foreach ($this->getRoutes() as $key => $value) {
                $str = $this->getRoutes()[$key]->route;
                $str2 = explode('{', $str);
                if (isset($str2[1])) {
                    $str2 = substr($str2[0], 0, -1);
                    array_push($this->canonicals, $str2);
                } else {
                    array_push($this->canonicals, $this->getRoutes()[$key]->route);
                }
            }
        }

        function getCanonicals() {
            return $this->canonicals;
        }

        function register() {
            $router = $this;
            $controllers = $this->router->getRoutes();
            // Each route here belongs to a Controller class
            foreach ($controllers as $key => $controller) {
                $controller->process($router);
            }
            $this->dispatcher = new Dispatcher($this->collector->getData());
            $this->setCanonicals();
            $this->response = $this->resolveDispatch();
            return $this->response;
        }
    }

?>