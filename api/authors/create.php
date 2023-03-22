<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';
  
    //db connection
    $database = new Database();
    $db = $database->connect();
  
    $auth = new Author($db);

    $data = json_decode(file_get_contents("php://input"));
    
       
    if (!isset($data->author)) { echo json_encode(array('message' => 'Missing Required Parameters')); 
    }

   else {
        $auth->author = $data->author;
        $auth->create();
        echo json_encode(array('id'=> $db->lastInsertId(),'author'=>$auth->author));
    }