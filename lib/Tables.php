<?php

/**
 * The Tables class holds the necessary database queries to 
 * bootstrap karban and offers methods to interact with the various
 * tables used in karban.
 */
class Tables {

	private $prefix;
	private $tables;
	private $groupsSQL;
	private $groupsEntry;
	private $usersSQL;

	function Tables($prefix = "") {
		$this->prefix = $prefix;

		/**
		 * Create SQL Queries
		 */
		$this->groupsSQL =
			"CREATE TABLE IF NOT EXISTS `".$this->prefix."Groups` (
			`Group_ID` int(11) NOT NULL auto_increment,
			`Group_Name` varchar(225) NOT NULL,
			PRIMARY KEY  (`Group_ID`)
			) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
		";

		$this->groupsEntry =
			"INSERT INTO `".$this->prefix."Groups` (`Group_ID`, `Group_Name`) VALUES
			(1, 'Standard User');
		";
		
		$this->usersSQL = 
			"CREATE TABLE IF NOT EXISTS `".$this->prefix."Users` (
			`User_ID` int(11) NOT NULL auto_increment,
			`Username` varchar(150) NOT NULL,
			`Username_Clean` varchar(150) NOT NULL,
			`Password` varchar(225) NOT NULL,
			`Email` varchar(150) NOT NULL,
			`ActivationToken` varchar(225) NOT NULL,
			`LastActivationRequest` int(11) NOT NULL,
			`LostPasswordRequest` int(1) NOT NULL default '0',
			`Active` int(1) NOT NULL,
			`Group_ID` int(11) NOT NULL,
			`SignUpDate` int(11) NOT NULL,
			 `LastSignIn` int(11) NOT NULL,
			 PRIMARY KEY  (`User_ID`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
		";
		
		/**
		 * All tables used in the karban database are listed here (without prefix).
		 * We can use this information to check if karban is already installed and
		 * to create the tables.
		 */
		$this->tables = array(
			"People" 	=> "",
			"Users" 	=> $this->usersSQL,
			"Clients" 	=> "",
			"Groups" 	=> $this->groupsSQL,
			"Projects" 	=> ""
		);
	}

	/**
	 * Returns the array of table names preceded by a prefix.
	 * This is the default way to interact with the tables
	 * in the database.
	 *
	 * @param String $myPrefix
	 */
	public function getTables() {
		$prefixedArray;
		while(list($tableName, $sqlStatement) = each ($this->tables)) {
			$prefixedArray[] = $this->prefix .  $tableName;
		}
		return $prefixedArray;
	}

	/**
	 * Constructs an SQL query string to create up the karban table.
	 * @param String $table_name
	 */
	public function getTable($tableName) {
		return $this->tables[$tableName];
	}
	
	/**
	 * Constructs an SQL query string to initialize the karban table.
	 * @param String $table_name
	 */
	public function init($tableName) {
		switch( $tableName) {
			case "Groups": return $this->groupsEntry; break;
		}
	}
}
?>