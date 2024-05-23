<?php
    //namespace app\database\database;

    namespace app\config;
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

        public function query($sql){
            return $this -> conn -> query($sql);
        }

        public function prepare($query) {
            return $this -> statement = $this -> conn -> prepare($query);
        }
        

        public function easyExecute(){
            try {
                return $this -> statement -> execute();
            } catch (\mysqli_sql_exception $exception) {
                return false;
            }
        }

        public function getStatement(){
            return $this -> statement;
        }

        public function getConn(){
            return $this -> conn;
        }

        public function close() {//chiude la connessione al DB
            $this -> statement -> close();
            $this -> conn -> close();
        }
    }
