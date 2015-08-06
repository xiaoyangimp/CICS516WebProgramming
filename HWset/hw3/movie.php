<?php
	$movie = $_REQUEST["film"]; //obtain the movie filefolder
	$info = file_get_contents("{$movie}/info.txt"); // info is content of info.txt for each movie
	$infoArray = explode("\n", $info); // parse the content that is separated by \n
	$overview = file_get_contents("{$movie}/overview.txt"); // overview is the content of overview.txt for each movie}/overview
	$reviews = glob("{$movie}/review*.txt"); // reviews is the collection of review files
?>

<!DOCTYPE html>
<!--Author: Jiyu Xiao 80625122 CICS 516
	Assignment: to implement movie.php file, which is about the php file that load different element
	according to different film names-->



<html>
	<head>
	
		<meta charset = "UTF-8" />
		
		<title> Rancid Tomatoes </title>
		
		<link rel = "stylesheet" type = "text/css" href = "movie.css" />
		<link rel = "shortcut icon" type = "image/gif" href = "image/rotten.gif" />
		
	</head>

	<body>
		<div class = "title">
			<img src = "image/banner.png" alt = "top banner" />
		</div>
		
		<h1> 
			<?php
				print $infoArray[0] . " (" . $infoArray[1] . ")";
			?> 
		</h1>
		
		<div class = "container">
			<div class = "inner">
				<div class = "leftcenter">
					<div class = "head">
						<div id ="headimage">
							<img src = 
								
								<?php //open different .png file according to the score
									$rate = (int) $infoArray[2];
							
									if( $rate >= 60) print "image/freshbig.png";
									else print "image/rottenbig.png";
								?> 
								
							alt = "critic image" />
						</div>

						<div id = "headtext"> 
							<?php
								print $infoArray[2]. "%";
							?>
						</div>
					</div>
				
					<div class = "col">
					
					
						<?php
							for( $i = 0; $i < (int) ( (count($reviews) + 1) / 2); $i++) {
								$review = file_get_contents($reviews[$i]);
								$reviewelement = explode("\n", $review);
						?>
						<div class = "box">
						
							<div class = "boximg">
								<img src = 
								<?php
									if(strcmp($reviewelement[1], "FRESH") == 0)
										print "image/fresh.gif";
									else
										print "image/rotten.gif"
								?>	
								alt = "com pic 1" />
							</div>
							
							<q><?php
									print "$reviewelement[0]";
								?>
							</q>
								
						</div>
						
						<div class = "critic">
							<div class = "boximg">
								<img src = "image/critic.gif" alt = " critic 1" />
							</div>
							
							<?php
								print "$reviewelement[2]" ;
							?>
							<br />
							<?php
								if( count($reviewelement) > 3) 
									print "$reviewelement[3]";
							?>
						</div>
						
						<?php
							}
						?>

					</div>
				
					<div class = "col">
					
						<?php
							for( $i = (int) ( (count($reviews) + 1) / 2) ; $i < count($reviews); $i++) {
								$review = file_get_contents($reviews[$i]);
								$reviewelement = explode("\n", $review);
						?>
						<div class = "box">
						
							<div class = "boximg">
								<img src = 
								<?php
									if(strcmp($reviewelement[1], "FRESH") == 0)
										print "image/fresh.gif";
									else
										print "image/rotten.gif"
								?>	
								alt = "com pic 1" />
							</div>
							
							<q><?php
									print "$reviewelement[0]";
								?>
							</q>
								
						</div>
						
						<div class = "critic">
							<div class = "boximg">
								<img src = "image/critic.gif" alt = " critic 1" />
							</div>
							
							<?php
								print "$reviewelement[2]" ;
							?>
							<br />
							<?php
								if( count($reviewelement) > 3) 
									print "$reviewelement[3]";
							?>
						</div>
						
						<?php
							}
						?>	
						
					</div>
				</div>
				
				<div class = "rightcenter">
					<div id = "filmimg" > 
						<img src = 
							<?php
								print "{$movie}/overview.png"
							?>
						alt = "intro pic" />
					</div>
					
					<div id = "intro">
						<dl>
						
							<?php 
								$listofinfo = explode("\n", $overview);
							
								foreach( $listofinfo as $todisplay) {
									$colinfo = explode(":", $todisplay, 2); // do not interrupt the hypertext link 
							?>
							<dt> 
								<?php
									print $colinfo[0];
								?>
							</dt>
							
							<dd>
							<?php
									print $colinfo[1];
								?>
							</dd>
							
							<?php }?>
							
						
						</dl>
					</div>
				</div>
				
				<div class = "bottom">
						(1-<?php
							print count($reviews);
						?>) of 
						<?php
							print count($reviews);
						?>
				</div>
			</div>
		</div>
	
		<div id = "floater">
			<div>
				<a href ="http://validator.w3.org/check/referer">
					<img src = "image/w3c-xhtml.png" alt = "Valid HTML5">
				</a>
			</div>
			
			<div>
				<a href = "http://jigsaw.w3.org/css-validator/check/referer?profile=css3">
					<img src = "image/w3c-css.png" alt = "Valid CSS">
				</a>
			</div>
		</div>	
		
	</body>
</html>

