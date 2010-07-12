<?php

/*
 *  _|    _|    _|_|    _|_|_|    _|_|_|      _|_|    _|      _|
 *  _|  _|    _|    _|  _|    _|  _|    _|  _|    _|  _|_|    _|
 *  _|_|      _|_|_|_|  _|_|_|    _|_|_|    _|_|_|_|  _|  _|  _|
 *  _|  _|    _|    _|  _|    _|  _|    _|  _|    _|  _|    _|_|
 *  _|    _|  _|    _|  _|    _|  _|_|_|    _|    _|  _|      _|
 *
 * This script installs karban on your server (via bootstrap)
 * using settings.php from the root directory. 
 * Delete the install folder after the installation is complete.
 */

require_once("Installer.php"); 			// Class handling installation routine
require_once(LIB_PATH .	"Button.php");	// CSS Buttons

include_once("header.html");			// Print a basic html header
$installer = new Installer();
start($installer);

// Installation routine
function start($installer) {
	if ($installer->hasConnection()) {
		if ($installer->isInstalled()) {
			// Already installed. No work for installer
		} else {
			// We are connected. Offer installation.
			echo "<br />You are one step away from a simple project management 
				system that is <em>fun</em> to use.<br /><br />";
			echo new Button("Install", "?install=true", ButtonType::POSITIVE);
		}		
	} else {
		// No connection to database. Ask for credentials.
		$installer->showSetupForm();	
	}
}

// Read user credentials and start installation
if(isset($_GET["install"])) {
	$installer->install();
	exit;
} elseif ($_POST) {
	$installer->setConnection(DB_HOST ,$_POST["dbname"],$_POST["dbuser"],$_POST["dbpass"]);
	start($installer);
}

include_once("footer.html");

?>