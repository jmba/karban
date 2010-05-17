<?php
include_once 'setup.php';
$Setup = new Setup;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>KARBAN - Setup</title>
<link href="include_once/style.css" rel="stylesheet" type="text/css">
<body>

Welcome to KARBAN! <br />
The setup will create all necessary database entries... <br />
<?php
	$Setup->init();
?>
Setup complete. You should <b>delete the setup folder now</b>.
</body>
</html>