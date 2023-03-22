<?php 
    class Database {
        private $conn;
        private $host;
        private $port;
        private $dbname;
        private $username;
        private $password;

        public function __contruct(){
            $this->username = getnv('USERNAME');
            $this->password = getnv('PASSWORD');
            $this->dbname = getnv('DBNAME');
            $this->host = getnv('HOST');
            $this->port = getnv('PORT');
        }

        public function conect(){
            if($this->conn) {
                return $this->conn;
            } else {
                $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname};";

                try{
                    $this->conn = new PDO($dsn, $this->username, $this->password);
                    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return $this->conn;
                }
                catch(PDOException $e){
                    echo 'Connection Error: ' . $e->getMessage();
                }
                return $this->conn;
            }
        }
    }
