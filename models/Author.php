<?php 
    class Author {
        private $conn;
        private $table = 'authors';

        //properties
        public $id;
        public $author;

        //connection 
        public function __construct($db){
            $this->conn = $db;
        }

        //get posts
        public function read(){
            //query
            $query = "SELECT id, author, 
                    FROM ".$this->table." 
                    ORDER BY id ASC";
        

            //prepare
            $stmt = $this->conn->prepare($query);
            //execute
            $stmt->execute();
            //return
            return $stmt;

        }

        //read single author 
        public function read_single(){
            //create query
            $query = "SELECT id, author 
                    FROM ".$this->table." 
                    WHERE id = :id
                    LIMIT 1 OFFSET 0 ";

            //prepare query
            $stmt = $this->conn->prepare($query);
            //clean data 
            $this->id = htmlspecialchars(strip_tags($this->id));
            //bind
            $stmt->bindParam(':id', $this->id);
            //execute
            $stmt->execute();
            //return

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row){
                $this->id = $row['id'];
                return true;
            }
            else {
                return false;
            }
        }

        //create a new author 
        public function create(){
            //create query
            $query = "INSERT INTO  ".$this->table."  (authors) 
                    VALUES(:author)";

            //perpare
            $stmt = $this->conn->prepare($query);

            //clean
            $this->author = htmlspecialchars(strip_tags($this->author));

            //bind
            $stmt->bindParam(':author', $this->author);

            if($stmt->execute()){
                return true;
            } else {
                printf("Error: %s. \n", $stmt->error);
                return false;
            }
        }

        public function update(){
            //create query
            $query = "UPDATE ".$this->table." (authors)
                     VALUES(:author)";
            
            //prepare clean and bind
            $stmt = $this->conn->prepare($query);
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->id = htmlspecialchars(strip_tags($this->id));
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':id', $this->id);

            //return
            if($stmt->execute()){
                if($stmt->roeCount() == 0){
                    return false;
                }
                else {
                    return true;
                }
            } 
            else {
                printf("Error: %s. \n", $stmt->error);
                return false;
            }


        }

        public function delete(){
            $query = "DELETE FROM  ".$this->table." 
                    WHERE id = :id";

            $stmt = $this->conn->prepare($query);
            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(':id', $this->id);


            if($stmt->execute()){
                return true;
            }
            else {
                printf("Error: %s \n", $stmt->error);
                return false;
            }

                    
        }
    }