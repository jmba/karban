<?php
error_reporting (E_ERROR | 0);
include_once '../inc/database.php';

class Setup {
	
	function init() {
		// Open database
		$DB = new Database;
		$DB->connect_db();
		// Create all database tables
		$DB->parse_mysql_dump(setup.sql);
	}
	
}
?>
