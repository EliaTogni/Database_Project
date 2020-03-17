<?php
  session_start();
  if (!isset($_SESSION['username']) || $_SESSION['type'] != 'administrator') {
    header("location: ../index.php?1=accessed");
  }
  require_once('config.php');
  require_once('../conn.php');
  $dbconn = pg_connect($connection_admin) or die($error_string);
  $sub = $_POST['operation'];
  $champ_name = $_POST['champ_name'];
  $champ_country = $_POST['champ_country'];
  if($sub == 'Create') {
    $result = champ_insert_nocsv($dbconn, $champ_name, $champ_country);
    header("location: admin.php");
  } else if($sub == 'Delete') {
    $result = champ_remove_nocsv($dbconn, $champ_name);
    header("location: admin.php");
  } else if($sub == 'Update') {
    $champ_to_update = $_POST['champ_to_update'];
    $result = champ_update_nocsv($dbconn, $champ_name, $champ_country, $champ_to_update);
    header("location: admin.php");
  }
?>
