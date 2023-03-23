<?php
    //delete for category
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';
  
    
    $database = new Database();
    $db = $database->connect();
  
    $cat = new Category($db);

    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->id)){
        echo(json_encode(array('message' => 'Missing Required Parameters')));
    }
    else
    {
        $cat->id = $data->id;
        $cat->delete();
        echo(json_encode(array('id'=>$cat->id)));
    }