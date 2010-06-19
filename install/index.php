<?php

require_once("../settings.php"); // Load often used settings and objects

// Database setup
Prosper\Query::configure(Prosper\Query::MYSQL_MODE, DB_USER, DB_PASS, DB_HOST, "");

$template = new Template;
echo($template->header("Karban - Installation"));

$installed = Prosper\Query::select()->from(DB_PREFIX."Groups");
if ($installed) {
	echo "ist da";
} else {
	echo "fehler";
}
foreach ($installed as $table) {
	echo $table;
}
exit;

	if($installed)
	{
		echo "<strong>UserCake has already been installed.<br /> Please remove the install directory for security reasons.</strong>";	
	}
	else
	{
		if(isset($_GET["install"]))
		{
				$groups_sql = "
					CREATE TABLE IF NOT EXISTS `".$db_table_prefix."Groups` (
					`Group_ID` int(11) NOT NULL auto_increment,
					`Group_Name` varchar(225) NOT NULL,
					 PRIMARY KEY  (`Group_ID`)
					) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
				";
				
				$group_entry = "
					INSERT INTO `".$db_table_prefix."Groups` (`Group_ID`, `Group_Name`) VALUES
					(1, 'Standard User');
				";
				
				$users_sql = "
					 CREATE TABLE IF NOT EXISTS `".$db_table_prefix."Users` (
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
				
				
				if(Prosper\Query::native($groups_sql))
				{
					echo "<p>".$db_table_prefix."Groups table created.....</p>";
				}
				else
				{
					echo "<p>Error constructing ".$db_table_prefix."Groups table.</p><br /><br /> DBMS said: ";
					
					echo print_r($db->_sql_error());
					$db_issue = true;
				}
				
				if(Prosper\Query::native($group_entry))
				{
					echo "<p>Inserted Standard User group into ".$db_table_prefix."Groups table.....</p>";
				}
				else
				{
					echo "<p>Error constructing Groups table.</p><br /><br /> DBMS said: ";
					
					echo print_r($db->_sql_error());
					$db_issue = true;
				}
				
				if(Prosper\Query::native($users_sql))
				{
					echo "<p>".$db_table_prefix."Users table created.....</p>";
				}
				else
				{
					echo "<p>Error constructing user table.</p><br /><br /> DBMS said: ";
					
					echo print_r($db->_sql_error());
					$db_issue = true;
				}
				
				if(!$db_issue)
					echo "<p><strong>Database setup complete, please delete the install folder.</strong></p>";
				else
					echo "<p><a href=\"?install=true\">Sorry. Something went wrong with the database setup. Please check your configuration and again</a></p>";
		}
		else
		{
	?>
			
		Welcome to KARBAN! <br />
		The setup will create all necessary database entries... <br />
		<a href="?install=true">Install</a>
	
	<?php } }
	
include_once("../themes/default/footer.php");
?>
