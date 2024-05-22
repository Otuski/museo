<?php

    namespace app\controller;
    
    class dispatcher {
        protected $params;
        public function __construct() {
            $this -> params = $this->parse($_SERVER['REQUEST_URI']);
        }
        public function handle() {
            $controller = $this -> params['controller'];
            $action = $this->params['method'];
            $args = $this->params['args'];

            if(method_exists($controller, $action)){ //controlla l'esistenza dell'azione se esiste elabora altrimenti manda all'index
                if(!is_null($args)) {
                    $controller::$action($args);
                } else {
                    $controller::$action();
                }
            } else {
                header("Location: /$controller/index");//manda all'index modificando l'header
                die();
            }

        }
        protected function parse($path) {
            /*
            se controller esiste vai ed elabora se no redirect a museo
            se metodo esiste vai ed elabora se no redirect a index
            */ 
            $parts = explode('/', $this->removeQueryStringVariables($path));
            $controller = $parts[1];
            $method = $parts[2];
            $args = array_slice($parts, 3);


            if(file_exists("app/controller/$controller.php")){ //controlla se esiste controller
                return [
                    'controller' => "app\controller\\$controller",
                    'method' => $method,
                    'args' => (count($args) > 0 ) ? $args : null
                ];
            } else {//se controller non esiste manda alla homepage
                header('Location: /museo/homepage');
                die();
            }
        }


        protected function removeQueryStringVariables($url) {
            $parts = explode('?', $url);
            return $parts[0];
        }
    }