<?php

session_start();

  define('DB_HOST', '');
  define('DB_USER', '');
  define('DB_PASSWORD', '');
  define('DB_DATABASE', '');


  define('SITE_URL', 'http://localhost/aviaoprojeto');

  include_once('DatabaseConnection.php');

  $db = DatabaseConnection::getInstance();


  function base_url($slug){
    echo SITE_URL.$slug;
  }
  
 
  function validateInput($dbcon, $input){
    return mysqli_real_escape_string($dbcon, $input);
  }

  function redirect($message,$page){
    $redirectTo = SITE_URL.$page;
    $_SESSION['message'] = "$message";
    header("Location: $redirectTo");
    exit(0);
  }

?>
