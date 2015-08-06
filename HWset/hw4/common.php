

<?php // PHP Initialization
	ini_set		('display_errors', 1);
	error_reporting	(E_ALL | E_STRICT);
	
	//open the DB
	$dbunix_socket 	= '/ubc/icics/mss/cics516/db/cur/mysql/mysql.sock';
	$dbuser			= 'cics516';
	$dbpass			= 'cics516password';
	$dbname			= 'cics516';
	
	// $dbunix_socket 	= '/ubc/icics/mss/jyxiao/mysql/mysql.sock';
	// $dbuser			= 'anon';
	// $dbpass			= 'anonpass';
	// $dbname			= 'imdb';

	try { // try to connect to the database
		$db = new PDO ("mysql:unix_socket=$dbunix_socket; dbname=$dbname", $dbuser, $dbpass);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		header("HTTP/1.1 500 Server Error");
		die("HTTP/1.1 500 Server Error: Database Unavailable ({$e->getMessage()})");
	}
	
	function getactorid( $fn, $ln, $db ) { // check whether the actors is in the database and return the id, -1 for not found
	
			if(strlen($fn) == 0) return -1; // the firstname should be at least one characters for the wild match
			
			$stmt = $db->prepare('select * from actors where first_name like :fn
			 and last_name=:ln order by film_count desc');

			$tfn = $fn."%";
			$stmt->bindParam(':fn', $tfn);
			$stmt->bindParam(':ln', $ln);
			$stmt->execute();
			$matchactor = $stmt->fetch();
			
			if( $matchactor == FALSE) {
				return -1;
				
	 		}
			
			$id = $matchactor['id'];
			
			return $id;
	}
	
	function getdirectorid( $fn, $ln, $db ) { // check whether the directors is in the database and return the id, -1 for not found
			
		if(strlen($fn) == 0) return -1; // the firstname should be at least one characters for the wild match
			
		$stmt = $db->prepare('select * from directors where first_name like :fn
		 and last_name=:ln');

		$tfn = $fn."%";
		$stmt->bindParam(':fn', $tfn);
		$stmt->bindParam(':ln', $ln);
		$stmt->execute();
		$matchdirector = $stmt->fetch();
			
		if( $matchdirector == FALSE) {
			return -1;
		}
			
		$id = $matchdirector['id'];
			
		return $id;
	}
?>
	
