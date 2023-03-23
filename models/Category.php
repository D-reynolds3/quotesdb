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
            $query = 'SELECT id, category, 
                    FROM '. $this->table .' 
                    ORDER BY id ASC';


            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;

        }

        //read single author 
        public function read_single(){

            $query = 'SELECT id, category 
                    FROM '.$this->table.' 
                    WHERE id = :id
                    LIMIT 1 OFFSET 0';

            
            $stmt = $this->conn->prepare($query);
            $this->id = htmlspecialchars(strip_tags($this->id));
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();

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
            $query = 'INSERT INTO '.$this->table.' (category) 
                    VALUES(:category)';
            $stmt = $this->conn->prepare($query);
            $this->author = htmlspecialchars(strip_tags($this->category));

            $stmt->bindParam(':author', $this->category);

            if($stmt->execute()){
                return true;
            } else {
                printf("Error: %s. \n", $stmt->error);
                return false;
            }
        }

        public function update(){
            $query = 'UPDATE '.$this->table.' 
                    SET category = :category 
                    WHERE id = :id';
                    
        
            $stmt = $this->conn->prepare($query);
            $this->author = htmlspecialchars(strip_tags($this->category));
            $this->id = htmlspecialchars(strip_tags($this->id));
            $stmt->bindParam(':category', $this->category);
            $stmt->bindParam(':id', $this->id);

            
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
            $query = 'DELETE FROM  '.$this->table.' 
                    WHERE id = :id';

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