"use strict";

window.onload = function() {
	readLogin(0);  // call to load the login view
};

/*function that create a ajax updater to the login result, cas as a
parameter to indicate whether to show the warning message*/
function readLogin(cas) {
	new Ajax.Updater('content', 'cowLogin.php', 
	{
		method: 'get',
		onComplete: function(r) {
			$("login").observe("click", AttemptLogin); // add an observe function to login
			if( cas === 1) {
				$("warning").update("Username or Password not valid");
			}
		}
	}
	);
}

/*function called when login is clicked. An ajax request will be made to cowLogin.php and
catch a json response. if result is 1, then the user-password pair is valid so turn to 
getList function; other result all call readLogin(1) to show the warning message.*/
function AttemptLogin(event) {
	var name = $("username").value;
	var pwd = $("password").value;
	
	new Ajax.Request("cowLogin.php",
	{
		method: "post",
		parameters: {username: name, password: pwd},
		onSuccess: function(response) {
			var json = response.responseText.evalJSON();
			
			if(json.response === "1") {
				getList(0);
			}
			else {
				readLogin(1);
			}
		}
	}
	);
}

/*function with a indicator cas that is called when update or login to the list view*/
function getList(cas) {	
	new Ajax.Updater('content', 'cowGet.php', 
	{
		method: 'get',
		onComplete: function(r) {
			$("addbutton").observe("click", addelement);	// add addelement to addbutton
			$("deletebutton").observe("click", deletetop);	// add deletetop to deletebutton
			$("logout").observe("click", logout);	//add logout to logout
			Sortable.create("todolist", 
			{
				only: 'level1',
				onUpdate: function(item) {
					reorder();
				}
			}
			); // create a sortable list which response to the onUpdate function reorder()

			
			if(cas === 1) {	// the animation that will be shown when the an element is added
				var l = $("todolist").childElements().last();
				l.hide();
				l.grow({duration:1.0});
			}
		}
	}
	);
}

/*function that is called when the order of the list changes*/
function reorder() {
	
	var narray = []; // an array to hold all the elements
	
	var start = $("todolist").childElements().first();
	var end = $("todolist").childElements().last();
	
	while( start !== end) {
		narray.push(start.innerHTML);
		start = start.nextSibling;
	}
	
	narray.push(start.innerHTML); 
	var jsonString = JSON.stringify(narray); // turn the array to a json file
	
	new Ajax.Request("cowUpdate.php",
	{
		method: "post",
		parameters: {type: "reo", elements: jsonString}
	}
	); // made an update to cowUpdate.php with two parameters, indicating it's an reorder 
	// and the new order of the points
}

/*function that is called when the addbutton is clicked*/
function addelement() {
	var text = $("addtext").value.escapeHTML();
	
	new Ajax.Request("cowUpdate.php",
	{
		method: "post",
		parameters: {type: "add", point: text},
		onComplete: function(response) {
			getList(1);
		}
	}
	); // made an update to cowUpdate.php with two parameters, indicating it's an addition 
	// and the new point to be added
}

function deletetop() { // the animation that is shown when the top element is deleted
	if( $("todolist") === undefined) {return;}
	
	var l = $("todolist").childElements().first();
	l.fade({duration:1.0, afterFinish: realdelete});
	
}

/*function that is called when the delsetebutton is clicked*/
function realdelete() {
	new Ajax.Request("cowUpdate.php",
	{
		method: "post",
		parameters: {type: "del"},
		onComplete: function(response) {
			getList(2);
		}
	}
	);
	// made an update to cowUpdate.php with one parameter, indicating it's an deletion 
}

/*function that is called when the Logout is clicked*/
function logout() {
	new Ajax.Request("cowLogout.php",
	{
		method: "get",
		onCreate: function() {
			$("addbutton").disable();
			$("deletebutton").disable();
		},
		onComplete: function(response) {
			readLogin(0);
		}
	}
	);
}