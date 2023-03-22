<?php
 // read all authors
  header('Access-Control-Allow-Origin: *');
  header('Content-Tupe:application/json');
  
  include_once '../../config/Database.php';
  include_once '../../models/Author.php';

  // db connection
  $database = new Database();
  $db = $database->connect();

  $auth = new Author($db); // create author object

  $result = $auth->read(); // read the db

  $num = $result->rowCount(); // create an array of rows

  if ($num > 0)
  {
    $authors_arr = array();
    

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) { // extract author data into object
        extract($row);
        $author_item = array(
            'id' => $id,
            'author' => $author
        );

     array_push($authors_arr, $author_item); // push to new array

    }

    echo json_encode($authors_arr); // send json

  }
  else {
    echo json_encode(
    array('message' => "No Authors Found!")); // message if no authors found
  }