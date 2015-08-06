<?php include("top.html"); ?>
<?php include("common.php"); ?>

	<?php 
		if( $_SERVER['REQUEST_METHOD'] == 'GET') {
			$fn = $_GET['firstname'];
			$ln = $_GET['lastname'];

					
			$id = getactorid($fn, $ln, $db); // obtain the id for the actor
			
			/* Search for the movie*/
			$stmt = $db->prepare('select m.name, m.year from actors a join actors a2
			 join roles r join roles r2 join movies m where a.id=:id and a2.first_name
			 = "Kevin" and a2.last_name = "Bacon" and a.id = r.actor_id and r.movie_id
			 = m.id and a2.id = r2.actor_id and r2.movie_id = m.id order by m.year desc');

			$stmt->bindParam(':id', $id);
			$stmt->execute();
			$rows = $stmt->fetchAll();
		}
		
	
	?>	

	<h1>Result for <?php print $fn." ".$ln ?></h1>
	<p>Films with <?php print $fn." ".$ln ?> and Kevin Bacon</p>
	
		<?php			
			if( $id == -1) {
				print "Actor ".$fn." ".$ln." not found.";
	 		}
			else if ( $rows == FALSE) {
				print $fn." ".$ln." wasn't in any film with Kevin Bacon.";
			}
			else {
		?>		
		
				<table>
					
					<tr>
						<th>#</th>
						<th>Title </th>
						<th>Year</th>
					</tr>
					<?php $i = 1;
						foreach ( $rows as $rownum => $row): ?>
						<tr>
							<td> <?php print $i; ?></td>
							<td> <?php print $row['name']; ?></td>
							<td> <?php print $row['year']; ?></td>
					<?php $i++;
						endforeach
					?>
						</tr>
				</table>

		<?php	
			}
		?>


<?php include("bottom.html"); ?>
