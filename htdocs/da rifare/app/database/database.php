<?php
    //namespace app\database\database;

    require_once 'app/config/db_config.php'; //riferito all'index perche' la pagina viene richiamata nell'index
    //use app\config;
    class database {
        protected $conn;
        protected \mysqli_stmt $statement;

        
        public function __construct() {

            try {
                $this -> conn = new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            } catch (\mysqli_sql_exception $exception) {
                echo "Errore di connessione: " . $exception->getMessage();
            }
        }

        public function query($sql):\mysqli_result {
            return $this -> conn -> query($sql);
        }

        public function prepare($query):\mysqli_stmt {
            return $this -> statement = $this -> conn -> prepare($query);
        }
        

        public function easyExecute():\mysqli_result|bool{
            try {
                return $this -> statement -> execute();
            } catch (\mysqli_sql_exception $exception) {
                return false;
            }
        }

        public function getStatement():\mysqli_stmt{
            return $this -> statement;
        }

        public function getConn():\mysqli{
            return $this -> conn;
        }

        public function close() {//chiude la connessione al DB
            $this -> statement -> close();
            $this -> conn -> close();
        }
    }
