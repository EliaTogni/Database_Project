<?php
	session_start();
	if (!isset($_SESSION['username']) || $_SESSION['type'] != 'partner') {
		header("location: ../index.php?1=accessed");
	}
	
	function quotes_insert($dbconn, $match_id, $h_quote, $a_quote, $d_quote, $username) {
    $result = pg_query($dbconn, "SELECT user_id FROM soccerscheme.partner WHERE name = '$username'");
    $row = pg_fetch_row($result);
    pg_prepare($dbconn, 'Quotes_insert', "INSERT INTO soccerscheme.quotes VALUES($1, $2, $3, $4, $5);");
    $result = pg_execute($dbconn, 'Quotes_insert', array($h_quote, $a_quote, $d_quote, $match_id, $row[0]));
    return $result;
	}

  function quotes_delete($dbconn, $match_id, $username) {
    $result = pg_query($dbconn, "SELECT user_id FROM soccerscheme.partner WHERE name = '$username'");
    $row = pg_fetch_row($result);
    pg_prepare($dbconn, 'Quotes_delete', "DELETE FROM soccerscheme.quotes WHERE match = $1 AND partner = $2");
    $result = pg_execute($dbconn, 'Quotes_delete', array($match_id, $row[0]));
    return $result;
  }

  function quotes_update($dbconn, $match_id, $h_quote, $a_quote, $d_quote, $username) {
    $result = pg_query($dbconn, "SELECT user_id FROM soccerscheme.partner WHERE name = '$username'");
    $row = pg_fetch_row($result);
    pg_prepare($dbconn, 'Quotes_update', "UPDATE soccerscheme.quotes SET home = $1, away = $2, draw = $3 WHERE match = $4 AND partner = $5");
    $result = pg_execute($dbconn, 'Quotes_update', array($h_quote, $a_quote, $d_quote, $match_id, $row[0]));
    return $result;
  }
?>
