<?php
namespace app\libs\view;

    class View {
        
        public $extension;
        private $twig;
        
        function __construct($extension = null, $twig = null) {
            $this->extension = !isset($extension) ? '.twig' : $extension;
            $this->twig = $twig;
        }

        function setTwig($gTwig) {
            $this->twig = $gTwig;
        }

        function getTwig() {
            return $this->twig;
        }

        /**
         * This function will require as minimum an object with 3 elements.
         * 1. Twig: Used for render the page.
         * 2. Data: The data that will be passed to the view.
         * 3. Name: The name of the view that you want to render.
         */
        function render($page) {
            $viewPage = $page['page'] . $this->extension;
            $data = null;
            $data = $this->parseArrayData($data, $page);
            return $this->twig->render($viewPage, $data);
        }

        /**
         * This function returns a package parsed of data that exclude the $page key 
         * because $page its a special and default data from Controller
         * and just returns all the other data required to be displayed on the page
         */
        private function parseArrayData($data, $page) {
            foreach ($page as $key => $value) {
                if ($key != 'page') {
                    $variables = array($key => $value);
                    if (!isset($data)) {
                        $data = $variables;
                    } else {
                        $data = array_merge($data, $variables);
                    }
                }
            }
            $data = !isset($data) ? array() : $data;
            return $data;
        }
    }

?>