<?php

    class Connection{

        private $host = "localhost";
        private $dbName = "pizza_and_dream";
        private $username = "root";
        private $password = "";

        public function connect(){
            $connect = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbName, $this->username, $this->password);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $connect;
        }

    }

?>