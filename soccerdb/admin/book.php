<?php
  session_start();
  if (!isset($_SESSION['username']) || $_SESSION['type'] != 'administrator') {
    header("location: ../index.php?1=accessed");
  }
  require_once('config.php');
  require_once('../conn.php');
  $dbconn = pg_connect($connection_admin) or die($error_string);
  $sub = $_POST['operation'];
  $book = $_POST['book'];
  if($sub == 'Crea') {
    $result = book_insert_nocsv($dbconn, $book);
    header("location: admin.php");
  } else if($sub == 'Elimina') {
    $result = book_remove_nocsv($dbconn, $book);
    header("location: admin.php");
  }
?>
