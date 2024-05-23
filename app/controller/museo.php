<?php  
    namespace app\controller;
    class museo { //controller

        //qui la parte view
        public static function index(){//funzione che verra' richiamata se non e' specificata o e' sbagliato il nome della funzione
            header('Location: /museo/homepage');//rimanda alla homepage
            die();
        }
        public static function homepage(){ //view dell'index
            require_once "app/view/museo/homepage.php";
        }

        public static function aboutUs(){
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
    }