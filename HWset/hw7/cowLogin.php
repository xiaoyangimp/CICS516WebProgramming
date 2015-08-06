<?php
	include("cow.php");
	$req_res = "0"; // result for the user validation
	
	if( $_SERVER["REQUEST_METHOD"] == "POST" ) {
		$name = $_POST["username"];
		$pwd = $_POST["password"];
		
		
		if( strcmp($name, "testuser") == 0 && strcmp($pwd, "testpass") == 0) {
			

			$_SESSION["name"] = $name;
			
			
			$req_res = "1";
		}
		
		echo json_encode(array('response'=>$req_res)); //return the json result to javascript
	}
	
	else	{
?>

			<p>
				Log in to start manage your daily affairs and enjoy other services!
			</p>

			<div>
				<input type="text" id="username" size="12"/> username <br />
				<input type="password" id="password" size="12"/> password <br />
				<button type="button" id="login">Log In</button> <br />
			</div>
			
			<div id = "warning"></div>	
<?php } ?>