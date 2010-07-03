<?php

/**
 * List of available message types that can be printed.
 */
abstract class MessageType {
	const ERROR 	= 0;
	const WARNING 	= 1; 
	const INFO 		= 2;
}

/**
 * The message class offers methods to show messages such as errors and warnings
 * on a page.
 */
class Message {

	private $heading;	// Heading of message
	private $type;		// Type of message (i.e. Warning)
	private $text;		// Text of message
	private $debugText; // Error dumps by system
	
	/**
	 * Create a new message object
	 */
	function Message($heading, $text = "", $type = MessageType::INFO, $debugText = "") 
	{
		$this->heading = $heading;
		$this->type = $type;
		$this->text = $text;
		$this->debugText = $debugText;
	}
	
	/**
	 * Returns a html snippet that shows a box containing
	 * the message.
	 */
	function __toString() {
		switch ($this->type) {
			case MessageType::ERROR: 	$msg = "<p class='error box'>"; break;
			case MessageType::WARNING: 	$msg = "<p class='warning box'>"; break;
			case MessageType::INFO: 	$msg = "<p class='info box'>"; break;
			default: $msg = "<p>"; break;
		}
		
		$msg .= "<strong>" . $this->heading . "</strong>";

		if (!empty($this->text)) {
			$msg .= "<br />" .
					$this->text;
		}
		if (!empty($this->debugText)) {
			$msg .= "<br /><br />" . 
					"<span class='machine'>" .
					$this->debugText . "</span>";
		}
		$msg .= "</p>";
		return $msg;
	}
}

?>