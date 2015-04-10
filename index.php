<?php
	$title = 'Season standings';
	require_once('header.php');
	/* 
	* Creating a header for the table 
	* and sending a query to the database
	*/
	echo '<div class="tablewrapper"><table><tr><th class="table_1st_column">Team</th>'
									. '<th>Games Played</th>'
									. '<th class="column">Wins</th>'
									. '<th class="column">Draws</th>'
									. '<th class="column">Losses</th>'
									. '<th class="column">Points</th>'
								. '</tr>';
	try
	{
		require_once('db.php');
		$sql = "SELECT * FROM premier_league ORDER BY points DESC"; // Ordering by points, seems reasonable for league standings
		$result = $conn -> query($sql);

		foreach($result as $row)
		{
			echo '<tr>'
					. '<td><a href="display-team-roster/display-team-roster.php?team_id=' . $row['team_id'] . '">' . $row['team'] . '</a></td>'
					. '<td>' . $row['games_played'] . '</td>'
					. '<td>' . $row['wins'] . '</td>'
					. '<td>' . $row['draws'] . '</td>'
					. '<td>' . $row['losses'] . '</td>'
					. '<td>' . $row['points'] . '</td>'
				. '</tr>';
		}
		$conn = null;
	} catch (Exception $ex) {
		mail('alex.andriishyn@icloud.com', 'From: soccer team roster', 'An error occured:\n' . $ex );
		header('location:error.php');
	}
	echo '</table></div>';
	require_once('footer.php'); 
?>
