<?php

/**
 * This file collects some special functions needed at various
 * places.
 */

require_once("../settings.php");

/**
 * Show a setup form for karban installation
 */
function showSetupForm() {
	?>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="contactform">
				<div>
				    <label for="dbname">Database name:</label>
					<input type="text" size="50" name="dbname" id="dbname" value="" />
				</div>

				<div>
					<label for="dbuser">Database username:</label>
					<input type="text" size="50" name="dbuser" id="dbuser" value="" />
				</div>

				<div>
					<label for="dbpass1">Database password:</label>
					<input type="password" size="50" name="dbpass1" id="dbpass1" value="" />
				</div>
				
				<div>
					<label for="dbpass2">Repeat password:</label>
					<input type="password" size="50" name="dbpass2" id="dbpass2" value="" />
				</div>

			    <input type="submit" value="Connect" class="button" name="submit" />
			</form>
	<?php	
}
?>