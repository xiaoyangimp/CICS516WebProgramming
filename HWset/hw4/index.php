<?php include("top.html"); ?>

<h1>The One Degree of Kevin Bacon</h1>
<p>Type in an actor's name to see if he/she was ever in a movie with Kevin Bacon!</p>
<p><img src="kevin_bacon.jpg" alt="Kevin Bacon" /></p>

<form action="add-film.php" method="get">
	<fieldset>
		<legend>Add new films</legend>
		<div>
			<input type="submit" value="go" />
		</div>
	</fieldset>
</form>
				
<?php include("bottom.html"); ?>
