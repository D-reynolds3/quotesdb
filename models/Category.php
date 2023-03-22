<?php 
    class Author {
        private $conn;
        private $table = 'categories';

        //properties
        public $id;
        public $category;

        //connection 
        public function __construct($db){
            $this->conn = $db;
        }

        //get posts
        public function read(){
            //query
            $query = "SELECT id, category, 
                    FROM '.$this->table.' 
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
            $query = "SELECT id, category 
                    FROM '.$this->table.' 
                    WHERE id = :id
                    LIMIT 1 OFFSET 0";

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
                $this->row['category'];
                return true;
            }
            else {
                return false;
            }
        }

        //create a new author 
        public function create(){
            //create query
            $query = "INSERT INTO '.$this->table.' (category) 
                    VALUES(:category)";

            //perpare
            $stmt = $this->conn->prepare($query);

            //clean
            $this->author = htmlspecialchars(strip_tags($this->category));

            //bind
            $stmt->bindParam(':author', $this->category);

            if($stmt->execute()){
                return true;
            } else {
                printf("Error: %s. \n", $stmt->error);
                return false;
            }
        }

        public function update(){
            //create query
            $query = "UPDATE '.$this->table.' 
                    SET category = :category 
                    WHERE id = :id";
                    
            
            //prepare clean and bind
            $stmt = $this->conn->prepare($query);
            $this->author = htmlspecialchars(strip_tags($this->category));
            $this->id = htmlspecialchars(strip_tags($this->id));
            $stmt->bindParam(':category', $this->category);
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
            $query = "DELETE FROM  '.$this->table.' 
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