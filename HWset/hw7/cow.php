<?php
	session_save_path('sessions');
	if (!isset($_SESSION)) { 
	session_start(); 
	}
?>