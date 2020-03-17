<?php
  session_start();
  if (!isset($_SESSION['username']) || $_SESSION['type'] != 'administrator') {
    header("location: ../index.php?1=accessed");
  }
  require_once('config.php');
  require_once('../conn.php');
  $dbconn = pg_connect($connection_admin) or die($error_string);
  $sub = $_POST['operation'];
  $team_long_name = $_POST['team_long_name'];
  $team_short_name = $_POST['team_short_name'];
  $team_id = $_POST['team_id'];
  if($sub == 'Crea') {
    $result = team_insert_nocsv($dbconn, $team_id, $team_long_name, $team_short_name);
    header("location: admin.php");
  } else if($sub == 'Elimina'){
    $result = team_remove_nocsv($dbconn, $team_id);
    header("location: admin.php");
  } else if($sub == 'Aggiorna'){
    $team_to_update = $_POST['team_to_update'];
    $result = team_update_nocsv($dbconn, $team_id, $team_long_name, $team_short_name, $team_to_update);
    header("location: admin.php");
  }
?>
