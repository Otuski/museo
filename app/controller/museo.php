<?php  
    namespace app\controller;
    use app\model\userModel;
    class museo { //controller

        //qui la parte view
        public static function index(){//funzione che verra' richiamata se non e' specificata o e' sbagliato il nome della funzione
            header('Location: /museo/homepage');//rimanda alla homepage
            die();
        }
        public static function homepage(){ //view dell'index
            session_start();
            if(isset($_SESSION['user']) ) {
                $user = $_SESSION['user'];
                $logged = self::log($user["username"], $user["passw"]);
            } else {
                session_destroy();
            }
            require_once "app/view/museo/homepage.php";
        }

        public static function aboutUs(){
            session_start();
            if(isset($_SESSION['user']) ) {
                $user = $_SESSION['user'];
                $logged = self::log($user["username"], $user["passw"]);
            } else {
                session_destroy();
            }
            require_once "app/view/museo/aboutUs.php";
        }

        //cambio controller
        public static function login(){ 
            header("Location: /utente/login"); //rimanda ad un'altro controller
            die();
        }

        public static function eventi(){
            header("Location: /eventi/eventiFuturi"); //rimanda ad un'altro controller
            die();
        }

        public static function eventiFuturi(){
            header("Location: /eventi/eventiFuturi"); //rimanda ad un'altro controller
            die();
        }

        public static function signin(){
            header("Location: /utente/signin"); //rimanda ad un'altro controller
            die();
        }

        public static function logout(){ // manda alla homepage
            session_start();
            session_destroy();
            header("Location: /utente/login");
            die();
        }

        public static function profilo(){
            header("Location: /utente/profilo"); //rimanda ad un'altro controller
            die();
        }

        public static function iMieiBiglietti(){
            header("Location: /utente/iMieiBiglietti"); //rimanda ad un'altro controller
            die();
        }

        /**
         * il metodo log verifica se l'utente esiste nel database
         * @param $username 
         * @param $passw
         * @return bool
         */
        private static function log($username, $passw){
            $user = userModel::getUserByUsername($username);
            if(is_string($username) && ( $passw == $user["passw"] )){
                return true;
            } else { //se valori errati rimanda alla login
                return false;
            }
        }
    }