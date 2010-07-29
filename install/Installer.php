<?php

/**
 * This installer class collects some lightweight 
 * special functions needed for karban setup.
 */

require_once("../settings.php"); 		// Load often used settings and objects
require_once(LIB_PATH . "Tables.php");	// Manage database tables
require_once(LIB_PATH . "Message.php");	// Format warnings and erros

class Installer {
	
	private $db;
	private $dbHost;
	private $dbName;
	private $dbUser;
	private $dbPass;
	
	function Installer($dbHost = DB_HOST, $dbName = DB_NAME, 
		$dbUser = DB_USER, $dbPass = DB_PASS) 
	{
		$this->setConnection($dbHost, $dbName, $dbUser, $dbPass);
	}

	function setConnection($dbHost, $dbName, $dbUser, $dbPass) {
		$this->dbHost = $this->sanitize($dbHost);
		$this->dbName = $this->sanitize($dbName);
		$this->dbUser = $this->sanitize($dbUser);
		$this->dbPass = $this->sanitize($dbPass);
	}
	
	/**
	 * Check database connection. 
	 * Returns true if connection established.
	 */ 
	function hasConnection() {
		try {
			$this->db = new PDO("mysql:host=" . $this->dbHost . ";dbname=" . $this->dbName, 
				$this->dbUser, $this->dbPass);
			echo new Message("Connected to database.", "Well done!", MessageType::SUCCESS);
			return true;
		} catch(PDOException $e) {
			echo new Message("Could not connect to database.",
				"This is normal for the first start. 
				Please configure karban below <br />(for advanced options modify 
				<em>settings.php</em> and reload this page).", 
			MessageType::INFO, $e->getMessage(), MoreTextType::DEBUG);
			return false;
		}
	}
	
	/* 
	 * Find out if karban is already installed.
	 * Returns true if already installed.
	 */
	function isInstalled() {
		
		// First load karban table names (with prefix).
		$setupTables = new Tables(DB_PREFIX);
		$tableNames = $setupTables->getTables();
		
		// Then load tables from database
		if (!$db) return; // Error! No database object.
		$results = $this->db->query("SHOW TABLES");
		$installedTables = $results->fetchAll(PDO::FETCH_COLUMN);
		
		// If we find a table in database that belongs to karban
		// we asume that karban is already installed.
		foreach ($installedTables as $table) {
			if ( in_array($table, $tableNames)) {
				return true; // Karban is installed.
			}
		}
		return false; // Karban is not yet installed.
	}
	
	/**
	 * Show a setup form for karban installation
	 */
	function showSetupForm() {
		?>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="contactform">	
			<div>
				<label id="l_dbname" title="The name of the database karban will be installed into." for="dbname">Database name:</label>
				<input type="text" size="30" name="dbname" id="dbname" value="<?php echo DB_NAME ?>" />
		
				<label id="l_dbuser" title="Username to access the database." for="dbuser">Database username:</label>
				<input type="text" size="30" name="dbuser" id="dbuser" value="<?php echo DB_USER ?>" />
					
				<label id="l_dbpass1" title="Password to access the database." for="dbpass1">Database password:</label>
				<input type="password" size="30" name="dbpass1" id="dbpass1" value="<?php echo DB_PASS ?>" />
					
				<label id="l_dbpass2" title="Check for typing mistake in password." for="dbpass2">Repeat password:</label>
				<input type="password" size="30" name="dbpass2" id="dbpass2" value="<?php echo DB_PASS ?>" />
			</div>	
		   	
		   	<input type="submit" value="Connect" class="button" name="submit" />
				    
		   	<!--  Tooltips -->
		   	<script type='text/javascript'> 
				$(function() {
					$('#dbname').tipsy({fade: true, gravity: 's'});
					$('#dbuser').tipsy({fade: true, gravity: 's'});
					$('#dbpass1').tipsy({fade: true, gravity: 's'});
					$('#dbpass2').tipsy({fade: true, gravity: 's'});
	  			});
			</script> 
		</form>
		<?php	
	}	
	
	function install() {
		if (!$db) {
			echo new Message("Oops! Something went wrong with the database setup.", 
				"Please check your configuration and <a href='index.php'>start again</a>", 
				MessageType::ERROR, "No database connection.");
			return;
		}
		$debugMsg = "Installation started...<br />";
		if($this->db->query($setupTables->getTable("Groups"))) {
			$debugMsg .=  DB_PREFIX ."Groups table created...<br />";
		} else {
			$debugMsg .=  "Error constructing ". DB_PREFIX ."Groups table.<br />";
			$db_issue = true;
		}
	
		if($this->db->query($setupTables->init("Groups"))) {
			$debugMsg .=  "Inserted Standard User group into ". DB_PREFIX ."Groups table...<br />";
		} else {
			$debugMsg .=  "Error constructing Groups table.<br />";
			$db_issue = true;
		}
	
		if($this->db->query($setupTables->getTable("Users"))) {
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
			echo new Message("Oops! Something went wrong with the database setup.", 
				"Please check your configuration and <a href=\"?install=true\">start again</a>", 
				MessageType::ERROR, $debugMsg . "<br />" . $db->_sql_error(), MoreTextType::DEBUG);
		}
	}
	
	/*
	 * Helper method returning a user input 
	 * string without special characters. 
	 * @param $str
	 */
	function sanitize($str) {
		return strip_tags(trim(($str)));
	}
}

?>