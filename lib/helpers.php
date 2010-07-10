<?php

/**
 * This file collects some lightweight special functions needed at various
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
				    <label id="dbname" title="The name of the database karban will be installed into." for="dbname">Database name:</label>
					<input type="text" size="50" name="dbname" id="dbname" value="" />
				</div>

				<div>
					<label id="dbuser" title="Username to access the database." for="dbuser">Database username:</label>
					<input type="text" size="50" name="dbuser" id="dbuser" value="" />
				</div>

				<div>
					<label id="dbpass1" title="Password to access the database." for="dbpass1">Database password:</label>
					<input type="password" size="50" name="dbpass1" id="dbpass1" value="" />
				</div>
				
				<div>
					<label id="dbpass2" title="Check for typing mistake in password." for="dbpass2">Repeat password:</label>
					<input type="password" size="50" name="dbpass2" id="dbpass2" value="" />
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

function sanitize($str) {
	return strip_tags(trim(($str)));
}

?>