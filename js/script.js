/* Changes the background color of nav links on hover */
$("nav li").hover(
	function()
	{
		$(this).css("background-color", "#554157");
	},
	function() 
	{
		$(this).css("background-color", "#9f9bb9");
	}
);

/* These scripts will execute every time user makes a selection in the drop-down menu */

/*
 * Inserts values taken from the database to the input fields of the form
 */
function insertResults(json) 
{
	$("#games_played").val(json["games_played"]);
	$("#wins").val(json["wins"]);
	$("#draws").val(json["draws"]);
	$("#losses").val(json["losses"]);
	$("#points").val(json["points"]);
}
/*
* Clears the form
*/
function clearForm() 
{
	$("#games_played, #wins, #draws, #losses, #points").val("0");
}

/*
* Makes an AJAX request to process-ajax.php
* The latter fetches the columns from the database based on the [team_id]
* In case of successful SQL query, it calls the inserResults function
* with the json object as an argument; 
*/
function makeAjaxRequest(team_id) 
{
	$.ajax({
		type: "POST",
		data: { team_id: team_id },
		dataType: "json",
		url: "../process-ajax.php",
		success: function(json) 
		{
			insertResults(json);
		}
	});
}

/*
* This script will run whenever a change has been made to the SELECT tag.
* If "Please select..." is chosen, it will call the clearForm function.
* Otherwise it will cal the AJAX request function.
*/
$("#team").on("change", function()
{
	var team_id = $(this).val();

	if(team_id === "0")
	{
		clearForm();
	} 
	else 
	{
		makeAjaxRequest(team_id);
	}
});