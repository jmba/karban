<?php

/**
 * The template class offers methods to show page headers, footers and so on.
 * Placeholders (hooks) for variables can be used inside html files.
 * 
 * For instance consider the following html snippet:
 * <title><%%TITLE%%></title>
 * This placeholder can be used to insert a dynamic site title.
 */

class Template {
	
	private $logo = "karban.png";
	
	/**
	 * Loads contents of a file.
	 * @param string $templatename - File to open
	 */
	private function load($templatename) {
		if(file_exists($templatename)) {
			$templatecontent = file($templatename);
			return $templatecontent;
		} else {
			echo("Error! File doesn't exist: " . $templatename);
			exit;
		}
	}

	/**
	 * Replaces the hooks with specified values.
	 * @param string $template_file - File to parse
	 * @param array $values - Values for replacement
	 */
	private function parser($template_file, $values='') { 
		if(is_array($values)) {
			foreach($values as $key => $value) {
				$pattern = "/<%%(".strtoupper($key).")%%>/si";
				// Replace values
				$template_file = preg_replace($pattern, $value, $template_file); 
			} 
		}
		// Remove hooks that weren't replaced
		$template_file = preg_replace("/((<%%)(.+?)(%%>))/si", '', $template_file);
		return (implode("", $template_file)); 
	}
	
	/**
	 * Show header
	 * @param string $page_title - Name for the site that appears in browser
	 */
	function header($page_title ='') {
		$contentarray = array(
			"LOGO"		=> THEME_PATH . $this->logo,
			"STYLESHEET"=> THEME_PATH . DESIGN . "/style.css",
			"TITLE"		=> $page_title
		); 
		
		$templatecontent = $this->load(THEME_PATH . DESIGN . "/header.php");
		return $tp_content_out = $this->parser($templatecontent, $contentarray);
	}
	
	/**
	 * Show footer
	 */
	function footer() {
		$templatecontent = $this->load(THEME_PATH . DESIGN . "/footer.php");
		return $tp_content_out = $this->parser($templatecontent);
	}

}

?>