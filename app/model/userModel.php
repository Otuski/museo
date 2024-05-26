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
            $db -> prepare("SELECT b.idBiglietto, b.prezzo, b.dataValidita, v.idVisita, v.titolo, v.descrizione, v.dataInizio, v.dataFine, c.nome as nomeCategoria, s.codServizio, s.descrizione as nomeServizio, s.prezzoAPersona as prezzoServizio, codTransazione  FROM BIGLIETTO b
            INNER JOIN VISITA v ON b.idVisita = v.idVisita
            INNER JOIN CATEGORIA c ON b.codCategoria = c.codCategoria 
            LEFT JOIN AGGIUNTA a ON a.idBiglietto = b.idBiglietto
            LEFT JOIN SERVIZIO s ON a.codServizio = s.codServizio
            WHERE UTENTE = ?
            ORDER BY codTransazione ASC, b.idBiglietto ASC;");
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

                
                
