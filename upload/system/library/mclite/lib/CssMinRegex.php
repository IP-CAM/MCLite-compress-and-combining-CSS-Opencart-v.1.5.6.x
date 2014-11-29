<?php 
/**
* Simple CssMinRegex
* @author Shashakhmetov Talgat <talgatks@gmail.com>
*/
class CssMinRegex
{
	protected static $instance;
	
	public static function minify($content){
		if(!self::$instance)
			self::$instance = new CssMinRegex();

		$content 	= preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content);
		$content 	= str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $content);
		$content 	= preg_replace('/ {2,}/', ' ', $content);
		return $content;
 	}
}
?>