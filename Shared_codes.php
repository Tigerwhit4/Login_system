<?php
/*
 * Shared code (13th of August) 
 * Mosaab
*/

// For escaping values (get, post, any-user-submitted-values
	$magic_quotes_active = get_magic_quotes_gpc();
	$real_escape_string_exists = function_exists( "mysql_real_escape_string" );
	function escape_value($value) {
		global $magic_quotes_active, $real_escape_string_exists;
		if( $real_escape_string_exists ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysql_real_escape_string( $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$real_escape_string_exists ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}
	
// To get the corrent php page without having attacks
defined("DS")? NULL :
	define("DS", DIRECTORY_SEPARATOR);
defined("SITE_ROOT")? NULL :
	define("SITE_ROOT", 'c:'. DS .'web_development'. DS .'www'. DS .'livecp'. DS .'slogin');
function get_page_name() {
	// Getting the correct version of siteroot
	$siteroot = str_replace("\\", "/", SITE_ROOT);
	
	// Get the filename by itself
	$rootfile = $_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'];
	
	if (stripos($rootfile, $siteroot) !== FALSE) {
		$extlen = strlen($siteroot);
		
		$filename = substr($rootfile, ($extlen+1));
	}
	else {$filename = false;}
	
	return $filename;
}

?>
