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
            $db -> prepare("SELECT * FROM visita v
                            WHERE v.idVisita = ?;");
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
            $db -> prepare("SELECT s.codServizio, s.descrizione, s.prezzoAPersona FROM visita v
                            INNER JOIN offerta o ON v.idVisita = o.idVisita
                            INNER JOIN servizio s ON o.codServizio = s.codServizio 
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

        public static function getCategorieByEvento($id){

            $db = new database();
            $db -> prepare("SELECT ca.codCategoria, ca.descrizione, ca.sconto, ca.tipoDocumento FROM visita v
            INNER JOIN variazione va ON v.idVisita = va.idVisita
            INNER JOIN categoria ca ON va.codCategoria = ca.codCategoria            
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
    }