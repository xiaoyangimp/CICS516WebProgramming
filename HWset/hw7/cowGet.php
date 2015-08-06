<?php include("cow.php"); ?>

<h1> <?=$_SESSION["name"] ?>'s To-Do List </h1>

<?php
	if (!isset($_SESSION)) { 
		session_start(); 
	}


	$fn = "list_".$_SESSION["name"].".json";
	
	if( !file_exists($fn) ) {	//create a file if the user's file does not exist
		$myfile = fopen( $fn, "w");
		$init = array( "item" => array() );
		fwrite($myfile, json_encode($init));
		fclose($myfile);
	}
	
	$str = file_get_contents($fn);
	$json = json_decode($str, true);
	
	if(count($json["item"]) != 0 ) {	// show the elements in json file
	?>
	<ul id="todolist">
	<?php 
	
	$i = 1;
	foreach($json["item"] as $value){
		?>
		
		<li id="item_<?=$i?>" class="level1"><?=$value?></li>
		
		<?php
		$i++;
	}
	
	?>
	</ul>
	<?php 
	}
?>


	<input type="text" id="addtext" />
	<button id="addbutton" >Add to Buttom</button>
	<button id="deletebutton" >Delete Top Item</button>


<ul>
	<li id="logout">Log Out</li>
</ul>