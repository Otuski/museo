<?php  
    namespace app\controller;
    use app\model\userModel;

    class utente{ //controller
        

       //  qui ci sono tutte le view
        public static function index(){
            //funzione che verra' richiamata se non e' specificata o e' sbagliato il nome della funzione
            header('Location: /utente/login');//rimanda alla homepage
            die();
        }

        public static function dettagliEvento($idEvento){
            //funzione che verra' richiamata se non e' specificata o e' sbagliato il nome della funzione
            session_start();
            if(isset($_SESSION['user']) ) {
                $user = $_SESSION['user'];
                $logged = self::log($user["username"], $user["passw"]);
            } else {
                session_destroy();
            }
            header('Location: /eventi/dettagliEvento/'.$idEvento[0]);//rimanda alla homepage
            die();
        }
        public static function login(){ //manda il forma
            session_start();
            if(isset($_SESSION['user']) ) {
                $user = $_SESSION['user'];
                $logged = self::log($user["username"], $user["passw"]);
            }
            require_once "app/view/utente/login.php";
        }

        public static function logout(){ // manda alla homepage
            session_start();
            session_destroy();
            header("Location: /utente/login");
            die();
        }
        
        public static function signin(){ //manda il forma
            session_start();
            if(isset($_SESSION['user']) ) {
                $user = $_SESSION['user'];
                $logged = self::log($user["username"], $user["passw"]);
            } 
            require_once "app/view/utente/signin.php";
        }

        
        public function confermaRegistrazione(){
            /*controlla se l'utente e' loggato e
            se si lo gli conferma con questa pagina
            altrimenti manda alla form di signin
            */
            
            session_start();

            $user = $_SESSION["user"];

            if(is_array($user) && self::log($user["username"], $user["passw"])){ //se il tipo e' loggato
                $logged = self::log($user["username"], $user["passw"]);
                require_once "app/view/utente/confermaRegistrazione.php";
            }else{ //se non e' loggato manda alla pagina signin per verificare gli errori
                header("Location: /utente/signin");
                die();
            }
        }
        public static function profilo(){ //se' loggato manda a profilo se no a login
            session_start();
            $user = $_SESSION["user"];

            if(is_array($user) && self::log($user["username"], $user["passw"]) ){ //se il tipo e' loggato mostra profilo
                $logged = self::log($user["username"], $user["passw"]);
                require_once "app/view/utente/profilo.php";
            }else{ //se non e' loggato manda alla login
                header("Location: /utente/login");
                die();
            }
            //var_dump($user);

        }

        public static function modificaProfilo(){ // se e' loggato manda alla form di modifica profilo
            session_start();
            $user = $_SESSION["user"];

            if(is_array($user) && self::log($user["username"], $user["passw"]) ){ //se il tipo e' loggato mostra profilo
                $logged = self::log($user["username"], $user["passw"]);
                require_once "app/view/utente/modificaProfilo.php";
            }else{ //se non e' loggato manda alla login
                header("Location: /utente/login");
                die();
            }
        }

        public static function modificaPassword(){ // se e' loggato manda alla form di modifica password
            session_start();
            $user = $_SESSION["user"];

            if(is_array($user) && self::log($user["username"], $user["passw"]) ){ //se il tipo e' loggato mostra profilo
                $logged = self::log($user["username"], $user["passw"]);
                require_once "app/view/utente/modificaPassword.php";
            }else{ //se non e' loggato manda alla login
                header("Location: /utente/login");
                die();
            }
        }

            /* controlla se l'utente e' loggato,
            se si manda alla pagina iMieiBiglietti
            -> nel tmplate si visualizzeranno gli eventi grazie all'array eventi[]
            altrimanti manda alla login*/
            
        public static function iMieiBiglietti(){
             
            session_start();
            $user = $_SESSION["user"];

            if(is_array($user) && self::log($user["username"], $user["passw"]) ){//se il tipo e' loggato mostra form
                $user = $_SESSION["user"];
                $biglietti =  userModel::getBigliettiByUtente($user["username"]);
                $accessori = userModel::getAccessoriByUtente($user["username"]);
                $logged = self::log($user["username"], $user["passw"]);
                require_once "app/view/utente/iMieiBiglietti.php";
            }else{ //se non e' loggato manda alla pagina login per verificare gli errori
                header("Location: /utente/login");
                die();
            }
        }
        /*

        public static function semplificaBiglietti($array){
            $semplificato = array();
            foreach ($array as $key => $value){
                $precedente = $array[$key];
                if($key == 0){}
                else{

                    if($array[$key]["codTransazione"] == $precedente["codTransazione"]){
                        $semplificato[ $array[$key]["codTransazione"] ] = 
                    }


                    $precedente = $array[$key];
                }
            }

        }
        */

        //cambio di controller
        public static function homepage(){ //view dell'index
            header("Location: /museo/homepage"); //rimanda ad un'altro controller
            die();
        }

        public static function aboutUs(){
            header("Location: /museo/aboutUs"); //rimanda ad un'altro controller
            die();
        }

        //cambio controller

        public static function eventi(){
            header("Location: /eventi/index"); //rimanda ad un'altro controller
            die();
        }

        public static function eventiFuturi(){
            header("Location: /eventi/index"); //rimanda ad un'altro controller
            die();
        }
        
        // dopo c'e' la parte logica del sito

        /**
         * controlla l'input della form di login 
         * guarda se l'utente esiste nel database
         * infine redirezziona alla pagina adeguata
         */
        public static function elaboraLogin(){

            session_start();

            if( !(isset($_POST["username"]) && isset($_POST["password"])) ){//se non c'e una richiesta post: redirect -> login
                $_SESSION["error"] = "no post";
                header("Location: /utente/login"); //redirect alla pagina di login con la form
                die();
            }

            //salvo valori da confrontare in variabili
            $username = $_POST["username"];
            $password = $_POST["password"];
            $user = userModel::getUserByUsername($username);


            //se password giusta: redirect -> eventi
            if(isset($user["passw"]) && password_verify($password, $user["passw"])){
                $_SESSION["user"] = $user;
                header("Location: /utente/profilo"); //redirect alla pagina di login con la form
                die();
            } else { //se valori errati rimanda alla login
                $_SESSION["error"] = "dati errati";
                header("Location: /utente/login"); //redirect alla pagina di login con la form
                die();
            }


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
        /** 
        * controlla se sono arrivati input post,
        * si prova a inserirli nel db,
        * se fallisce manda alla pagina di signin specificando l'errore,
        * altrimenti logga l'utente mandandolo agli eventi
        */
        public static function elaboraSignin(){
            if( isset($_POST["username"],$_POST["nome"],$_POST["cognome"],$_POST["mail"],$_POST["mail"],$_POST["password"])){ //controllo se c'e' stata un vera richiesta per questa pagina
                session_start();
                $username = $_POST["username"];
                $nome = $_POST["nome"];
                $mail = $_POST["mail"];
                $cognome = $_POST["cognome"];
                $password = $_POST["password"];
                $user = userModel::getUserByUsername($username);

                //controlla se si puo' mettere e se lo fa lo logga
                if(is_array($user)){
                    $_SESSION["error"] = "username gia' in uso";
                    header("Location: utente/signin");
                    die();
                } else { //se valori errati rimanda alla login
                    userModel::insertUtente($username,$nome,$cognome,$mail,$password);
                    $_SESSION["user"] = userModel::getUserByUsername($username);
                    header("Location: utente/profilo");
                    die();
                }
            } else {//se non ci sono stati i post inviati dal form  rimanda alla login
                header("Location: utente/signin");
                die();//manda a signin
            }
            
        }

        /**  se ci sono gli input tramite post e il login
        *    cambio i dati  dell'utente, aggiorno pure l'user di sessione e mando alla pagina di profilo
        *    altrimenti mando a login
        */
        public static function elaboraModificaProfilo(){
            
            
            session_start();
            $user = $_SESSION["user"];

            if( is_array($user) 
                && self::log($user["username"], $user["passw"]) 
                && isset($_POST["nome"],$_POST["cognome"],$_POST["mail"],$_SESSION["user"]))
            {
                $nome = $_POST["nome"];
                $cognome = $_POST["cognome"];
                $email = $_POST["mail"];

                $user = $_SESSION["user"];

                userModel::updateDatiByUtente($user["username"], $nome, $cognome, $email); //modifica profilo

                $_SESSION["user"]= userModel::getUserByUsername($user["username"]);;//aggiorno sessione

                header("Location: /utente/profilo");
                die();


            }else{ //se non e' loggato manda alla pagina login per verificare gli errori
                header("Location: /utente/login");
                die();
            }
        }


        /** se ci sono gli input tramite post e il login
         * cambio dell'utente i dati e mando alla pagina di profilo
         * altrimenti mando a login
        */
        public static function elaboraModificaPassword(){
            
            session_start();
            $user = $_SESSION["user"];

            if( is_array($user) 
                && self::log($user["username"], $user["passw"]) 
            )
            {
                $user = $_SESSION["user"];
                $password = $user["passw"];
            }else{ //se non e' loggato manda alla pagina login per verificare gli errori
                header("Location: /utente/login");
                die();
            }

            if( $_POST["password"] && !password_verify($_POST["password"],$password))
            {
            
            $password = $_POST["password"];
            $user = $_SESSION["user"];
            userModel::updatePasswordByUtente($user["username"],$password); //modifica password

            $_SESSION["user"]= userModel::getUserByUsername($user["username"]);;//aggiorno sessione

            header("Location: /utente/profilo");
            die();


            }else{ //se la password e' uguale
                $_SESSION["error"]="inserisci una password diversa";
                header("Location: /utente/modificaPassword");
                die();
            }
        }

    }