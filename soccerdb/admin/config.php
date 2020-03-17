<?php
	function prepare_queries_attributes($dbconn) {
		pg_prepare(
			$dbconn,
			'Stats_insert',
			'INSERT INTO soccerscheme.statistics VALUES (
				$1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12,
				$13, $14, $15, $16, $17, $18, $19, $20, $21, $22, $23,
				$24, $25, $26, $27, $28, $29, $30, $31, $32, $33, $34,
				$35, $36, $37, $38, $39, $40
			);'
		);
	}

	function valid_values($value, $accepted) {
		if (in_array($value, $accepted)) {
	  	return $value;
	  }
	  return NULL;
	}

	function stats_read_row($row){
		$stats = array(
	  	"player"                => empty($row[0])? NULL : $row[0],
	    "attribute_date"        => empty($row[1])? NULL : $row[1],
	    "overall_rating"        => empty($row[2])? NULL : $row[2],
	    "potential"             => empty($row[3])? NULL : $row[3],
	    "preferred_foot"        => empty($row[4])? NULL : $row[4],
	    "attacking_work_rate"   => empty($row[5])? NULL : $row[5],
	    "defensive_work_rate"   => empty($row[6])? NULL : $row[6],
	    "crossing"              => empty($row[7])? NULL : $row[7],
	    "finishing"             => empty($row[8])? NULL : $row[8],
	    "heading_accuracy"      => empty($row[9])? NULL : $row[9],
	    "short_passing"         => empty($row[10])? NULL : $row[10],
	    "volleys"               => empty($row[11])? NULL : $row[11],
	    "dribbling"             => empty($row[12])? NULL : $row[12],
	    "curve"                 => empty($row[13])? NULL : $row[13],
	    "free_kick_accuracy"    => empty($row[14])? NULL : $row[14],
	    "long_passing"          => empty($row[15])? NULL : $row[15],
	    "ball_control"          => empty($row[16])? NULL : $row[16],
	    "acceleration"          => empty($row[17])? NULL : $row[17],
	    "sprint_speed"          => empty($row[18])? NULL : $row[18],
	    "agility"               => empty($row[19])? NULL : $row[19],
	    "reactions"             => empty($row[20])? NULL : $row[20],
	    "balance"               => empty($row[21])? NULL : $row[21],
	    "shot_power"            => empty($row[22])? NULL : $row[22],
	    "jumping"               => empty($row[23])? NULL : $row[23],
	    "stamina"               => empty($row[24])? NULL : $row[24],
	    "strength"              => empty($row[25])? NULL : $row[25],
	    "long_shots"            => empty($row[26])? NULL : $row[26],
	    "aggression"            => empty($row[27])? NULL : $row[27],
	    "interceptions"         => empty($row[28])? NULL : $row[28],
	    "positioning"           => empty($row[29])? NULL : $row[29],
	    "vision"                => empty($row[30])? NULL : $row[30],
	    "penalties"             => empty($row[31])? NULL : $row[31],
	    "marking"               => empty($row[32])? NULL : $row[32],
	    "standing_tackle"       => empty($row[33])? NULL : $row[33],
	    "sliding_tackle"        => empty($row[34])? NULL : $row[34],
	    "gk_diving"             => empty($row[35])? NULL : $row[35],
	    "gk_handling"           => empty($row[36])? NULL : $row[36],
	    "gk_kicking"            => empty($row[37])? NULL : $row[37],
	    "gk_positioning"        => empty($row[38])? NULL : $row[38],
	    "gk_reflexes"           => empty($row[39])? NULL : $row[39]
		);
	  $lmh = array('low', 'medium', 'high');
	  $stats['attacking_work_rate'] = valid_values($stats['attacking_work_rate'], $lmh);
	  $stats['defensive_work_rate'] = valid_values($stats['defensive_work_rate'], $lmh);
	  $stats['preferred_foot'] = valid_values($stats['preferred_foot'], array('left', 'right'));
	  return $stats;
	}

	function stats_insert($dbconn, $stats){
		pg_execute(
			$dbconn,
			'Stats_insert',
			array($stats['player'],
      	$stats['attribute_date'],
      	$stats['overall_rating'],
        $stats['potential'],
        $stats['preferred_foot'],
        $stats['attacking_work_rate'],
        $stats['defensive_work_rate'],
        $stats['crossing'],
        $stats['finishing'],
        $stats['heading_accuracy'],
        $stats['short_passing'],
        $stats['volleys'],
        $stats['dribbling'],
        $stats['curve'],
        $stats['free_kick_accuracy'],
        $stats['long_passing'],
        $stats['ball_control'],
        $stats['acceleration'],
        $stats['sprint_speed'],
        $stats['agility'],
        $stats['reactions'],
        $stats['balance'],
        $stats['shot_power'],
        $stats['jumping'],
        $stats['stamina'],
        $stats['strength'],
        $stats['long_shots'],
        $stats['aggression'],
        $stats['interceptions'],
        $stats['positioning'],
        $stats['vision'],
        $stats['penalties'],
        $stats['marking'],
        $stats['standing_tackle'],
        $stats['sliding_tackle'],
        $stats['gk_diving'],
        $stats['gk_handling'],
        $stats['gk_kicking'],
        $stats['gk_positioning'],
        $stats['gk_reflexes']
			)
		);
    return true;
	}

	function prepare_queries_bet($dbconn) {
		/* PREPARAZIONE QUERY BOOKMAKER */
		pg_prepare($dbconn,
			'Book_insert',
			'INSERT INTO soccerscheme.bookmaker VALUES (DEFAULT, $1);'
		);
		pg_prepare($dbconn,
			'Book_verify',
			'SELECT bookmaker_id FROM soccerscheme.bookmaker WHERE $1 = name'
		);
		/* PREPARAZIONE QUERY PARTNER */
		pg_prepare($dbconn,
			'Partner_insert',
			'INSERT INTO soccerscheme.partner VALUES (DEFAULT, $1, $2, $3);'
		);
		pg_prepare($dbconn,
			'Partner_verify',
			'SELECT user_id FROM soccerscheme.partner WHERE name = $1'
		);
		/* PREPARAZIONE QUERY QUOTES */
		pg_prepare($dbconn,
			'Quotes_insert',
			'INSERT INTO soccerscheme.quotes VALUES ($1, $3, $2, $4, $5);'
		);
	}

	function betp_read_row($row, $from) {
		$string = substr($row[$from], 0, -1);
		$betp = array(
			"name"	=> empty($string)? NULL : $string
		);
		return $betp;
	}

	function betp_insert($dbconn, $betp) {
		$result = pg_execute($dbconn,
			'Book_verify',
			array($betp['name'])
		);
		if (pg_num_rows($result) == 0) {
			pg_execute($dbconn,
				'Book_insert',
				array($betp['name'])
			);
			$bookmaker_id = pg_execute($dbconn,
				'Book_verify',
				array($betp['name'])
			);
			$id = pg_fetch_row($bookmaker_id);
			$name = 'admin';
			$name = $name.$betp['name'];
			pg_execute($dbconn,
				'Partner_insert',
				array($name, password_hash('password', PASSWORD_DEFAULT), $id[0])
			);
			return $name;
		}
		return 'admin'.$betp['name'];
	}

	function quote_read_row($row, $from, $value) {
		$quote = array(
			"home"		=> empty($row[$from])? NULL : $row[$from],
			"away"		=> empty($row[$from+1])? NULL : $row[$from+1],
			"draw"		=> empty($row[$from+2])? NULL : $row[$from+2],
			"match"		=> empty($row[0])? NULL : $row[0],
			"partner"	=> isset($value)? $value : NULL
		);
		return $quote;
	}

	function quote_insert($dbconn, $quote) {
		$cont = 0;
		if ($quote['home'] == NULL) {
			$cont++;
		}
		if ($quote['away'] == NULL) {
			$cont++;
		}
		if ($quote['draw'] == NULL) {
			$cont++;
		}
		if ($cont > 2 || $cont == 0) {
			pg_execute($dbconn,
				'Quotes_insert',
				array(
					$quote['home'],
					$quote['away'],
					$quote['draw'],
					$quote['match'],
					$quote['partner']
				)
			);
		}
		return true;
	}

	$OFFSET_PLAYERS = 14;
	$P_ATTRIBUTES = 5;

	function prepare_queries_match($dbconn) {
		/* PREPARAZIONE QUERY LEAGUE */
		pg_prepare($dbconn,
			'League_insert',
			'INSERT INTO soccerscheme.league VALUES ($1, $2);'
		);
		/* PREPARAZIONE QUERY TEAM */
		pg_prepare($dbconn,
			'Team_insert',
			'INSERT INTO soccerscheme.team VALUES ($1, $2, $3);'
		);
		/* PREPARAZIONE QUERY PLAYER */
		pg_prepare($dbconn,
			'Player_insert',
			'INSERT INTO soccerscheme.player VALUES ($1, $2, $3, $4, $5);'
		);
		/* PREPARAZIONE QUERY MATCH */
		pg_prepare($dbconn,
			'Match_insert',
			'INSERT INTO soccerscheme.match VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10);'
		);
		/* PREPARAZIONE QUERY SQUAD */
		pg_prepare($dbconn,
			'Squad_insert',
			'INSERT INTO soccerscheme.squad VALUES ($1, $2, $3);'
		);
	}

	function league_read_row($row) {
		$league = array(
			"league_name"	=> empty($row[2])? NULL : $row[2],
			"country"     => empty($row[1])? NULL : $row[1]
		);
		return $league;
	}

	function league_insert($dbconn, $league) {
		pg_execute($dbconn,
			'League_insert',
			array($league['league_name'], $league['country'])
		);
		return true;
	}

	function team_read_row($row, $from, $type) {
		$team = array(
			"team_id"			=> empty($row[$type])? NULL : $row[$type],
			"long_name"		=> empty($row[$from])? NULL : $row[$from],
			"short_name"	=> empty($row[$from+1])? NULL : $row[$from+1]
		);
		return $team;
	}

	function team_insert($dbconn, $team) {
		pg_execute($dbconn,
			'Team_insert',
			array($team['team_id'], $team['long_name'], $team['short_name'])
		);
		return true;
	}


	function player_read_row($row, $from) {
		if (empty($row[$from])) {
			return NULL;
		}
		$player = array(
			"player_id"	=> $row[$from],
			"name"			=> empty($row[$from+1])? NULL : $row[$from+1],
			"birthday"	=> empty($row[$from+2])? NULL : $row[$from+2],
			"height"		=> empty($row[$from+3])? NULL : $row[$from+3],
			"weight"		=> empty($row[$from+4])? NULL : $row[$from+4]
		);
		return $player;
	}

	function player_insert($dbconn, $player) {
		pg_execute($dbconn,
			'Player_insert',
			array(
				$player['player_id'],
				$player['name'],
				$player['birthday'],
				$player['height'],
				$player['weight']
			)
		);
		return true;
	}


	function match_read_row($row) {
		$match = array(
			"match_id"		=> empty($row[0])? NULL : $row[0],
			"season"			=> empty($row[3])? NULL : $row[3],
			"stage"				=> empty($row[4])? NULL : $row[4],
			"home_goals"	=> isset($row[12])? $row[12] : NULL,
			"away_goals"	=> isset($row[13])? $row[13] : NULL,
			"home_team"		=> empty($row[6])? NULL : $row[6],
			"away_team"		=> empty($row[9])? NULL : $row[9],
			"league"			=> empty($row[2])? NULL : $row[2],
			"operator"		=> 1,
			"date"				=> empty($row[5])? NULL : $row[5]
		);
		return $match;
	}

	function match_insert($dbconn, $match) {
		$result = pg_execute($dbconn,
			'Match_insert',
			array(
				$match['match_id'],
				$match['season'],
				$match['stage'],
				$match['home_goals'],
				$match['away_goals'],
				$match['home_team'],
				$match['away_team'],
				$match['league'],
				$match['operator'],
				$match['date']
			)
		);
		echo pg_result_error($result);
		echo pg_last_error($dbconn);
		return true;
	}

	function squad_read_row($row, $type, $player) {
		$squad = array(
			"team"		=> $row[$type],
			"player"	=> $player['player_id'],
			"match"		=> $row[0]
		);
		return $squad;
	}

	function squad_insert($dbconn, $squad) {
		pg_execute($dbconn,
			'Squad_insert',
			array($squad['team'], $squad['player'], $squad['match'])
		);
		return true;
	}

	function champ_insert_nocsv($dbconn, $name, $country) {
		pg_prepare($dbconn, 'Champ_insert_nocsv', 'INSERT INTO soccerscheme.league VALUES($1, $2);');
		$result = pg_execute($dbconn, 'Champ_insert_nocsv', array($name, $country));
		return $result;
	}

	function champ_remove_nocsv($dbconn, $name) {
		pg_prepare($dbconn, 'Champ_remove_nocsv', 'DELETE FROM soccerscheme.league WHERE league_name = $1');
		$result = pg_execute($dbconn, 'Champ_remove_nocsv', array($name));
		return $result;
	}

	function champ_update_nocsv($dbconn, $name, $country, $update) {
		pg_prepare($dbconn, 'Champ_update_nocsv', 'UPDATE soccerscheme.league SET league_name = $1, country = $2 WHERE league_name = $3');
		$result = pg_execute($dbconn, 'Champ_update_nocsv', array($name, $country, $update));
		return $result;
	}

	function team_insert_nocsv($dbconn, $team_id, $team_long_name, $team_short_name) {
		pg_prepare($dbconn, 'Team_insert_nocsv', 'INSERT INTO soccerscheme.team VALUES($1, $2, $3);');
		$result = pg_execute($dbconn, 'Team_insert_nocsv', array($team_id, $team_long_name, $team_short_name));
		return $result;
	}

	function team_remove_nocsv($dbconn, $team_id) {
		pg_prepare($dbconn, 'Team_remove_nocsv', 'DELETE FROM soccerscheme.team WHERE team_id = $1');
		$result = pg_execute($dbconn, 'Team_remove_nocsv', array($team_id));
		return $result;
	}

	function team_update_nocsv($dbconn, $team_id, $team_long_name, $team_short_name, $update) {
		pg_prepare($dbconn, 'Team_update_nocsv', 'UPDATE soccerscheme.team SET team_id = $1, long_name = $2, short_name = $3 WHERE team_id = $4');
		$result = pg_execute($dbconn, 'Team_update_nocsv', array($team_id, $team_long_name, $team_short_name, $update));
		return $result;
	}

	function player_insert_nocsv($dbconn, $player_id, $player_name, $player_birthday, $player_height, $player_weight) {
		pg_prepare($dbconn, 'Player_insert_nocsv', 'INSERT INTO soccerscheme.player VALUES($1, $2, $3, $4, $5);');
		$result = pg_execute($dbconn, 'Player_insert_nocsv', array($player_id, $player_name, $player_birthday, $player_height, $player_weight));
		return $result;
	}

	function player_remove_nocsv($dbconn, $player_id) {
		pg_prepare($dbconn, 'Player_remove_nocsv', 'DELETE FROM soccerscheme.player WHERE player_id = $1');
		$result = pg_execute($dbconn, 'Player_remove_nocsv', array($player_id));
		return $result;
	}

	function player_update_nocsv($dbconn, $player_id, $player_name, $player_birthday, $player_height, $player_weight, $update) {
		pg_prepare($dbconn, 'Player_update_nocsv', 'UPDATE soccerscheme.player SET player_id = $1, name = $2, birthday = $3, height = $4, weight = $5 WHERE player_id = $6');
		$result = pg_execute($dbconn, 'Player_update_nocsv', array($player_id, $player_name, $player_birthday, $player_height, $player_weight, $update));
		return $result;
	}

	function attributes_insert_nocsv($dbconn,
		$player, $attribute_date, $overall_rating, $potential, $preferred_foot, $attacking_work_rate,
		$defensive_work_rate, $crossing, $finishing, $heading_accuracy, $short_passing, $volleys,
		$dribbling, $curve, $free_kick_accuracy, $long_passing, $ball_control, $acceleration, $sprint_speed,
		$agility, $reactions, $balance, $shot_power, $jumping, $stamina, $strength, $long_shots,
		$aggression, $interceptions, $positioning, $vision, $penalties, $marking, $standing_tackle,
		$sliding_tackle, $gk_diving, $gk_handling, $gk_kicking, $gk_positioning, $gk_reflexes) {
		pg_prepare(
			$dbconn,
			'Attributes_insert_nocsv',
			'INSERT INTO soccerscheme.statistics VALUES (
				$1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12,
				$13, $14, $15, $16, $17, $18, $19, $20, $21, $22, $23,
				$24, $25, $26, $27, $28, $29, $30, $31, $32, $33, $34,
				$35, $36, $37, $38, $39, $40
			);'
		);
		$result = pg_execute($dbconn, 'Attributes_insert_nocsv', array(
			$player, $attribute_date, $overall_rating, $potential, $preferred_foot, $attacking_work_rate,
			$defensive_work_rate, $crossing, $finishing, $heading_accuracy, $short_passing, $volleys,
			$dribbling, $curve, $free_kick_accuracy, $long_passing, $ball_control, $acceleration, $sprint_speed,
			$agility, $reactions, $balance, $shot_power, $jumping, $stamina, $strength, $long_shots,
			$aggression, $interceptions, $positioning, $vision, $penalties, $marking, $standing_tackle,
			$sliding_tackle, $gk_diving, $gk_handling, $gk_kicking, $gk_positioning, $gk_reflexes));
		return $result;
	}

	function attributes_remove_nocsv($dbconn) {
		pg_prepare($dbconn, 'Attributes_remove_nocsv', 'DELETE FROM soccerscheme.statistics WHERE player = $1 AND attribute_date = $2');
		$result = pg_execute($dbconn, 'Attributes_remove_nocsv', array($player, $attribute_date));
		return $result;
	}

	function attributes_update_nocsv($dbconn, $player, $attribute_date, $overall_rating, $potential, $preferred_foot, $attacking_work_rate,
			$defensive_work_rate, $crossing, $finishing, $heading_accuracy, $short_passing, $volleys,
			$dribbling, $curve, $free_kick_accuracy, $long_passing, $ball_control, $acceleration, $sprint_speed,
			$agility, $reactions, $balance, $shot_power, $jumping, $stamina, $strength, $long_shots,
			$aggression, $interceptions, $positioning, $vision, $penalties, $marking, $standing_tackle,
			$sliding_tackle, $gk_diving, $gk_handling, $gk_kicking, $gk_positioning, $gk_reflexes, $update) {
		pg_prepare($dbconn, 'Attributes_update_nocsv', 'UPDATE soccerscheme.statistics SET player = $1, attribute_date = $2, overall_rating = $3, potential = $4, preferred_foot = $5, attacking_work_rate = $6,
			defensive_work_rate = $7, crossing = $8, finishing = $9, heading_accuracy = $10, short_passing = $11, volleys = $12,
			dribbling = $13, curve = $14, free_kick_accuracy = $15, long_passing = $16, ball_control = $17, acceleration = $18, sprint_speed = $19,
			agility = $19, reactions = $20, balance = $21, shot_power = $22, jumping = $23, stamina = $24, strength = $25, long_shots = $26,
			aggression = $27, interceptions = $28, positioning = $29, vision = $30, penalties = $31, marking = $32, standing_tackle = $33,
			sliding_tackle = $34, gk_diving = $35, gk_handling = $36, gk_kicking = $37, gk_positioning = $38, gk_reflexes = $39 WHERE player = $40');
		$result = pg_execute($dbconn, 'Attributes_update_nocsv', array($player, $attribute_date, $overall_rating, $potential, $preferred_foot, $attacking_work_rate,
				$defensive_work_rate, $crossing, $finishing, $heading_accuracy, $short_passing, $volleys,
				$dribbling, $curve, $free_kick_accuracy, $long_passing, $ball_control, $acceleration, $sprint_speed,
				$agility, $reactions, $balance, $shot_power, $jumping, $stamina, $strength, $long_shots,
				$aggression, $interceptions, $positioning, $vision, $penalties, $marking, $standing_tackle,
				$sliding_tackle, $gk_diving, $gk_handling, $gk_kicking, $gk_positioning, $gk_reflexes, $update));
		return $result;
	}

	function book_insert_nocsv($dbconn, $book) {
		pg_prepare($dbconn, 'Book_insert_nocsv', 'INSERT INTO soccerscheme.bookmaker VALUES(DEFAULT, $1);');
		$result = pg_execute($dbconn, 'Book_insert_nocsv', array($book));
		return $result;
	}

	function book_remove_nocsv($dbconn, $book) {
		pg_prepare($dbconn, 'Book_remove_nocsv', 'DELETE FROM soccerscheme.bookmaker WHERE name = $1');
		$result = pg_execute($dbconn, 'Book_remove_nocsv', array($book));
		return $result;
	}
?>
