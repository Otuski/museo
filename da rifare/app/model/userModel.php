<?php

/*
        classe userModel
        campi: 
            username
            nome
            cognome
            mail 
            password: (campo calcolato cosi' = hash(passwordutente + salt) )
            salt
            tipoUtente
        
        metodi:
            __construct(username, password)
            login(): fa la query e se esiste l'account 
            signin(username, nome, cognome, mail, password): inserisce utente nel db
            update(nome, cognome, mail): cambia campi e aggiorna db
            updatePassword(password): cambia password usando anche il salt e aggiorna db
            getBiglietti(): ritorna un array di oggetti bliglietti e questi sono i biglietti comprati da quella persona
         

        classe bigliettiModel
        campi:
            id
            prezzo
            validita'
            visita(un tipo di oggetto) 
            categoria (un tipo di oggetto) 
        metodi:
            __contruct(id, prezzo, validita, visita(un tipo di oggetto), categoria (un tipo di oggetto) )
            setter e getter
        
        classe visitaModel
        campi:
            id
            titolo
            descrizione
            tariffa
            tipoVisita
            dataInizio
            dataFine
            bigliettiDisponibili
        metodi:
            _contruct(tutti i campi)

        
        
        classe categoriaModel
        campi:
            id
            tipoDocumento
            sconto
            descrizione
        metodi:
            __construct(id): imposta l'id ( se l'evento non esiste e va creato l'id lo crea automaticamente il db,
                                            se esiste l'id serve per caricare i dati da db -> oggetto) 
            
            caricaDati(): in base all'id carica i dati nell'oggetto
            
            creaEvento(id, titolo, descrizione, tariffa, tipoVisita, dataInizio, dataFine, bigliettiDisponibili): 
                - crea l'evento e lo inserisce nel db


        
        
        
        
        classe eventoModel
        campi:
            id
            titolo
            descrizione 
            tariffa
            tipoVisita
            dataInizio
            dataFine
            bigliettiDisponibili
        metodi:
            __construct(id): imposta l'id ( se l'evento non esiste e va creato l'id lo crea automaticamente il db,
                                            se esiste l'id serve per caricare i dati da db -> oggetto) 
            
            caricaDati(): in base all'id carica i dati nell'oggetto
            
            creaEvento(id, titolo, descrizione, tariffa, tipoVisita, dataInizio, dataFine, bigliettiDisponibili): 
                - crea l'evento e lo inserisce nel db
            
            getGallery(): restituisce un array di tipo galleryModel[] con tutte le foto legate a quell'evento

        classe galleryModel
            campi:
                id
                descrizione
            metodi:
                __construct(id): imposta l'id ( se l'evento non esiste e va creato l'id lo crea automaticamente il db,
                                            se esiste l'id serve per caricare i dati da db -> oggetto) 
            
                caricaDati(): in base all'id carica i dati nell'oggetto
                creaFoto(descrizione): fa insert into

*/

    //namespace app\model\userModel;
    //use app\database\database;
    require_once 'app/database/database.php';
    
    
	class userModel{
    	public $username, $nome, $cognome, $email, $passw, $tipoUtente, $error;

		public function __construct($username, $pass){
        	$this->username = $username;
            $this->passw = $pass;
            $this->error = null;
        }
        
        /**
         * fa la query e cerca la password del utente non accertato ritorna true se la password esiste ed e' giusta
         */
        public function login(){

            $psw = array();

            $db = new database();
            $db -> prepare("SELECT passw FROM UTENTE where username = ?");
            $db -> getStatement() -> bind_param("s", $this->username);

            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                $this->error = "errore di sistema";
                return false;
            }

            
            $psw = $db -> getStatement() -> get_result() -> fetch_assoc() ;

            
            if( is_null($psw)){//se non trova la password 
                $db -> close();
                $this-> error = "username non trovato";
                return false;
            }

            if( password_verify($this -> passw, $psw["passw"] )){//controlla se la password e' giusta
                return true;
            }else{
                $db -> close();
                $this-> error = "password errata";
                return false;
            }

        }
        
        /*
            cerca i dati rimanenti dell'utente tramite username da inserire nell'oggetto: nome, cognome, mail, tipoUtente
            fa il fetch e li associa all'oggetto
            */
        public function caricaDati():bool{

            $db = new database();
            $db -> prepare("SELECT nome, cognome, mail, tipoUtente FROM UTENTE where username = ?");
            $db -> getStatement() -> bind_param("s", $this->username);

            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                $this -> error = "errore di sistema";
                return false;
            }

            $result = $db -> getStatement() -> get_result() -> fetch_array() ;

            if( (is_array($result)) && count($result) < 1){//se non trova l'username
                $db -> close();
                $this -> error = "username non trovato";
                return false;
            }

            $this -> nome = $result[0];
            $this -> cognome = $result[1];
            $this -> email = $result[2];
            $this -> tipoUtente = $result[3];

            $db -> close();

            return true;
        }
        
        /**
         * esegue la query di insert into, 
         * se inserisce ritorna true
         * se fallisce ritorna false 
         */
        public function signin($username, $nome, $cognome, $mail, $passw):bool{
            

            // creazione statement
            $db = new database();
            $db -> prepare('INSERT INTO `utente` (`username`, `nome`, `cognome`, `mail`, `passw`, `tipoUtente`) VALUES (?,?,?,?,?,"user")');
            $db -> getStatement() -> bind_param("sssss", $username, $nome, $cognome, $mail, password_hash($passw, PASSWORD_DEFAULT)); 

            // prova a eseguire lo statement
            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                $this -> error = "errore di sistema";
                return false;
            }

            $db -> close();

            return true;
        }
        /**
         * fa l'update dei dati dell'utente nel db
         *
         * @param [String] $nome
         * @param [String] $cognome
         * @param [String] $mail
         * @return bool
         */
        public function update($nome, $cognome, $email):bool{

            // creazione statement
            $db = new database();
            $db -> prepare("UPDATE UTENTE SET nome = ?, cognome = ?, mail = ? where username = ?");
            $db -> getStatement() -> bind_param("ssss", $nome, $cognome, $email, $this ->username); 

            // prova a eseguire lo statement
            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                $this -> error = "errore di sistema";
                return false;
            }

            $this -> nome = $nome;
            $this -> cognome = $cognome;
            $this -> email = $email; 

            $db -> close();

            return true;

        }
         /**
          * updata l'hash della password salvata nel db con la password nuova 
          *
          * @param [String] $password
          * @return boolean
          */
        public function updatePassword($password):bool{

            // creazione statement
            $db = new database();
            $db -> prepare("UPDATE UTENTE SET passw = ? where username = ?");
            $db -> getStatement() -> bind_param("ss", password_hash($password, PASSWORD_DEFAULT), $this ->username); 

            // prova a eseguire lo statement
            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                $this -> error = "errore di sistema";
                return false;
            }
            $this -> passw = $password;

            return true;
        }
        
        /**
         * ritorna la queri con tutti i biglietti dell'utente in un array di 2 dimensioni
         *
         * @return array
         */
        public function getBiglietti(): array|false{
            


            $db = new database();
            $db -> prepare("SELECT b.idBiglietto, b.prezzo, b.dataValidita, v.idVisita, v.titolo, v.descrizione, v.dataInizio, v.dataFine, c.nome as nomeCategoria, s.codServizio, s.descrizione as nomeServizio, s.prezzoAPersona as prezzoServizio, codTransazione  FROM biglietto b
            INNER JOIN visita v ON b.idVisita = v.idVisita
            INNER JOIN categoria c ON b.codCategoria = c.codCategoria 
            LEFT JOIN aggiunta a ON a.idBiglietto = b.idBiglietto
            LEFT JOIN servizio s ON a.codServizio = s.codServizio
            WHERE utente = ?
            ORDER BY codTransazione ASC, b.idBiglietto ASC;");
            $db -> getStatement() -> bind_param("s", $this->username);

            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                $this -> error = "errore di sistema";
                return false;
            }


            $result = $db -> getStatement() -> get_result() -> fetch_all(MYSQLI_ASSOC) ;

            if( (is_array($result)) && count($result) < 1){//se non trova l'username
                $db -> close();
                $this -> error = "username non trovato";
                return false;
            }

            $db -> close();

            return $result;

            


            




            /*

            

            $result = $db -> getStatement() -> get_result() -> fetch_array() ;

            if( count($result) < 1){//se non trova l'username
                $db -> close();
                $this -> error = "username non trovato";
                return false;
            }

            $this ->nome = $result[0];
            $this ->cognome = $result[1];
            $this ->maill = $result[2];
            $this ->tipoUtente = $result[3];













            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $stmt = $mysqli -> prepare("select * from BIGLIETTO B INNER JOIN VISITA V on V.idVisita = B.idVisita INNER JOIN CATEGORIA C on C.codCategoria = B.codCategoria  WHERE utente = ?");
            $stmt -> bind_param("s", $this ->username);
            $stmt -> execute();
            $result = $stmt -> get_result();
            $biglietti = $result -> fetch_all();
            $mysqli->close();
            return $biglietti;

            */
        }
     
    }

                
                