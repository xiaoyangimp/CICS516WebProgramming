"use strict";

/* This file provides the javascript file for fifteen.html, which give the on load function,
	a judgement function to determine whether or not such a chip can be moved, a shuffle function
	that provide a random pattern for the image*/

var emptyslot = 15; // the variable that record the empty slot position
var P_LENGTH = 100;	// the length of the all square
var ROW_N = 4;	// number of rows
var COL_N = 4;  // number of columns

/* The following function is executed on windows loading that it generate a specific number of pieces
	that is in the normal order*/
window.onload = function() {
	var alldivs = document.querySelectorAll("#puzzlearea div"); 
	
	for( var i = 0; i < alldivs.length; i++) {
		var left =  ( i % COL_N ) * P_LENGTH; 	// the length to the left of the area
		var top = 	Math.floor( i / COL_N ) * P_LENGTH;  // the length to the top of the area
		
		alldivs[i].className += "puzzlepiece";  // add an class name for the general CSS class
		alldivs[i].pos = i;  // add a element that describe the current position of the division
		alldivs[i].style.left = left + "px" ;
		alldivs[i].style.top = top + "px" ;
		
		alldivs[i].style.backgroundPosition = "-" + left + "px -" + top + "px";	 // set the position of the picture in the all piece
		alldivs[i].onclick = movetoempty;	// add onclick function to all pieces
	}
	
	emptyslot = 15;
	
	determinemove(); // determine moveable pieces
	
	var sbutton = document.getElementById("shufflebutton");
	sbutton.onclick = shuffle;  // add onlick function to shuffle button
};

/* The function that is applied to the onclick of all pieces*/
function movetoempty() {
	var clickpos = this.pos;	// get the clicked piece position
	if( ! judgeposition( clickpos )) { return; }	// if can not move, return
	
	var destleft =  ( emptyslot % COL_N ) * P_LENGTH;	// the length of the emptyslot to the left of the area
	var desttop = 	Math.floor( emptyslot / COL_N ) * P_LENGTH;	// the length of the emptyslot to the top of the area
	this.pos = emptyslot;
	
	var curl = this.style.left.substr(0, this.style.left.indexOf('p'));	// get the current position of clicked piece to the left of the area
	var curh = this.style.top.substr(0, this.style.top.indexOf('p'));	// get the current position of clicked piece to the top of the area
	emptyslot = curl / P_LENGTH + curh / P_LENGTH * COL_N;	// calculate the emptyslot number
	
	this.style.left = destleft + "px";	
	this.style.top = desttop + "px";	// move the piece to the original emptyslot
	
	determinemove(); // determine moveable pieces
}

/*	The function is called to exam which pieces are movable pieces*/
function determinemove() {
	var alldivs = document.querySelectorAll("#puzzlearea div");
	
	for( var i = 0; i < alldivs.length; i++) {
		if( judgeposition( alldivs[i].pos ) ) {
			alldivs[i].className = "puzzlepiece movablepiece";	// apply the CSS to movable pieces
		}
		else {
			alldivs[i].className = "puzzlepiece";	// apply the CSS to pieces other than movable pieces
		}
	}
}

/* onlick funtion for shuffle button*/
function shuffle() {

	var alldivs = document.querySelectorAll("#puzzlearea div");
	var turn = Math.random();
	
	for( var m = 0; m < turn * 300 + 150; m++) { // randomly click movable pieces several times
		var canchoose = [];
		for( var i = 0; i < alldivs.length; i++) {
			if( judgeposition( alldivs[i].pos ) ) {
				canchoose.push(alldivs[i]);
			}
		} // get all the movable pieces in this round
		
		var choicenum = canchoose.length;
		var rand = Math.random();
			
		switch(choicenum) {	// consider the different case that pieces in middle (4), on the side (3) and in the corner (2)
			case 2: 
				if( rand < 0.5) { canchoose[0].click(); }
				else { canchoose[1].click(); }
				break;
			case 3:
				if( rand < 0.33 ) { canchoose[0].click(); }
				else if (rand < 0.67) { canchoose[1].click(); }
				else { canchoose[2].click(); }
				break;
			case 4:
				if( rand < 0.25) { canchoose[0].click(); }
				else if (rand < 0.5) { canchoose[1].click(); }
				else if (rand < 0.75) { canchoose[2].click(); }
				else { canchoose[3].click(); }
				break;
		}
	}
}

/* judge whether a piece at position i is movable*/
function judgeposition( i ) {
	if( i === emptyslot - COL_N ) { return true; }	// the piece is above the emptyslot
	if( i === emptyslot + COL_N ) { return true; }	// the piece is beneath the emptyslot
	if( i === emptyslot - 1 && i % COL_N !== 3 ) { return true; }	// the piece is to the left of the emptyslot and in the same row
	if( i === emptyslot + 1 && i % COL_N !== 0 ) { return true; }	// the piece is to the right of the emptyslot and in the same row
	return false;
}