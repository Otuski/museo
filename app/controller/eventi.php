<?php  
    namespace app\controller;
    use app\model\eventoModel;
    use app\model\userModel;

    class eventi { //controller

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
        
        //  qui ci sono tutte le view
        public static function index(){//funzione che verra' richiamata se non e' specificata o e' sbagliato il nome della funzione
            header('Location: /eventi/eventiFuturi');//rimanda agli eventi futuri
            die();
        }
        public static function eventiFuturi(){ 
            session_start();
            if(isset($_SESSION['user']) ) {
                $user = $_SESSION['user'];
                $logged = self::log($user["username"], $user["passw"]);
            } else {
                session_destroy();
            }
            $eventi = eventoModel::eventiFuturi();
            require_once "app/view/eventi/eventiFuturi.php";
        }

        public static function eventiPassati(){ 
            session_start();
            if(isset($_SESSION['user']) ) {
                $user = $_SESSION['user'];
                $logged = self::log($user["username"], $user["passw"]);
            } else {
                session_destroy();
            }
            $eventi = eventoModel::eventiPassati();
            require_once "app/view/eventi/eventiPassati.php";
        }

        public static function dettagliEvento($params){ 
            /*
            prende in input un url tipo: eventi/dettaglievento/nomeEvento
            controlla se esiste l'evento
            trova l'evento, le categorie ammesse e gli accessori disponibili nel db e li mostra 
            */

            $id = $params[0];

            $evento = eventoModel::getEventoById($id);

            session_start();
            if(isset($_SESSION['user']) ) {
                $user = $_SESSION['user'];
                $logged = self::log($user["username"], $user["passw"]);
            } else {
                session_destroy();
            }

            if(strtotime($evento["dataInizio"]) > time() ){
                $accessori = eventoModel::getAccessoriByEvento($id);
                $categorie = eventoModel::getCategorieByEvento($id);
                require_once "app/view/eventi/dettagliEvento.php";
            }else{
                header('Location: /eventi/index');//rimanda agli eventi futuri
                die();
            }
        }

        public static function dettagliEventoPassato($params){ 

            $id = $params[0];

            $evento = eventoModel::getEventoById($id);

            session_start();
            if(isset($_SESSION['user']) ) {
                $user = $_SESSION['user'];
                $logged = self::log($user["username"], $user["passw"]);
            } else {
                session_destroy();
            }

            if(strtotime($evento["dataInizio"]) < time() ){
                $accessori = eventoModel::getAccessoriByEvento($id);
                $categorie = eventoModel::getCategorieByEvento($id);
                require_once "app/view/eventi/dettagliEventoPassato.php";
            }else{
                header('Location: /eventi/index');//rimanda agli eventi futuri
                die();
            }
        }

        /*
        ordine delle pagine:
        acquistaBiglietto 
        pagamento -> riepilogo
        inserisciCarta -> pagamento
        */ 

        public static function acquistaBiglietto($params){// 

            /*
            controlla se l'utente e' loggato e 
            se si fa vedere tutte
            altrimenti manda alla form di signin
            */
            session_start();
            var_dump(isset($_SESSION["evento"]));

            $id = $params[0];
            
            
            $user = $_SESSION["user"];
            var_dump($user);
            echo "dsfggrergerwggegerafgsergherasg";
            if(is_array($_SESSION["user"]) && self::log($user['username'],$user['passw'])){ //se il tipo e' loggato
                $user = $_SESSION["user"];
                $evento = eventoModel::getEventoById( $id );
                $accessori = eventoModel::getAccessoriByEvento($id);
                $categorie = eventoModel::getCategorieByEvento($id);
                require_once "app/view/eventi/acquistaBiglietto.php";
            }else{ //se non e' loggato manda alla pagina signin per verificare gli errori
                header("Location: /utente/login");
                die();
            }

            
        }

        //parte logica

        public function elaboraAcquistaBiglietto(){
            
            /*controlla se l'utente e' loggato e se ci sono accessori e categorie dentro post in input 
            se si fa vedere tutte
            altrimenti manda alla form di signin
            */
            session_start();
            var_dump($_SESSION);
            var_dump($_POST);

            
            
            

            foreach ($_POST as $key => $value) {
                $dato = explode('/', $key);

                if($dato[0]=='categoria'){
                    $categorie[$dato[1]] =$value;

                }else if($dato[0]=='accessorio'){
                    $accessori[] = $dato[1];

                }else{
                    //header('Location: /eventi/index');//rimanda agli eventi futuri
                    //die();
                }
                
            }

            $_SESSION['AccessoriAcquistati'] = $accessori;
            $_SESSION['CategorieAcquistate'] = $categorie;

            header("Location: /eventi/inserisciCarta");
            die();

            /*
            session_start();
            if(isset($_SESSION["user"]) && $_SESSION["user"] -> login()){ //se il tipo e' loggato
                $user = $_SESSION["user"];
                $evento = new eventoModel($idEvento);
                $evento -> caricaDati();
                $accessiori = $evento -> getAccessori();
                $categorie = $evento -> getCategorie();
                require_once "app/template/eventi/acquistaBiglietto.php";
            }else{ //se non e' loggato manda alla pagina signin per verificare gli errori
                header("Location: /utente/login");
                die();
            }

            */
        }

        public function inserisciCarta(){
            session_start();

            //trasformo array in modo strano, nella riscrittura va modifica

            $vecchieCategorie = $_SESSION['evento']['categorie']; 

            var_dump($vecchieCategorie);
            
            foreach ( $vecchieCategorie as $key => $value) {
                $categorieScelte[$vecchieCategorie[$key]['codCategoria']]= $vecchieCategorie[$key] ;
            }
            
            echo "<br><br>";
            var_dump($categorieScelte);


            require_once "app/template/eventi/inserisciCarta.php";


        }

        //link vari

        public static function logout(){ // manda alla homepage
            session_start();
            session_destroy();
            header("Location: /museo/homepage"); 
            die(); 
        }

        public static function homepage(){ //view dell'index
            header("Location: /museo/homepage"); //rimanda ad un'altro controller
            die();
        }

        public static function aboutUs(){
            header("Location: /museo/aboutUs"); //rimanda ad un'altro controller
            die();
        }

        //cambio controller
        public static function login(){ 
            header("Location: /utente/login"); //rimanda ad un'altro controller
            die();
        }

        public static function eventi(){
            header("Location: /eventi/index"); //rimanda ad un'altro controller
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