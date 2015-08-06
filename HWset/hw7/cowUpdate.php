<?php 
	include("cow.php");


	$fn = "list_".$_SESSION["name"].".json";
	$str = file_get_contents($fn);
	$json = json_decode($str, true);
	
	if( strcmp($_POST["type"], "add") == 0 ) {	// add an element into the array
		array_push($json["item"], $_POST["point"] );
	}
	else if ( strcmp($_POST["type"], "del") == 0){	// remove the top one
		if(count($json["item"]) != 0 ) {
			array_shift($json["item"]);
		}
	}
	else if ( strcmp($_POST["type"], "reo") == 0){	// update the reordered array
		$narray = json_decode( stripslashes($_POST["elements"]));
		$json["item"] = $narray;
	}

	
	$fp = fopen($fn, 'w');
	fwrite($fp, json_encode($json));
	fclose($fp);
?>