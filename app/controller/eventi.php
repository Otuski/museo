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

            

            session_start();
            //controllo login
            if(isset($_SESSION['user']) ) {
                $user = $_SESSION['user'];
                $logged = self::log($user["username"], $user["passw"]);
            } else {
                session_destroy();
                header('Location: /eventi/index');//rimanda agli eventi futuri
                die();
            }

            $id = $params[0];

            $evento = eventoModel::getEventoById($id);

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
            //controllo login
            if(isset($_SESSION['user']) ) {
                $user = $_SESSION['user'];
                $logged = self::log($user["username"], $user["passw"]);
            } else {
                session_destroy();
                header('Location: /utente/index');//rimanda agli eventi futuri
                die();
            }

            $id = $params[0];
            
            
            $user = $_SESSION["user"];

            $_SESSION['idVisita'] = $id;

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

        public static function elaboraAcquistaBiglietto(){
            
            /*controlla se l'utente e' loggato e se ci sono accessori e categorie dentro post in input 
            se si fa vedere tutte
            altrimenti manda alla form di signin
            */
            session_start();
            //controllo login
            if(isset($_SESSION['user']) ) {
                $user = $_SESSION['user'];
                $logged = self::log($user["username"], $user["passw"]);
            } else {
                session_destroy();
                header('Location: /utente/index');//rimanda agli eventi futuri
                die();
            }

            foreach ($_POST as $key => $value) {
                $dato = explode('/', $key);

                if($dato[0]=='categoria'){
                    $categorie[$dato[1]]["codCategoria"] = (int) $dato[1];
                    $categorie[$dato[1]]["qta"] = (int) $value;

                }else if($dato[0]=='accessorio'){
                    $accessori[$dato[1]]["codServizio"] = (int) $dato[1];

                }else{
                    //header('Location: /eventi/index');//rimanda agli eventi futuri
                    //die();
                }
                
            }

            $_SESSION['categorie'] = $categorie;
            $_SESSION['accessori'] = $accessori;
            $_SESSION['dataBiglietto'] = $_POST["dataBiglietto"];

            header("Location: /eventi/pagamento");
            die();

        }

        public static function pagamento(){
            session_start();
            //controllo login
            if(isset($_SESSION['user']) ) {
                $user = $_SESSION['user'];
                $logged = self::log($user["username"], $user["passw"]);
            } else {
                session_destroy();
                header('Location: /utente/index');//rimanda agli eventi futuri
                die();
            }
            
            $id = $_SESSION["idVisita"];

            $evento = eventoModel::getEventoById( $id );
            $accessori = eventoModel::getAccessoriByEvento($id);
            $categorie = eventoModel::getCategorieByEvento($id);

            $categorieScelte = $_SESSION["categorie"];
            $accessoriScelti = $_SESSION['accessori'];
            var_dump($accessori, $accessoriScelti, $categorie, $categorieScelte);
            require_once "app/view/eventi/pagamento.php";

        }

        public static function inserisciCarta(){

            session_start();
            //controllo login
            if(isset($_SESSION['user']) ) {
                $user = $_SESSION['user'];
                $logged = self::log($user["username"], $user["passw"]);
            } else {
                session_destroy();
                header('Location: /utente/index');//rimanda agli eventi futuri
                die();
            }
            require_once "app/view/eventi/inserisciCarta.php";
        }

        public static function testElaboraInserisciCarta(){
            session_start();

            $id = $_SESSION["idVisita"];

            echo "session : ",var_dump($_SESSION);
            echo '<br>';
            echo '<br>';
            echo "evento : ",var_dump(eventoModel::getEventoById( $id ));
            echo '<br>';
            echo '<br>';
            echo "accessoriDisponibili : ",var_dump(eventoModel::getAccessoriByEvento($id));
            echo '<br>';
            echo '<br>';
            echo "categorieDisponibili : ",var_dump(eventoModel::getCategorieByEvento($id));
            echo '<br>';
            echo '<br>';
            echo "categorie : ",var_dump($_SESSION["categorie"]);
            echo '<br>';
            echo '<br>';
            echo "accessori : ",var_dump($_SESSION['accessori']);
            echo '<br>';
            echo '<br>';
            echo "insertCarta : ",var_dump(eventoModel::insertTransizione("dfdf", "efe"));
            echo '<br>';
            echo '<br>';
            echo "getLastTransizione : ",var_dump(eventoModel::getLastTransizione());
            echo '<br>';
            echo '<br>';
            echo "getLastTransizione : ",var_dump(eventoModel::getLastBiglietto());
            echo '<br>';
            echo '<br>';
        }

        public static function elaboraInserisciCarta(){
            session_start();
            //controllo login
            if(isset($_SESSION['user']) ) {
                $user = $_SESSION['user'];
                $logged = self::log($user["username"], $user["passw"]);
            } else {
                session_destroy();
                header('Location: /utente/index');//rimanda agli eventi futuri
                die();
            }

            $id = $_SESSION["idVisita"];
            $user = $_SESSION["user"];
            $categorieScelte = $_SESSION["categorie"];
            $accessoriScelti = $_SESSION['accessori'];

            $evento = eventoModel::getEventoById( $id );
            $accessori = eventoModel::getAccessoriByEvento($id);
            $categorie = eventoModel::getCategorieByEvento($id);

            //inserisci carta

            $numCarta = $_POST["numCarta"];
            $nome = $_POST["nome"];
            $cognome = $_POST["cognome"];
            $tipoCarta = "patata";

            eventoModel::insertCarta($numCarta, $nome, $cognome, $tipoCarta);

            //inserisci transazione

            $username = $user["username"];

            eventoModel::insertTransizione($username, $numCarta);

            //inserisci biglietti

            foreach($categorie as $categoria) {

                for ($i=0; $i < $categorieScelte[ $categoria['codCategoria'] ]['qta']; $i++) { 

                    $prezzo = $evento['tariffa'] - $evento['tariffa'] * $categoria['sconto'];
                    $lastTransazione = eventoModel::getLastTransizione()[0];

                    $data =$_SESSION['dataBiglietto'];

                    $iolo = eventoModel::insertBiglietto($prezzo, $data, $username, $id, $lastTransazione["codTransazione"], $categoria['codCategoria']);
                    echo "insertBiglietto : ",var_dump($iolo);
                    echo '<br>';
                    echo '<br>';
                    echo "lastTransazione : ",var_dump($lastTransazione);
                    echo '<br>';
                    echo '<br>';
                }

            }
            

            //inserisci accessori

            $lastBiglietto = eventoModel::getLastBiglietto()[0];



            foreach ($accessori as $accessorio) {
                if(isset($accessoriScelti [ $accessorio["codServizio"] ])){
                    $banna =eventoModel::insertAccessorio($lastBiglietto["idBiglietto"], $accessorio["codServizio"]);
                    echo "insertAccessorio: ",var_dump($banna);
                    echo '<br>';
                    echo '<br>';
                }
            }

            header("Location: /eventi/buonaVisita");
        }

        public static function buonaVisita(){
            session_start();
            //controllo login
            if(isset($_SESSION['user']) ) {
                $user = $_SESSION['user'];
                $logged = self::log($user["username"], $user["passw"]);
            } else {
                session_destroy();
                header('Location: /utente/index');//rimanda agli eventi futuri
                die();
            }
            require_once "app/view/eventi/buonaVisita.php";
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
        

        private static function testInsertTransazione($args){
            $user = $args[0];
            $numCarta = $args[1];

            $result = eventoModel::insertTransizione($user, $numCarta);
            var_dump($user,$numCarta, $result);
        }

        private static function testInsertBiglietto($args){ // http://localhost/eventi/testInsertBiglietto/12/2024-12-23/aaaaaaaa/2/5/1
            var_dump($args);
            $prezzo = $args[0];
            $dataValidita = $args[1];
            $utente = $args[2];
            $idVisita = $args[3];
            $codTransazione = $args[4];
            $codCategoria = $args[5];

            $result = eventoModel::insertBiglietto($prezzo, $dataValidita, $utente, $idVisita, $codTransazione, $codCategoria);
            var_dump($prezzo, $dataValidita, $utente, $codTransazione, $codCategoria, $result);
        }

        private static function testInsertAccessorio($args){ // http://localhost/eventi/testInsertAccessorio/8/2 cambiare con valori a piacere
            var_dump($args);
            $idBiglietto = $args[0];
            $codServizio = $args[1];

            $result = eventoModel::insertAccessorio($idBiglietto, $codServizio);
            var_dump($idBiglietto, $codServizio, $result);
        }

        private static function testInsertCarta($args){ // http://localhost/eventi/testInsertCarta/76597976/PPoldoo/Cognome/VIAS cambiare con valori a piacere
            var_dump($args);
            $numCarta = $args[0];
            $nome = $args[1];
            $cognome = $args[2];
            $tipoCarta = $args[3];

            $result = eventoModel::insertCarta($numCarta, $nome, $cognome, $tipoCarta);
            var_dump($numCarta, $nome, $cognome, $tipoCarta, $result);
        }
        


        

    }