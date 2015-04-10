<?php
	/*
	 * We execute this piece of code everytime the user selects a different option
	 * in the SELECT tag. The query selects all columns (except for the [team] column)
	 * based on the primary key[team_id] which equals to whatever our user has selected
	 * in the dropdown menu.  
	 */
	try
	{
		$team_id = $_POST['team_id'];
		require_once('db.php');
		$sql = "SELECT games_played, wins, draws, losses, points FROM premier_league WHERE team_id = :team_id";

		$cmd = $conn->prepare($sql);
		$cmd->bindParam(':team_id', $team_id, PDO::PARAM_INT);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$cmd->execute();
		$result = $cmd->fetchAll();
		foreach($result as $row)
		{
			/* 
			 * If I understood you correctly, json_encode with the query output
			 * echoes itself to the page where makeAjaxRequest function call was made
			 */
			echo json_encode($row); 
		}
			$conn = null;
	} 
	catch (Exception $ex)
	{
		mail('200296533@student.georgianc.on.ca', 'An error occured ...', $ex, 'From: soccer team roster');
		header('location:error.php');
	}
?>