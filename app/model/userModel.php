<?php

    namespace app\model;
    use app\config\database;
    
    
	class userModel{

        public static function getUserByUsername($username){
            $db = new database();
            $db -> prepare("SELECT * FROM UTENTE where username = ?");
            $db -> getStatement() -> bind_param("s", $username);

            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                return false;
            }

            $user = $db -> getStatement() -> get_result() -> fetch_assoc() ;
            
            if( is_null($user)){//se non trova la password 
                $db -> close();
                return false;
            }

            return $user;
        }
        
        /**
         * esegue la query di insert into, 
         * se inserisce ritorna true
         * se fallisce ritorna false 
         */
        public static function insertUtente($username, $nome, $cognome, $mail, $passw){
            

            // creazione statement
            $db = new database();
            $db -> prepare('INSERT INTO `UTENTE` (`username`, `nome`, `cognome`, `mail`, `passw`, `tipoUtente`) VALUES (?,?,?,?,?,"user")');
            $db -> getStatement() -> bind_param("sssss", $username, $nome, $cognome, $mail, password_hash($passw, PASSWORD_DEFAULT)); 

            // prova a eseguire lo statement
            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
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
        public static function updateDatiByUtente($username, $nome, $cognome, $email){

            // creazione statement
            $db = new database();
            $db -> prepare("UPDATE UTENTE SET nome = ?, cognome = ?, mail = ? where username = ?");
            $db -> getStatement() -> bind_param("ssss", $nome, $cognome, $email, $username); 

            // prova a eseguire lo statement
            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                return false;
            }

            $db -> close();

            return true;

        }
         /**
          * updata l'hash della password salvata nel db con la password nuova 
          *
          * @param [String] $password
          * @return boolean
          */
        public static function updatePasswordByUtente($username, $password){

            // creazione statement
            $db = new database();
            $db -> prepare("UPDATE UTENTE SET passw = ? where username = ?");
            $db -> getStatement() -> bind_param("ss", password_hash($password, PASSWORD_DEFAULT), $username); 

            // prova a eseguire lo statement
            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                return false;
            }

            return true;
        }
        
        /**
         * ritorna la queri con tutti i biglietti dell'utente in un array di 2 dimensioni
         *
         * @return array | bool
         */
        public static function getBigliettiByUtente($username,){
            


            $db = new database();
            $db -> prepare("SELECT t.codTransazione, b.utente, c.nome, v.idVisita, v.titolo, v.dataInizio, v.dataFine, v.tariffa - v.tariffa * c.sconto as Prezzo, COUNT(b.idBiglietto) as NumeroBiglietti FROM BIGLIETTO b
            INNER JOIN TRANSAZIONE t ON t.codTransazione = b.codTransazione
            INNER JOIN CATEGORIA c ON c.codCategoria = b.codCategoria
            INNER JOIN VISITA v ON v.idVisita =b.idVisita
            WHERE b.utente = ?
            GROUP BY b.codTransazione, b.codCategoria;");
            $db -> getStatement() -> bind_param("s", $username);

            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                return false;
            }


            $result = $db -> getStatement() -> get_result() -> fetch_all(MYSQLI_ASSOC) ;

            if( (is_array($result)) && count($result) < 1){//se non trova l'username
                $db -> close();
                return false;
            }

            $db -> close();

            return $result;
        }

        public static function getAccessoriByUtente($username,){
            


            $db = new database();
            $db -> prepare("SELECT *
            FROM TRANSAZIONE t 
            INNER JOIN BIGLIETTO b ON t.codTransazione = b.codTransazione
            INNER JOIN AGGIUNTA a ON a.idBiglietto = b.idBiglietto
            INNER JOIN SERVIZIO s ON s.codServizio = a.codServizio
            WHERE b.utente = ?;");
            $db -> getStatement() -> bind_param("s", $username);

            if( !$db -> easyExecute()){//se non va la query manda via
                $db -> close();
                return false;
            }


            $result = $db -> getStatement() -> get_result() -> fetch_all(MYSQLI_ASSOC) ;

            if( (is_array($result)) && count($result) < 1){//se non trova l'username
                $db -> close();
                return false;
            }

            $db -> close();

            return $result;
        }
     
    }