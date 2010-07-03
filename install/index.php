<?php

/*
 *  _|    _|    _|_|    _|_|_|    _|_|_|      _|_|    _|      _|
 *  _|  _|    _|    _|  _|    _|  _|    _|  _|    _|  _|_|    _|
 *  _|_|      _|_|_|_|  _|_|_|    _|_|_|    _|_|_|_|  _|  _|  _|
 *  _|  _|    _|    _|  _|    _|  _|    _|  _|    _|  _|    _|_|
 *  _|    _|  _|    _|  _|    _|  _|_|_|    _|    _|  _|      _|
 *
 * This script installs KARBAN on your server (via bootstrap) using settings.php from the
 * root directory. Delete the install folder after the installation is complete.
 */

include_once("header.html");		// Print a basic html header
require_once("../settings.php"); 	// Load often used settings and objects

// Database setup
try {
	$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
	echo new Message("Connected to database.");
} catch(PDOException $e) {
	echo new Message("Could not connect to database.",
	"This is normal for the first start. 
	Please adjust the file settings.php and reload this page.", 
	MessageType::ERROR, $e->getMessage());
	exit;
}

// Find out if karban is already installed:

// First load karban table names (without prefix).
include_once( LIB_PATH . "Tables.php");
$setupTables = new Tables();
$table_names = $setupTables->getTablesWithPrefix();

// Then load tables from database
$results = $db->query("SHOW TABLES");
$installedTables = $results->fetchAll(PDO::FETCH_COLUMN);

// If we find a table in database that belongs to karban
// we asume that karban is already installed.
foreach ($installedTables as $table) {
	if ( in_array($table, $table_names)) {
		echo new Message("Karban is already installed.",
		"Either delete this installation folder or reinstall karban 
		by deleting the database tables or adjusting your settings file.",
		 MessageType::WARNING,
		"The table ". $table . " was found. It belongs to a karban installation. 
		A previous installation of karban is present.");
		exit;
	}
}

// Karban is not yet installed. Offer installation:
if(isset($_GET["install"])) {
	$debugMsg = "Installation started...<br />";
	if($db->query($setupTables->getGroupsTable())) {
		$debugMsg .=  DB_PREFIX ."Groups table created...<br />";
	} else {
		$debugMsg .=  "Error constructing ". DB_PREFIX ."Groups table.<br />";
		$db_issue = true;
	}

	if($db->query($setupTables->initGroupsTable())) {
		$debugMsg .=  "Inserted Standard User group into ". DB_PREFIX ."Groups table...<br />";
	} else {
		$debugMsg .=  "Error constructing Groups table.<br />";
		$db_issue = true;
	}

	if($db->query($setupTables->getUsersTable())) {
		$debugMsg .=  DB_PREFIX. "Users table created.....<br />";
	} else {
		$debugMsg .=  "Error constructing user table.<br />";
		$db_issue = true;
	}

	if(!$db_issue) {
		echo new Message("Karban has been installed", "Please remove this folder for security reasons.");
	} else {
		echo new Message("Sorry. Something went wrong with the database setup.", 
			"Please check your configuration and <a href=\"?install=true\">start again</a>", 
			MessageType::ERROR, $debugMsg . "<br />" . $db->_sql_error());
	}
} else {
	echo new Link()
	?> <a href="?install=true">Install</a> <?php 
}

include_once("../themes/default/footer.php");
?>