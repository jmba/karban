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

include_once("header.html");			// Print a nice html header
$installer = new Installer();			// Our installer object does the hard work.

// Installation routine
function start($installer) {
	if ($installer->hasConnection()) {
		if ($installer->isInstalled()) {
			// Already installed. No work for installer
				echo new Message("Karban is already installed.",
				"You have three possibilites:<br />
				1. If you want to install another copy of karban adjust the <em>settings.php</em> file
				in the root directory (set new prefix or database name).<br />
				2. If you want reinstall karban remove the tables in the <em>". DB_NAME ."</em> database<br />
				3. Remove this <em>install</em> directory to prevent accidential reinstall.",
				 MessageType::WARNING,
				"The table <strong>". $table . "</strong> was found. It belongs to a karban installation. 
				A previous installation of karban is present.", MoreTextType::DEBUG);
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

if(isset($_GET["install"])) {
	// User wants to install. Let's go!
	$installer->install();
	exit;
} elseif ($_POST) {
	// User gave login credentials via form.
	$installer->setConnection(DB_HOST ,$_POST["dbname"],$_POST["dbuser"],$_POST["dbpass"]);
	start($installer);
} else {
	start($installer);
}

include_once("footer.html");

?>