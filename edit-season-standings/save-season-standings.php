<?php ob_start(); ?>
<!-- Stuff all of the HTML into buffer to run our PHP code -->
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Save season standings</title>
	</head>
	<body>
		<?php
			// Getting the values for our variables from the form using POST method
			$team_id = $_POST['team_id'];
			$games_played = $_POST['games_played'];
			$wins = $_POST['wins'];
			$draws = $_POST['draws'];
			$losses = $_POST['losses'];
			$points = $_POST['points'];
			$email = $_POST['email'];
			$complete = true;

			// Verifying the input, checking whether the value is empty or it is not numeric
			if ($team_id === "0")
			{
				echo 'Team name is required<br />';
				$complete = false;
			}
			if (empty($games_played) || !is_numeric($games_played))
			{
				echo 'Number of games played is required<br />';
				$complete = false;
			}

			if (empty($wins) || !is_numeric($wins))
			{
				echo 'Number of wins is required<br />';
				$complete = false;
			}

			if (empty($draws) || !is_numeric($draws))
			{
				echo 'Number of draws is required<br />';
				$complete = false;
			}

			if (empty($losses) || !is_numeric($losses))
			{
				echo 'Number of losses is required<br />';
				$complete = false;
			}

			if (empty($points) || !is_numeric($points))
			{
				echo 'Number of points is required<br />';
				$complete = false;
			}

			if ($complete)
			{
			/*
			 * I've decided to use two different variable names for my queries,
			 * not much sense in this project, but may be useful
			 * if I want to manipulate a query somehow or debug it
			 */
				try
				{
					require_once('../db.php');
					$sql_1 = "UPDATE premier_league SET games_played = :games_played, wins = :wins,"
						. " draws = :draws, losses = :losses, points = :points WHERE team_id = :team_id";
					$cmd = $conn -> prepare($sql_1);
					$cmd -> bindParam(':games_played', $games_played, PDO::PARAM_INT);
					$cmd -> bindParam(':wins', $wins, PDO::PARAM_INT);
					$cmd -> bindParam(':draws', $draws, PDO::PARAM_INT);
					$cmd -> bindParam(':losses', $losses, PDO::PARAM_INT);
					$cmd -> bindParam(':points', $points, PDO::PARAM_INT);
					$cmd -> bindParam(':team_id', $team_id, PDO::PARAM_INT);
					$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$cmd -> execute();
					/* 
					 * The next query takes a team name to inform a user of a successful stats change
					 */
					
					$sql_2 = "SELECT team FROM premier_league WHERE team_id = :team_id";
					$cmd = $conn -> prepare($sql_2);
					$cmd -> bindParam(':team_id', $team_id, PDO::PARAM_INT); // do i have to bind it twice?
					$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$cmd -> execute();
					$result = $cmd -> fetchAll();
					
					foreach($result as $row)
					{
						$team = $row['team'];
					}
					$conn = null;
					/*
					* Sending an email to the user.
					* Here I use the \n newline escape sequence.
					* I had to querry the database one more time to get the name of the team which record was changed,
					* I don't think its possible to get the name from the OPTION tag value, 
					* since it contains the team_id(primary key) and sends it to the SELECT tag when a user hits SUBMIT
					*/
					mail($email, 'Successful change of ' . $team . ' record', "Hooray!\nYou did it!");
					// redirecting to the main page
					header('location:../index.php');
				} 
				catch (Exception $ex) 
				{
					mail('alex.andriishyn@icloud.com', 'From: soccer team roster', 'An error occured:\n' . $ex );
					header('location:../error.php');
				}
			}
		?>
	</body>
</html>
<!-- Here we flush everything from the buffer -->
<?php ob_flush(); ?>