<?php  
    require_once "app/model/eventoModel.php";
    require_once "app/model/userModel.php";

    class eventi { //controller
        
        

        //  qui ci sono tutte le view
        public function index(){//funzione che verra' richiamata se non e' specificata o e' sbagliato il nome della funzione
            header('Location: /eventi/eventiFuturi');//rimanda agli eventi futuri
            die();
        }
        public function eventiFuturi(){ 

            /*
            la classe eventoModel ha un metodo statico che ritorna tutti gli eventi futuri
            passa gli eventi alla view e li mostra
            */

           
            $modello = new eventoModel(null) ;
            $eventi = $modello -> eventiFuturi();
            require_once "app/template/eventi/eventiFuturi.php";
        }

        public function eventiPassati(){ 
            
            /*
            la classe eventoModel ha un metodo statico che ritorna tutti gli eventi passati
            passa gli eventi alla view e li mostra
            */

            $modello = new eventoModel(null) ;
            $eventi = $modello -> eventiPassati();
            require_once "app/template/eventi/eventiPassati.php";
        }

        public function dettagliEvento($idEvento){ 
            /*
            prende in input un url tipo: eventi/dettaglievento/nomeEvento
            controlla se esiste l'evento
            trova l'evento, le categorie ammesse e gli accessori disponibili nel db e li mostra 
            */

            $evento = new eventoModel((int) ($idEvento[0]));

            session_start();

            if($evento->caricaDati() && (strtotime($evento->dataInizio) > time()) ){
                $accessori = $evento -> getAccessori();
                $categorie = $evento -> getCategorie();
                $_SESSION['evento'] = [
                    'evento'=> $evento,
                    'accessori'=> $accessori,
                    'categorie'=> $categorie
                ];
                require_once "app/template/eventi/dettagliEvento.php";
                var_dump($_SESSION['evento']);
            }else{
                header('Location: /eventi/index');//rimanda agli eventi futuri
                die();
            }
        }

        public function dettagliEventoPassato($idEvento){ 

            $evento = new eventoModel((int) ($idEvento[0]));

            echo " l'if :".$evento->caricaDati()." && (strtotime($evento->dataInizio) > time()";

            if($evento->caricaDati() && (strtotime($evento->dataInizio) < time())){
                $accessori = $evento -> getAccessori();
                $categorie = $evento -> getCategorie();
                require_once "app/template/eventi/dettagliEventoPassato.php";
            }else{
                header('Location: /eventi/index');//rimanda agli eventi futuri
                die();
            }
        }

        public function acquistaBiglietto(){// 

            /*
            controlla se l'utente e' loggato e 
            se si fa vedere tutte
            altrimenti manda alla form di signin
            */
            session_start();
            var_dump(isset($_SESSION["evento"]));
            
            $evento = $_SESSION["evento"];
            $user = $_SESSION["user"]; 
            var_dump($evento);
            var_dump($user);
            echo "dsfggrergerwggegerafgsergherasg";
            if(isset($_SESSION["user"]) && $_SESSION["user"]->login() && isset($_SESSION["evento"])){ //se il tipo e' loggato
                $user = $_SESSION["user"];
                $evento = $_SESSION['evento']['evento'];
                $accessori = $_SESSION['evento']['accessori'];
                $categorie = $_SESSION['evento']['categorie'];
                require_once "app/template/eventi/acquistaBiglietto.php";
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




            var_dump($categorie);
            var_dump($accessori);

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

        public function logout(){ // manda alla homepage
            session_destroy();
            header("Location: /museo/homepage"); 
            die(); 
        }

        public function homepage(){ //view dell'index
            header("Location: /museo/homepage"); //rimanda ad un'altro controller
            die();
        }

        public function aboutUs(){
            header("Location: /museo/aboutUs"); //rimanda ad un'altro controller
            die();
        }

        //cambio controller
        public function login(){ 
            header("Location: /utente/login"); //rimanda ad un'altro controller
            die();
        }

        public function eventi(){
            header("Location: /eventi/index"); //rimanda ad un'altro controller
            die();
        }


        public function profilo(){
            header("Location: /utente/profilo"); //rimanda ad un'altro controller
            die();
        }

        public function iMieiBiglietti(){
            header("Location: /utente/iMieiBiglietti"); //rimanda ad un'altro controller
            die();
        }
        
        

    }