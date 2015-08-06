<?php include("top.html"); 
	include("commonforadd.php");
	
	
	
	$stmt = $db->prepare('select distinct genre from movies_genres');
	$stmt->execute();
	$rows = $stmt->fetchAll();

	$submission = 1; // flag to indicate whether to submit
	
	$movieid = "";
	
	if( isset($_POST['movieid']) ) {
		$movieid = $_POST['movieid'];
		
		if( ! preg_match("/^\d+$/",$movieid)){ //Validate ID
		$submission = 0
			?>
				<p class="alert"><?php print "Movie ID is not valid!"?> </p>
		<?php
		}
	}
		
	
	if( $_SERVER['REQUEST_METHOD'] == 'POST'  ) {
		
		if( isset($_POST["moviehandin"])) {
		
			$moviename = $_POST['moviename'];
			$movieyear = $_POST['movieyear'];
		
			$stmt = $db->prepare('select * from movies where id = :mi');
			$stmt->bindParam(':mi', $movieid);
			$stmt->execute();
			$movieexist = $stmt->fetchAll();
		
			if( count($movieexist) != 0) { //Check whether the movie id exists
			$submission = 0
			?>
				<p class="alert"><?php print "Movie ID exist!"?> </p>
			<?php
			}
			
			if( strlen($moviename) > 100) { //Check the length of the moviename
			$submission = 0
			?>
				<p class="alert"><?php print "Movie Name Too Long!"?> </p>
			<?php
			}
			
			if( ! preg_match("/^\d+$/",$movieyear) || $movieyear > 2015){ //Validate movie year
			$submission = 0
			?>
				<p class="alert"><?php print "Year is not valid!"?> </p>
			<?php
			}
			
			
			if( $submission== 1) {
				$stmt = $db->prepare('insert into movies values ( :mi ,  :mn, :yr, null)');
				$stmt->bindParam(':mi', $movieid);
				$stmt->bindParam(':mn', $moviename);
				$stmt->bindParam(':yr', $movieyear);
				$stmt->execute();
				
				?>
				<p> Movie <?php print $movieid."-".$moviename ?> inserted successfully <p>
				<?php
			}
		}
		
		if( isset($_POST["actorhandin"])) { // confirm actor is in the database
			
			$stmt = $db->prepare('select * from movies where id = :mi');
			$stmt->bindParam(':mi', $movieid);
			$stmt->execute();
			$movieexist = $stmt->fetchAll();
		
			if( count($movieexist) == 0) { //Check whether the movie id exists
			$submission = 0
			?>
				<p class="alert"><?php print "Movie ID ".$movieid." doesn't exist!"?> </p>
			<?php
			}
		
			$fn = $_POST['afirstname'];
			$ln = $_POST['alastname'];
			$rl = $_POST['rolename'];

			
			$id = getactorid($fn, $ln, $db);
			
			if( $id == -1) {
				?>
				<p class="alert"><?php print "Actor ".$fn." ".$ln." not in the database."?> </p>
				<?php
				$submission = 0;
			}
			
			if( $submission== 1) {
				$stmt = $db->prepare('insert into roles values ( :ai, :mi, :rl)');
				$stmt->bindParam(':ai', $id);
				$stmt->bindParam(':mi', $movieid);
				$stmt->bindParam(':rl', $rl);
				$stmt->execute();
			
			?>
			<p> Actor <?php print $fn." ".$ln ?> inserted successfully <p>
			<?php }
		}
		
		if( isset($_POST["directorhandin"])) {// confirm director is in the database
		
			$stmt = $db->prepare('select * from movies where id = :mi');
			$stmt->bindParam(':mi', $movieid);
			$stmt->execute();
			$movieexist = $stmt->fetchAll();
		
			if( count($movieexist) == 0) { //Check whether the movie id exists
			$submission = 0
			?>
				<p class="alert"><?php print "Movie ID ".$movieid." doesn't exist!"?> </p>
			<?php
			}
		
			$fn = $_POST['dfirstname'];
			$ln = $_POST['dlastname'];
			
			$id = getdirectorid($fn, $ln, $db);
			
			
			if( $id == -1) {
				?>
				<p class="alert"><?php print "Director not in the database."?> </p>
				<?php
				$submission = 0;
			}
			
			if( $submission== 1) {
				$stmt = $db->prepare('insert into movies_directors values ( :di, :mi)');
				$stmt->bindParam(':di', $id);
				$stmt->bindParam(':mi', $movieid);
				$stmt->execute();
			
			?>
			<p> Director <?php print $fn." ".$ln ?> inserted successfully <p>
			<?php }
		}
		
		if( isset($_POST["genrehandin"])) { //  add genre to the database
		
			$stmt = $db->prepare('select * from movies where id = :mi');
			$stmt->bindParam(':mi', $movieid);
			$stmt->execute();
			$movieexist = $stmt->fetchAll();
		
			if( count($movieexist) == 0) { //Check whether the movie id exists
			$submission = 0
			?>
				<p class="alert"><?php print "Movie ID ".$movieid." doesn't exist!"?> </p>
			<?php
			}
		
			$genre = $_POST['moviegenre'];
			
			if($submission == 1) {
				$stmt = $db->prepare('insert into movies_genres values ( :mi, :gn)');
				$stmt->bindParam(':gn', $genre);
				$stmt->bindParam(':mi', $movieid);
				$stmt->execute();
			
				?>
				<p> Genre <?php print $genre." for movie ".$movieid ?> inserted successfully <p>
				<?php
			}
		}

		
		
		
	}

?>

<h1>Please give the detailed information about the film</h1>

	<form method = "post">
		<fieldset>
			<legend>Movie Name</legend>
				<div class="add">
					Movie ID: <input name="movieid" type="text" size="12" <?php if(isset($movieid)) print "value=\"".$movieid."\""?> /> 
				</div>
			
				<div class="add">
					Movie Name: <input name="moviename" type="text" size="20" placeholder="moviename" /> 
				</div>
			
				<div class="add">
					Movie Year: <input name="movieyear" type="text" size="12" placeholder="movieyear" /> 

					<input type="submit" name="moviehandin" value="Submit" />
				</div>
		</fieldset>
	</form>
		
		<form method = "post">
		<fieldset>
			<legend>Actors and roles</legend>
				<div class="add">
					Movie ID: <input name="movieid" type="text" size="12" <?php if(isset($movieid)) print "value=\"".$movieid."\""?> /> 
				</div>
				
				<div class="add">
					First Name: <input name="afirstname" type="text" size="12" placeholder= "firstname" /> 
				</div>
				
				<div class="add">
					Last Name: <input name="alastname" type="text" size="12" placeholder= "lastname" /> 
				</div>
				
				<div class="add">
					Role: <input name="rolename" type="text" size="12" placeholder= "rolename" /> 
					<input type="submit" name="actorhandin" value="Submit" />
				</div>
		</fieldset>
	</form>

	<form method = "post">
		<fieldset>
			<legend>Directors</legend>
				<div class="add">
					Movie ID: <input name="movieid" type="text" size="12" <?php if(isset($movieid)) print "value=\"".$movieid."\""?> /> 
				</div>
				
				<div class="add">
					First Name: <input name="dfirstname" type="text" size="12" placeholder= "firstname" />
				</div>
				
				<div class="add">
					Last Name: <input name="dlastname" type="text" size="12" placeholder= "lastname" /> 
					<input type="submit" name="directorhandin" value="Submit" />
				</div>
		</fieldset>
	</form>

	<form method = "post">
		<fieldset>
			<legend>Directors</legend>
				<div class="add">
					Movie ID: <input name="movieid" type="text" size="12" <?php if(isset($movieid)) print "value=\"".$movieid."\""?> /> 
				</div>
				
				<div class="add">
					Movie Genre: <select name="moviegenre">
					<?php foreach ( $rows as $rownum => $row) { // get all the genres that exist in the database and add to the selection
							 if( $row['genre'] != NULL ) {
					?>
						<option><?php print $row['genre'];?></option>
							 <?php } } ?>
					</select>
					<input type="submit" name="genrehandin" value="Submit" />
				</div>
		</fieldset>
	</form>
	
<hr/>
<?php include("bottom.html"); ?>