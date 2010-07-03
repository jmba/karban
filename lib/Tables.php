<?php

require_once ("../settings.php");

class Tables {

	/**
	 * All tables used in the karban database are listed here (without prefix).
	 * We can use this information to check if karban is already installed.
	 */
	private $table_names = array(
		"People",
		"Users",
		"Clients",
		"Groups",
		"Projects"
	);

	
	/**
	 * Gives the array of table names preceded by a prefix.
	 * This is the default way to interact with the tables
	 * in the database.
	 *  
	 * @param String $myPrefix
	 */
	public function getTablesWithPrefix() {
		$prefixedArray;
		foreach ($this->table_names as $table) {
			$prefixedArray[] = DB_PREFIX . $table;
		}
		return $prefixedArray;
	}
	
	/**
	 * Constructs an SQL query string to set up the karban groups table.
	 * @param String $myPrefix
	 */
	public function getTable($table_name) {
		return "CREATE TABLE IF NOT EXISTS `". DB_PREFIX ."Groups` (
			`Group_ID` int(11) NOT NULL auto_increment,
			`Group_Name` varchar(225) NOT NULL,
			 PRIMARY KEY  (`Group_ID`)
			) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
			";
	}
	
	/**
	 * Initialize the karban groups table.
	 * @param $myPrefix
	 */
	public function initGroupsTable() {
		return "INSERT INTO `". DB_PREFIX ."Groups` (`Group_ID`, `Group_Name`) VALUES
			(1, 'Standard User');
			";
	}
	
	/**
	 * Constructs an SQL query string to set up the karban users table.
	 * @param String $myPrefix
	 */
	public function getUsersTable() {
		return "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."Users` (
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
	}
}
?>