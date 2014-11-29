<?php
/**
* Simple HTMLMinRegex
* @author Shashakhmetov Talgat <talgatks@gmail.com>
*/
class HTMLMinRegex 
{
	protected static $instance;

	public static function minify($content){
		if(!self::$instance)
			self::$instance = new HTMLMinRegex;
		
		$general['search'] 	= array('/\>[^\S ]+/s', '/[^\S ]+\</s','/(\s)+/s');
		$general['replace'] = array('>', '<', '\\1');
		$content 	= preg_replace($general['search'], $general['replace'], $content);
		return $content;
    }
}
?>