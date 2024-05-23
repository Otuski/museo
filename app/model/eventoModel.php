<?php
    namespace app\model;
    use app\config;

    class eventoModel{
        
    	public $id, $titolo, $descrizione, $tariffa, $tipoVisita, $dataInizio, $dataFine, $bigliettiDisponibili, $error;
        
        // costruttore
        public function __construct($id){
        	$this->id = $id;
            
        }

        public static function getEventoById($id){
            $db = new database();
            $db -> prepare("SELECT * FROM visita v
                            WHERE v.idVisita = ?;");
            $db -> getStatement() -> bind_param("s", $id);

            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                return false;
            }

            $result = $db -> getStatement() -> get_result() -> fetch_array(MYSQLI_ASSOC) ;

            if( (is_array($result)) && count($result) < 1){//se non trova la visita tramite l'id:
                $db -> close();
                return false;
            }

            $db -> close();

            return $result;
        }
        
        // funzione che prende tutti gli altri campi della tabella se esistono
        public function caricaDati(){


            $db = new database();
            $db -> prepare("SELECT * FROM visita v
            WHERE v.idVisita = ?;");
            $db -> getStatement() -> bind_param("s", $this->id);

            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                $this -> error = "errore di sistema";
                return false;
            }

            $result = $db -> getStatement() -> get_result() -> fetch_array(MYSQLI_ASSOC) ;

            if( (is_array($result)) && count($result) < 1){//se non trova la visita tramite l'id:
                $db -> close();
                $this -> error = "id non trovato";
                return false;
            }

            $this ->titolo = $result['titolo'];
            $this ->descrizione = $result['descrizione'];
            $this ->tariffa = $result['tariffa'];
            $this ->tipoVisita = $result['tipoVisita'];
            $this ->dataInizio = $result['dataInizio'];
            $this ->dataFine = $result['dataFine'];
            $this ->bigliettiDisponibili = $result['maxBiglietti'];

            $db -> close();

            return true;

        }
        
        // funzione che ritorna gli eventi futuri (dopo la data odierna)
        public function eventiFuturi(){

            $db = new database();
            $db -> prepare("SELECT * FROM VISITA WHERE dataInizio > ?");
            $today = date("Y-m-d",time());
            $db -> getStatement() -> bind_param("s", $today);

            // prova a eseguire lo statement
            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                $this -> error = "errore di sistema";
                return false;
            }

            $result = $db -> getStatement() -> get_result();

            $eventi = $result -> fetch_all(MYSQLI_ASSOC);

            $db -> close();
            return $eventi;
        } 
        
        // funzione che ritorna gli eventi passati (prima della data odierna)
        /** */
        public function eventiPassati(){

            
            $db = new database();
            $db -> prepare("SELECT * FROM VISITA WHERE dataInizio < ?");
            $today = date("Y-m-d",time());
            $db -> getStatement() -> bind_param("s", $today);

            // prova a eseguire lo statement
            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                $this -> error = "errore di sistema";
                return false;
            }


            $eventi = array();

            $result = $db -> getStatement() -> get_result();

            $eventi = $result -> fetch_all(MYSQLI_ASSOC);
            $db -> close();
            return $eventi;
        }
        
        // crea e inserisce evento nel db
        public function creaEvento($titolo, $descrizione, $traiffa, $tipoVisita, $saraInizio, $dataFine, $bigliettiDisponibili){
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        	$stmt = $mysqli -> prepare("INSERT INTO VISITA (titolo, descrizione, traiffa, tipoVisita, daraInizio, dataFine, bigliettiDisponibili) VALUES (?,?,?,?,?,?,?)");
          	$stmt -> bind_param("ssdsssi",$titolo, $descrizione, $traiffa, $tipoVisita, $saraInizio, $dataFine, $bigliettiDisponibili);
            $ris = $stmt -> execute();
            $mysqli -> close();
            return $ris;
        }
        
        // prende tutte le foto di un evento
        public function getGallery(){
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        	$stmt = $mysqli -> prepare("SELECT idFoto FROM GALLERY WHERE idVisita = ?");
          	$stmt -> bind_param("i", $this->id);
            $stmt -> execute();
            $res = $stmt -> get_result();
            $foto = $res -> fetch_all();
            $mysqli -> close();
            return $foto;
        }	

        public function getAccessori():array|false{

            $db = new database();
            $db -> prepare("SELECT s.codServizio, s.descrizione, s.prezzoAPersona FROM visita v
            INNER JOIN offerta o ON v.idVisita = o.idVisita
            INNER JOIN servizio s ON o.codServizio = s.codServizio 
            WHERE v.idVisita = ?");
            $db -> getStatement() -> bind_param("s", $this -> id);

            // prova a eseguire lo statement
            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                $this -> error = "errore di sistema";
                return false;
            }

            $result = $db -> getStatement() -> get_result();

            $accessori = $result -> fetch_all(MYSQLI_ASSOC);

            $db -> close();

            return $accessori;
        }

        public function getCategorie(){

            $db = new database();
            $db -> prepare("SELECT ca.codCategoria, ca.descrizione, ca.sconto, ca.tipoDocumento FROM visita v
            INNER JOIN variazione va ON v.idVisita = va.idVisita
            INNER JOIN categoria ca ON va.codCategoria = ca.codCategoria            
            WHERE v.idVisita = ?");
            $db -> getStatement() -> bind_param("s", $this -> id);

            // prova a eseguire lo statement
            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                $this -> error = "errore di sistema";
                return false;
            }

            $result = $db -> getStatement() -> get_result();

            $categorie = $result -> fetch_all(MYSQLI_ASSOC);

            $db -> close();

            return $categorie;
        }
    }