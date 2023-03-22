<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Tupe:application/json');
    
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();

    $cat = new Category($db);

    $cat->id = isset($_GET['id']) ? $_GET['id']: die();

    
    if($cat->read_single()) {

      echo json_encode(array(
        'id' => $cat->id,
        'category' => $cat->category
      ));
    }
  else {
      echo json_encode(array('message' => 'category_id Not Found'));

  }
