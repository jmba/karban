<?php

/**
 * List of available button types.
 */
abstract class ButtonType {
	const NORMAL	= 0;
	const POSITIVE 	= 1;
	const NEGATIVE 	= 2; 
}

/**
 * The button class offers methods to show buttons on a page using plain CSS.
 * Button styles can be defined by custom css files.
 */
class Button {
	
	private $link;	// Button link
	private $text;	// Button text
	private $type; 	// Positive, negative or normal.
	
	/**
	 * Create a new button object
	 */
	function Button($text, $link, $type = ButtonType::NORMAL) 
	{
		$this->link = $link;
		$this->text = $text;
		$this->type = $type;
	}
	
	/**
	 * Returns a html snippet that shows the button.
	 */
	function __toString() {
		$button = "<a class='";
		switch ($this->type) {
			case ButtonType::POSITIVE: $button .= "positive"; break;
			case ButtonType::NEGATIVE: $button .= "negative"; break;
		}
		$button .= " button' href='" . $this->link . "'>" . $this->text . "</a>";
		return $button;
	}
}

?>