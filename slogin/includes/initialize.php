<?php
	// Defining mysqli var to be used in all pages
	$mysqli;
	
	// Defining the sites navigation
	defined("DS")? NULL :
		define("DS", DIRECTORY_SEPARATOR);
	defined("SITE_ROOT")? NULL :
		define("SITE_ROOT", 'c:'. DS .'path_to_your_website_root'. DS .'slogin');
	defined("SITE_LIBS")? NULL :
		define("SITE_LIBS", SITE_ROOT. DS .'includes');
	
	// Including the config library
	require_once(SITE_LIBS . DS .'config.php');
	// Including the functions library
	require_once(SITE_LIBS . DS .'functions.php');
	session_start();
	
	db_connect();
	// If the user is logged in already, send them to home page
	check_login();
?>