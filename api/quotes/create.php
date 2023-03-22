<?php
    //create quote
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
    include_once '../../models/Author.php';
    include_once '../../models/Category.php';
  
    $database = new Database();
    $db = $database->connect();
    
    $quo = new Quote($db);
    $auth = new Author($db);
    $cat = new Category($db);

    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id))
    {
        echo json_encode(array('message' => 'Missing Required Parameters'));
        exit();

    }
    
        $quo->quote = $data->quote;
        $quo->author_id = $data->author_id;
        $quo->category_id = $data->category_id;

        $auth->id = $data->author_id;
        $cat->id = $data->category_id;
        
    
        $auth->read_single();
        $cat->read_single();

       
        if (!$auth->author) { echo json_encode(array('message' => 'author_id Not Found')); }
        else if (!$cat->category) { echo json_encode(array('message' => 'category_id Not Found'));}
        
      
        else if ($quo->create()){
            echo json_encode(array('id'=> $db->lastInsertId(),'quote'=> $quo->quote, 'author_id'=>$quo->author_id, 'category_id'=>$quo->category_id));
        }
       
        else{
            echo json_encode(array('message' => 'Quote not added'));
        }