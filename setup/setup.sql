SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `user` (
  `userid` int(25) NOT NULL auto_increment,
  `first_name` varchar(25) NOT NULL default '',
  `last_name` varchar(25) NOT NULL default '',
  `email_address` varchar(50) NOT NULL default '',
  `username` varchar(25) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `info` varchar(50) NOT NULL,
  `last_loggedin` varchar(100) NOT NULL default 'never',
  `user_level` enum('1','2','3','4','5') NOT NULL default '1',
  `forgot` varchar(100) default NULL,
  `status` enum('live','suspended','pending') NOT NULL default 'live',
  PRIMARY KEY  (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Membership Information' AUTO_INCREMENT=0002 ;

INSERT INTO `user` (`userid`, `first_name`, `last_name`, `email_address`, `username`, `password`, `info`, `last_loggedin`, `user_level`, `forgot`, `status`) VALUES
(0001, 'Administrative', '<insert>', '<insert>', 'Administrative', '5f4dcc3b5aa765d61d8327deb882cf99', 'Administrative', 'never', '5', NULL, 'live');