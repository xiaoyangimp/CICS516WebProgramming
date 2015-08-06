"use strict";

var num = 0;
var refreshIntervalId;
var step = 250;
var anim = "";
var anims = [];


function $(id) {
	return document.getElementById(id);
}

function clickstart( ) {

	$('start').disabled = true;
	$('stop').disabled = false;
	$('animation').disabled = true;
	refreshIntervalId = setInterval(animationloop, step);
	num = 0;
}

function clickstop ( ) {

	$('start').disabled = false;
	$('stop').disabled = true;
	$('animation').disabled = false;
	clearInterval(refreshIntervalId);
	
	var t = $('disp');
	t.innerHTML = anim;
}

function turbo () {
	if( ! $('start').disabled) {
		if($('turbo').checked) {step = 50;}
		else {step = 250;}
		
		return;
	}
	
	if($('turbo').checked) {
		clearInterval(refreshIntervalId);
		step = 50;
		refreshIntervalId = setInterval(animationloop, step);
	}
	else {
		clearInterval(refreshIntervalId);
		step = 250;
		refreshIntervalId = setInterval(animationloop, step);
	}
}

function changeAnimation() {
	var t = $('disp');

	anim = ANIMATIONS[$('animation').value];
	anims = anim.split("=====\n");
	
	t.innerHTML = anim;
}

function changeSize() {
	var t = $('disp');
	
	var x = $('size').value;
	t.style.fontSize = x + "pt";
}

function animationloop() {
	var t = $('disp');

	if(anims.length != 0) {
		t.innerHTML = anims[num];
		num = (num + 1) % anims.length;
	}
	
}