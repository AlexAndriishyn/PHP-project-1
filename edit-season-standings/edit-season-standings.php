<?php 
	$title = 'Edit season standings';
	require_once('../header.php'); 
?>
<form method="post" action="save-season-standings.php">
	<fieldset>
		<legend>Barclays Premier League</legend>
		<div class="row">
			<label for="team">Select team</label>
			<select id="team" name="team_id">
				<option value="0">Please select...</option>
				<?php
					try
					{
						require_once('../db.php');
						$sql = "SELECT team_id, team FROM premier_league ORDER BY 2 ASC";
						$result = $conn->query($sql);
						foreach($result as $row)
						{
							/* 
							 * Here we assign a value of the team_id column taken from the mysql table 
							 * to the value attribute of the option tag which, upon selection, will transfer
							 * the value to the SELECT tag.
							 */
							echo '<option value="' . $row['team_id'] . '">' . $row['team'] . '</option>';
						}
						$conn = null;
					} catch (Exception $ex) {
						mail('alex.andriishyn@icloud.com', 'From: soccer team roster', 'An error occured:\n' . $ex );
						header('location:../error.php');
					}
				?>
			</select>
		</div>
		<div class="row">
			<label for="games_played">Games played: </label>
			<input id="games_played" name="games_played" type="text" />
		</div>
			<div class="row">
			<label for="wins">Wins: </label>
			<input id="wins" name="wins" type="text" />
		</div>
			<div class="row">
				<label for="draws">Draws: </label>
				<input id="draws" name="draws" type="text" />
		</div>
		<div class="row">
			<label for="losses">Losses: </label>
			<input id="losses" name="losses" type="text" />
		</div>
		<div class="row">
			<label for="points">Points: </label>
			<input id="points" name="points" type="text" />
		</div>
	</fieldset>
	<fieldset>
		<legend>Change request confirmation</legend>
		<div class="row">
			<!-- Here, mail has a required attribute. I like it more this way. -->
			<label for="email">Email: </label>
			<input id="email" name="email" type="email" required placeholder="example@mail.com"/>
		</div>
	</fieldset>
	<!-- Here I don't use a hidden value, the team's id comes from the SELECT tag at the top -->
	<div class="submit">
		<input type ="submit" value="Save" />
	</div>
</form>
<?php require_once('../footer.php'); ?>
