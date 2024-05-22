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
            header('Location: /eventi/dettagliEvento/'.$idEvento[0]);//rimanda alla homepage
            die();
        }
        public static function login(){ //manda il forma
            session_start();
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
            require_once "app/view/utente/signin.php";
            var_dump(userModel::getUserByID(1));
        }

        
        public static function confermaRegistrazione(){
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
        public static function profilo(){ //se' loggato manda a profilo se no a login
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

        public static function modificaProfilo(){ // se e' loggato manda alla form di modifica profilo
            session_start();
            if(isset($_SESSION["user"]) && $_SESSION["user"] -> login()){ //se il tipo e' loggato mostra form
                $user = $_SESSION["user"];
                require_once "app/template/utente/modificaProfilo.php";
            }else{ //se non e' loggato manda alla pagina login per verificare gli errori
                header("Location: /utente/login");
                die();
            }
        }

        public static function modificaPassword(){ // se e' loggato manda alla form di modifica password
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
            
        public static function iMieiBiglietti(){

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
        public static function homepage(){ //view dell'index
            header("Location: /museo/hompage"); //rimanda ad un'altro controller
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





        
        // dopo c'e' la parte logica del sito
        public static function elaboraLogin(){

            /*controlla i post in input,
            prova a loggare
            se si allora logga l'utente e lo manda a eventi*/

            if(isset($_POST["username"]) && isset($_POST["password"])){

                session_start();
                $username = $_POST["username"];
                $password = $_POST["password"];
                $user = new userModel($username, $password);
                if($user -> login()){
                    $user -> caricaDati();
                    $_SESSION["user"] = $user;
                    header("Location: /eventi/index"); //redirect alla pagina di login con la form
                    exit();
                } else { //se valori errati rimanda alla login
                    $_SESSION["error"] = $user -> error;
                    header("Location: /utente/login"); //redirect alla pagina di login con la form
                    die();
                }
            } else {//se non ci sono stati i post inviati dal form  rimanda alla login
                $_SESSION["error"] = "no post";
                header("Location: /utente/login"); //redirect alla pagina di login con la form
                die();
            }

        }


        public static function elaboraSignin(){
            /* controlla se sono arrivati input post,
            si prova a inserirli nel db,
            se fallisce manda alla pagina di signin specificando l'errore,
            altrimenti logga l'utente mandandolo agli eventi
            */
            if( isset($_POST["username"]) &&
                isset($_POST["nome"]) &&
                isset($_POST["cognome"]) &&
                isset($_POST["mail"]) &&
                isset($_POST["password"]) ){ //controllo se c'e' stata un vera richiesta per questa pagina
                
                session_start();
                $username = $_POST["username"];
                $nome = $_POST["nome"];
                $mail = $_POST["mail"];
                $cognome = $_POST["cognome"];
                $password = $_POST["password"];
                $user = new userModel($username, $password); //crea un ipotetico utente

                //controlla se si puo' mettere e se lo fa lo logga
                if($user -> signin($username, $nome, $cognome, $mail, $password)){
                    $_SESSION["user"] = $user;
                    header("Location: eventi/index"); //redirect alla pagina di login con la form
                    die();
                } else { //se valori errati rimanda alla login
                    $_SESSION["error"] = $user -> error;
                    header("Location: utente/signin"); //redirect alla pagina di login con la form
                    die();
                }
            } else {//se non ci sono stati i post inviati dal form  rimanda alla login
                header("Location: utente/signin"); //redirect alla pagina di login con la form
                die();
            }
        }

        public static function elaboraModificaProfilo(){
            
            /*se ci sono gli input tramite post e il login
            cambio i dati  dell'utente, aggiorno pure l'user di sessione e mando alla pagina di profilo
            altrimenti mando a login*/
            
            session_start();

            if( isset($_POST["nome"]) &&//controlli post
                isset($_POST["cognome"]) &&
                isset($_POST["mail"]) &&
                isset($_SESSION["user"]) && //controllo login
                $_SESSION["user"] -> login() )
            {

                $nome = $_POST["nome"];
                $cognome = $_POST["cognome"];
                $email = $_POST["mail"];

                $user = $_SESSION["user"];

                $user -> update($nome, $cognome, $email); //modifica profilo

                $_SESSION["user"]= $user;//aggiorno sessione

                header("Location: /utente/profilo");
                die();


            }else{ //se non e' loggato manda alla pagina login per verificare gli errori
                header("Location: /utente/login");
                die();
            }
        }

        public static function elaboraModificaPassword(){
            /*se ci sono gli input tramite post e il login
            cambio dell'utente i dati e mando alla pagina di profilo
            altrimenti mando a login*/
            
            session_start();

            if( isset($_POST["password"]) && //controlli post
                isset($_SESSION["user"]) && //controllo login
                $_SESSION["user"] -> login() )
            {
            
            $password = $_POST["password"];

            $_SESSION["user"] -> updatePassword($password); //modifica password

            header("Location: /utente/profilo");
            die();


            }else{ //se non e' loggato manda alla pagina login per verificare gli errori
                header("Location: /utente/login");
                die();
            }
        }

    }