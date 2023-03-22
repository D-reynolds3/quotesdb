<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';
  
    $database = new Database();
    $db = $database->connect();
  
    $cat = new Category($db);
    $data = json_decode(file_get_contents("php://input"));
    
    if(!isset($data->category)){echo json_encode(array('message' => 'Missing Required Parameters'));
    }
    else {
        $cat->category = $data->category;
        $cat->create();
        echo json_encode(array('id'=> $db->lastInsertId(),'category'=>$cat->category));
    }