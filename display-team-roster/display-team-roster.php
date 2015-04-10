<?php 
	$title = 'Team roster';
	require_once('../header.php');

	/* Based on a link(team name) our user has followed, we grab team_id
	 * from the URL using the GET method
	 */
	if(isSet($_GET['team_id']))
	{
		$team_id = $_GET['team_id'];
		
		try
		{
			require_once('../db.php');
			/*
			* Used primary - foreign key relationship and NATURAL JOIN to query,
			* NATURAL JOIN joins records only if primary-foreign key values are equal.
			* haven't tried this before as well, but seems to be working and that's good.
			*/
			$sql = "SELECT team, firstName, lastName FROM players NATURAL JOIN premier_league WHERE team_id = '$team_id'";
			$cmd = $conn -> prepare($sql);
			$cmd -> bindParam(':team_id', $team_id, PDO::PARAM_INT);
			$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$cmd -> execute();
			$result = $cmd -> fetchAll();
			
			/* Creating a table for players */
			echo '<h2 id="teamName"></h2>';
			echo '<div class="tablewrapper"><table><tr><th>First Name</th><th>Last Name</th></tr>';
			foreach($result as $row)
			{
				echo '<tr>'
						. '<td>' . $row['firstName'] . '</td>'
						. '<td>' . $row['lastName'] . '</td>'
					. '</tr>';
			}
			$conn = null;
		} catch (Exception $ex) {
			mail('alex.andriishyn@icloud.com', 'From: soccer team roster', 'An error occured:\n' . $ex );
			header('location:../error.php');
		}
	}
	echo '</table></div>';
	require_once('../footer.php'); 
?>


