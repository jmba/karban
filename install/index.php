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


// Check database connection
try {
	$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
	echo new Message("Connected to database.", "Well done!", MessageType::SUCCESS);
} catch(PDOException $e) {
	echo new Message("Could not connect to database.",
	"This is normal for the first start. 
	Please configure karban below <br />(for advanced options modify 
	<em>settings.php</em> and reload this page).", 
	MessageType::INFO, $e->getMessage(), MoreTextType::DEBUG);
	require_once(LIB_PATH . "helpers.php");
	showSetupForm();
	exit;
}

// Find out if karban is already installed:

// First load karban table names (without prefix).
include_once( LIB_PATH . "Tables.php");
$setupTables = new Tables(DB_PREFIX);
$tableNames = $setupTables->getTables();
// Then load tables from database
$results = $db->query("SHOW TABLES");
$installedTables = $results->fetchAll(PDO::FETCH_COLUMN);

// If we find a table in database that belongs to karban
// we asume that karban is already installed.
foreach ($installedTables as $table) {
	if ( in_array($table, $tableNames)) {
		echo new Message("Karban is already installed.",
		"You have three possibilites:<br />
		1. If you want to install another copy of karban adjust the <em>settings.php</em> file
		in the root directory (set new prefix or database name).<br />
		2. If you want reinstall karban remove the tables in the <em>". DB_NAME ."</em> database<br />
		3. Remove this <em>install</em> directory to prevent accidential reinstall.",
		 MessageType::WARNING,
		"The table <strong>". $table . "</strong> was found. It belongs to a karban installation. 
		A previous installation of karban is present.", MoreTextType::DEBUG);
		exit;
	}
}

// Karban is not yet installed. Offer installation:
if(isset($_GET["install"])) {
	$debugMsg = "Installation started...<br />";
	if($db->query($setupTables->getTable("Groups"))) {
		$debugMsg .=  DB_PREFIX ."Groups table created...<br />";
	} else {
		$debugMsg .=  "Error constructing ". DB_PREFIX ."Groups table.<br />";
		$db_issue = true;
	}

	if($db->query($setupTables->init("Groups"))) {
		$debugMsg .=  "Inserted Standard User group into ". DB_PREFIX ."Groups table...<br />";
	} else {
		$debugMsg .=  "Error constructing Groups table.<br />";
		$db_issue = true;
	}

	if($db->query($setupTables->getTable("Users"))) {
		$debugMsg .=  DB_PREFIX. "Users table created.....<br />";
	} else {
		$debugMsg .=  "Error constructing user table.<br />";
		$db_issue = true;
	}

	if(!$db_issue) {
		echo new Message("Karban has been installed", 
			"Please remove this <em>install</em> folder for security reasons.", 
			MessageType::SUCCESS);
	} else {
		echo new Message("Sorry. Something went wrong with the database setup.", 
			"Please check your configuration and <a href=\"?install=true\">start again</a>", 
			MessageType::ERROR, $debugMsg . "<br />" . $db->_sql_error(), MoreTextType::DEBUG);
	}
} else {
	include_once(LIB_PATH .	"Button.php");
	?>
		<br />You are one step away from a simple project management system that is <em>fun</em> to use.<br /><br />
	<?php
	echo new Button("Install", "?install=true", ButtonType::POSITIVE);
}

include_once("footer.html");
?>