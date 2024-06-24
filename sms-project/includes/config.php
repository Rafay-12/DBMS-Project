<?php

  $db_conn = mysqli_connect('localhost', 'root', '','project');

  if (!$db_conn) {
    echo 'Connection Failed';
    exit;
  }
  session_start();
  if (isset($_SESSION['std_id'])) {
    // Retrieve $std_id from the session
    $std_id = $_SESSION['std_id'];
  }
  // if(empty($_SESSION) || !isset($_SESSION['login']))
  // {
  //   session_start();
  // }
  date_default_timezone_set('Asia/Karachi');
  include('functions.php');
?>
