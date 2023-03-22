<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
    include_once '../../models/Author.php';
    include_once '../../models/Category.php';
  
    $database = new Database();
    $db = $database->connect();
    $quo = new Quote($db);

    $data = json_decode(file_get_contents("php://input"));
    
    if (!isset($data->id) || !isset($data->quote) || !isset($data->author_id) || !isset($data->category_id))
    {
        echo json_encode(array('message' => 'Missing Required Parameters'));
        exit();

    }
    $quo->id = $data->id;
    $quo->quote = $data->quote;
    $quo->author_id = $data->author_id;
    $quo->category_id = $data->category_id;

    $auth = new Author($db);
    $cat = new Category($db);
    $auth->id = $quo->author_id;
    $cat->id = $quo->category_id;
    
    $auth->read_single();
    if (!$auth->author) {
        echo json_encode(array('message' => 'author id Not Found'));
        exit();
    }
    
    $cat->read_single();
    if (!$cat->category) {
        echo json_encode(array('message' => 'category id Not Found'));
        exit();
    }

    if ($quo->update()){
        echo json_encode(array('id'=>$quo->id,'quote'=>$quo->quote,'author_id'=>$quo->author_id,'category_id'=>$quo->category_id));
    }
    else{
       echo json_encode(array('message' => 'No Quotes Found'));
    }