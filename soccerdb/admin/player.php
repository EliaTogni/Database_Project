<?php
  session_start();
  if (!isset($_SESSION['username']) || $_SESSION['type'] != 'administrator') {
    header("location: ../index.php?1=accessed");
  }
  require_once('config.php');
  require_once('../conn.php');
  $dbconn = pg_connect($connection_admin) or die($error_string);
  $sub = $_POST['operation'];
  $player_id = $_POST['player_id'];
  $player_name = $_POST['player_name'];
  $player_birthday = $_POST['player_birthday'];
  $player_height = $_POST['player_height'];
  $player_weight = $_POST['player_weight'];
  if($sub == 'Crea') {
    $result = player_insert_nocsv($dbconn, $player_id, $player_name, $player_birthday, $player_height, $player_weight);
    header("location: admin.php");
  } else if($sub == 'Elimina'){
    $result = player_remove_nocsv($dbconn, $player_id);
    header("location: admin.php");
  } else if($sub == 'Aggiorna'){
    $player_to_update = $_POST['player_to_update'];
    $result = player_update_nocsv($dbconn, $player_id, $player_name, $player_birthday, $player_height, $player_weight, $player_to_update);
    header("location: admin.php");
  }
?>
