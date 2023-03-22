<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Tupe:application/json');
    
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();
    $cat = new Category($db);
    $result = $cat->read();
    $num = $result->rowCount();

    if ($num > 0)
    {
      $category_arr = array();

      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);
          $cat_item = array(
              'id' => $id,
              'category' => $category
          );

      array_push($category_arr, $cat_item);

      }

      echo json_encode($category_arr);

    }
   
    else {
      echo json_encode(array('message' => "No Categories Found!"));
    }