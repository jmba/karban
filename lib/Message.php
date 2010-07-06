<?php

/**
 * List of available message types that can be printed.
 */
abstract class MessageType {
	const ERROR 	= 0;
	const WARNING 	= 1; 
	const INFO 		= 2;
	const SUCCESS	= 3;
}

/**
 * Message types that can be shown by clicking on the "more..." link inside the
 * message box.
 */
abstract class MoreTextType {
	const EXPLANATION 	= 0;
	const DEBUG 		= 1;
}

/**
 * The message class offers methods to show messages such as errors and warnings
 * on a page.
 */
class Message {

	private $heading;		// Heading of message
	private $type;			// Type of message (i.e. Warning)
	private $text;			// Text of message
	private $moreText; 		// Only shown on demand. By default the text is truncated.
	private $moreTextType; 	// Showing an error dump by system or explanation text?
	
	/**
	 * Create a new message object
	 */
	function Message($heading, $text = "", $type = MessageType::INFO, $moreText = "", $moreTextType = MoreTextType::EXPLANATION) 
	{
		$this->heading = $heading;
		$this->text = $text;
		$this->type = $type;
		$this->moreText = $moreText;
		$this->moreTextType = $moreTextType;
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
			case MessageType::SUCCESS: 	$msg = "<p class='success box'>"; break;
			default: $msg = "<p>"; break;
		}
		
		$msg .= "<strong>" . $this->heading . "</strong>";

		if (!empty($this->text)) {
			$msg .= "<br />" .
					$this->text;
		}
		if (!empty($this->moreText)) {
			$msg .= "<br /><br />" . 
					"<span class='";
			
			// Special css class for system debug messages
			if ( $this->moreTextType == MoreTextType::DEBUG ) 
				$msg.= "machine ";
				
			$msg .= "truncated'>" . $this->moreText . "</span>";
		}
		$msg .= "</p>";
		return $msg;
	}
}

?>