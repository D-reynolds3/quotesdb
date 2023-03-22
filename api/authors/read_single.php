<?php
  // for getting a single author
  header('Access-Control-Allow-Origin: *');
  header('Content-Tupe:application/json');
  
  include_once '../../config/Database.php';
  include_once '../../models/Author.php';

  // create db
  $database = new Database();
  $db = $database->connect();

  $auth = new Author($db);
  
  // make sure id is set or quit
  $auth->id = isset($_GET['id']) ? $_GET['id']: die();

  
  // get auth
  if($auth->read_single()) {

     echo json_encode(array(
       'id' => $auth->id,
        'author' => $auth->author
     ));
    }
  else {
    echo json_encode(array(
      'message' => 'author_id Not Found' // message if author not found
    ));

  }