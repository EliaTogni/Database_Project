<?php
	function dump_quotes($dbconn, $match_id) {
		$result = pg_query($dbconn, "SELECT b.name, q.home, q.away, q.draw
			FROM soccerscheme.quotes AS q JOIN soccerscheme.partner AS p ON q.partner = p.user_id
			JOIN soccerscheme.bookmaker AS b ON p.bookmaker = b.bookmaker_id
			WHERE q.match = $match_id
		");
		return $result;
	}

	function best_home_player($dbconn, $match_id) {
		$result = pg_query($dbconn, "SELECT player.name AS name, statistics.overall_rating AS rating
			FROM (
				SELECT squad.player AS id, MAX(S.attribute_date) AS sdate
				FROM soccerscheme.match JOIN soccerscheme.squad ON squad.match = match.match_id
				JOIN soccerscheme.statistics AS S ON squad.player = S.player
				WHERE match.match_id = $match_id AND squad.team = match.home_team AND match.date >= S.attribute_date
				GROUP BY squad.player
			) closest_date_players
			JOIN soccerscheme.statistics ON id = statistics.player AND sdate = statistics.attribute_date
			JOIN soccerscheme.player ON id = player.player_id
			ORDER BY rating DESC
			LIMIT 1;
		");
		return $result;
	}

	function best_away_player($dbconn, $match_id) {
		$result = pg_query($dbconn, "SELECT player.name AS name, statistics.overall_rating AS rating
			FROM (
				SELECT squad.player AS id, MAX(S.attribute_date) AS sdate
				FROM soccerscheme.match JOIN soccerscheme.squad ON squad.match = match.match_id
				JOIN soccerscheme.statistics AS S ON squad.player = S.player
				WHERE match.match_id = $match_id AND squad.team = match.away_team AND match.date >= S.attribute_date
				GROUP BY squad.player
			) closest_date_players
			JOIN soccerscheme.statistics ON id = statistics.player AND sdate = statistics.attribute_date
			JOIN soccerscheme.player ON id = player.player_id
			ORDER BY rating DESC
			LIMIT 1;
		");
		return $result;
	}

	function squad_home_team($dbconn, $match_id, $home_team) {
		$result = pg_query($dbconn, "SELECT player.name AS name,
			st.overall_rating AS rating,
			st.potential,
			st.preferred_foot,
			st.attacking_work_rate,
			st.defensive_work_rate,
			st.crossing,
			st.finishing,
			st.heading_accuracy,
			st.short_passing,
			st.volleys,
			st.dribbling,
			st.curve,
			st.free_kick_accuracy,
			st.long_passing,
			st.ball_control,
			st.acceleration,
			st.sprint_speed,
			st.agility,
			st.reactions,
			st.balance,
			st.shot_power,
			st.jumping,
			st.stamina,
			st.strength,
			st.long_shots,
			st.aggression,
			st.interceptions,
			st.positioning,
			st.vision,
			st.penalties,
			st.marking,
			st.standing_tackle,
			st.sliding_tackle,
			st.gk_diving,
			st.gk_handling,
			st.gk_kicking,
			st.gk_positioning,
			st.gk_reflexes
			FROM (
				SELECT squad.player AS id, MAX(S.attribute_date) AS sdate
				FROM soccerscheme.match JOIN soccerscheme.squad ON squad.match = match.match_id
				JOIN soccerscheme.statistics AS S ON squad.player = S.player
				WHERE match.match_id = $match_id AND squad.team = match.home_team AND match.date >= S.attribute_date
				GROUP BY squad.player
			) closest_date_players
			JOIN soccerscheme.statistics AS st ON id = st.player AND sdate = st.attribute_date
			JOIN soccerscheme.player ON id = player.player_id
			ORDER BY rating DESC
		");
		return $result;
	}


	function squad_away_team($dbconn, $match_id, $away_team) {
		$result = pg_query($dbconn, "SELECT player.name AS name,
			st.overall_rating AS rating,
			st.potential,
			st.preferred_foot,
			st.attacking_work_rate,
			st.defensive_work_rate,
			st.crossing,
			st.finishing,
			st.heading_accuracy,
			st.short_passing,
			st.volleys,
			st.dribbling,
			st.curve,
			st.free_kick_accuracy,
			st.long_passing,
			st.ball_control,
			st.acceleration,
			st.sprint_speed,
			st.agility,
			st.reactions,
			st.balance,
			st.shot_power,
			st.jumping,
			st.stamina,
			st.strength,
			st.long_shots,
			st.aggression,
			st.interceptions,
			st.positioning,
			st.vision,
			st.penalties,
			st.marking,
			st.standing_tackle,
			st.sliding_tackle,
			st.gk_diving,
			st.gk_handling,
			st.gk_kicking,
			st.gk_positioning,
			st.gk_reflexes
			FROM (
				SELECT squad.player AS id, MAX(S.attribute_date) AS sdate
				FROM soccerscheme.match JOIN soccerscheme.squad ON squad.match = match.match_id
				JOIN soccerscheme.statistics AS S ON squad.player = S.player
				WHERE match.match_id = $match_id AND squad.team = match.away_team AND match.date >= S.attribute_date
				GROUP BY squad.player
			) closest_date_players
			JOIN soccerscheme.statistics AS st ON id = st.player AND sdate = st.attribute_date
			JOIN soccerscheme.player ON id = player.player_id
			ORDER BY rating DESC
		");
		return $result;
	}
?>
