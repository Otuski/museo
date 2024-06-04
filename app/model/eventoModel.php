<?php
    namespace app\model;
    use app\config\database;

    class eventoModel{
        /**
         * il metodo ritorna tutti i campi di un evento tramite un id
         * 
         * @param [int] id del evento
         * @return [false|array] ritorna false se c'è un errore nella query ma il risultato se va a buon fine
         */
        

        public static function getEventoById($id){
            $db = new database();
            $db -> prepare("SELECT * FROM VISITA v
                            WHERE v.idVisita = ?");
            $db -> getStatement() -> bind_param("i", $id);

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
        
        
        // funzione che ritorna gli eventi futuri (dopo la data odierna)
        public static function eventiFuturi(){

            $db = new database();
            $db -> prepare("SELECT * FROM VISITA WHERE dataInizio > ?");
            $today = date("Y-m-d",time());
            $db -> getStatement() -> bind_param("s", $today);

            // prova a eseguire lo statement
            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                return false;
            }

            $result = $db -> getStatement() -> get_result();

            if( (is_array($result)) && count($result) < 1){//se non trova la visita tramite l'id:
                $db -> close();
                return false;
            }

            $eventi = $result -> fetch_all(MYSQLI_ASSOC);

            $db -> close();

            return $eventi;
        } 
        
        // funzione che ritorna gli eventi passati (prima della data odierna)
        /** */
        public static function eventiPassati(){

            
            $db = new database();
            $db -> prepare("SELECT * FROM VISITA WHERE dataInizio < ?");
            $today = date("Y-m-d",time());
            $db -> getStatement() -> bind_param("s", $today);

            // prova a eseguire lo statement
            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                return false;
            }

            $result = $db -> getStatement() -> get_result();

            if( (is_array($result)) && count($result) < 1){//se non trova la visita tramite l'id:
                $db -> close();
                return false;
            }

            $eventi = $result -> fetch_all(MYSQLI_ASSOC);
            $db -> close();
            return $eventi;
        }
        
        // crea e inserisce evento nel db
        public static function creaEvento($titolo, $descrizione, $tariffa, $tipoVisita, $saraInizio, $dataFine, $bigliettiDisponibili){

            $db = new database();
            $db -> prepare("INSERT INTO VISITA (titolo, descrizione, tariffa, tipoVisita, daraInizio, dataFine, bigliettiDisponibili) VALUES (?,?,?,?,?,?,?)");
            $db -> getStatement() -> bind_param("ssdsssi",$titolo, $descrizione, $tariffa, $tipoVisita, $saraInizio, $dataFine, $bigliettiDisponibili);

            // prova a eseguire lo statement
            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                return false;
            }

            $result = $db -> getStatement() -> get_result();

            if( (is_array($result)) && count($result) < 1){//se non trova la visita tramite l'id:
                $db -> close();
                return false;
            }

            $db -> close();

            return true;


        }
        
        // prende tutte le foto di un evento
        public function getGalleryByEvento($id){
            
            $db = new database();
            $db -> prepare("SELECT idFoto FROM GALLERY WHERE idVisita = ?");
            $db -> getStatement() -> bind_param("i", $id);

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

        public static function getAccessoriByEvento($id){

            $db = new database();
            $db -> prepare("SELECT s.codServizio, s.descrizione, s.prezzoAPersona FROM VISITA v
                            INNER JOIN OFFERTA o ON v.idVisita = o.idVisita
                            INNER JOIN SERVIZIO s ON o.codServizio = s.codServizio 
                            WHERE v.idVisita = ?");
            $db -> getStatement() -> bind_param("i", $id);

            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                return false;
            }

            $result = $db -> getStatement() -> get_result() -> fetch_all(MYSQLI_ASSOC) ;

            if( (is_array($result)) && count($result) < 1){//se non trova la visita tramite l'id:
                $db -> close();
                return false;
            }

            $db -> close();

            return $result;
        }

        public static function getCategorieByEvento($id){

            $db = new database();
            $db -> prepare("SELECT ca.codCategoria, ca.descrizione, ca.sconto, ca.tipoDocumento FROM VISITA v
            INNER JOIN VARIAZIONE va ON v.idVisita = va.idVisita
            INNER JOIN CATEGORIA ca ON va.codCategoria = ca.codCategoria            
            WHERE v.idVisita = ?");
            $db -> getStatement() -> bind_param("i", $id);

            // prova a eseguire lo statement
            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                return false;
            }

            $result = $db -> getStatement() -> get_result() -> fetch_all(MYSQLI_ASSOC);

            if( (is_array($result)) && count($result) < 1){//se non trova la visita tramite l'id:
                $db -> close();
                return false;
            }

            $db -> close();

            return $result;
        }

        public static function insertTransizione($utente, $numCarta){

            $db = new database();
            $db -> prepare("INSERT INTO TRANSAZIONE (`codTransazione`, `utente`, `numCarta`) VALUES (NULL, ?, ?);");
            $db -> getStatement() -> bind_param("ss",$utente, $numCarta);

            // prova a eseguire lo statement
            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                return false;
            }

            $result = $db -> getStatement() -> get_result();

            if( $result){//se non trova la visita tramite l'id:
                $db -> close();
                return false;
            }

            $db -> close();

            return true;
            
        }

        public static function insertBiglietto($prezzo, $dataValidita, $utente, $idVisita, $codTransazione, $codCategoria){

            $db = new database();
            $db -> prepare("INSERT INTO BIGLIETTO (`idBiglietto`, `prezzo`, `dataValidita`, `utente`, `idVisita`, `codTransazione`, `codCategoria`) VALUES (NULL, ?, ?, ?, ?, ?, ?);");
            $db -> getStatement() -> bind_param("issiii",$prezzo, $dataValidita, $utente, $idVisita, $codTransazione, $codCategoria);

            // prova a eseguire lo statement
            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                return false;
            }

            $result = $db -> getStatement() -> get_result();

            if( $result){//se non trova la visita tramite l'id:
                $db -> close();
                return false;
            }

            $db -> close();

            return true;
            
        }

        public static function insertAccessorio($idBiglietto, $codServizio){
            $db = new database();
            $db -> prepare("INSERT INTO AGGIUNTA (`codServizio`, `idBiglietto`) VALUES (?, ?);");
            $db -> getStatement() -> bind_param("ii", $idBiglietto, $codServizio);

            // prova a eseguire lo statement
            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                return false;
            }

            $result = $db -> getStatement() -> get_result();

            if( $result){//se non trova la visita tramite l'id:
                $db -> close();
                return false;
            }

            $db -> close();

            return true;
        }

        public static function insertCarta($numCarta, $nome, $cognome, $tipoCarta){
            $db = new database();
            $db -> prepare("INSERT INTO CARTA (`numCarta`, `nome`, `cognome`, `tipoCarta`) VALUES (?, ?, ?, ?)");
            $db -> getStatement() -> bind_param("ssss", $numCarta, $nome, $cognome, $tipoCarta);

            // prova a eseguire lo statement
            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                return false;
            }

            $result = $db -> getStatement() -> get_result();

            if( $result){//se non trova la visita tramite l'id:
                $db -> close();
                return false;
            }

            $db -> close();

            return true;
        }
    }

    
