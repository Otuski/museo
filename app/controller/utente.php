<?php  
    //namespace app\controller\utente;
    //use app\model\userModel;
    
    require_once "app/model/userModel.php";
    class utente{ //controller
        

       //  qui ci sono tutte le view
        public static function index(){
            //funzione che verra' richiamata se non e' specificata o e' sbagliato il nome della funzione
            header('Location: /utente/login');//rimanda alla homepage
            die();
        }

        public function dettagliEvento($idEvento){
            //funzione che verra' richiamata se non e' specificata o e' sbagliato il nome della funzione
            header('Location: /eventi/dettagliEvento/'.$idEvento[0]);//rimanda alla homepage
            die();
        }
        public static function login(){ //manda il forma
            session_start();
            require_once "app/view/utente/login.php";
            $_SESSION["user"] -> login().' -> login <br>';
        }

        public function logout(){ // manda alla homepage
            session_start();
            session_destroy();
            header("Location: /utente/login");
            die();
        }
        
        public function signin(){ //manda il forma
            session_start();
            require_once "app/template/utente/signin.php";
        }

        
        public function confermaRegistrazione(){
            /*controlla se l'utente e' loggato e
            se si lo gli conferma con questa pagina
            altrimenti manda alla form di signin
            */
            
            session_start();
            if(isset($_SESSION["user"]) && $_SESSION["user"] -> login()){ //se il tipo e' loggato
                $user = $_SESSION["user"];
                require_once "app/template/utente/confermaRegistrazione.php";
            }else{ //se non e' loggato manda alla pagina signin per verificare gli errori
                header("Location: /utente/signin");
                die();
            }
        }
        public function profilo(){ //se' loggato manda a profilo se no a login
            session_start();
            if(isset($_SESSION["user"]) && $_SESSION["user"] -> login()){ //se il tipo e' loggato mostra profilo
                $user = $_SESSION["user"];
                require_once "app/template/utente/profilo.php";
            }else{ //se non e' loggato manda alla login
                header("Location: /utente/login");
                die();
            }

            echo ''.var_dump($_SESSION["user"]);
        }

        public function modificaProfilo(){ // se e' loggato manda alla form di modifica profilo
            session_start();
            if(isset($_SESSION["user"]) && $_SESSION["user"] -> login()){ //se il tipo e' loggato mostra form
                $user = $_SESSION["user"];
                require_once "app/template/utente/modificaProfilo.php";
            }else{ //se non e' loggato manda alla pagina login per verificare gli errori
                header("Location: /utente/login");
                die();
            }
        }

        public function modificaPassword(){ // se e' loggato manda alla form di modifica password
            session_start();
            if(isset($_SESSION["user"]) && $_SESSION["user"] -> login()){ //se il tipo e' loggato mostra form
                $user = $_SESSION["user"];
                require_once "app/template/utente/modificaPassword.php";
            }else{ //se non e' loggato manda alla pagina login per verificare gli errori
                header("Location: /utente/login");
                die();
            }
        }

            /* controlla se l'utente e' loggato,
            se si manda alla pagina iMieiBiglietti
            -> nel tmplate si visualizzeranno gli eventi grazie all'array eventi[]
            altrimanti manda alla login*/
            
        public function iMieiBiglietti(){

            session_start();
            if(isset($_SESSION["user"]) && $_SESSION["user"] -> login()){ //se il tipo e' loggato mostra form
                $user = $_SESSION["user"];
                $biglietti =  $user -> getBiglietti();
                require_once "app/template/utente/iMieiBiglietti.php";
            }else{ //se non e' loggato manda alla pagina login per verificare gli errori
                header("Location: /utente/login");
                //die();
            }
        }



        //cambio di controller
        public function homepage(){ //view dell'index
            require_once "app/template/museo/homepage.php";
        }

        public function aboutUs(){
            require_once "app/template/museo/aboutUs.php";
        }

        //cambio controller

        public function eventi(){
            header("Location: /eventi/index"); //rimanda ad un'altro controller
            die();
        }





        
        // dopo c'e' la parte logica del sito

        /**
         * controlla l'input della form di login 
         * guarda se l'utente esiste nel database
         * infine redirezziona alla pagina adeguata
         */
        public function elaboraLogin(){


            if(isset($_POST["username"]) && isset($_POST["password"])){

                session_start();
                $username = $_POST["username"];
                $password = $_POST["password"];
                $user = userModel::getUserByUsername($username);
                if(is_string($user["passw"]) && password_verify($password,$user["passw")){
                    $_SESSION["user"] = $user;
                    header("Location: /eventi/index"); //redirect alla pagina di login con la form
                    exit();
                } else { //se valori errati rimanda alla login
                    $_SESSION["error"] = "password errata";
                    header("Location: /utente/login"); //redirect alla pagina di login con la form
                    die();
                }
            } else {//se non ci sono stati i post inviati dal form  rimanda alla login
                $_SESSION["error"] = "no post";
                header("Location: /utente/login"); //redirect alla pagina di login con la form
                die();
            }

        }
        
        /** 
        * controlla se sono arrivati input post,
        * si prova a inserirli nel db,
        * se fallisce manda alla pagina di signin specificando l'errore,
        * altrimenti logga l'utente mandandolo agli eventi
        */
        public function elaboraSignin(){
            if( isset($_POST["username"],$_POST["nome"],$_POST["cognome"],$_POST["mail"],$_POST["mail"],$_POST["password"])){ //controllo se c'e' stata un vera richiesta per questa pagina
                session_start();
                $username = $_POST["username"];
                $nome = $_POST["nome"];
                $mail = $_POST["mail"];
                $cognome = $_POST["cognome"];
                $password = $_POST["password"];
                $user = userModel::getUserByUsername($username);

                //controlla se si puo' mettere e se lo fa lo logga
                if(is_string($user["passw"])){
                    $_SESSION["user"] = $userername;
                    userModel::insertUtente($username,$nome,$cognome,$mail,$passw);
                    header("Location: eventi/index"); //redirect alla pagina di login con la form
                    die();
                } else { //se valori errati rimanda alla login
                    $_SESSION["error"] = "username gia' in uso";
                    header("Location: utente/signin"); //redirect alla pagina di login con la form
                    die();
                }
            } else {//se non ci sono stati i post inviati dal form  rimanda alla login
                header("Location: utente/signin"); //redirect alla pagina di login con la form
                die();
            }
        }

        /**  se ci sono gli input tramite post e il login
        *    cambio i dati  dell'utente, aggiorno pure l'user di sessione e mando alla pagina di profilo
        *    altrimenti mando a login
        */
        public function elaboraModificaProfilo(){
            
            
            
            session_start();

            if( isset($_POST["nome"],$_POST["cognome"],$_POST["mail"],$_SESSION["user"]))
            {
                $nome = $_POST["nome"];
                $cognome = $_POST["cognome"];
                $email = $_POST["mail"];

                $user = $_SESSION["user"];

                userModel::updateDatiByUtente($user["username"], $nome, $cognome, $email); //modifica profilo

                $_SESSION["user"]= $user;//aggiorno sessione

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
        public function elaboraModificaPassword(){
            
            session_start();

            if(isset($_SESSION["user"])){
                $us = $_SESSION["user"];
                $pas = $us["passw"];
            }else{ //se non e' loggato manda alla pagina login per verificare gli errori
                header("Location: /utente/login");
                die();
            }

            if( $_POST["password"]&&!password_verify($_POST["password"],$pas))
            {
            
            $password = $_POST["password"];
            $user = $_SESSION["user"]
            userModel::updatePasswordByUtente($user["username"],$password); //modifica password

            header("Location: /utente/profilo");
            die();


            }else{ //se la password e' uguale
                header("Location: /utente/modificaPassword");
                die();
            }
        }

    }